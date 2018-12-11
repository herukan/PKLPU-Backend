<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Peminjam;

class PeminjamController extends Controller
{
    public function index(){

        return Peminjam::all();
    
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


//ORDER
if(empty($request->get('kolom'))){
    $order = 'id';
}else{

    if ($tempcol[0]=='id'){
        $order = 'id';
    }else if ($tempcol[0]=='name'){
        $order = 'id';
    }else if ($tempcol[0]=='alamat'){
        $order = 'id';
    }

    // $order = $array[$request->get('kolom')];

}
        $totalData = Peminjam::count();
        $totalFiltered = $totalData; 

        $limit = $request->get('length');
        $start = $request->get('start') * $limit;
        
        $dir = $request->get('order.0.dir');
        $searchtemp = $request->get('search');
            
        if(empty($searchtemp))
        {            
            $posts = Peminjam::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();

                        //  $posts = Peminjam::paginate($limit);

                         $totalFiltered = Peminjam::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->count();
        }
        else {
            $search = $searchtemp;

            $posts =  Peminjam::where('id','LIKE',"%{$search}%")
                            ->orWhere('nama', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = Peminjam::where('id','LIKE',"%{$search}%")
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
            // $authorModel = Peminjam::find($id);

            $column = 'id'; // This is the name of the column you wish to search
     
            $authorModel = Peminjam::where($column , '=', $id)->get();

            // $authorModel = Peminjam::where($column,'LIKE',"%{$id}%")
            //                 ->get();
        }
        else
        {
            $column = 'nama'; // This is the name of the column you wish to search
     
            $authorModel = Peminjam::where($column,'LIKE',"%{$id}%")
                            ->orWhere('nama', 'LIKE',"%{$id}%")
                            ->orWhere('instansi', 'LIKE',"%{$id}%")
                            ->orWhere('alamat', 'LIKE',"%{$id}%")
                            ->get();

            // $authorModel = Peminjam::where($column , '=', $id)->get();
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
        $instansi = $request->get('instansi');
        $alamat = $request->get('alamat');

        $Peminjam = new Peminjam;
        $Peminjam->nama = $nama;
        $Peminjam->instansi = $instansi;
        $Peminjam->alamat = $alamat;
        $Peminjam->save();

        $data = array('id' => $Peminjam->id,'nama' => $nama, 'instansi' => $instansi
        , 'alamat' => $alamat);
        // return "Data Berhasil di Buat";
        return response()->json($data);

    }

    public function update(request $request,$id){

        $nama = $request->get('nama');
        $instansi = $request->get('instansi');
        $alamat = $request->get('alamat');
    
        $Peminjam = Peminjam::find($id);
        $Peminjam->nama = $nama;
        $Peminjam->instansi = $instansi;
        $Peminjam->alamat = $alamat;
        $Peminjam->save();

        $data = array('id' => $Peminjam->id,'nama' => $nama, 'instansi' => $instansi
        , 'alamat' => $alamat);
        
        // return "Data Berhasil di Update";
        return response()->json($data);

    }

    public function delete($id){

        $idnya = $id;

        $Peminjam = Peminjam::find($id);
        $Peminjam -> delete();

        $data = array('id' => $idnya);

        return response()->json($data);
    }
}
