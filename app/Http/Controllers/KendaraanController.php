<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Kendaraan;

class KendaraanController extends Controller
{
    public function index(){

        return Kendaraan::orderBy('plat')
        ->get();
    
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
        $totalData = Kendaraan::count();
        $totalFiltered = $totalData; 

        $limit = $request->get('length');
        $start = $request->get('start') * $limit;
        
        $dir = $request->get('order.0.dir');
        $searchtemp = $request->get('search');
            
        if(empty($searchtemp))
        {            
            $posts = Kendaraan::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();

                        //  $posts = Kendaraan::paginate($limit);

                         $totalFiltered = Kendaraan::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->count();
        }
        else {
            $search = $searchtemp;

            $posts =  Kendaraan::where('id','LIKE',"%{$search}%")
                            ->orWhere('nama', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = Kendaraan::where('id','LIKE',"%{$search}%")
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
            // $authorModel = Kendaraan::find($id);

            $column = 'id'; // This is the name of the column you wish to search
     
            $authorModel = Kendaraan::where($column , '=', $id)->get();

            // $authorModel = Kendaraan::where($column,'LIKE',"%{$id}%")
            //                 ->get();
        }
        else
        {
            $column = 'plat'; // This is the name of the column you wish to search
     
            $authorModel = Kendaraan::where($column,'LIKE',"%{$id}%")->get();
                            // ->orWhere('id', 'LIKE',"%{$id}%")
                            

            // $authorModel = Kendaraan::where($column , '=', $id)->get();
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
     
            // $authorModel = Kendaraan::where($column,'LIKE',"%{$id}%")->get();
                            // ->orWhere('id', 'LIKE',"%{$id}%")
                            
            $authorModel = Kendaraan::where($column , '=', $id)->get();

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
        $status = $request->get('status');

        $Kendaraan = new Kendaraan;
        $Kendaraan->plat = $plat;
        $Kendaraan->jenis = $jenis;
        $Kendaraan->status = $status;
        $Kendaraan->save();

        $data = array('id' => $Kendaraan->id,'plat' => $plat, 'jenis' => $jenis
        , 'status' => $status);
        // return "Data Berhasil di Buat";
        return response()->json($data);

    }

    public function platku(){

        $collection = Kendaraan::groupBy('jenis')
                                 ->selectRaw('count(*) as total, jenis')
                                ->get();

        return response()->json($collection);
    }

    public function update(request $request,$id){

        $plat = $request->get('plat');
        $jenis = $request->get('jenis');
        $status = $request->get('status');

        if (is_numeric($id)){

        $Kendaraan = Kendaraan::find($id);
        $Kendaraan->plat = $plat;
        $Kendaraan->jenis = $jenis;
        $Kendaraan->status = $status;
        

        $data = array('id' => $Kendaraan->id,'plat' => $plat, 'jenis' => $jenis
        , 'status' => $status);

        return response()->json($data);

        }else{

            Kendaraan::where('plat', $id)->update(array('status' => $status));

            // $Kendaraan = Kendaraan::where('plat','=',"%{$id}%");
            // $Kendaraan->plat = $plat;
            // $Kendaraan->jenis = $jenis;
            // $Kendaraan->status = $status;
            // $Kendaraan->save();

        //     $data = array('id' => $Kendaraan->id,'plat' => $plat, 'jenis' => $jenis
        // , 'status' => $status);

        }
      

    }

    public function jenis($id){

        // $jenis = $request->get('jenis');

        $posts =  Kendaraan::where('jenis','=',$id)
                            ->Where('status', '=','Tersedia')
                            ->get();
                            
         return response()->json($posts);
    }

    public function delete($id){

        $idnya = $id;

        $Kendaraan = Kendaraan::find($id);
        $Kendaraan -> delete();

        $data = array('id' => $idnya);

        return response()->json($data);
    }

}
