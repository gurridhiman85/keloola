<?php

namespace App\Http\Controllers;

use App\Helpers\FileUpload;
use App\Helpers\Helper;
use App\Library\Ajax;
use App\Models\Attachment;
use App\Models\Pricing;
use Illuminate\Http\Request;
use Validator;
use Auth;
use \Illuminate\Support\Facades\View as View;

class PricingController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function index(){
        return view('pricing.index');
    }

    public function getPricing(Request $request,Ajax $ajax){
        $tabid = $request->input('tabid');
        $filters = $request->input('filters',[]);
        $page = $request->input('page',1);
        $records_per_page = 15;
        $position = ($page-1) * $records_per_page;
        $rType = $request->input('rtype','');

        $query = Pricing::query();
        Helper::applyFilters($filters, $query, 'pricing');
        $records = $query->skip($position)->take($records_per_page)->get();

        $tquery = Pricing::query();
        Helper::applyFilters($filters, $tquery, 'pricing');
        $total_records = $tquery->count();
        $tabName = 'Completed';

        $data = [
            'records' => $records,
            'tab' => $tabName,
            'filters' => json_encode($filters)
        ];

        if($rType == 'pagination'){
            $html = View::make('pricing.tabs.all.table',$data)->render();
        }else {
            $html = View::make('pricing.tabs.all.index', $data)->render();
        }

        $paginationhtml = View::make('pricing.tabs.all.pagination-html',[
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
    public function pricingForm($rec_id, Ajax $ajax)
    {
        $title = 'Add Pricing';
        $data = [
            'is_create' => true
        ];
        if($rec_id != '0'){
            $record = Pricing::find($rec_id);
            $data = [
                'record' => $record,
                'is_create' => false
            ];
            $title = 'Edit Pricing';
        }

        $content = View::make('pricing.form.add', $data)->render();

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
    public function storePricing(Request $request, Ajax $ajax)
    {
        $rules = [
            'detailed_title' => 'required',
            'description' => 'required',
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
            $Pricing = Pricing::find($id);
            $Pricing->detailed_title = $request->input('detailed_title');
            $Pricing->description = $request->input('description');
            $Pricing->save();
            $msg = 'updated';
        }else{
            $insertedData = Pricing::create([
                'detailed_title' => $request->input('detailed_title'),
                'description' => $request->input('description'),
            ]);
            $id = $insertedData['id'];
            $msg = 'created';
        }
        return $ajax->success()
            ->message('Pricing ' . $msg . ' successfully')
            ->jscallback('ajax_pricing_load')
            ->response();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function pricingView($rec_id, Ajax $ajax)
    {
        $title = 'View Pricing';
        $record = Pricing::where('id', $rec_id)->first(['id','detailed_title', 'description', 'Created_at'])->toArray();

        $content = View::make('pricing.form.view', ['record' => $record])->render();

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

        $pricing = Pricing::find($rec_id);

        $pricing->delete();

        return $ajax->success()
            ->message('Pricing deleted successfully')
            ->jscallback('ajax_pricing_load')
            ->response();
    }
}
