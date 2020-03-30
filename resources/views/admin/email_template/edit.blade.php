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
    @include('admin/'.$type.'/_form')
    @if($user=='admin')
        <fieldset>
            <legend>{{trans('profile.history')}}</legend>
            <ul>
                @foreach($emailTemplate->revisionHistory as $history )
                    @if(isset($history->userResponsible()->first_name))
                        <li>{{ $history->userResponsible()->first_name }} changed
                            <strong>{{ $history->fieldName() }}</strong>
                            from {{ $history->oldValue() }} to {{ $history->newValue() }}</li>
                    @endif
                @endforeach
            </ul>
        </fieldset>
    @endif
@stop
