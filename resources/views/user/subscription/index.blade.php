@extends('layouts.user')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <div class="page-header clearfix">
        <div class="row">
            <div class="col-md-12">
                @include('flash::message')
            </div>
        </div>
        <div class="pull-right">
            @if ( isset($active_subscription->subscription_type) && $active_subscription->subscription_type=='stripe' && isset($organization->subscriptions) && $organization->subscriptions->count() != 0)
                <a href="{{url('update_card')}}" class="btn btn-warning m-b-10">{{trans('subscription.update_card')}}</a>
            @endif
        </div>
    </div>
    <div class="card">
        <div class="card-header bg-white">
            <h4 class="float-left">
                <i class="material-icons">flag</i>
                {{ $title }}
            </h4>
            <span class="pull-right">
                <i class="fa fa-fw fa-chevron-up clickable"></i>
                <i class="fa fa-fw fa-times removecard clickable"></i>
            </span>
        </div>
        <div class="card-body">
            <div class="alert alert-warning">
                @if(isset($active_subscription->subscription_type) && $active_subscription->subscription_type=='paypal')
                    If the amount of the plan you changed is 120% greater than the previous plan then new subscription will be created.
                @else
                    Changing plans will remove trial.
                @endif
            </div>
            <div class="table-responsive">
                <table id="data" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>{{ trans('payplan.name') }}</th>
                        <th>{{ trans('payplan.amount') }}</th>
                        <th>{{ trans('payplan.interval') }}</th>
                        <th>{{ trans('payplan.no_people') }}</th>
                        <th>{{ trans('payplan.description') }}</th>
                        <th class="noExport">{{ trans('table.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
{{--                    @if($settings['stripe_secret']!="" && $settings['stripe_publishable']!="")--}}
                        <tr>
                            <td>{{$active_plan->name}}</td>
                            <td>{{$active_plan->amount/100}} {!! $active_plan->currency !!}</td>
                            <td>
                                {{ ($active_plan->interval_count==1?$active_plan->interval_count.' '.$active_plan->interval:$active_plan->interval_count.' '.$active_plan->interval.'s') }}
                            </td>
                            <td>{{$active_plan->no_people}}</td>
                            <td>{{$active_plan->statement_descriptor}}</td>
                            <td>
                                @if(isset($active_subscription))
                                    @if($active_subscription->subscription_type=='paypal')
                                        @if($active_subscription->status!=='Canceled')
                                            {!! Form::open(['url' => $type.'/'.$active_plan->id.'/cancel', 'method' => 'post']) !!}
                                            <button type="submit" class="btn btn-danger m-b-10">
                                                <i class="fa fa-trash"></i> Cancel
                                            </button>
                                            {!! Form::close() !!}
                                            {!! Form::open(['url' => $type.'/'.$active_plan->id.'/suspend', 'method' => 'post']) !!}
                                            <button type="submit" class="btn btn-primary m-b-10">
                                                <i class="fa fa-ban"></i> Suspend
                                            </button>
                                            {!! Form::close() !!}
                                        @endif
                                    @else
                                        @if(isset($active_subscription->ends_at))
                                            {!! Form::open(['url' => $type.'/'.$active_plan->id.'/resume', 'method' => 'post']) !!}
                                            <button type="submit" class="btn btn-success m-b-10"><i
                                                        class="fa fa-undo"></i> {{trans('subscription.resume')}}</button>
                                            {!! Form::close() !!}
                                        @else
                                            {!! Form::open(['url' => $type.'/'.$active_plan->id.'/cancel', 'method' => 'post']) !!}
                                            <button type="submit" class="btn btn-danger m-b-10">
                                                    <i class="fa fa-trash"></i>
                                                    {{trans('subscription.cancel')}}
                                            </button>
                                            {!! Form::close() !!}
                                        @endif
                                    @endif
                                    <a href="{{url($type.'/change')}}" class="btn btn-warning m-b-10"><i
                                                class="fa fa-edit"></i> {{trans('subscription.change')}}</a>
                                @else
                                    <a href="{{url($type.'/change_generic_plan')}}" class="btn btn-warning m-b-10"><i
                                                class="fa fa-edit"></i> {{trans('subscription.change')}}</a>
                                @endif
                            </td>
                        </tr>
                    {{--@endif--}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @if(isset($subscriptions->data))
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <h4 class="float-left">{{ trans('subscription.invoices') }}</h4>
                </div>
                <div class="card-body">
                    <div class="column_dropdown invoice_data pull-right m-b-15">
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                {{ trans('table.column_visibility') }} <span class="caret"></span></button>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <div class="checkbox">
                                        <label for="column1_0" class="toggle-vis">
                                            <input type="checkbox" class="icheckblue" data-column="0" id="column1_0"> {{ trans('subscription.amount') }}
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="checkbox">
                                        <label for="column1_1" class="toggle-vis">
                                            <input type="checkbox" class="icheckblue" data-column="1" id="column1_1"> {{ trans('subscription.status') }}
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="checkbox">
                                        <label for="column1_2" class="toggle-vis">
                                            <input type="checkbox" class="icheckblue" data-column="2" id="column1_2"> {{ trans('subscription.billing') }}
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="checkbox">
                                        <label for="column1_3" class="toggle-vis">
                                            <input type="checkbox" class="icheckblue" data-column="3" id="column1_3"> {{ trans('subscription.customer') }}
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="checkbox">
                                        <label for="column1_4" class="toggle-vis">
                                            <input type="checkbox" class="icheckblue" data-column="4" id="column1_4"> {{ trans('subscription.subscription_id') }}
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="checkbox">
                                        <label for="column1_5" class="toggle-vis">
                                            <input type="checkbox" class="icheckblue" data-column="5" id="column1_5"> {{ trans('subscription.invoice_number') }}
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="checkbox">
                                        <label for="column1_6" class="toggle-vis">
                                            <input type="checkbox" class="icheckblue" data-column="6" id="column1_6"> {{ trans('subscription.created') }}
                                        </label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="invoice_data" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>{{ trans('subscription.amount') }}</th>
                                <th>{{ trans('subscription.status') }}</th>
                                <th>{{ trans('subscription.billing') }}</th>
                                <th>{{ trans('subscription.customer') }}</th>
                                <th>{{ trans('subscription.subscription_id') }}</th>
                                <th>{{ trans('subscription.invoice_number') }}</th>
                                <th>{{ trans('subscription.created') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach (count($subscriptions->data) > 100 ? $subscriptions->autoPagingIterator() : $subscriptions->data as $data)
                                    <tr>
                                        <td>
                                            {{ '$'.number_format(($data->total/100),2).' USD' }}
                                        </td>
                                        <td>
                                            @if(isset($data->paid))
                                                {{ trans('subscription.paid') }}
                                            @else
                                                {{ trans('subscription.not_paid') }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($data->billing==='charge_automatically')
                                                {{ trans('subscription.auto') }}
                                            @endif
                                        </td>
                                        <td>
                                            {{ $subscription_customer->email }}
                                        </td>
                                        <td>
                                            {{ $active_subscription->stripe_id }}
                                        </td>
                                        <td>
                                            {{ $data->number }}
                                        </td>
                                        <td>
                                            {{ date(config('settings.date_time_format'), $data->date) }}
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
    @if(isset($active_subscription->subscription_type) && $active_subscription->subscription_type=='paypal')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <h4>{{ trans('subscription.recurring_payment_details') }}</h4>
                    </div>
                    <div class="card-body">
                        <div>
                            <strong>{{ trans('subscription.status') }}:</strong>
                            <span class="text-success">
                                {{ $recurring_payment_details['STATUS'] }}
                            </span>
                        </div>
                        <div>
                            {{ trans('subscription.customer') }} <strong>{{ $recurring_payment_details['SUBSCRIBERNAME'] }}</strong>
                        </div>
                        <div>
                            {{ trans('subscription.profile_start_date') }} <strong>{{ date( config('settings.date_time_format'),strtotime($recurring_payment_details['PROFILESTARTDATE'])) }}</strong>
                        </div>
                        <h5 class="m-t-20">{{ trans('subscription.payment_details') }}</h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>
                                        {{ trans('subscription.payment_type') }}
                                    </th>
                                    <th>
                                        {{ trans('subscription.Amount due each cycle') }}
                                    </th>
                                    <th>
                                        {{ trans('subscription.total_cycles') }}
                                    </th>
                                    <th>
                                        {{ trans('subscription.remaining_cycles') }}
                                    </th>
                                    <th>
                                        {{ trans('subscription.cycle_frequency') }}
                                    </th>
                                    <th>
                                        {{ trans('subscription.amount_received') }}
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ trans('subscription.initial_payment') }}</td>
                                    <td>
                                        <?php
                                        echo getCurrencySymbol($recurring_payment_details['CURRENCYCODE']);
                                        ?>{{ $recurring_payment_details['OUTSTANDINGBALANCE'].' '.$recurring_payment_details['CURRENCYCODE'] }}
                                    </td>
                                    <td>--</td>
                                    <td>--</td>
                                    <td>--</td>
                                    <td>
                                        <?php
                                        echo getCurrencySymbol($recurring_payment_details['CURRENCYCODE']);
                                        ?>{{ $recurring_payment_details['OUTSTANDINGBALANCE'].' '.$recurring_payment_details['CURRENCYCODE'] }}
                                    </td>
                                </tr>
                                @if(isset($recurring_payment_details['TRIALBILLINGPERIOD']))
                                    <tr>
                                        <td>
                                            {{ trans('subscription.trial_period') }}
                                        </td>
                                        <td>
                                            <?php
                                            echo getCurrencySymbol($recurring_payment_details['CURRENCYCODE']);
                                            ?>{{ $recurring_payment_details['TRIALAMT'].' '.$recurring_payment_details['CURRENCYCODE'] }}
                                        </td>
                                        <td>
                                            {{ $recurring_payment_details['TRIALTOTALBILLINGCYCLES'] }}
                                        </td>
                                        <td>
                                            0
                                        </td>
                                        <td>
                                            @if($recurring_payment_details['TRIALBILLINGFREQUENCY']==1)
                                                @if($recurring_payment_details['TRIALBILLINGPERIOD']=='Day')
                                                    {{ trans('subscription.daily') }}
                                                @else
                                                    {{ $recurring_payment_details['TRIALBILLINGPERIOD'].'ly' }}
                                                @endif
                                            @else
                                                {{ 'Every '.$recurring_payment_details['TRIALBILLINGFREQUENCY'].' '.$recurring_payment_details['TRIALBILLINGPERIOD'].'s' }}
                                            @endif
                                        </td>
                                        <td>
                                            <?php
                                            echo getCurrencySymbol($recurring_payment_details['CURRENCYCODE']);
                                            ?>{{ $recurring_payment_details['TRIALAMT'].' '.$recurring_payment_details['CURRENCYCODE'] }}
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td>
                                        {{ trans('subscription.regular_recurring_payment') }}
                                    </td>
                                    <td>
                                        <?php
                                        echo getCurrencySymbol($recurring_payment_details['CURRENCYCODE']);
                                        ?>{{ $recurring_payment_details['REGULARAMT'].' '.$recurring_payment_details['CURRENCYCODE'] }}
                                    </td>
                                    <td>
                                        {{ trans('subscription.indefinite') }}
                                    </td>
                                    <td>
                                        {{ trans('subscription.indefinite') }}
                                    </td>
                                    <td>
                                        @if($recurring_payment_details['REGULARBILLINGFREQUENCY']==1)
                                            @if($recurring_payment_details['REGULARBILLINGPERIOD']=='Day')
                                                {{ trans('subscription.daily') }}
                                            @else
                                                {{ $recurring_payment_details['REGULARBILLINGPERIOD'].'ly' }}
                                            @endif
                                        @else
                                            {{ 'Every '.$recurring_payment_details['REGULARBILLINGFREQUENCY'].' '.$recurring_payment_details['REGULARBILLINGPERIOD'].'s' }}
                                        @endif
                                    </td>
                                    <td>
                                        <?php
                                        echo getCurrencySymbol($recurring_payment_details['CURRENCYCODE']);
                                        ?>
                                        {{ $recurring_payment_details['REGULARAMTPAID'].' '.$recurring_payment_details['CURRENCYCODE'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right">
                                        <strong>Total</strong>
                                    </td>
                                    <td>
                                        <?php
                                        echo getCurrencySymbol($recurring_payment_details['CURRENCYCODE']);
                                        ?>{{ $recurring_payment_details['AGGREGATEAMT'].' '.$recurring_payment_details['CURRENCYCODE'] }}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <h5 class="m-t-30">{{ trans('subscription.billing_details') }}</h5>
                        <div class="row">
                            <div class="col-12">

                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <th class="text-right">{{ trans('subscription.item_name') }}</th>
                                        <td>{{ $recurring_payment_details['DESC'] }}</td>
                                    </tr>
                                    @if(isset($recurring_payment_details['NEXTBILLINGDATE']))
                                    <tr>
                                        <th class="text-right">{{ trans('subscription.next_payment_due') }}</th>
                                        <td>{{ date( config('settings.date_time_format'),strtotime($recurring_payment_details['NEXTBILLINGDATE'])) }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <th class="text-right">Last payment due</th>
                                        <td>
                                            @if($recurring_payment_details['STATUS']=='Cancelled')
                                                {{ date( config('settings.date_time_format'),strtotime($recurring_payment_details['PROFILESTARTDATE'])) }}
                                            @elseif($recurring_payment_details['STATUS']=='Suspended')
                                                {{ trans('subscription.no_end_date') }}
                                            @else
                                                {{ trans('subscription.indefinite_continue_until_canceled') }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-right">{{ trans('subscription.add_payments_that_failed_to_next_bill') }}</th>
                                        <td>No</td>
                                    </tr>
                                    <tr>
                                        <th class="text-right">{{ trans('subscription.this_profile_will_be_suspended_after') }}</th>
                                        <td>{{ trans('subscription.no_limit_failure') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <h4>{{ trans('subscription.transactions') }}</h4>
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
                                            <a href="{{ url('activity/payment/'.$transaction['TRANSACTIONID']) }}">
                                                <i class="fa fa-fw fa-eye text-primary"></i>
                                            </a>
                                        </th>
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
@stop
{{-- Scripts --}}
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            var invoice_data = $('#invoice_data').DataTable({
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
            invoice_data.columns().every(function(id) {
                if(invoice_data.column( id ).visible() === true){
                    $(".column_dropdown.invoice_data .checkbox").find("input[data-column='"+id+"']").prop('checked',false);
                }else{
                    $(".column_dropdown.invoice_data .checkbox").find("input[data-column='"+id+"']").prop('checked',true);
                }
            });

            $('body').on('ifChanged','.invoice_data .checkbox', function(e) {
                e.preventDefault();
                // Get the column API object
                var column1 = invoice_data.column($(this).find('input').attr('data-column'));
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
