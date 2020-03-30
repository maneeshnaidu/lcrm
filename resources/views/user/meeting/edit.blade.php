@extends('layouts.user')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <div class="page-header clearfix">
    </div>
    <!-- ./ notifications -->
    @include('user/'.$type.'/_form')
    @if($orgRole=='admin')
        <div class="card">
            <div class="card-header bg-white">
                <h4>{{trans('profile.history')}}</h4>
            </div>
            <div class="card-body">
                <ul class="pl-0">
                    @foreach($meeting->revisionHistory as $history )
                        @if(isset($history->userResponsible()->first_name))
                            <li>{{ $history->userResponsible()->first_name }} changed
                                <strong>{{ $history->fieldName() }}</strong>
                                from {{ $history->oldValue() }} to {{ $history->newValue() }}</li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
@stop
