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
                    <div class="table-responsive">
                        <table id="basic_table2" class="table">
                            <thead>
                            <th colspan="3">Details </th>
                            </thead>
                            <tbody>
                            @foreach($allowedFields as  $key => $allowedField)
                                <tr>
                                    @if(strpos($allowedField, '__') !== false)
                                        @php
                                        $subset = explode('__', $allowedField);
                                        @endphp

                                        <td>{{ ucwords(str_replace('_', ' ', $subset[0]) .' '. str_replace('_', ' ', $subset[1])) }}</td>
                                        <td colspan="2">{{ !empty($record[$subset[0]][$subset[1]]) ? $record[$subset[0]][$subset[1]] : '-' }}</td>
                                    @else

                                        <td>{{ ucwords(str_replace('_', ' ', $allowedField)) }}</td>
                                        <td colspan="2">
                                            {{ !empty($record[$allowedField]) ? $record[$allowedField] : '-' }}
                                        </td>

                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal bs-example-modal-sm" id="filtersModel" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title pl-1" id="myModalLabel">Filters</h6>
                    <button type="button" class="close pr-3" data-dismiss="modal" aria-label="Close" style="background: transparent;"><i class="fas fa-times-circle" style="color: #d9d7d7;"></i></button>
                </div>
                <div class="modal-body p-1">
                    <div class="card mb-1">
                        <div class="card-body p-1">
                            <form id="filter_form" class=" filter-inner respo-filter-myticket" data-title="tickets#24#536" autocomplete="off">
                                <input type="hidden" name="searchterm" class="form-control form-control-sm" placeholder="" data-placeholder="">

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

@stop
