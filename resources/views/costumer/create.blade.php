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
                <h6>آدرس ها</h6>
                <div>
                <div class="address">            
                    @if(old('addressname'))
                        @for ($i = 0; $i < count(old('addressname')); $i++)
                            <div id="address-block" style="display:grid;grid-template-columns:30px auto">
                                <img class="delete" src="{{ asset('icons/delete.svg') }}" onclick="removeAddressFromList(event)">
                                <div class="row" style="margin-bottom:15px">
                                    <div class="col col-2">
                                        <input type="text" name="addressname[]" class="form-control" value="{{old('addressname')[$i]}}" placeholder="عنوان">
                                    </div>
                                    <div class="col col-5">
                                        <input type="text" name="address[]" class="form-control" value="{{old('address')[$i]}}" placeholder="آدرس">
                                    </div>
                                    <div class="col col-2">
                                        <input type="text" name="cellphonenum[]" class="form-control" value="{{old('cellphonenum')[$i]}}" placeholder="شماره همراه">
                                    </div>
                                    <div class="col col-2">
                                        <input type="text" name="zipcode[]" class="form-control" value="{{old('zipcode')[$i]}}" placeholder="کد پستی">
                                    </div>
                                    <div class="col col-1">
                                        <input class="center" type="radio" name="default" value="{{ $i }}"
                                            @if (old('default') == $i)
                                                checked
                                            @endif
                                        >
                                    </div>
                                </div>
                            </div>
                        @endfor
                    @else
                        <div id="address-block" style="display:grid;grid-template-columns:30px auto">
                            <img class="delete" src="{{ asset('icons/delete.svg') }}" onclick="removeAddressFromList(event)">
                            <div class="row" style="margin-bottom:15px">
                                <div class="col col-2">
                                    <input type="text" name="addressname[]" class="form-control" value="" placeholder="عنوان">
                                </div>
                                <div class="col col-5">
                                    <input type="text" name="address[]" class="form-control" placeholder="آدرس">
                                </div>
                                <div class="col col-2">
                                    <input type="text" name="cellphonenum[]" class="form-control" placeholder="شماره همراه">
                                </div>
                                <div class="col col-2">
                                    <input type="text" name="zipcode[]" class="form-control" placeholder="کد پستی">
                                </div>
                                <div class="col col-1">
                                    <input class="center" type="radio" name="default" value="0">
                                </div>
                            </div>
                        </div>
                    @endif
                    <div id="add-address">
                        <img onclick="appendAddressToList()" style="width:15px;cursor:pointer" src="{{ asset('icons/add.svg') }}" alt="">
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
    <script>
        function appendAddressToList() {
            $val = document.querySelectorAll("#address-block").length;
            
            var str = 
            `<div id="address-block" style="display:grid;grid-template-columns:30px auto">
                <img class="delete" src="{{ asset('icons/delete.svg') }}" onclick="removeAddressFromList(event)">
                <div class="row" style="margin-bottom: 15px">
                    <div class="col col-2">
                        <input type="text" name="addressname[]" class="form-control" placeholder="عنوان">
                    </div>
                    <div class="col col-5">
                        <input type="text" name="address[]" class="form-control" placeholder="آدرس">
                    </div>
                    <div class="col col-2">
                        <input type="text" name="cellphonenum[]" class="form-control" placeholder="شماره همراه">
                    </div>
                    <div class="col col-2">
                        <input type="text" name="zipcode[]" class="form-control" placeholder="کد پستی">
                    </div>
                    <div class="col col-1">
                        <input class="center" type="radio" name="default" value="${$val}">
                    </div>
                </div>
            </div>`;

            var x = document.querySelector("#add-address");
            x.insertAdjacentHTML('beforebegin', str);
        }

        function removeAddressFromList(e) {
            e.target.parentNode.remove();
        }
    </script>
@endsection

