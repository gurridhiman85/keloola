<?php

namespace App\Http\Controllers;

use App\Helpers\FileUpload;
use App\Helpers\Helper;
use App\Library\Ajax;
use App\Models\Attachment;
use App\Models\NewsVideos;
use Illuminate\Http\Request;
use Validator;
use Auth;
use \Illuminate\Support\Facades\View as View;

class NewsVideosController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function index(){
        return view('news_videos.index');
    }

    public function getNewsVideos(Request $request,Ajax $ajax){
        $tabid = $request->input('tabid');
        $filters = $request->input('filters',[]);
        $page = $request->input('page',1);
        $records_per_page = 15;
        $position = ($page-1) * $records_per_page;
        $rType = $request->input('rtype','');

        $query = NewsVideos::query()->with(['attachment']);
        Helper::applyFilters($filters, $query, 'news_videos');
        $records = $query->skip($position)->take($records_per_page)->get();
        $tquery = NewsVideos::query();
        Helper::applyFilters($filters, $tquery, 'news_videos');
        $total_records = $tquery->count();
        $tabName = 'Completed';

        $data = [
            'records' => $records,
            'tab' => $tabName,
            'filters' => json_encode($filters)
        ];

        if($rType == 'pagination'){
            $html = View::make('news_videos.tabs.all.table',$data)->render();
        }else {
            $html = View::make('news_videos.tabs.all.index', $data)->render();
        }

        $paginationhtml = View::make('news_videos.tabs.all.pagination-html',[
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
    public function newsVideosForm($rec_id, Ajax $ajax)
    {
        $title = 'Add News & Videos';
        $data = [
            'is_create' => true
        ];
        if($rec_id != '0'){
            $record = NewsVideos::find($rec_id);
            $data = [
                'record' => $record,
                'is_create' => false
            ];
            $title = 'Edit News & Videos';
        }

        $content = View::make('news_videos.form.add', $data)->render();

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
    public function storeNewsVideos(Request $request, Ajax $ajax)
    {
        $rules = [
            'title' => 'required',
            'date' => 'required',
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
            $news_videos = NewsVideos::find($id);
            $news_videos->title = $request->input('title');
            $news_videos->date = $request->input('date');
            $news_videos->description = $request->input('description');
            $news_videos->save();

            if(!empty($news_videos->attachment)){
                foreach($news_videos->attachment as $attachment){
                    if($request->file('Photo') && !empty($request->file('Photo')) && isset($attachment['attachment_url']) && $attachment['file_type'] == 'image'){
                        $file_path = public_path('/uploads/news_videos/'.$attachment['attachment_url']);
                        $file_path_thumb = public_path('/uploads/news_videos/thumb/'.$attachment['attachment_url']);

                        if(file_exists($file_path)) unlink($file_path);
                        if(file_exists($file_path_thumb)) unlink($file_path_thumb);
                        $attachment->delete();
                    }
                    if($request->file('Video') && !empty($request->file('Video')) && isset($attachment['attachment_url']) && $attachment['file_type'] == 'video'){
                        $file_path = public_path('/uploads/news_videos/videos/'.$attachment['attachment_url']);

                        if(file_exists($file_path)) unlink($file_path);
                        $attachment->delete();
                    }
                }
            }
            $msg = 'updated';
        }else{
            $insertedData = NewsVideos::create([
                'title' => $request->input('title'),
                'date' => $request->input('date'),
                'description' => $request->input('description')
            ]);
            $id = $insertedData['id'];
            $msg = 'created';
        }
        $attachment_array = [];
        if($request->file('Photo') && !empty($request->file('Photo'))) {
            $destination = public_path('/uploads/news_videos/');
            $result = FileUpload::uploadSingle($request->file('Photo'), $destination, 1);

            if (count($result) > 0) {
                $attachment_array[] = [
                    'user_id' => Auth::id(),
                    'type_id' => $id,
                    'attachment_type' => 'News_Videos',
                    'file_type' => 'image',
                    'attachment_title' => $result['attachment_title'],
                    'attachment_url' => $result['attachment_url'],
                    'is_thumbnail' => 1,
                ];
            }
        }
        if($request->file('Video') && !empty($request->file('Video'))) {
            $destination = public_path('/uploads/news_videos/videos');
            $result = FileUpload::uploadSingle($request->file('Video'), $destination, 1);

            if (count($result) > 0) {
                $attachment_array[] = [
                    'user_id' => Auth::id(),
                    'type_id' => $id,
                    'attachment_type' => 'News_Videos',
                    'file_type' => 'video',
                    'attachment_title' => $result['attachment_title'],
                    'attachment_url' => $result['attachment_url'],
                    'is_thumbnail' => 0,
                ];
            }
        }
        if(!empty($attachment_array)){
            Attachment::insert($attachment_array);
        }
        return $ajax->success()
            ->message('News & Videos ' . $msg . ' successfully')
            ->jscallback('ajax_news_videos_load')
            ->response();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function newsVideosVeiw($rec_id, Ajax $ajax)
    {
        $title = 'View Feature';
        $record = NewsVideos::with('attachment')->where('id', $rec_id)->first(['id','title','date','description','Created_at'])->toArray();

        $content = View::make('news_videos.form.view', ['record' => $record])->render();

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

        $news_videos = NewsVideos::find($rec_id);

        if(!empty($news_videos->attachment)){
            foreach($news_videos->attachment as $attachment){
                if(!empty($attachment['attachment_url']) && $attachment['file_type'] == 'image'){
                    $file_path = public_path('/uploads/news_videos/'.$attachment['attachment_url']);

                    $file_path_thumb = public_path('/uploads/news_videos/thumb/'.$attachment['attachment_url']);

                    if(file_exists($file_path)) unlink($file_path);
                    if(file_exists($file_path_thumb)) unlink($file_path_thumb);
                }
                if(!empty($attachment['attachment_url']) && $attachment['file_type'] == 'video'){
                    $file_path = public_path('/uploads/news_videos/videos/'.$attachment['attachment_url']);

                    if(file_exists($file_path)) unlink($file_path);
                }
                $attachment->delete();
            }
        }

        $news_videos->delete();

        return $ajax->success()
            ->message('News & videos deleted successfully')
            ->jscallback('ajax_news_videos_load')
            ->response();
    }
}
