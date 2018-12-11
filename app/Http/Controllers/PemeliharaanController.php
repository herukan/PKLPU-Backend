<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pemeliharaan;

class PemeliharaanController extends Controller
{
    public function index(){

        return Pemeliharaan::all();
    
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
        $totalData = Pemeliharaan::count();
        $totalFiltered = $totalData; 

        $limit = $request->get('length');
        $start = $request->get('start') * $limit;
        
        $dir = $request->get('order.0.dir');
        $searchtemp = $request->get('search');
            
        if(empty($searchtemp))
        {            
            $posts = Pemeliharaan::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();

                        //  $posts = Pemeliharaan::paginate($limit);

                         $totalFiltered = Pemeliharaan::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->count();
        }
        else {
            $search = $searchtemp;

            $posts =  Pemeliharaan::where('id','LIKE',"%{$search}%")
                            ->orWhere('nama', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = Pemeliharaan::where('id','LIKE',"%{$search}%")
            ->orWhere('nama', 'LIKE',"%{$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->count();
        }


        $pagesku = ceil ( $totalFiltered / $limit ); 

        return $data = [
            'limit' => $limit,
            'filtered'=>$totalFiltered,
            'page' => $pagesku,
            'rows'  => $limit,
            'pages'   => $posts
        ];

        // return $posts;
    }


    public function select($id){
        
        if (is_numeric($id))
        {
            // $authorModel = Pemeliharaan::find($id);

            $column = 'id'; // This is the name of the column you wish to search
     
            $authorModel = Pemeliharaan::where($column , '=', $id)->get();

            // $authorModel = Pemeliharaan::where($column,'LIKE',"%{$id}%")
            //                 ->get();
        }
        else
        {
            $column = 'plat'; // This is the name of the column you wish to search
     
            $authorModel = Pemeliharaan::where($column,'LIKE',"%{$id}%")->get();
                            // ->orWhere('id', 'LIKE',"%{$id}%")
                            

            // $authorModel = Pemeliharaan::where($column , '=', $id)->get();
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

    public function selectplat($id){
            $column = 'plat'; // This is the name of the column you wish to search
     
            // $authorModel = Pemeliharaan::where($column,'LIKE',"%{$id}%")->get();
                            // ->orWhere('id', 'LIKE',"%{$id}%")
                            
            $authorModel = Pemeliharaan::where($column , '=', $id)->get();

            // $dataku = array('nama' => $authorModel[0]->nama, 'alamat' => $authorModel[0]->alamat);
        return $authorModel;

        // return [
        //     'status' => "success",
        //     'data' => [
        //         'posts' => $authorModel
        //     ]
        // ];

    }

    
    public function create(request $request){

        $plat = $request->get('plat');
        $jenis = $request->get('jenis');
        $odometer = $request->get('odometer');
        $keterangan = $request->get('keterangan');
        $jenis_bb = $request->get('jenis_bb');
        $harga_bb = $request->get('harga_bb');
        $jumlah_bb = $request->get('jumlah_bb');
        $tipe_service = $request->get('tipe_service');
        $harga_service = $request->get('harga_service');
        $tgl_mulai = $request->get('tgl_mulai');
        $tgl_selesai = $request->get('tgl_selesai');
        $suku_cadang = $request->get('suku_cadang');
        $harga_suku = $request->get('harga_suku');

        $Pemeliharaan = new Pemeliharaan;
        $Pemeliharaan->plat = $plat;
        $Pemeliharaan->jenis = $jenis;
        $Pemeliharaan->odometer = $odometer;
        $Pemeliharaan->keterangan = $keterangan;
        $Pemeliharaan->jenis_bb = $jenis_bb;
        $Pemeliharaan->harga_bb = $harga_bb;
        $Pemeliharaan->jumlah_bb = $jumlah_bb;
        $Pemeliharaan->tipe_service = $tipe_service;
        $Pemeliharaan->harga_service = $harga_service;
        $Pemeliharaan->tgl_mulai = $tgl_mulai;
        $Pemeliharaan->tgl_selesai = $tgl_selesai;
        $Pemeliharaan->suku_cadang = $suku_cadang;
        $Pemeliharaan->harga_suku = $harga_suku;
        $Pemeliharaan->save();

        $data = array('id' => $Pemeliharaan->id,'plat' => $plat, 'jenis' => $jenis
        , 'odometer' => $odometer, 'keterangan' => $keterangan, 'jenis_bb' => $jenis_bb, 'harga_bb' => $harga_bb
        , 'jumlah_bb' => $jumlah_bb, 'tipe_service' => $tipe_service, 'harga_service' => $harga_service, 'tgl_mulai' => $tgl_mulai
        , 'tgl_selesai' => $tgl_selesai, 'suku_cadang' => $suku_cadang, 'harga_suku' => $harga_suku );
        // return "Data Berhasil di Buat";
        return response()->json($data);

    }

    public function update(request $request,$id){

        $plat = $request->get('plat');
        $jenis = $request->get('jenis');
        $odometer = $request->get('odometer');
        $keterangan = $request->get('keterangan');
        $jenis_bb = $request->get('jenis_bb');
        $harga_bb = $request->get('harga_bb');
        $jumlah_bb = $request->get('jumlah_bb');
        $tipe_service = $request->get('tipe_service');
        $harga_service = $request->get('harga_service');
        $tgl_mulai = $request->get('tgl_mulai');
        $tgl_selesai = $request->get('tgl_selesai');
        $suku_cadang = $request->get('suku_cadang');
        $harga_suku = $request->get('harga_suku');
        
        // $plat = $request->plat;
        // $jenis = $request->jenis;
        // $odometer = $request->odometer;
        // $keterangan = $request->keterangan;
        // $jenis_bb = $request->jenis_bb;
        // $harga_bb = $request->harga_bb;
        // $jumlah_bb = $request->jumlah_bb;
        // $tipe_service = $request->tipe_service;
        // $harga_service = $request->harga_service;
        // $tgl_mulai = $request->tgl_mulai;
        // $tgl_selesai = $request->tgl_selesai;
        // $suku_cadang = $request->suku_cadang;
        // $harga_suku = $request->harga_suku;
        
        $Pemeliharaan = Pemeliharaan::find($id);
        $Pemeliharaan->plat = $plat;
        $Pemeliharaan->jenis = $jenis;
        $Pemeliharaan->odometer = $odometer;
        $Pemeliharaan->keterangan = $keterangan;
        $Pemeliharaan->jenis_bb = $jenis_bb;
        $Pemeliharaan->harga_bb = $harga_bb;
        $Pemeliharaan->jumlah_bb = $jumlah_bb;
        $Pemeliharaan->tipe_service = $tipe_service;
        $Pemeliharaan->harga_service = $harga_service;
        $Pemeliharaan->tgl_mulai = $tgl_mulai;
        $Pemeliharaan->tgl_selesai = $tgl_selesai;
        $Pemeliharaan->suku_cadang = $suku_cadang;
        $Pemeliharaan->harga_suku = $harga_suku;
        $Pemeliharaan->save();
        
        $data = array('id' => $Pemeliharaan->id,'plat' => $plat, 'jenis' => $jenis
        , 'odometer' => $odometer, 'keterangan' => $keterangan, 'jenis_bb' => $jenis_bb, 'harga_bb' => $harga_bb
        , 'jumlah_bb' => $jumlah_bb, 'tipe_service' => $tipe_service, 'harga_service' => $harga_service, 'tgl_mulai' => $tgl_mulai
        , 'tgl_selesai' => $tgl_selesai, 'suku_cadang' => $suku_cadang, 'harga_suku' => $harga_suku );
        // return "Data Berhasil di Buat";
        return response()->json($data);

        // return "Data Berhasil di Update";

    }

    public function delete($id){

        $idnya = $id;

        $Pemeliharaan = Pemeliharaan::find($id);
        $Pemeliharaan -> delete();

        $data = array('id' => $idnya);

        return response()->json($data);
    }
 

}
