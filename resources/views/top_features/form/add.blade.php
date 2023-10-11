<?php
$n = isset($record) ? true : false;
?>
<form class="forms-sample ajax-Form" method="post" action="{{ url('/top_features/store') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="exampleInputUsername1">Text</label>
        <input type="text" name="text" class="form-control" id="exampleInputName" placeholder="Text" value="{{ $n ? $record->text : '' }}">
    </div>

    <div class="form-group">
        <label for="exampleInputPassword1">Photo</label>
        <input type="file" name="Photo" class="form-control" id="exampleInputPhoto" >
    </div>

    <input type="hidden" name="rec_id" class="form-control" value="{{ $n ? $record->id : '0' }}">
    <button type="submit" class="btn btn-primary me-2">{{ $is_create ? 'Create' : 'Update' }}</button>
    <button type="button" data-bs-dismiss="modal" class="btn btn-light">Cancel</button>
</form>
