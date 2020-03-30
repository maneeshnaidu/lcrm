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
                    <h4>{{ trans('invoice.invoice_details_for_current_month') }}</h4>
                </div>
                <div class="card-body">
                    <div id="invoice-chart" style="width:100%; height:300px;"></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-6">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4>{{trans('invoice.invoices_total')}}</h4>
                        </div>
                        <div class="card-body">
                            <h5 class="number c-red">{{$organizationSettings['currency'] ?? null}} {{ $invoices_total_collection}} </h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-warning text-white">
                            <h4>{{trans('invoice.open_invoice')}}</h4>
                        </div>
                        <div class="card-body">
                            <h5 class="number c-green">{{$organizationSettings['currency'] ?? null}} {{$open_invoice_total}} </h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-danger text-white">
                            <h4>{{trans('invoice.overdue_invoice')}}</h4>
                        </div>
                        <div class="card-body">
                            <h5 class="number c-green">{{$organizationSettings['currency'] ?? null}} {{$overdue_invoices_total}} </h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h4>{{trans('invoice.paid_invoice')}}</h4>
                        </div>
                        <div class="card-body">
                            <h5 class="number c-green">{{$organizationSettings['currency'] ?? null}} {{$paid_invoices_total}} </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header bg-white">
            <h4 class="float-left">
                <i class="material-icons">web</i>
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
                                    <input type="checkbox" class="icheckblue" data-column="1" id="column1"> {{ trans('invoice.invoice_number') }}
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label for="column2" class="toggle-vis">
                                    <input type="checkbox" class="icheckblue" data-column="2" id="column2"> {{ trans('invoice.company_id') }}
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label for="column3" class="toggle-vis">
                                    <input type="checkbox" class="icheckblue" data-column="3" id="column3"> {{ trans('invoice.sales_team_id') }}
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label for="column4" class="toggle-vis">
                                    <input type="checkbox" class="icheckblue" data-column="4" id="column4"> {{ trans('invoice.invoice_date') }}
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label for="column5" class="toggle-vis">
                                    <input type="checkbox" class="icheckblue" data-column="5" id="column5"> {{ trans('invoice.due_date') }}
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label for="column6" class="toggle-vis">
                                    <input type="checkbox" class="icheckblue" data-column="6" id="column6"> {{ trans('invoice.total') }}
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label for="column7" class="toggle-vis">
                                    <input type="checkbox" class="icheckblue" data-column="7" id="column7"> {{ trans('invoice.unpaid_amount') }}
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label for="column8" class="toggle-vis">
                                    <input type="checkbox" class="icheckblue" data-column="8" id="column8"> {{ trans('invoice.payment_term') }}
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label for="column9" class="toggle-vis">
                                    <input type="checkbox" class="icheckblue" data-column="9" id="column9"> {{ trans('invoice.status') }}
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
                        <th>{{ trans('invoice.invoice_number') }}</th>
                        <th>{{ trans('invoice.company_id') }}</th>
                        <th>{{ trans('invoice.sales_team_id') }}</th>
                        <th>{{ trans('invoice.invoice_date') }}</th>
                        <th>{{ trans('invoice.due_date') }}</th>
                        <th>{{ trans('invoice.total') }}</th>
                        <th>{{ trans('invoice.unpaid_amount') }}</th>
                        <th>{{ trans('invoice.payment_term') }}</th>
                        <th>{{ trans('invoice.status') }}</th>
                        <th class="noExport">{{ trans('invoice.expired') }}</th>
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

        /*invoice chart*/

        var chart = c3.generate({
            bindto: '#invoice-chart',
            data: {
                columns: [
                    ['Open invoice', {{$open_invoice_total}}],
                    ['Overdue invoice', {{$overdue_invoices_total}}],
                    ['Paid invoice', {{$paid_invoices_total}}]
                ],
                type : 'donut',
                colors: {
                    'Open invoice': '#3295ff',
                    'Overdue invoice': '#fc4141',
                    'Paid invoice': '#A0D468'
                }
            }
        });
        setTimeout(function () {
            chart.resize()
        }, 500);
        //c3 customisation

        /* invoice chart end*/
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
                        {"data":"invoice_number"},
                        {"data":"company_id"},
                        {"data":"sales_team_id"},
                        {"data":"invoice_date"},
                        {"data":"due_date"},
                        {"data":"final_price"},
                        {"data":"unpaid_amount"},
                        {"data":"payment_term"},
                        {"data":"status"},
                        {"data":"expired"},
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
