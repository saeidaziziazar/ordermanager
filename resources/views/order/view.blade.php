@extends('homepage')

@section('title')
    <h5 class="title">شماره حواله {{ $order->order_num }}</h5>
@endsection

@section('content')
    <div class="content">    
        <br>
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
                          <span class="input-group-text">کد پستی<span>
                        </div>
                        {!! Form::text('ordernum', $order->costumer->zip_code, ['class' => 'form-control', 'readonly']); !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
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
            <div class="col-6">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-append">
                          <span class="input-group-text">شماره همراه<span>
                        </div>
                            {!! Form::text('ordernum', $order->costumer->cell_phone_num, ['class' => 'form-control', 'readonly']); !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-append">
                  <span class="input-group-text">آدرس<span>
                </div>
                {!! Form::text('ordernum', $order->costumer->address, ['class' => 'form-control', 'readonly']); !!}
            </div>
        </div>
    </div>

@endsection