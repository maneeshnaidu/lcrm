@extends('layouts.user')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <div class="row">
        <div class="col-12 col-xl-6">
            <div class="card">
                <div class="card-header bg-white ">
                    <h4>{{ trans('salesteam.invoice_taget_vs_actual_invoice') }}</h4>
                </div>
                <div class="card-body">
                    <div id="invoice_target_by_month" class="max_height_300"></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-6">
            <div class="card">
                <div class="card-header bg-white ">
                    <h4>{{ trans('salesteam.sales_teams_by_month') }}</h4>
                </div>
                <div class="card-body">
                    <div id="salesteam_by_month" class="max_height_300"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-header clearfix">
        @if($user->hasAccess(['sales_team.write']) || $orgRole=='admin')
            <div class="pull-right">
                <a href="{{ request()->url() }}/import" class="btn btn-primary m-b-10">
                    <i class="fa fa-download"></i> {{ trans('table.import') }}
                </a>
                <a href="{{ url($type.'/create') }}" class="btn btn-primary m-b-10">
                    <i class="fa fa-plus-circle"></i> {{ trans('salesteam.new') }}
                </a>
            </div>
        @endif
    </div>
    <div class="card">
        <div class="card-header bg-white">
            <h4 class="float-left">
                <i class="material-icons">groups</i>{{ $title }}
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
                                    <input type="checkbox" class="icheckblue" data-column="1" id="column1"> {{ trans('salesteam.salesteam') }}
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label for="column2" class="toggle-vis">
                                    <input type="checkbox" class="icheckblue" data-column="2" id="column2"> {{ trans('salesteam.invoice_target') }}
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label for="column3" class="toggle-vis">
                                    <input type="checkbox" class="icheckblue" data-column="3" id="column3"> {{ trans('salesteam.invoice_forecast') }}
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label for="column4" class="toggle-vis">
                                    <input type="checkbox" class="icheckblue" data-column="4" id="column4"> {{ trans('salesteam.actual_invoice') }}
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label for="column5" class="toggle-vis">
                                    <input type="checkbox" class="icheckblue" data-column="5" id="column5"> {{ trans('salesteam.team_leader') }}
                                </label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
             <div class="table-responsive">
            <table id="data" class="table table-bordered table-hover ">
                <thead>
                <tr>
                    <th>{{ trans('table.id') }}</th>
                    <th>{{ trans('salesteam.salesteam') }}</th>
                    <th>{{ trans('salesteam.invoice_target') }}</th>
                    <th>{{ trans('salesteam.invoice_forecast') }}</th>
                    <th>{{ trans('salesteam.actual_invoice') }}</th>
                    <th>{{ trans('salesteam.team_leader') }}</th>
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

        //invoice target by month
        var data1 = [
            ['Invoice Target','Actual Invoice'],
                @foreach($graphics as $item)
            [{{$item['invoice_target']}}, {{$item['actual_invoice']}}],
            @endforeach
        ];
        var chart1 = c3.generate({
            bindto: '#invoice_target_by_month',
            data: {
                rows: data1,
                type: 'bar'
            },
            color: {
                pattern: ['#3295ff','#fc4141']
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

        var data2 = [
            ['Sales Teams'],
                @foreach($graphics as $item)
            [{{$item['salesteams']}}],
            @endforeach
        ];
        var chart2 = c3.generate({
            bindto: '#salesteam_by_month',
            data: {
                rows: data2,
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
    <!-- Scripts -->
    @if(isset($type))
        <script type="text/javascript">
            var oTable;
            $(document).ready(function () {
                oTable = $('#data').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "order": [],
                    "columns":[
                        {"data":"id"},
                        {"data":"salesteam"},
                        {"data":"target"},
                        {"data":"invoice_forecast"},
                        {"data":"actual_invoice"},
                        {"data":"team_leader"},
                        {"data":"actions"},
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
        </script>
    @endif

@stop
