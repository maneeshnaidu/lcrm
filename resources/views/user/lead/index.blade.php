@extends('layouts.user')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop
{{-- Content --}}
@section('content')
    <div class="row analytics">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-header bg-white ">
                    <h4>{{ trans('lead.product') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="float-left">
                                {{ $leadProduct }}
                            </div>
                            <div class="float-right">
                                {{ $leads?round(($leadProduct/$leads)*100,2):0 }}%
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: {{$leads?($leadProduct/$leads)*100:0}}%" aria-valuenow="{{$leads?($leadProduct/$leads)*100:0}}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-header bg-white ">
                    <h4>{{ trans('lead.design') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="float-left">
                                {{ $leadDesign }}
                            </div>
                            <div class="float-right">
                                {{ $leads?round(($leadDesign/$leads)*100,2):0 }}%
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: {{$leads?($leadDesign/$leads)*100:0}}%" aria-valuenow="{{$leads?($leadDesign/$leads)*100:0}}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-header bg-white ">
                    <h4>{{ trans('lead.software') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="float-left">
                                {{ $leadSoftware }}
                            </div>
                            <div class="float-right">
                                {{ $leads?round(($leadSoftware/$leads)*100, 2):0 }}%
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{$leads?($leadSoftware/$leads)*100:0}}%" aria-valuenow="{{$leads?($leadProduct/$leads)*100:0}}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-header bg-white ">
                    <h4>{{ trans('lead.others') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="float-left">
                                {{ $leadOthers }}
                            </div>
                            <div class="float-right">
                                {{ $leads?round(($leadOthers/$leads)*100,2):0 }}%
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="progress">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: {{$leads?($leadOthers/$leads)*100:0}}%" aria-valuenow="{{$leads?($leadProduct/$leads)*100:0}}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-xl-6">
            <div class="card">
                <div class="card-header bg-white ">
                    <h4>{{ trans('lead.leads_by_priority') }}</h4>
                </div>
                <div class="card-body">
                    <div id="leads_priority" class="max_height_300"></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-6">
            <div class="card">
                <div class="card-header bg-white ">
                    <h4>{{ trans('lead.leads_by_month') }}</h4>
                </div>
                <div class="card-body">
                    <div id="leads_by_month" class="max_height_300"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-header clearfix">
        @if($user->hasAccess(['leads.write']) || $orgRole=='admin')
            <div class="pull-right">
                <a href="{{ $type.'/create' }}" class="btn btn-primary m-b-10">
                    <i class="fa fa-plus-circle"></i> {{ trans('lead.new') }}</a>
                <a href="{{ $type.'/import' }}" class="btn btn-primary m-b-10">
                    <i class="fa fa-download"></i> {{ trans('lead.import') }}</a>
            </div>
        @endif
    </div>
    <div class="card">
        <div class="card-header bg-white">
            <h4 class="float-left">
                <i class="material-icons">thumb_up</i>
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
                                    <input type="checkbox" class="icheckblue" data-column="1" id="column1"> {{ trans('lead.creation_date') }}
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label for="column2" class="toggle-vis">
                                    <input type="checkbox" class="icheckblue" data-column="2" id="column2"> {{ trans('lead.company_name') }}
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label for="column3" class="toggle-vis">
                                    <input type="checkbox" class="icheckblue" data-column="3" id="column3"> {{ trans('lead.function') }}
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label for="column4" class="toggle-vis">
                                    <input type="checkbox" class="icheckblue" data-column="4" id="column4"> {{ trans('lead.product_name') }}
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label for="column5" class="toggle-vis">
                                    <input type="checkbox" class="icheckblue" data-column="5" id="column5"> {{ trans('lead.title') }}
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label for="column6" class="toggle-vis">
                                    <input type="checkbox" class="icheckblue" data-column="6" id="column6"> {{ trans('lead.contact_name') }}
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label for="column7" class="toggle-vis">
                                    <input type="checkbox" class="icheckblue" data-column="7" id="column7"> {{ trans('lead.email') }}
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label for="column8" class="toggle-vis">
                                    <input type="checkbox" class="icheckblue" data-column="8" id="column8"> {{ trans('lead.phone') }}
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label for="column9" class="toggle-vis">
                                    <input type="checkbox" class="icheckblue" data-column="9" id="column9"> {{ trans('lead.mobile') }}
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label for="column10" class="toggle-vis">
                                    <input type="checkbox" class="icheckblue" data-column="10" id="column10"> {{ trans('lead.priority') }}
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label for="column11" class="toggle-vis">
                                    <input type="checkbox" class="icheckblue" data-column="11" id="column11"> {{ trans('lead.country') }}
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label for="column12" class="toggle-vis">
                                    <input type="checkbox" class="icheckblue" data-column="12" id="column12"> {{ trans('lead.state') }}
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label for="column13" class="toggle-vis">
                                    <input type="checkbox" class="icheckblue" data-column="13" id="column13"> {{ trans('lead.city') }}
                                </label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="table-responsive">
            <table id="data" class="table table-striped table-bordered ">
                <thead>
                <tr>
                    <th>{{ trans('table.id') }}</th>
                    <th>{{ trans('lead.creation_date') }}</th>
                    <th>{{ trans('lead.company_name') }}</th>
                    <th>{{ trans('lead.function') }}</th>
                    <th>{{ trans('lead.product_name') }}</th>
                    <th>{{ trans('lead.title') }}</th>
                    <th>{{ trans('lead.contact_name') }}</th>
                    <th>{{ trans('lead.email') }}</th>
                    <th>{{ trans('lead.phone') }}</th>
                    <th>{{ trans('lead.mobile') }}</th>
                    <th>{{ trans('lead.priority') }}</th>
                    <th>{{ trans('lead.country') }}</th>
                    <th>{{ trans('lead.state') }}</th>
                    <th>{{ trans('lead.city') }}</th>
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
        var chart1 = c3.generate({
            bindto: '#leads_priority',
            data: {
                columns: [
                        @foreach($priorities as $item)
                    ['{{$item['value']}}', {{$item['leads']}}],
                    @endforeach
                ],
                type : 'donut',
                colors: {
                    @foreach($priorities as $item)
                    '{{$item['value']}}': '{{$item['color']}}',
                    @endforeach
                }
            }
        });
        setTimeout(function () {
            chart1.resize()
        }, 500);


        //products by month
        var productsData = [
            ['leads'],
                @foreach($graphics as $item)
            [{{$item['leads']}}],
            @endforeach
        ];
        var chart2 = c3.generate({
            bindto: '#leads_by_month',
            data: {
                rows: productsData,
                type: 'bar'
            },
            color: {
                pattern: ['#3295ff']
            },
            axis: {
                x: {
                    tick: {
                        format: function (d) {
                            return formatMonth(d);
                        }
                    }
                }
            },
            legend: {
                show: true,
                position: 'bottom'
            },
            padding: {
                top: 10
            }
        });

        function formatMonth(d) {
            @foreach($graphics as $id => $item)
            if ('{{$id}}' == d) {
                return '{{$item['month']}}' + ' ' + '{{$item['year']}}'
            }
            @endforeach
        }

        $(".sidebar-toggle").on("click",function () {
            setTimeout(function () {
                chart1.resize();
                chart2.resize();
            },200)
        });


    </script>
    @if(isset($type))
        <script type="text/javascript">
            var oTable;
            $(document).ready(function () {
                oTable = $('#data').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "order": [],
                    columns:[
                        {"data":"id"},
                        {"data":"created_at"},
                        {"data":"company_name"},
                        {"data":"function"},
                        {"data":"product_name"},
                        {"data":"title"},
                        {"data":"contact_name"},
                        {"data":"email"},
                        {"data":"phone"},
                        {"data":"mobile"},
                        {"data":"priority"},
                        {"data":"country_id"},
                        {"data":"state_id"},
                        {"data":"city_id"},
                        {"data":"actions"}
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
                        },
                        {
                            "targets": [ 5 ],
                            "visible": false,
                            "searchable": false
                        },
                        {
                            "targets": [ 9 ],
                            "visible": false,
                            "searchable": false
                        },
                        {
                            "targets": [ 11 ],
                            "visible": false,
                            "searchable": false
                        },
                        {
                            "targets": [ 12 ],
                            "visible": false,
                            "searchable": false
                        },
                        {
                            "targets": [ 13 ],
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
        </script>
    @endif

@stop
