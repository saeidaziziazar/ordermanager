@extends('homepage')

@section('content')
    <script src="{{ asset('datepicker/persianDatepicker.min.js') }}"></script>

    <div class="content">
        <h5>حواله جدید</h5>

        @if(count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
        @endif
        
        {!! Form::open(['action' => 'OrderController@store', 'method' => 'POST', 'autocomplete' => 'off']) !!}
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">مالک<span>
                    </div>
                    {!! Form::select('owner', $owners, null , ['class' => 'custom-select']); !!}
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">شماره حواله<span>
                    </div>
                    {!! Form::text('ordernum', '', ['class' => 'form-control', 'id' => 'test']); !!}
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">مشتری<span>
                    </div>
                    {!! Form::select('costumer', $costumers, $costumer , ['class' => 'custom-select']); !!}
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">باربری<span>
                    </div>
                    {!! Form::select('transport', $trans, null , ['class' => 'custom-select']); !!}
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">تاریخ<span>
                    </div>
                    {!! Form::text('date', '', ['class' => 'form-control', 'id' => 'date']); !!}
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">مقدار<span>
                    </div>
                    {!! Form::text('amount', '', ['class' => 'form-control', 'autocomplete' => 'off']); !!}
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">توضیحات<span>
                    </div>
                    {!! Form::text('description', '', ['class' => 'form-control']); !!}
                </div>
            </div>
            <div class="row" style="margin:0;padding:5px">
                <div class="form-group">
                    {!! Form::submit('ایجاد حواله و قطعی کردن', ['class' => 'btn btn-success', 'name' => 'create']); !!}
                </div>
                <div class="form-group" style="margin-right:5px">
                    {!! Form::submit('ایجاد حواله', ['class' => 'btn btn-primary', 'name' => 'create']); !!}
                </div>
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
            selectedBefore: !0,
            calendarPosition: {
                x: 380,
                y: 0,
            },
        });
    </script>
@endsection