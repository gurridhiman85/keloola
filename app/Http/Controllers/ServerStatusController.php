<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Library\Ajax;
use App\Models\ServerStatus;
use Illuminate\Http\Request;
use Validator;
use Auth;
use \Illuminate\Support\Facades\View as View;

class ServerStatusController extends Controller
{
    /**
        * Display a listing of the resource.
     */
    public function index(){
        $data = ServerStatus::first();
        $record = (!empty($data) ? $data->toArray() : []);
        return view('server_status.index',['record' => $record]);
    }

    public function storeServerStatus(Request $request, Ajax $ajax){
        $rules = [
            'server_status' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $ajax->fail()
                ->form_errors($validator->errors())
                ->jscallback()
                ->response();
        }
        $id = $request->input('rec_id');
        if($request->input('rec_id') != '0'){
            $status = ServerStatus::find($id);
            $status->server_status = $request->input('server_status');
            $status->save();
            $msg = 'updated';
        }else{
            $insertedData = ServerStatus::create([
                'server_status' => $request->input('server_status'),
            ]);
            $id = $insertedData['id'];
            $msg = 'created';
        }

        return $ajax->success()
            ->message('Server status ' . $msg . ' successfully')
            ->jscallback('ajax_server_status_load')
            ->response();
    }
}
