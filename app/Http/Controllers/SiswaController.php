<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Siswa;

class SiswaController extends Controller
{
    public function index(){

        return Siswa::all();
    
    }

    public function allPosts(Request $request)
    {
        
        // $columns = array( 
        //                     0 =>'nama', 
        //                     1 =>'alamat',
        //                 );
$array[0] = 'nama';
$array[1] = 'alamat';

$tempcol = $request->get('kolom');



if(empty($request->get('kolom'))){
    $order = 'nama';
}else{

    if ($tempcol[0]=='id'){
        $order = 'id';
    }else if ($tempcol[0]=='name'){
        $order = 'nama';
    }else if ($tempcol[0]=='alamat'){
        $order = 'alamat';
    }

    // $order = $array[$request->get('kolom')];

}



        $totalData = Siswa::count();
        $totalFiltered = $totalData; 

        $limit = $request->get('length');
        $start = $request->get('start') * $limit;
        
        $dir = $request->get('order.0.dir');
        $searchtemp = $request->get('search');
            
        if(empty($searchtemp))
        {            
            $posts = Siswa::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();

                        //  $posts = Siswa::paginate($limit);

                         $totalFiltered = Siswa::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->count();
        }
        else {
            $search = $searchtemp;

            $posts =  Siswa::where('id','LIKE',"%{$search}%")
                            ->orWhere('nama', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = Siswa::where('id','LIKE',"%{$search}%")
            ->orWhere('nama', 'LIKE',"%{$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->count();
        }


        $pagesku = ceil ( $totalFiltered / $limit ); 

        // return $data = [
        //     'limit' => $limit,
        //     'filtered'=>$totalFiltered,
        //     'page' => $pagesku,
        //     'rows'  => $limit,
        //     'pages'   => $posts
        // ];

        return $posts;

        
        
    }


    public function select($id){
        
        if (is_numeric($id))
        {
            // $authorModel = Siswa::find($id);

            $column = 'id'; // This is the name of the column you wish to search
     
            // $authorModel = Siswa::where($column , '=', $id)->get();

            $authorModel = Siswa::where($column,'LIKE',"%{$id}%")
                            ->get();
        }
        else
        {
            $column = 'nama'; // This is the name of the column you wish to search
     

            $authorModel = Siswa::where($column,'LIKE',"%{$id}%")
                            ->orWhere('id', 'LIKE',"%{$id}%")
                            ->get();

            // $authorModel = Siswa::where($column , '=', $id)->get();
            // $dataku = array('nama' => $authorModel[0]->nama, 'alamat' => $authorModel[0]->alamat);


        }

        return $authorModel;

        // return [
        //     'status' => "success",
        //     'data' => [
        //         'posts' => $authorModel
        //     ]
        // ];

    }
    
    public function create(request $request){
        $nama = $request->get('nama');
        $alamat = $request->get('alamat');

        $siswa = new Siswa;
        $siswa->nama = $nama;
        $siswa->alamat = $alamat;
        $siswa->save();

        $data = array('id' => $siswa->id,'nama' => $nama, 'alamat' => $alamat);
        // return "Data Berhasil di Buat";
        return response()->json($data);

    }

    public function update(request $request,$id){

        $nama = $request->nama;
        $alamat = $request->alamat;

        $siswa = Siswa::find($id);
        $siswa ->nama = $nama;
        $siswa ->alamat = $alamat;
        $siswa->save();
        
        return "Data Berhasil di Update";

    }

    public function delete($id){

        $idnya = $id;

        $siswa = Siswa::find($id);
        $siswa -> delete();

        $data = array('id' => $idnya);

        return response()->json($data);
    }

}
