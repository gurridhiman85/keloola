<?php
$n = isset($record) ? true : false;
?>
<form class="forms-sample ajax-Form" method="post" action="{{ url('/pricing/store') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="exampleInputUsername1">Detailed Title</label>
        <input type="text" name="detailed_title" class="form-control" id="exampleInputName" placeholder="Detailed Title" value="{{ $n ? $record->detailed_title : '' }}">
    </div>
    <div class="form-group">
        <label for="exampleInputUsername1">Description</label>
        <textarea cols="5" rows="10" name="description" class="form-control" id="exampleInputDescription">{{ $n ? $record->description : '' }}</textarea>
    </div>

    <input type="hidden" name="rec_id" class="form-control" value="{{ $n ? $record->id : '0' }}">
    <button type="submit" class="btn btn-primary me-2">{{ $is_create ? 'Create' : 'Update' }}</button>
    <button type="button" data-bs-dismiss="modal" class="btn btn-light">Cancel</button>
</form>
