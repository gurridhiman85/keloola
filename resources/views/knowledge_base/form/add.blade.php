<?php
$n = isset($record) ? true : false;
?>
<form class="forms-sample ajax-Form" method="post" action="{{ url('/knowledge_base/store') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="exampleInputUsername1">Title</label>
        <input type="text" name="title" class="form-control" id="exampleInputName" placeholder="Title" value="{{ $n ? $record->title : '' }}">
    </div>
    <div class="form-group">
        <label for="exampleInputUsername1">Question</label>
        <input type="text" name="question" class="form-control" id="exampleInputName" placeholder="Question" value="{{ $n ? $record->question : '' }}">
    </div>
    <div class="form-group">
        <label for="exampleInputUsername1">Answer</label>
        <input type="text" name="answer" class="form-control" id="exampleInputName" placeholder="Answer" value="{{ $n ? $record->answer : '' }}">
    </div>
    <div class="form-group">
        <label for="exampleInputUsername1">Description</label>
        <textarea cols="5" rows="10" name="description" class="form-control" id="exampleInputDescription">{{ $n ? $record->description : '' }}</textarea>
    </div>

    <input type="hidden" name="rec_id" class="form-control" value="{{ $n ? $record->id : '0' }}">
    <button type="submit" class="btn btn-primary me-2">{{ $is_create ? 'Create' : 'Update' }}</button>
    <button type="button" data-bs-dismiss="modal" class="btn btn-light">Cancel</button>
</form>
