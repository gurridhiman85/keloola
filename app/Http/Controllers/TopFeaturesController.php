<?php

namespace App\Http\Controllers;

use App\Helpers\FileUpload;
use App\Helpers\Helper;
use App\Library\Ajax;
use App\Models\Attachment;
use App\Models\MasterProduct;
use App\Models\TopFeatures;
use Illuminate\Http\Request;
use Validator;
use Auth;
use \Illuminate\Support\Facades\View as View;

class TopFeaturesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        return view('top_features.index');
    }

    public function getTopFeatures(Request $request,Ajax $ajax){
        $tabid = $request->input('tabid');
        $filters = $request->input('filters',[]);
        $page = $request->input('page',1);
        $records_per_page = 15;
        $position = ($page-1) * $records_per_page;
        $rType = $request->input('rtype','');

        $query = TopFeatures::query()->with(['attachment']);
        Helper::applyFilters($filters, $query, 'top_features');
        $records = $query->skip($position)->take($records_per_page)->get();

        $tquery = TopFeatures::query();
        Helper::applyFilters($filters, $tquery, 'top_features');
        $total_records = $tquery->count();
        $tabName = 'Completed';

        $data = [
            'records' => $records,
            'tab' => $tabName,
            'filters' => json_encode($filters)
        ];

        if($rType == 'pagination'){
            $html = View::make('top_features.tabs.all.table',$data)->render();
        }else {
            $html = View::make('top_features.tabs.all.index', $data)->render();
        }

        $paginationhtml = View::make('top_features.tabs.all.pagination-html',[
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
    public function topFeaturesForm($rec_id, Ajax $ajax)
    {
        $title = 'Add Top Features';
        $data = [
            'is_create' => true
        ];
        if($rec_id != '0'){
            $record = TopFeatures::find($rec_id);
            $data = [
                'record' => $record,
                'is_create' => false
            ];
            $title = 'Edit Top Features';
        }

        $content = View::make('top_features.form.add', $data)->render();

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
    public function storeTopFeature(Request $request, Ajax $ajax)
    {
        $rules = [
            'text' => 'required|min:3|max:50',
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
            $top_feature = TopFeatures::find($id);
            $top_feature->text = $request->input('text');
            $top_feature->save();
            if($request->file('Photo') && !empty($request->file('Photo')) && isset($top_feature->attachment->attachment_url)){
                $file_path = public_path('/uploads/top_features/'.$top_feature->attachment->attachment_url);

                $file_path_thumb = public_path('/uploads/top_features/thumb/'.$top_feature->attachment->attachment_url);

                if(file_exists($file_path)) unlink($file_path);
                if(file_exists($file_path_thumb)) unlink($file_path_thumb);

                $top_feature->attachment->delete();
            }
            $msg = 'updated';
        }else{
            $insertedData = TopFeatures::create([
                'text' => $request->input('text')
            ]);
            $id = $insertedData['id'];
            $msg = 'created';
        }
        if($request->file('Photo') && !empty($request->file('Photo'))) {
            $destination = public_path('/uploads/top_features/');
            $result = FileUpload::uploadSingle($request->file('Photo'), $destination, 1);

            if (count($result) > 0) {
                Attachment::create([
                    'user_id' => Auth::id(),
                    'type_id' => $id,
                    'attachment_type' => 'Top_Features',
                    'attachment_title' => $result['attachment_title'],
                    'attachment_url' => $result['attachment_url'],
                    'is_thumbnail' => 1,
                ]);
            }
        }
        return $ajax->success()
            ->message('Feature ' . $msg . ' successfully')
            ->jscallback('ajax_top_features_load')
            ->response();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function topFeatureVeiw($rec_id, Ajax $ajax)
    {
        $title = 'View Feature';
        $record = TopFeatures::with('attachment')->where('id', $rec_id)->first(['id','text', 'Created_at'])->toArray();

        $content = View::make('top_features.form.view', ['record' => $record])->render();

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

        $top_feature = TopFeatures::find($rec_id);

        if(!empty($top_feature->attachment->attachment_url)){
            $file_path = public_path('/uploads/top_features/'.$top_feature->attachment->attachment_url);

            $file_path_thumb = public_path('/uploads/top_features/thumb/'.$top_feature->attachment->attachment_url);

            if(file_exists($file_path)) unlink($file_path);
            if(file_exists($file_path_thumb)) unlink($file_path_thumb);
            $top_feature->attachment->delete();
        }

        $top_feature->delete();

        return $ajax->success()
            ->message('Feature deleted successfully')
            ->jscallback('ajax_top_features_load')
            ->response();
    }
}
