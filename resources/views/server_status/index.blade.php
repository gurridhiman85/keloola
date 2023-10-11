@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="bd">
                <div class="row">
                    <div class="col-md-12">
                        <div class="after-filter"></div>
                    </div>
                </div>

                <div class="row" style="border-bottom: 1px solid #dee2e6;">

                    <div class="col-md-7">

                        <ul class="nav nav-tabs mt-2 border-bottom-0 font-14 tab-hash">
                            <li class="nav-item active" style="border-bottom: 1px solid #dee2e6;">
                                <a class="nav-link" data-toggle="tab" data-tabid="20" href="#tab_20" role="tab" aria-selected="true">
                                    <span class="hidden-sm-up"></span>
                                    <span class="hidden-xs-down">Server Status</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>
                <div class="tab-content br-n pn">
                    <div class="tab-pane customtab active" id="tab_20" role="tabpanel">
                        <div id="completed_tab">
                            <form class="forms-sample ajax-Form" method="post" action="{{ url('/server_status/store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row grid-margin">
                                    <div class="col-lg-12">
                                      <div class="card">
                                        <div class="card-body">
                                          <h4 class="card-title">Server Status Editor</h4>
                                          <textarea cols="5" rows="10" name="server_status" class="form-control" id="exampleInputDescription" style="min-height: 6.75rem !important;">{{(!empty($record['server_status']) ? $record['server_status']:'')}}</textarea>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <input type="hidden" name="rec_id" class="form-control" value="{{ $record ? $record['id'] : '0' }}">
                                  <button type="submit" class="btn btn-primary me-2">{{ $record ? 'Update' : 'Create' }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function () {
            // if ($("#quillExample1").length) {
            //     var quill = new Quill('#quillExample1', {
            //     modules: {
            //         toolbar: [
            //         [{
            //             header: [1, 2, false]
            //         }],
            //         ['bold', 'italic', 'underline'],
            //         ['image', 'code-block']
            //         ]
            //     },
            //     placeholder: 'Compose an epic...',
            //     theme: 'snow' // or 'bubble'
            //     });
            // }
            // quill.on('text-change', function(delta, oldDelta, source) {
            //     document.getElementById("quill_html").value = quill.root.innerHTML;
            // });
            ACFn.ajax_server_status_load = function (F, R) {
                if(R.success){
                    ACFn.display_message(R.messageTitle, '', 'success');
                }
            }
        })

    </script>

@stop
