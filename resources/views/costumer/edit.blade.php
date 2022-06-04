@extends('homepage')

@section('content')
    <div class="content">
        <h5>ویرایش مشتری</h5>
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

        {!! Form::open(['action' => ['CostumerController@update', $costumer->id], 'method' => 'POST', 'autocomplete' => 'off']) !!}
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">نام</span>
                    </div>
                    {!! Form::text('firstname', $costumer->first_name, ['class' => 'form-control']); !!}
                </div>
            </div>
            
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">نام خانوادگی</span>
                    </div>
                    {!! Form::text('lastname', $costumer->last_name, ['class' => 'form-control']); !!}
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">توضیحات<span>
                    </div>
                    {!! Form::text('description', $costumer->description , ['class' => 'form-control']); !!}
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">کد یا شناسه ملی</span>
                    </div>
                    {!! Form::text('nationalcode', $costumer->national_code, ['class' => 'form-control']); !!}
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">شماره تماس<span>
                    </div>
                    {!! Form::text('phonenum', $costumer->phone_num, ['class' => 'form-control']); !!}
                </div>
            </div> 
            <div class="form-group">
                <h6>آدرس ها</h6>
                <div>
                <div class="address">           
                    @if(old('addressname'))
                        @for ($i = 0; $i < count(old('addressname')); $i++)
                            <div id="address-block" style="display:grid;grid-template-columns:30px auto">
                                @if (old('disabled')[$i] == true)
                                    <img class="delete" src="{{ asset('icons/delete.svg') }}" style="opacity:0.2;cursor: not-allowed;" alt="با این آدرس حواله در سیستم ثبت شده است و امکان حذف وجود ندارد">
                                @else
                                    <img class="delete" src="{{ asset('icons/delete.svg') }}" onclick="removeAddressFromList(event)">
                                @endif
                                <input type="hidden" name="id[]"  value="{{old('id')[$i]}}">
                                <input type="hidden" name="disabled[]"  value="{{old('disabled')[$i]}}">
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
                                        <input class="center" type="radio" name="default"
                                            @if (old('default')[0] == $i)
                                                checked
                                            @endif
                                        >
                                    </div>
                                </div>
                            </div>
                        @endfor
                    @else
                        @foreach ($addresses as $address)
                            <div id="address-block" style="display:grid;grid-template-columns:30px auto">
                                @if ($address["disabled"] == true)
                                    <img class="delete" src="{{ asset('icons/delete.svg') }}" style="opacity:0.2;cursor: not-allowed;" alt="با این آدرس حواله در سیستم ثبت شده است و امکان حذف وجود ندارد">
                                @else
                                    <img class="delete" src="{{ asset('icons/delete.svg') }}" onclick="removeAddressFromList(event)">
                                @endif
                                <div class="row" style="margin-bottom:15px">
                                    <input type="hidden" name="id[]"  value="{{ $address['id'] }}">
                                    <input type="hidden" name="disabled[]"  value="{{ $address['disabled'] }}">
                                    <div class="col col-2">
                                        <input type="text" name="addressname[]" class="form-control" value="{{ $address['name'] }}" placeholder="عنوان">
                                    </div>
                                    <div class="col col-5">
                                        <input type="text" name="address[]" class="form-control" value="{{ $address['address'] }}" placeholder="آدرس">
                                    </div>
                                    <div class="col col-2">
                                        <input type="text" name="cellphonenum[]" class="form-control" value="{{ $address['phone_number'] }}" placeholder="شماره همراه">
                                    </div>
                                    <div class="col col-2">
                                        <input type="text" name="zipcode[]" class="form-control" value="{{ $address['zip_code'] }}" placeholder="کد پستی">
                                    </div>
                                    <div class="col col-1">
                                        <input class="center" type="radio" name="default[]" value="{{ $loop->index }}"
                                            @if ($address["is_default"] == 1)
                                                checked
                                            @endif
                                        >
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    <div id="add-address">
                        <img onclick="appendAddressToList()" style="width:15px;cursor:pointer" src="{{ asset('icons/add.svg') }}" alt="">
                    </div>
                </div>
            </div>
            {!! Form::hidden('_method', 'PUT') !!}
            {!! Form::submit('ذخیره', ['class' => 'btn btn-primary']); !!}
            <a href="{{ url($url) }}">
                {!! Form::button('ایجاد حواله', ['class' => 'btn btn-success']); !!}
            </a>
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
                    <input type="hidden" name="id[]"  value="">
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
                        <input class="center" type="radio" name="default[]" value="${$val}">
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