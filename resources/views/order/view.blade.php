@extends('homepage')

@section('content')
    <div class="content">    
        <br>
        <h6>اطلاعات حواله</h6>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-append">
                          <span class="input-group-text">شماره حواله<span>
                        </div>
                        {!! Form::text('ordernum', $order->order_num, ['class' => 'form-control', 'readonly']); !!}
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-append">
                          <span class="input-group-text">تاریخ حواله<span>
                        </div>
                        {!! Form::text('ordernum', $date, ['class' => 'form-control', 'readonly']); !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-append">
                          <span class="input-group-text">باربری<span>
                        </div>
                        {!! Form::text('ordernum', $order->transportation->name, ['class' => 'form-control', 'readonly']); !!}
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-append">
                          <span class="input-group-text">مقدار حواله<span>
                        </div>
                        {!! Form::text('ordernum', $order->amount, ['class' => 'form-control', 'readonly']); !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-append">
                          <span class="input-group-text">توضیحات<span>
                        </div>
                        {!! Form::text('ordernum', $order->description, ['class' => 'form-control', 'readonly']); !!}
                    </div>
                </div>
            </div>
        </div>
        <h6>اطلاعات فرستنده</h6>
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-append">
                  <span class="input-group-text">شرکت | شخص<span>
                </div>
                {!! Form::text('ordernum', $order->owner->name, ['class' => 'form-control', 'readonly']); !!}
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-append">
                          <span class="input-group-text">شناسه ملی<span>
                        </div>
                        {!! Form::text('ordernum', $order->owner->national_id, ['class' => 'form-control', 'readonly']); !!}
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-append">
                          <span class="input-group-text">کد پستی<span>
                        </div>
                        {!! Form::text('ordernum', $order->owner->zip_code, ['class' => 'form-control', 'readonly']); !!}
                    </div>
                </div>
            </div>
        </div>
        <br>
        <h6>اطلاعات گیرنده</h6>
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-append">
                  <span class="input-group-text">شرکت | شخص<span>
                </div>
                {!! Form::text('ordernum', $order->costumer->first_name . " " . $order->costumer->last_name, ['class' => 'form-control', 'readonly']); !!}
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-append">
                          <span class="input-group-text">شناسه ملی<span>
                        </div>
                        {!! Form::text('ordernum', $order->costumer->national_code, ['class' => 'form-control', 'readonly']); !!}
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-append">
                          <span class="input-group-text">شماره تماس<span>
                        </div>
                        {!! Form::text('ordernum', $order->costumer->phone_num, ['class' => 'form-control', 'readonly']); !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-append">
                <span class="input-group-text">آدرس<span>
                </div>
                {!! Form::text('ordernum', $order->address->address, ['class' => 'form-control', 'readonly']); !!}
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-append">
                          <span class="input-group-text">کد پستی<span>
                        </div>
                        {!! Form::text('ordernum', $order->address->zip_code, ['class' => 'form-control', 'readonly']); !!}
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-append">
                          <span class="input-group-text">شماره همراه<span>
                        </div>
                            {!! Form::text('ordernum', $order->address->phone_number, ['class' => 'form-control', 'readonly']); !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection