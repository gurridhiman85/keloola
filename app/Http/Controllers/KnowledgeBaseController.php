<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Library\Ajax;
use App\Models\KnowledgeBase;
use Illuminate\Http\Request;
use Validator;
use Auth;
use \Illuminate\Support\Facades\View as View;

class KnowledgeBaseController extends Controller
{
    /**
        * Display a listing of the resource.
     */
    public function index(){
        return view('knowledge_base.index');
    }

    public function getKnowledgeBase(Request $request,Ajax $ajax){
        $tabid = $request->input('tabid');
        $filters = $request->input('filters',[]);
        $page = $request->input('page',1);
        $records_per_page = 15;
        $position = ($page-1) * $records_per_page;
        $rType = $request->input('rtype','');

        $query = KnowledgeBase::query();
        Helper::applyFilters($filters, $query, 'knowledge_base');
        $records = $query->skip($position)->take($records_per_page)->get();

        $tquery = KnowledgeBase::query();
        Helper::applyFilters($filters, $tquery, 'knowledge_base');
        $total_records = $tquery->count();
        $tabName = 'Completed';
        $data = [
            'records' => $records,
            'tab' => $tabName,
            'filters' => json_encode($filters)
        ];

        if($rType == 'pagination'){
            $html = View::make('knowledge_base.tabs.all.table',$data)->render();
        }else {
            $html = View::make('knowledge_base.tabs.all.index', $data)->render();
        }

        $paginationhtml = View::make('knowledge_base.tabs.all.pagination-html',[
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
    public function knowledgeBaseForm($rec_id, Ajax $ajax)
    {
        $title = 'Add Knowledge Base';
        $data = [
            'is_create' => true
        ];
        if($rec_id != '0'){
            $record = KnowledgeBase::find($rec_id);
            $data = [
                'record' => $record,
                'is_create' => false
            ];
            $title = 'Edit Knowledge Base';
        }

        $content = View::make('knowledge_base.form.add', $data)->render();

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
    public function storeKnowledgeBase(Request $request, Ajax $ajax)
    {
        $rules = [
            'title' => 'required',
            'question' => 'required',
            'answer' => 'required',
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
            $knowledge_base = KnowledgeBase::find($id);
            $knowledge_base->title = $request->input('title');
            $knowledge_base->question = $request->input('question');
            $knowledge_base->answer = $request->input('answer');
            $knowledge_base->description = $request->input('description');
            $knowledge_base->save();
            $msg = 'updated';
        }else{
            $insertedData = KnowledgeBase::create([
                'title' => $request->input('title'),
                'question' => $request->input('question'),
                'answer' => $request->input('answer'),
                'description' => $request->input('description'),
            ]);
            $id = $insertedData['id'];
            $msg = 'created';
        }
        return $ajax->success()
            ->message('Knowledge Base ' . $msg . ' successfully')
            ->jscallback('ajax_knowledge_base_load')
            ->response();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function knowledgeBaseView($rec_id, Ajax $ajax)
    {
        $title = 'View Knowledge Base';
        $record = KnowledgeBase::where('id', $rec_id)->first(['id','title', 'question', 'answer', 'description', 'Created_at'])->toArray();
        $content = View::make('knowledge_base.form.view', ['record' => $record])->render();

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

        $knowledge_base = KnowledgeBase::find($rec_id);

        $knowledge_base->delete();

        return $ajax->success()
            ->message('Knowledge Base deleted successfully')
            ->jscallback('ajax_knowledge_base_load')
            ->response();
    }
}
