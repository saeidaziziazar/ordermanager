@extends('homepage')

@section('content')
<script src="{{ asset('datepicker/persianDatepicker.min.js') }}"></script>
    <div class="content">
        <h5>ویرایش حواله</h5>

        @if(count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
        @endif
        
        {!! Form::open(['action' => ['OrderController@update', $order->id], 'method' => 'POST', 'autocomplete' => 'off']) !!}
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">مالک<span>
                    </div>
                    {!! Form::select('owner', $owners, $order->owner->id , ['class' => 'custom-select']); !!}
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">شماره حواله<span>
                    </div>
                    {!! Form::text('ordernum', $order->order_num, ['class' => 'form-control', 'id' => 'test']); !!}
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">مشتری<span>
                    </div>
                    {!! Form::hidden('costumer_id', $order->costumer->id) !!}
                    {!! Form::text('costumer_name', $order->costumer->first_name . " " . $order->costumer->last_name, ['class' => 'form-control', 'readonly']); !!}
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">آدرس<span>
                    </div>
                    {!! Form::select('address', $addresses, $order->address_id, ['class' => ['form-control'], 'size' => 4]); !!}
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">باربری<span>
                    </div>
                    {!! Form::select('transport', $trans, $order->transportation->id , ['class' => 'custom-select']); !!}
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">تاریخ<span>
                    </div>
                    {!! Form::text('date', $order->date, ['class' => 'form-control', 'id' => 'date']); !!}
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">مقدار<span>
                    </div>
                    {!! Form::text('amount', $order->amount, ['class' => 'form-control', 'autocomplete' => 'off']); !!}
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">توضیحات<span>
                    </div>
                    {!! Form::text('description', $order->description, ['class' => 'form-control']); !!}
                </div>
            </div>
            {!! Form::hidden('confirmed', $order->is_viewed) !!}
            {!! Form::hidden('_method', 'PUT') !!}
            <div class="form-group">
                {!! Form::submit('ذخیره', ['class' => 'btn btn-primary']); !!}
            </div>
        {!! Form::close() !!}

    </div>
@endsection

@section('scripts')
<script type="text/javascript">
    $("#date").persianDatepicker({
        cellWidth: 35,
        cellHeight: 35,
        fontSize: 14,
        formatDate: "YYYY/0M/0D",
        // selectedBefore: !0,
        calendarPosition: {
            x: 380,
            y: 0,
        },
    });
</script>
@endsection