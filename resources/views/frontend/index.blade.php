@extends('layouts.frontend.user')
@section('styles')
    <style>

    </style>
@stop
@section('content')
    <div class="container-fluid home_slider_section">
        <div class="row">
            <div class="col-12 text-center home_slider_section_padd">
                <h1 class="text-white">{{ trans('frontend.welcome_to_lcrm_saas') }}</h1>
                <p class="text-white mt-4">{{ trans('frontend.run_your_own_crm_service') }}</p>
                <div class="mt-4">
                    <a href="#" class="btn btn_bordered_white text-uppercase">{{ trans('frontend.more_information') }}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="features_section m-b-30 m-t-30">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="section-heading text-center m-b-30 mt-3">
                                <h2>{{ trans('frontend.features_of_lcrm_saas') }}</h2>
                            </div>
                            <div class="section-heading text-center m-b-30">
                                <h2 class="heading mb-0">{{ trans('frontend.admin_features') }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 m-t-30">
                            <div class="awesome-feature one media">
                                <div class="awesome-feature-icon media-left">
                                    <img src="{{ asset('front/images/features/payplans.png') }}" alt="organization">
                                </div>
                                <div class="asesome-feature-details media-body">
                                    <h4>{{ trans('left_menu.payplans') }}</h4>
                                    <p class="text_light">
                                        {{ trans('frontend.payplans_feature_description') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 m-t-30">
                            <div class="awesome-feature two media">
                                <div class="awesome-feature-icon media-left">
                                    <img src="{{ asset('front/images/features/organization.png') }}" alt="organization">
                                </div>
                                <div class="asesome-feature-details media-body">
                                    <h4>{{ trans('left_menu.organizations') }}</h4>
                                    <p class="text_light">
                                        {{ trans('frontend.organizations_feature_description_one') }}
                                    </p>
                                    <p class="text_light">
                                        {{ trans('frontend.organizations_feature_description_two') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 m-t-30">
                            <div class="awesome-feature three media">
                                <div class="awesome-feature-icon media-left">
                                    <img src="{{ asset('front/images/features/subscriptions.png') }}" alt="organization">
                                </div>
                                <div class="asesome-feature-details media-body">
                                    <h4>{{ trans('left_menu.subscription') }}</h4>
                                    <p class="text_light">
                                        {{ trans('frontend.subscriptions_feature_description') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 m-t-30">
                            <div class="awesome-feature three media">
                                <div class="awesome-feature-icon media-left">
                                    <img src="{{ asset('front/images/features/support.png') }}" alt="organization">
                                </div>
                                <div class="asesome-feature-details media-body">
                                    <h4>{{ trans('left_menu.support') }}</h4>
                                    <p class="text_light">
                                        {{ trans('frontend.support_feature_description') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="section-heading text-center m-b-30 mt-3">
                                <h2 class="heading mb-0">{{ trans('frontend.organization_features') }}</h2>
                                <p class="mt-2 text_light heading_title">
                                    {{ trans('frontend.organization_features_title') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 m-t-30">
                            <div class="awesome-feature one media">
                                <div class="awesome-feature-icon media-left">
                                    <img src="{{ asset('front/images/features/staff.png') }}" alt="organization">
                                </div>
                                <div class="asesome-feature-details media-body">
                                    <h4>{{ trans('left_menu.staff') }}</h4>
                                    <p class="text_light">
                                        {{ trans('frontend.staff_feature_description') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 m-t-30">
                            <div class="awesome-feature two media">
                                <div class="awesome-feature-icon media-left">
                                    <img src="{{ asset('front/images/features/leads.png') }}" alt="organization">
                                </div>
                                <div class="asesome-feature-details media-body">
                                    <h4>{{ trans('left_menu.leads') }}</h4>
                                    <p class="text_light">
                                        {{ trans('frontend.leads_feature_description') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 m-t-30">
                            <div class="awesome-feature one media">
                                <div class="awesome-feature-icon media-left">
                                    <img src="{{ asset('front/images/features/salesteams.png') }}" alt="organization">
                                </div>
                                <div class="asesome-feature-details media-body">
                                    <h4>{{ trans('left_menu.salesteam') }}</h4>
                                    <p class="text_light">
                                        {{ trans('frontend.sales_team_feature_description') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 m-t-30">
                            <div class="awesome-feature one media">
                                <div class="awesome-feature-icon media-left">
                                    <img src="{{ asset('front/images/features/opportunities.png') }}" alt="organization">
                                </div>
                                <div class="asesome-feature-details media-body">
                                    <h4>{{ trans('left_menu.opportunities') }}</h4>
                                    <p class="text_light">
                                        {{ trans('frontend.opportunities_feature_description') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 m-t-30">
                            <div class="awesome-feature one media">
                                <div class="awesome-feature-icon media-left">
                                    <img src="{{ asset('front/images/features/quotations.png') }}" alt="organization">
                                </div>
                                <div class="asesome-feature-details media-body">
                                    <h4>{{ trans('left_menu.quotations') }}</h4>
                                    <p class="text_light">
                                        {{ trans('frontend.quotations_feature_description') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 m-t-30">
                            <div class="awesome-feature one media">
                                <div class="awesome-feature-icon media-left">
                                    <img src="{{ asset('front/images/features/sales_orders.png') }}" alt="organization">
                                </div>
                                <div class="asesome-feature-details media-body">
                                    <h4>{{ trans('left_menu.sales_order') }}</h4>
                                    <p class="text_light">
                                        {{ trans('frontend.sales_order_feature_description') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 m-t-30">
                            <div class="awesome-feature two media">
                                <div class="awesome-feature-icon media-left">
                                    <img src="{{ asset('front/images/features/invoice.png') }}" alt="organization">
                                </div>
                                <div class="asesome-feature-details media-body">
                                    <h4>{{ trans('left_menu.invoices') }}</h4>
                                    <p class="text_light">
                                        {{ trans('frontend.invoices_feature_description') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 m-t-30">
                            <div class="awesome-feature two media">
                                <div class="awesome-feature-icon media-left">
                                    <img src="{{ asset('front/images/features/calendar.png') }}" alt="organization">
                                </div>
                                <div class="asesome-feature-details media-body">
                                    <h4>{{ trans('left_menu.calendar') }}</h4>
                                    <p class="text_light">
                                        {{ trans('frontend.calendar_feature_description') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="section-heading text-center m-b-30 mt-3">
                                <h2 class="heading mb-0">{{ trans('frontend.customer_features') }}</h2>
                                <p class="mt-2 text_light heading_title">
                                    {{ trans('frontend.customer_features_title') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 m-t-30">
                            <div class="awesome-feature one media">
                                <div class="awesome-feature-icon media-left">
                                    <img src="{{ asset('front/images/features/cust_quotation.png') }}" alt="organization">
                                </div>
                                <div class="asesome-feature-details media-body">
                                    <h4>{{ trans('left_menu.quotations') }}</h4>
                                    <p class="text_light">
                                        {{ trans('frontend.customer_quotations_feature_description') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 m-t-30">
                            <div class="awesome-feature one media">
                                <div class="awesome-feature-icon media-left">
                                    <img src="{{ asset('front/images/features/cust_sales_order.png') }}" alt="organization">
                                </div>
                                <div class="asesome-feature-details media-body">
                                    <h4>{{ trans('left_menu.sales_order') }}</h4>
                                    <p class="text_light">
                                        {{ trans('frontend.customer_sales_order_feature_description') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 m-t-30">
                            <div class="awesome-feature two media">
                                <div class="awesome-feature-icon media-left">
                                    <img src="{{ asset('front/images/features/cust_invoice.png') }}" alt="organization">
                                </div>
                                <div class="asesome-feature-details media-body">
                                    <h4>{{ trans('left_menu.invoices') }}</h4>
                                    <p class="text_light">
                                        {{ trans('frontend.customer_invoices_feature_description') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 m-t-30">
                            <div class="awesome-feature two media">
                                <div class="awesome-feature-icon media-left">
                                    <img src="{{ asset('front/images/features/cust_email.png') }}" alt="organization">
                                </div>
                                <div class="asesome-feature-details media-body">
                                    <h4>{{ trans('frontend.email_communication') }}</h4>
                                    <p class="text_light">
                                        {{ trans('frontend.customer_email_communication_feature_description') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('scripts')
    <script src="{{ asset('front/vendors/isotope/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('front/vendors/imagesloaded/js/imagesloaded.pkgd.js') }}"></script>
    <script src="{{ asset('front/js/home.js') }}"></script>
    <script>
        new WOW().init();

    </script>
    @stop
