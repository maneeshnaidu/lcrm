@extends('layouts.frontend.user')
@section('styles')
@stop
@section('content')
    <div class="features_section m-b-30">
        <div class="container">
            <div class="card">
                <div class="card-body mt-3">
                    <div class="row">
                        <div class="col-12">
                            <div class="section-heading text-center">
                                <h2 class="heading">{{ trans('frontend.about_lcrm_saas') }}</h2>
                                <p class="mt-2 text_light">
                                    {{ trans('frontend.about_lcrm_saas_description') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="about-app mt-100">
                                <h3>{{ trans('frontend.take_a_look_around_our_app') }}</h3>
                                <h4>{{ trans('left_menu.organizations') }}</h4>
                                <p class="text_light">
                                    {{ trans('frontend.organizations_feature_description_one') }}
                                </p>
                                <h4>{{ trans('left_menu.subscription') }}</h4>
                                <p class="text_light">
                                    {{ trans('frontend.subscriptions_feature_description') }}
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-6 hidden-xs wow fadeIn">
                            <div class="about-app-mockup">
                                <img src="{{ asset('front/images/aboutus.png') }}" alt="" class="img-fluid">
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
