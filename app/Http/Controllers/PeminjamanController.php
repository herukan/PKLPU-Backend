<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Peminjaman;

class PeminjamanController extends Controller
{
    public function index(){

        return Peminjaman::all();
    
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
        $totalData = Peminjaman::count();
        $totalFiltered = $totalData; 

        $limit = $request->get('length');
        $start = $request->get('start') * $limit;
        
        $dir = $request->get('order.0.dir');
        $searchtemp = $request->get('search');
            
        if(empty($searchtemp))
        {            
            $posts = Peminjaman::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();

                        //  $posts = Peminjaman::paginate($limit);

                         $totalFiltered = Peminjaman::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->count();
        }
        else {
            $search = $searchtemp;

            $posts =  Peminjaman::where('id','LIKE',"%{$search}%")
                            ->orWhere('nama', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = Peminjaman::where('id','LIKE',"%{$search}%")
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
            // $authorModel = Peminjaman::find($id);

            $column = 'id'; // This is the name of the column you wish to search
     
            $authorModel = Peminjaman::where($column , '=', $id)->get();

            // $authorModel = Peminjaman::where($column,'LIKE',"%{$id}%")
            //                 ->get();
        }
        else
        {
            $column = 'nama'; // This is the name of the column you wish to search
     
            $authorModel = Peminjaman::where($column,'LIKE',"%{$id}%")
                            ->orWhere('nama', 'LIKE',"%{$id}%")
                            ->orWhere('instansi', 'LIKE',"%{$id}%")
                            ->orWhere('jenis', 'LIKE',"%{$id}%")
                            ->orWhere('alamat', 'LIKE',"%{$id}%")
                            ->orWhere('perihal', 'LIKE',"%{$id}%")
                            ->orWhere('plat', 'LIKE',"%{$id}%")
                            ->get();

            // $authorModel = Peminjaman::where($column , '=', $id)->get();
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
        $perihal = $request->get('perihal');
        $tgl_mulai = $request->get('tgl_mulai');
        $tgl_kembali = $request->get('tgl_kembali');
        $jenis = $request->get('jenis');
        $plat = $request->get('plat');
        $harga = $request->get('harga');
        $status = $request->get('status');

        $Peminjaman = new Peminjaman;
        $Peminjaman->nama = $nama;
        $Peminjaman->instansi = $instansi;
        $Peminjaman->alamat = $alamat;
        $Peminjaman->perihal = $perihal;
        $Peminjaman->tgl_mulai = $tgl_mulai;
        $Peminjaman->tgl_kembali = $tgl_kembali;
        $Peminjaman->jenis = $jenis;
        $Peminjaman->plat = $plat;
        $Peminjaman->harga = $harga;
        $Peminjaman->status = $status;
        $Peminjaman->save();

        $data = array('id' => $Peminjaman->id,'nama' => $nama, 'instansi' => $instansi
        , 'alamat' => $alamat, 'perihal' => $perihal, 'tgl_mulai' => $tgl_mulai, 'tgl_kembali' => $tgl_kembali
        , 'jenis' => $jenis, 'plat' => $plat, 'harga' => $harga, 'status' => $status);
        // return "Data Berhasil di Buat";
        return response()->json($data);

    }

    public function update(request $request,$id){

        $nama = $request->get('nama');
        $instansi = $request->get('instansi');
        $alamat = $request->get('alamat');
        $perihal = $request->get('perihal');
        $tgl_mulai = $request->get('tgl_mulai');
        $tgl_kembali = $request->get('tgl_kembali');
        $jenis = $request->get('jenis');
        $plat = $request->get('plat');
        $harga = $request->get('harga');
        $status = $request->get('status');
    
        $Peminjaman = Peminjaman::find($id);
        $Peminjaman->nama = $nama;
        $Peminjaman->instansi = $instansi;
        $Peminjaman->alamat = $alamat;
        $Peminjaman->perihal = $perihal;
        $Peminjaman->tgl_mulai = $tgl_mulai;
        $Peminjaman->tgl_kembali = $tgl_kembali;
        $Peminjaman->jenis = $jenis;
        $Peminjaman->plat = $plat;
        $Peminjaman->harga = $harga;
        $Peminjaman->status = $status;
        $Peminjaman->save();

        $data = array('id' => $Peminjaman->id,'nama' => $nama, 'instansi' => $instansi
        , 'alamat' => $alamat, 'perihal' => $perihal, 'tgl_mulai' => $tgl_mulai, 'tgl_kembali' => $tgl_kembali
        , 'jenis' => $jenis, 'plat' => $plat, 'harga' => $harga, 'status' => $status);
        
        // return "Data Berhasil di Update";
        return response()->json($data);

    }

    public function delete($id){

        $idnya = $id;

        $Peminjaman = Peminjaman::find($id);
        $Peminjaman -> delete();

        $data = array('id' => $idnya);

        return response()->json($data);
    }
}
