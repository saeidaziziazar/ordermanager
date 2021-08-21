@extends('homepage')

@section('content')
    <div class="content">
        <h5>معرفی مشتری</h5>
        @if(count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {!! Form::open(['action' => 'CostumerController@store', 'method' => 'POST', 'autocomplete' => 'off']) !!}
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">نام</span>
                    </div>
                    {!! Form::text('firstname', '', ['class' => 'form-control']); !!}
                </div>
            </div>
            
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">نام خانوادگی</span>
                    </div>
                    {!! Form::text('lastname', '', ['class' => 'form-control']); !!}
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
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">کد یا شناسه ملی</span>
                    </div>
                    {!! Form::text('nationalcode', '', ['class' => 'form-control']); !!}
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">شماره تماس<span>
                    </div>
                    {!! Form::text('phonenum', '', ['class' => 'form-control']); !!}
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">شماره همراه<span>
                    </div>
                    {!! Form::text('cellphonenum', '', ['class' => 'form-control']); !!}
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">کد پستی<span>
                    </div>
                    {!! Form::text('zipcode', '', ['class' => 'form-control']); !!}
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">آدرس<span>
                    </div>
                    {!! Form::text('address', '', ['class' => 'form-control']); !!}
                </div>
            </div>
            <div class="form-group">
                <h6>آدرس ها</h6>
                <div>
                <div class="address">
                    <div style="display:grid;grid-template-columns:30px auto">
                        <a href="" class="delete">
                            <img src="{{ asset('icons/delete.svg') }}" alt="">
                        </a>
                        <div class="row" style="margin-bottom:15px">
                            <div class="col col-2">
                                <input type="text" class="form-control" placeholder="عنوان">
                            </div>
                            <div class="col col-5">
                                <input type="text" class="form-control" placeholder="آدرس">
                            </div>
                            <div class="col col-2">
                                <input type="text" class="form-control" placeholder="شماره همراه">
                            </div>
                            <div class="col col-2">
                                <input type="text" class="form-control" placeholder="کد پستی">
                            </div>
                            <div class="col col-1">
                                <input class="center" type="radio" name="default">
                            </div>
                        </div>
                    </div>
                    <div id="add-address">
                        <a href="#" class="" onclick="appendAddressToList()">
                            <img style="width:15px" src="{{ asset('icons/add.svg') }}" alt="">
                        </a>
                    </div>
                </div>
            </div>
            <div class="form-group">
                {!! Form::submit('ایجاد مشتری', ['class' => 'btn btn-primary']); !!}
            </div>
        {!! Form::close() !!}
    </div>
@endsection

@section('scripts')
    <<script>
        var str = 
            `<div style="display:grid;grid-template-columns:30px auto">
                <a href="" class="delete">
                    <img src="{{ asset('icons/delete.svg') }}" alt="">
                </a>
                <div class="row" style="margin-bottom: 15px">
                    <div class="col col-2">
                        <input type="text" class="form-control" placeholder="عنوان">
                    </div>
                    <div class="col col-5">
                        <input type="text" class="form-control" placeholder="آدرس">
                    </div>
                    <div class="col col-2">
                        <input type="text" class="form-control" placeholder="شماره همراه">
                    </div>
                    <div class="col col-2">
                        <input type="text" class="form-control" placeholder="کد پستی">
                    </div>
                    <div class="col col-1">
                        <input class="center" type="radio" name="default">
                    </div>
                </div>
            </div>`;

            function appendAddressToList() {
                var x = document.querySelector("#add-address");
                console.log(x);
                x.insertAdjacentHTML('beforebegin', str);
            }
    </script>
@endsection