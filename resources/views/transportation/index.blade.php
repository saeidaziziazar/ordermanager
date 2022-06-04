@extends('homepage')

@section('contextmenu')
    <div class="menu">
        <ul class="menu-options">
            @can('update', $trans[0])
                <li class="menu-option" id="edit">ویرایش</li>
            @endcan
            @can('delete', $trans[0])
                <li class="menu-option" id="delete">حذف</li>
            @endcan
        </ul>
    </div>
@endsection

@section('content')
    <div class="content">
        <h5>لیست باربری ها</h5>

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
                        <th>
                            <input type="checkbox" id="checkAll" onclick="checkAllCheckBox(event)">
                        </th>
                        <th scope="col">نام باربری</th>
                        <th scope="col">مدیر باربری</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($trans as $tran)
                        <tr>
                            <td>{{ $tran->id }}</td>
                            <td>
                                {!! Form::checkbox('trans[]', $tran->id) !!}
                            </td>
                            <td>{{ $tran->name }}</td>
                            <td>{{ $tran->manager }}</td>
                        </tr>
                    @endforeach
                    <ul class="actions">
                        @can('delete', $trans[0])
                            <li><a href="#" onclick="deleteTrans(true)">حذف باربری ها</a></li>
                        @endcan 
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

        function checkAllCheckBox(event) {
            if (event.target.checked) {
                document.querySelectorAll("input[type='checkbox']").forEach( item => {
                    item.checked = true;
                })
            } else {
                document.querySelectorAll("input[type='checkbox']").forEach( item => {
                    item.checked = false;
                })
            }
        }

        function deleteTrans(multiple = false) {
            var form = document.getElementById("printForm");

            if (multiple) {
                var respond = confirm('آیا از حذف حواله های انتخاب شده مطمئن هستید ؟');
            }

            if (respond || multiple == false) {
                console.log('delete');
                var input = document.createElement("INPUT");
                input.setAttribute('name', '_method');
                input.setAttribute('type', 'hidden');
                input.setAttribute('value', 'DELETE');
                form.appendChild(input);

                form.submit();
            } else {
                // do nothing
            }
        }

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
                    window.location.href = 'transportations/' + item.firstChild.innerHTML + '/edit';
                }
            }

            if (document.getElementById('delete')) {
                document.getElementById('delete').onclick = (event) => {
                    var number = item.children[2].innerHTML;
                
                    var respond = confirm(('آیا از حذف کردن '.concat(number)).concat(' مطمئن هستید ؟ '));

                    if (respond) {
                        item.children[1].children[0].checked = true;
                        deleteTrans(false);
                    } else {

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