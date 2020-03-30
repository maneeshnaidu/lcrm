@extends('layouts.user')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-header clearfix">
            </div>
            <div class="details">
                @include('admin/'.$type.'/_details')
            </div>
        </div>
    </div>
    @if(isset($payments->data))
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <h4 class="float-left">{{ trans('payment.payments') }}</h4>
                </div>
                <div class="card-body">
                    <div class="column_dropdown payment_data pull-right m-b-15">
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                {{ trans('table.column_visibility') }} <span class="caret"></span></button>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <div class="checkbox">
                                        <label for="column1_0" class="toggle-vis">
                                            <input type="checkbox" class="icheckblue" data-column="0" id="column1_0"> {{ trans('payment.amount') }}
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="checkbox">
                                        <label for="column1_1" class="toggle-vis">
                                            <input type="checkbox" class="icheckblue" data-column="1" id="column1_1"> {{ trans('payment.id') }}
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="checkbox">
                                        <label for="column1_2" class="toggle-vis">
                                            <input type="checkbox" class="icheckblue" data-column="2" id="column1_2"> {{ trans('payment.name') }}
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="checkbox">
                                        <label for="column1_3" class="toggle-vis">
                                            <input type="checkbox" class="icheckblue" data-column="3" id="column1_3"> {{ trans('payment.date') }}
                                        </label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="payment_data" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>{{ trans('payment.amount') }}</th>
                                <th>{{ trans('payment.id') }}</th>
                                <th>{{ trans('payment.name') }}</th>
                                <th>{{ trans('payment.date') }}</th>
                            </tr>
                            </thead>
                            <tbody>

                                @foreach ($payments->data as $data)
                                    <tr>
                                        <td>
                                            {{ '$'.number_format(($data->amount/100),2).' USD' }}
                                        </td>
                                        <td>
                                            {{ $data->id }}
                                        </td>
                                        <td>
                                            {{ $data->source->name }}
                                        </td>
                                        <td>
                                            {{ date(config('settings.date_time_format'), $data->created) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if(isset($events->data))
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <h4 class="float-left">{{ trans('subscription.events') }}</h4>
                </div>
                <div class="card-body">
                    <div class="column_dropdown events_data pull-right m-b-15">
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                {{ trans('table.column_visibility') }} <span class="caret"></span></button>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <div class="checkbox">
                                        <label for="column2_0" class="toggle-vis">
                                            <input type="checkbox" class="icheckblue" data-column="0" id="column2_0"> {{ trans('subscription.event') }}
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="checkbox">
                                        <label for="column2_1" class="toggle-vis">
                                            <input type="checkbox" class="icheckblue" data-column="1" id="column2_1"> {{ trans('subscription.created') }}
                                        </label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="events_data" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>{{ trans('subscription.event') }}</th>
                                <th>{{ trans('subscription.created') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach(count($events->data) > 100 ? $events->autoPagingIterator(): $events->data as $event)
                                    @if(isset($event->data->object->customer) && $event->data->object->customer==$subscription_customerid || $event->data->object->id==$subscription_customerid)
                                        <tr>
                                            <td>
                                                @if($event->type=='customer.created')
                                                    {{ $subscription_customer->email.' is a new customer' }}
                                                @elseif($event->type=='customer.subscription.updated')
                                                    @if(isset($event->data->previous_attributes->plan))
                                                        {{ $subscription_customer->email.' upgraded to '.$event->data->object->plan->id.' from ' .$event->data->previous_attributes->plan->id}}
                                                    @elseif(isset($event->data->object->cancel_at_period_end) && $event->data->object->cancel_at_period_end=='true')
                                                        {{ $subscription_customer->email.'\'s subscription has been set to cancel at the end of billing period'}}
                                                    @else
                                                        {{ $subscription_customer->email.'\'s' }} subscription has changed
                                                    @endif

                                                @elseif($event->type=='customer.subscription.created')

                                                    {{ $subscription_customer->email.' subscribed to the '.$event->data->object->plan->id.' plan' }}

                                                @elseif($event->type=='customer.subscription.trial_will_end')
                                                    {{ $subscription_customer->email.'\'s trial on the '.$event->data->object->plan->id.' plan will end in few seconds'}}

                                                @elseif($event->type=='charge.succeeded')

                                                    {{ $subscription_customer->email }} was charged {{ '$'.number_format(($event->data->object->amount/100),2) }}

                                                @elseif($event->type=='invoice.payment_succeeded')

                                                    {{ $subscription_customer->email.'\'s invoice for $'.number_format(($event->data->object->amount_due/100),2).' was paid' }}

                                                @elseif($event->type=='invoice.created')

                                                    {{ $subscription_customer->email.' has a new invoice for $'.number_format(($event->data->object->amount_due/100),2) }}

                                                @elseif($event->type=='invoice.upcoming')

                                                    {{ $subscription_customer->email.' has an upcoming invoice scheduled for automatic payment in' }}
                                                    {{ ($event->data->object->period_end - $event->data->object->period_start)/86400 .' Days' }}

                                                @elseif($event->type=='customer.updated')
                                                    @if(isset($event->data->previous_attributes->default_source))
                                                        {{ $subscription_customer->email.'\'s details payment source changed' }}
                                                    @else
                                                        {{ $subscription_customer->email.'\'s details were updated' }}
                                                    @endif

                                                @elseif($event->type=='customer.source.created')

                                                    {{ $subscription_customer->email.' added a new '.$event->data->object->brand.' ending in '.$event->data->object->last4 }}

                                                @elseif($event->type=='invoiceitem.created')
                                                    @if($event->data->object->amount<0)
                                                        {{ 'A proration adjustment for was created for ($'.(-($event->data->object->amount/100)).') '. $subscription_customer->email}}
                                                        @else
                                                        {{ 'A proration adjustment for was created for ($'.($event->data->object->amount/100).') '. $subscription_customer->email}}
                                                        @endif

                                                @elseif($event->type=='invoiceitem.updated')

                                                    {{ $subscription_customer->email.'\'s invoice item was invoiced' }}

                                                @elseif($event->type=='invoice.updated')

                                                    {{ $subscription_customer->email.'\'s invoice has changed' }}

                                                @else

                                                @endif

                                            </td>
                                            <td>
                                                {{ date(config('settings.date_time_format'), $event->created) }}
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <?php
    function getCurrencySymbol($currencyCode, $locale = 'en_US')
    {
        $formatter = new \NumberFormatter($locale . '@currency=' . $currencyCode, \NumberFormatter::CURRENCY);
        return $formatter->getSymbol(\NumberFormatter::CURRENCY_SYMBOL);
    }
    ?>
    @if($organization->subscription_type=='paypal')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <h4>Transactions</h4>
                    </div>
                    <div class="card-body">
                        <div class="column_dropdown transactions_data pull-right m-b-15">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                    {{ trans('table.column_visibility') }} <span class="caret"></span></button>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <div class="checkbox">
                                            <label for="column3_0" class="toggle-vis">
                                                <input type="checkbox" class="icheckblue" data-column="0" id="column3_0"> {{ trans('subscription.date') }}
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox">
                                            <label for="column3_1" class="toggle-vis">
                                                <input type="checkbox" class="icheckblue" data-column="1" id="column3_1"> {{ trans('subscription.type') }}
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox">
                                            <label for="column3_2" class="toggle-vis">
                                                <input type="checkbox" class="icheckblue" data-column="2" id="column3_2"> {{ trans('subscription.sub_name') }}
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox">
                                            <label for="column3_3" class="toggle-vis">
                                                <input type="checkbox" class="icheckblue" data-column="3" id="column3_3"> {{ trans('subscription.payment') }}
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox">
                                            <label for="column3_4" class="toggle-vis">
                                                <input type="checkbox" class="icheckblue" data-column="4" id="column3_4"> {{ trans('subscription.gross') }}
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox">
                                            <label for="column3_5" class="toggle-vis">
                                                <input type="checkbox" class="icheckblue" data-column="5" id="column3_5"> {{ trans('subscription.fee') }}
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox">
                                            <label for="column3_6" class="toggle-vis">
                                                <input type="checkbox" class="icheckblue" data-column="6" id="column3_6"> {{ trans('subscription.net') }}
                                            </label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="transactions_data" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>{{ trans('subscription.date') }}</th>
                                    <th>{{ trans('subscription.type') }}</th>
                                    <th>{{ trans('subscription.sub_name') }}</th>
                                    <th>{{ trans('subscription.payment') }}</th>
                                    <th>{{ trans('subscription.gross') }}</th>
                                    <th>{{ trans('subscription.fee') }}</th>
                                    <th>{{ trans('subscription.net') }}</th>
                                    <th class="noExport">{{ trans('table.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($paypalTransactions))
                                    @foreach($paypalTransactions as $transaction)
                                        <tr>
                                            <td>{{ date(config('settings.date_time_format'),strtotime($transaction['ORDERTIME'])) }}</td>
                                            <td>
                                                @if($transaction['TRANSACTIONTYPE']=='recurring_payment')
                                                    Payment from
                                                @else
                                                    Recurring payment from
                                                @endif
                                            </td>
                                            <td>
                                                {{ $transaction['FIRSTNAME'].' '.$transaction['LASTNAME'] }}
                                            </td>
                                            <td>
                                                {{ $transaction['PAYMENTSTATUS'] }}
                                            </td>
                                            <td>
                                                <?php
                                                echo getCurrencySymbol($transaction['CURRENCYCODE']);
                                                ?>{{ $transaction['AMT'].' '.$transaction['CURRENCYCODE'] }}
                                            </td>
                                            <td>
                                                <?php
                                                echo getCurrencySymbol($transaction['CURRENCYCODE']);
                                                ?>{{ $transaction['FEEAMT'].' '.$transaction['CURRENCYCODE'] }}
                                            </td>
                                            <td>
                                                <?php
                                                echo getCurrencySymbol($transaction['CURRENCYCODE']);
                                                ?>{{ ($transaction['AMT'] - $transaction['FEEAMT']).' '.$transaction['CURRENCYCODE'] }}
                                            </td>
                                            <th>
                                                <a href="{{ url('organizations/activity/payment/'.$transaction['TRANSACTIONID']) }}">
                                                    <i class="fa fa-fw fa-eye text-primary"></i>
                                                </a>
                                            </th>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@stop
{{-- Scripts --}}
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            var payment_data = $('#payment_data').DataTable({
                "processing": true,
                "order": [],
                dom: 'Bfrtip',
                pageLength: 15,
                stateSave: true,
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
            payment_data.columns().every(function(id) {
                if(payment_data.column( id ).visible() === true){
                    $(".column_dropdown.payment_data .checkbox").find("input[data-column='"+id+"']").prop('checked',false);
                }else{
                    $(".column_dropdown.payment_data .checkbox").find("input[data-column='"+id+"']").prop('checked',true);
                }
            });

            $('body').on('ifChanged','.payment_data .checkbox', function(e) {
                e.preventDefault();
                // Get the column API object
                var column1 = payment_data.column($(this).find('input').attr('data-column'));
                // Toggle the visibility
                column1.visible(!column1.visible());
            });

            var events_data = $('#events_data').DataTable({
                "processing": true,
                "order": [],
                dom: 'Bfrtip',
                pageLength: 15,
                stateSave: true,
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
            events_data.columns().every(function(id) {
                if(events_data.column( id ).visible() === true){
                    $(".column_dropdown.events_data .checkbox").find("input[data-column='"+id+"']").prop('checked',false);
                }else{
                    $(".column_dropdown.events_data .checkbox").find("input[data-column='"+id+"']").prop('checked',true);
                }
            });

            $('body').on('ifChanged','.events_data .checkbox', function(e) {
                e.preventDefault();
                // Get the column API object
                var column2 = events_data.column($(this).find('input').attr('data-column'));
                // Toggle the visibility
                column2.visible(!column2.visible());
            });

            var transactions_data = $('#transactions_data').DataTable({
                "processing": true,
                "order": [],
                dom: 'Bfrtip',
                pageLength: 15,
                stateSave: true,
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
            transactions_data.columns().every(function(id) {
                if(transactions_data.column( id ).visible() === true){
                    $(".column_dropdown.transactions_data .checkbox").find("input[data-column='"+id+"']").prop('checked',false);
                }else{
                    $(".column_dropdown.transactions_data .checkbox").find("input[data-column='"+id+"']").prop('checked',true);
                }
            });

            $('body').on('ifChanged','.transactions_data .checkbox', function(e) {
                e.preventDefault();
                // Get the column API object
                var column3 = transactions_data.column($(this).find('input').attr('data-column'));
                // Toggle the visibility
                column3.visible(!column3.visible());
            });
            
            $(".icheckblue").iCheck({
                checkboxClass: 'icheckbox_minimal-blue'
            });
        });
    </script>
@stop