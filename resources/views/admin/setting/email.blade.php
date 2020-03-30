<div class="tab-pane" id="email_configuration">
    <div class="form-group required {{ $errors->has('email_driver') ? 'has-error' : '' }}">
        {!! Form::label('email_driver', trans('settings.email_driver'), ['class' => 'control-label required']) !!}
        <div class="controls">
            <div class="form-inline">
                <div class="radio">
                    <div class="form-inline">
                        {!! Form::radio('email_driver', 'smtp', (isset($settings['email_driver'])&&$settings['email_driver']=='smtp')?true:false,['id'=>'smtp','class' => 'email_driver icheck'])  !!}
                        {!! Form::label('false', 'SMTP',['class'=>'ml-1 mr-2']) !!}
                    </div>
                </div>
                <div class="radio">
                    <div class="form-inline">
                        {!! Form::radio('email_driver', 'ses', (isset($settings['email_driver'])&&$settings['email_driver']=='ses')?true:false,['id'=>'ses','class' => 'email_driver icheck'])  !!}
                        {!! Form::label('false', 'SES',['class'=>'ml-1 mr-2']) !!}
                    </div>
                </div>
                <div class="radio">
                    <div class="form-inline">
                        {!! Form::radio('email_driver', 'mailgun', (isset($settings['email_driver'])&&$settings['email_driver']=='mailgun')?true:false,['id'=>'mailgun','class' => 'email_driver icheck'])  !!}
                        {!! Form::label('false', 'Mailgun',['class'=>'ml-1']) !!}
                    </div>
                </div>
            </div>
            <span class="help-block">{{ $errors->first('email_driver', ':message') }}</span>
        </div>
    </div>
    <div class="smtp">
        <div class="alert alert-warning">
            {{ trans('settings.mailtrap_gmail_elasticemail') }}
        </div>
        <div class="form-group required {{ $errors->has('email_host') ? 'has-error' : '' }}">
            {!! Form::label('email_host', trans('settings.email_host'), ['class' => 'control-label']) !!}
            <div class="controls">
                {!! Form::input('text','email_host', old('email_host', isset($settings['email_host'])?$settings['email_host']:''), ['class' => 'form-control']) !!}
                <span class="help-block">{{ $errors->first('email_host', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('email_port') ? 'has-error' : '' }}">
            {!! Form::label('email_port', trans('settings.email_port'), ['class' => 'control-label']) !!}
            <div class="controls">
                {!! Form::input('text','email_port', old('email_port', isset($settings['email_port'])?$settings['email_port']:''), ['class' => 'form-control']) !!}
                <span class="help-block">{{ $errors->first('email_port', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('email_username') ? 'has-error' : '' }}">
            {!! Form::label('email_username', trans('settings.email_username'), ['class' => 'control-label']) !!}
            <div class="controls">
                {!! Form::input('text','email_username', old('email_username', isset($settings['email_username'])?$settings['email_username']:''), ['class' => 'form-control']) !!}
                <span class="help-block">{{ $errors->first('email_username', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('email_password') ? 'has-error' : '' }}">
            {!! Form::label('email_password', trans('settings.email_password'), ['class' => 'control-label']) !!}
            <div class="controls">
                {!! Form::input('text','email_password', old('email_password', isset($settings['email_password'])?$settings['email_password']:''), ['class' => 'form-control']) !!}
                <span class="help-block">{{ $errors->first('email_password', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('mail_encryption') ? 'has-error' : '' }}">
            {!! Form::label('mail_encryption', trans('settings.mail_encryption'), ['class' => 'control-label']) !!}
            <div class="controls">
                {!! Form::input('text','mail_encryption', old('mail_encryption', isset($settings['mail_encryption'])?$settings['mail_encryption']:''), ['class' => 'form-control']) !!}
                <span class="help-block">{{ $errors->first('mail_encryption', ':message') }}</span>
            </div>
        </div>
    </div>
    <div class="ses_section">
        <div class="form-group required {{ $errors->has('ses_key') ? 'has-error' : '' }}">
            {!! Form::label('ses_key', trans('settings.ses_key'), ['class' => 'control-label']) !!}
            <div class="controls">
                {!! Form::input('text','ses_key', old('ses_key', isset($settings['ses_key'])?$settings['ses_key']:''), ['class' => 'form-control']) !!}
                <span class="help-block">{{ $errors->first('ses_key', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('ses_secret') ? 'has-error' : '' }}">
            {!! Form::label('ses_secret', trans('settings.ses_secret'), ['class' => 'control-label']) !!}
            <div class="controls">
                {!! Form::input('text','ses_secret', old('ses_secret', isset($settings['ses_secret'])?$settings['ses_secret']:''), ['class' => 'form-control']) !!}
                <span class="help-block">{{ $errors->first('ses_secret', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('ses_region') ? 'has-error' : '' }}">
            {!! Form::label('ses_region', trans('settings.ses_region'), ['class' => 'control-label']) !!}
            <div class="controls">
                {!! Form::input('text','ses_region', old('ses_region', isset($settings['ses_region'])?$settings['ses_region']:''), ['class' => 'form-control']) !!}
                <span class="help-block">{{ $errors->first('ses_region', ':message') }}</span>
            </div>
        </div>
    </div>
    <div class="mailgun_section">
        <div class="form-group required {{ $errors->has('mailgun_domain') ? 'has-error' : '' }}">
            {!! Form::label('mailgun_domain', trans('settings.mailgun_domain'), ['class' => 'control-label']) !!}
            <div class="controls">
                {!! Form::input('text','mailgun_domain', old('mailgun_domain', isset($settings['mailgun_domain'])?$settings['mailgun_domain']:''), ['class' => 'form-control']) !!}
                <span class="help-block">{{ $errors->first('mailgun_domain', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('mailgun_secret') ? 'has-error' : '' }}">
            {!! Form::label('mailgun_secret', trans('settings.mailgun_secret'), ['class' => 'control-label']) !!}
            <div class="controls">
                {!! Form::input('text','mailgun_secret', old('mailgun_secret', isset($settings['mailgun_secret'])?$settings['mailgun_secret']:''), ['class' => 'form-control']) !!}
                <span class="help-block">{{ $errors->first('mailgun_secret', ':message') }}</span>
            </div>
        </div>
    </div>
</div>
@section('scripts')
    <script>
        $(document).ready(function($) {
            $(".select2").select2({
                theme:"bootstrap"
            });
            $('.icheck').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            });

            $("#smtp").on("ifChecked",function(){
                $('.smtp').show();
            });
            $("#smtp").on("ifUnchecked",function(){
                $(".smtp").hide();
            });
            if($("#smtp").closest(".iradio_minimal-blue").hasClass("checked")){
                $('.smtp').show();
            }else{
                $('.smtp').hide();
            }

//            ses
            $("#ses").on("ifChecked",function(){
                $('.ses_section').show();
            });
            $("#ses").on("ifUnchecked",function(){
                $(".ses_section").hide();
            });
            if($("#ses").closest(".iradio_minimal-blue").hasClass("checked")){
                $(".ses_section").show();
            }else{
                $(".ses_section").hide();
            }

            //            mailgun
            $("#mailgun").on("ifChecked",function(){
                $('.mailgun_section').show();
            });
            $("#mailgun").on("ifUnchecked",function(){
                $(".mailgun_section").hide();
            });
            if($("#mailgun").closest(".iradio_minimal-blue").hasClass("checked")){
                $(".mailgun_section").show();
            }else{
                $(".mailgun_section").hide();
            }

            $("input[name='date_format']").on('ifChecked', function () {
                if ("date_format_custom_radio" != $(this).attr("id"))
                    $("input[name='date_format_custom']").val($(this).val()).siblings('.example').text($(this).siblings('span').text());
            });
            $("input[name='date_format_custom']").focus(function () {
                $("#date_format_custom_radio").attr("checked", "checked");
            });

            $("input[name='time_format']").on('ifChecked', function () {
                if ("time_format_custom_radio" != $(this).attr("id"))
                    $("input[name='time_format_custom']").val($(this).val()).siblings('.example').text($(this).siblings('span').text());
            });
            $("input[name='time_format_custom']").focus(function () {
                $("#time_format_custom_radio").attr("checked", "checked");
            });
            $("input[name='date_format_custom'], input[name='time_format_custom']").on('ifChecked', function () {
                var format = $(this);
                format.siblings('img').css('visibility', 'visible');
                $.post(ajaxurl, {
                    action: 'date_format_custom' == format.attr('name') ? 'date_format' : 'time_format',
                    date: format.val()
                }, function (d) {
                    format.siblings('img').css('visibility', 'hidden');
                    format.siblings('.example').text(d);
                });
            });
            $(".paypal_live,.paypal_sandbox").hide();
            if('{{ isset($settings['paypal_mode']) && !empty($settings['paypal_mode']) }}'){
                if('{{ isset($settings['paypal_mode']) && $settings['paypal_mode']=='sandbox' }}'){
                    $(".paypal_sandbox").show();
                }else{
                    $(".paypal_live").show();
                }
            }
            if('{{ old('paypal_mode')=='sandbox' }}'){
                $(".paypal_sandbox").show();
                $(".paypal_live").hide();
            }
            if('{{ old('paypal_mode')=='live' }}'){
                $(".paypal_sandbox").hide();
                $(".paypal_live").show();
            }
            $(".sandbox").on("ifChecked",function(){
                $(".paypal_sandbox").show();
                $(".paypal_live").hide();
            });
            $(".sandbox").on("ifUnchecked",function(){
                $(".paypal_sandbox").hide();
                $(".paypal_live").show();
            });
        });
    </script>
@stop
