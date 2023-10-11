<?php

namespace App\Http\Controllers;

use App\Helpers\FileUpload;
use App\Helpers\Helper;
use App\Library\Ajax;
use App\Models\Attachment;
use App\Models\HardwareIntegration;
use Illuminate\Http\Request;
use Validator;
use Auth;
use \Illuminate\Support\Facades\View as View;

class HardwareIntegrationController extends Controller
{
    /**
     * Display a listing of the resource.
    */
    public function index(){
        return view('hardware_integrations.index');
    }

    public function getHardwareIntegration(Request $request,Ajax $ajax){
        $tabid = $request->input('tabid');
        $filters = $request->input('filters',[]);
        $page = $request->input('page',1);
        $records_per_page = 15;
        $position = ($page-1) * $records_per_page;
        $rType = $request->input('rtype','');

        $query = HardwareIntegration::query()->with(['attachment']);
        Helper::applyFilters($filters, $query, 'hardware_integrations');
        $records = $query->skip($position)->take($records_per_page)->get();

        $tquery = HardwareIntegration::query();
        Helper::applyFilters($filters, $tquery, 'hardware_integrations');
        $total_records = $tquery->count();
        $tabName = 'Completed';

        $data = [
            'records' => $records,
            'tab' => $tabName,
            'filters' => json_encode($filters)
        ];

        if($rType == 'pagination'){
            $html = View::make('hardware_integrations.tabs.all.table',$data)->render();
        }else {
            $html = View::make('hardware_integrations.tabs.all.index', $data)->render();
        }

        $paginationhtml = View::make('hardware_integrations.tabs.all.pagination-html',[
            'total_records' => $total_records,
            'records' => $records,
            'position' => $position,
            'records_per_page' => $records_per_page,
            'page' => $page
        ])->render();

        return $ajax->success()
            ->appendParam('records',$records)
            ->appendParam('total_records',$total_records)
            ->appendParam('html',$html)
            ->appendParam('paginationHtml',$paginationhtml)
            ->jscallback('load_ajax_tab')
            ->response();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function hardwareIntegrationForm($rec_id, Ajax $ajax)
    {
        $title = 'Add Hardware Integration';
        $data = [
            'is_create' => true
        ];
        if($rec_id != '0'){
            $record = HardwareIntegration::find($rec_id);
            $data = [
                'record' => $record,
                'is_create' => false
            ];
            $title = 'Edit Hardware Integration';
        }

        $content = View::make('hardware_integrations.form.add', $data)->render();

        $sdata = [
            'content' => $content
        ];

        $size = 'modal-md';

        if (isset($title)) {
            $sdata['title'] = $title;
        }
        if (isset($size)) {
            $sdata['size'] = $size;
        }

        $view = View::make('layouts.modal-popup-layout', $sdata);
        $html = $view->render();

        return $ajax->success()
            ->appendParam('html', $html)
            ->jscallback('loadModalLayout')->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeHardwareIntegration(Request $request, Ajax $ajax)
    {
        $rules = [
            'title' => 'required',
            'description' => 'required',
            'url' => 'required',
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
            $hardware_integrations = HardwareIntegration::find($id);
            $hardware_integrations->title = $request->input('title');
            $hardware_integrations->description = $request->input('description');
            $hardware_integrations->url = $request->input('url');
            $hardware_integrations->save();
            if($request->file('Photo') && !empty($request->file('Photo')) && isset($hardware_integrations->attachment->attachment_url)){
                $file_path = public_path('/uploads/hardware_integrations/'.$hardware_integrations->attachment->attachment_url);

                $file_path_thumb = public_path('/uploads/hardware_integrations/thumb/'.$hardware_integrations->attachment->attachment_url);

                if(file_exists($file_path)) unlink($file_path);
                if(file_exists($file_path_thumb)) unlink($file_path_thumb);

                $hardware_integrations->attachment->delete();
            }
            $msg = 'updated';
        }else{
            $insertedData = HardwareIntegration::create([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'url' => $request->input('url')
            ]);
            $id = $insertedData['id'];
            $msg = 'created';
        }
        if($request->file('Photo') && !empty($request->file('Photo'))) {
            $destination = public_path('/uploads/hardware_integrations/');
            $result = FileUpload::uploadSingle($request->file('Photo'), $destination, 1);

            if (count($result) > 0) {
                Attachment::create([
                    'user_id' => Auth::id(),
                    'type_id' => $id,
                    'attachment_type' => 'Hardware_Integrations',
                    'attachment_title' => $result['attachment_title'],
                    'attachment_url' => $result['attachment_url'],
                    'is_thumbnail' => 1,
                ]);
            }
        }
        return $ajax->success()
            ->message('Hardware integration ' . $msg . ' successfully')
            ->jscallback('ajax_hardware_integrations_load')
            ->response();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function hardwareIntegrationView($rec_id, Ajax $ajax)
    {
        $title = 'View Feature';
        $record = HardwareIntegration::with('attachment')->where('id', $rec_id)->first(['id','title','description','url','Created_at'])->toArray();

        $content = View::make('hardware_integrations.form.view', ['record' => $record])->render();

        $sdata = [
            'content' => $content
        ];

        $size = 'modal-md';

        if (isset($title)) {
            $sdata['title'] = $title;
        }
        if (isset($size)) {
            $sdata['size'] = $size;
        }

        $view = View::make('layouts.modal-popup-layout', $sdata);
        $html = $view->render();

        return $ajax->success()
            ->appendParam('html', $html)
            ->jscallback('loadModalLayout')->response();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($rec_id, Ajax $ajax)
    {

        $hardware_integrations = HardwareIntegration::find($rec_id);

        if(!empty($hardware_integrations->attachment->attachment_url)){
            $file_path = public_path('/uploads/hardware_integrations/'.$hardware_integrations->attachment->attachment_url);

            $file_path_thumb = public_path('/uploads/hardware_integrations/thumb/'.$hardware_integrations->attachment->attachment_url);

            if(file_exists($file_path)) unlink($file_path);
            if(file_exists($file_path_thumb)) unlink($file_path_thumb);

            $hardware_integrations->attachment->delete();
        }

        $hardware_integrations->delete();

        return $ajax->success()
            ->message('Feature deleted successfully')
            ->jscallback('ajax_hardware_integrations_load')
            ->response();
    }
}
