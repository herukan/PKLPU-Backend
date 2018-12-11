<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\User;
use App\Kendaraan;
use App\Pemeliharaan;
use App\Peminjaman;

use JWTAuth;
use JWTAuthException;

class UserController extends Controller
{
    private function getToken($email, $password)
    {
        $token = null;
        //$credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt( ['email'=>$email, 'password'=>$password])) {
                return response()->json([
                    'response' => 'error',
                    'message' => 'Password or email is invalid',
                    'token'=>$token
                ]);
            }
        } catch (JWTAuthException $e) {
            return response()->json([
                'response' => 'error',
                'message' => 'Token creation failed',
            ]);
        }
        return $token;
    }
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->get()->first();
        if ($user && \Hash::check($request->password, $user->password)) // The passwords match...
        {
            $token = self::getToken($request->email, $request->password);
            $user->auth_token = $token;
            $user->save();
            $response = ['success'=>true, 'data'=>['id'=>$user->id,'auth_token'=>$user->auth_token,'name'=>$user->name, 'nip'=>$user->nip, 'email'=>$user->email]];           
        }
        else 
          $response = ['success'=>false, 'data'=>'Record doesnt exists'];
      
        return response()->json($response, 201);
    }
    public function register(Request $request)
    { 
        $payload = [
            'password'=>\Hash::make($request->password),
            'email'=>$request->email,
            'name'=>$request->name,
            'nip'=>$request->nip,
            'auth_token'=> ''
        ];
                  
        $user = new User($payload);
        if ($user->save())
        {
            
            $token = self::getToken($request->email, $request->password); // generate user token
            
            if (!is_string($token))  return response()->json(['success'=>false,'data'=>'Token generation failed'], 201);
            
            $user = User::where('email', $request->email)->get()->first();
            
            $user->auth_token = $token; // update user token
            
            $user->save();
            
            $response = ['success'=>true, 'data'=>['name'=>$user->name,'id'=>$user->id, 'nip'=>$user->nip, 'email'=>$request->email,'auth_token'=>$token]];        
        }
        else
            $response = ['success'=>false, 'data'=>'Couldnt register user'];
        
        
        return response()->json($response, 201);
    }

    public function Userlist(Request $request)
    { 
        $start = $request->page;
        $users = User::all();
        // $users = User::where('auth_token' , '=',$start)->get();
        
        $response = ['success'=>true, 'data'=>$users];
        return response()->json($response, 201);
    }

    public function User(Request $request)
    { 
        return $request->user();
    }

    public function deleteuser($id){

        $idnya = $id;

        $Kendaraan = User::find($id);
        $Kendaraan -> delete();

        $data = array('id' => $idnya);

        return response()->json($data);
    }

    public function total()
    {
        $Kendaraan = Kendaraan::count();

        $Pemeliharaan = Pemeliharaan::count();
        $Peminjaman = Peminjaman::count();
        $User = User::count();

        $response = ['Kendaraan'=>$Kendaraan,'Pemeliharaan'=>$Pemeliharaan,'Peminjaman'=>$Peminjaman,'User'=>$User];

        return response()->json($response, 201);
    }

    
    public function chart(){

        $Eskavator =    Pemeliharaan::where('jenis' , '=', 'Eskavator')->count();

        $Mobil =    Pemeliharaan::where('jenis' , '=', 'Mobil')->count();

        $Motor =    Pemeliharaan::where('jenis' , '=', 'Motor')->count();

        $Stomp =    Pemeliharaan::where('jenis' , '=', 'Stomp')->count();

        $Truk =    Pemeliharaan::where('jenis' , '=', 'Truk')->count();

        $Dipinjam = Peminjaman::where('status' , '=', 'Dipinjam')->count();

        $Tersedia = Peminjaman::where('status' , '=', 'Tersedia')->count();


        $response = ['labels'=>['Eskavator', 'Mobil', 'Motor', 'Stomp', 'Truk'],'data'=>[$Eskavator,$Mobil,$Motor,$Stomp,$Truk],'dipinjam'=>$Dipinjam,'tersedia'=>$Tersedia];
            

        return response()->json($response);
    }



}