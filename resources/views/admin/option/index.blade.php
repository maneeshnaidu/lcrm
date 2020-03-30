@extends('layouts.user')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <div class="page-header clearfix">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <label class="radio-inline">
                            <input type='radio' id='category' name='category' checked value='__' class='icheck'/> All
                        </label>
                        @foreach($categories as $key => $value)
                            <label class="radio-inline">
                                <input type='radio' id='category' name='category' value='{{$key}}' class='icheck'/> {{$value}}
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="pull-right">
            <a href="{{ url($type.'/create') }}" class="btn btn-primary m-b-10">
                <i class="fa fa-plus-circle"></i> {{ trans('option.create') }}
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-white">
            <h4 class="float-left">
                <i class="material-icons">dashboard</i>
                {{ $title }}
            </h4>
            <span class="pull-right">
                <i class="fa fa-fw fa-chevron-up clickable"></i>
                <i class="fa fa-fw fa-times removecard clickable"></i>
            </span>
        </div>
        <div class="card-body">
            <div class="column_dropdown pull-right m-b-15">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        {{ trans('table.column_visibility') }} <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <div class="checkbox">
                                <label for="column0" class="toggle-vis">
                                    <input type="checkbox" class="icheckblue" data-column="0" id="column0" checked> {{ trans('table.id') }}
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label for="column1" class="toggle-vis">
                                    <input type="checkbox" class="icheckblue" data-column="1" id="column1"> {{ trans('option.category') }}
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label for="column2" class="toggle-vis">
                                    <input type="checkbox" class="icheckblue" data-column="2" id="column2"> {{ trans('option.title') }}
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label for="column3" class="toggle-vis">
                                    <input type="checkbox" class="icheckblue" data-column="3" id="column3"> {{ trans('option.value') }}
                                </label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="table-responsive">
                <table id="data" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>{{ trans('table.id') }}</th>
                        <th>{{ trans('option.category') }}</th>
                        <th>{{ trans('option.title') }}</th>
                        <th>{{ trans('option.value') }}</th>
                        <th class="noExport">{{ trans('table.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@stop

{{-- Scripts --}}
@section('scripts')
    <script>
        $(document).ready(function () {
            $('.icheck').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            });
        });
    </script>
    <script>
        var oTable;
        $(document).ready(function () {
            oTable = $('#data').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [],
                "columns": [
                    {"data":"id"},
                    {"data": "category"},
                    {"data": "title"},
                    {"data": "value"},
                    {"data": "actions"},
                ],
                "ajax": "{{ url($type) }}" + ((typeof $('#data').attr('data-id') != "undefined") ? "/" + $('#id').val() + "/" + $('#data').attr('data-id') : "/data"),
                dom: 'Bfrtip',
                pageLength: 15,
                stateSave: true,
                "columnDefs": [
                    {
                        "targets": [ 0 ],
                        "visible": false,
                        "searchable": false
                    }
                ],
                lengthMenu: [[10,25,50,100, -1],[10,25,50,100, "All"]],
                buttons: [
                    {
                        extend: 'pageLength'
                    },
                    {
                        extend: 'collection',
                        text: 'Export',
                        buttons: [
                            {
                                extend: 'copy',
                                exportOptions: {
                                    columns: "thead th:not(.noExport)"
                                }
                            },
                            {
                                extend: 'csv',
                                exportOptions: {
                                    columns: "thead th:not(.noExport)"
                                }
                            },
                            {
                                extend: 'excel',
                                exportOptions: {
                                    columns: "thead th:not(.noExport)"
                                }
                            },
                            {
                                extend: 'pdf',
                                exportOptions: {
                                    columns: "thead th:not(.noExport)"
                                }
                            },
                            {
                                extend: 'print',
                                exportOptions: {
                                    columns: "thead th:not(.noExport)"
                                }
                            }
                        ]
                    }
                ]
            });
            oTable.columns().every(function(id) {
                if(oTable.column( id ).visible() === true){
                    $(".column_dropdown .checkbox").find("input[data-column='"+id+"']").prop('checked',false);
                }else{
                    $(".column_dropdown .checkbox").find("input[data-column='"+id+"']").prop('checked',true);
                }
            });

            $('body').on('ifChanged','.checkbox', function(e) {
                e.preventDefault();
                // Get the column API object
                var column = oTable.column($(this).find('input').attr('data-column'));
                // Toggle the visibility
                column.visible(!column.visible());
            });
            $(".icheckblue").iCheck({
                checkboxClass: 'icheckbox_minimal-blue'
            });
        });
        $('input[type=radio]').on('ifChecked', function (event) {
            oTable.ajax.url('{!! url($type.'/data') !!}/' + $(this).val());
            oTable.ajax.reload();
        });
    </script>
@stop
