<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\StoredAssets;
use App\Models\StoredAssetsUser;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function add_transfer(){

        $data = StoredAssetsUser::Orderby('id','desc')
        ->select('document','assets1', 'assets2', 'created_at', 'id','fa','invoice_no','item_description','invoice_description')
        ->get();
      
        // return $data;
        return view("backend.transfer-select",['data'=> $data ]);
    }

    public function add_transfer_detail($id){
      
        $asset = StoredAssets::with(['images', 'files'])
        ->where('assets_id', $id)
        ->where('last_varaint',1)
        ->first();

        
        return view("backend.add-transfer",['asset' => $asset]);
    }
}
