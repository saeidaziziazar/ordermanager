@extends('homepage')

@section('contextmenu')
    <div class="menu">
        <ul class="menu-options">
            @can('all', $years[0])
                <li class="menu-option" id="edit">ویرایش</li>
            @endcan
            @can('all', $years[0])
                <li class="menu-option" id="delete">حذف</li>
            @endcan
        </ul>
    </div>
@endsection

@section('content')
    <div class="content">
        <h5>سال مالی</h5>
        
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('fail'))
            <div class="alert alert-danger">{{ session('fail') }}</div>
        @endif

        {!! Form::open(['method' => 'POST', 'id' => 'printForm']) !!}

            <table id="table" class="table table-sm table-bordered" style="margin-top:30px;text-align:center;font-size:85%">
                <thead class="thead-light">
                    <tr>
                        <th style="display:none"></th>
                        <th>ردیف</th>
                        <th scope="col">سال مالی</th>
                        <th scope="col">تاریخ شروع</th>
                        <th scope="col">تاریخ پایان</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($years as $year)
                        <tr>
                            <td>{{ $year->id }}</td>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>{{ $year->name }}</td>
                            <td>{{ $year->start }}</td>
                            <td>{{ $year->end }}</td>
                        </tr>
                    @endforeach
                    <ul class="actions">
                        <a class="btn btn-primary" href="{{ url('years/create') }}">سال مالی جدید</a>
                    </ul>
                    <div style="display:flex">
                        <div id="search-status"></div>
                    </div>
                </tbody>
            </table>
        {!! Form::close() !!}
    </div>
@endsection

@section('scripts')
    <script>
        $('#table').dynatable({
            features: {
                perPageSelect: false,
            },
            dataset: {
                perPageDefault: 25,
            },
            inputs: {
                searchTarget: '#search-status',
            }
        });

        var menu = document.querySelector('.menu');

        function contextMenu(event) {
            event.preventDefault();

            document.querySelectorAll("input[type='checkbox']").forEach( item => {
                item.checked = false;
            })

            var item = event.path[1];

            menu.style.display = 'block';
            menu.style.left = event.pageX - 150 + 'px';
            menu.style.top = event.pageY + 'px';

            if (document.getElementById('edit')) {
                document.getElementById('edit').onclick = (event) => {
                    window.location.href = 'years/' + item.firstChild.innerHTML + '/edit';
                }
            }

            if (document.getElementById('delete')) {
                document.getElementById('delete').onclick = (event) => {
                    var name = item.children[2].innerHTML;
                    console.log(item);
                    var respond = confirm(('آیا از حذف کردن '.concat(name)).concat(' مطمئن هستید ؟ '));

                    if (respond) {
                        var form = document.getElementById("printForm");
                        var input = document.createElement("INPUT");
                        input.setAttribute('name', '_method');
                        input.setAttribute('type', 'hidden');
                        input.setAttribute('value', 'DELETE');
                        form.appendChild(input);

                        var input = document.createElement("INPUT");
                        input.setAttribute('name', 'id');
                        input.setAttribute('type', 'hidden');
                        input.setAttribute('value', item.children[0].innerHTML);
                        form.appendChild(input);

                        form.submit();
                    } 
                }   
            }
        }

        menu.onmousedown = (event) => {
            event.stopPropagation();
        };

        window.onblur = () => {
            menu.style.display = 'none';
        };

        document.onmousedown = () => {
            menu.style.display = 'none';
        };

        document.onmousewheel = () => {
            menu.style.display = 'none';
        };

        document.onkeydown = (event) => {
            if (event.keyCode === 27) {
                menu.style.display = 'none';
            }
        }
    </script>
@endsection