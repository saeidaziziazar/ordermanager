@extends('homepage')

@section('content')
    <div class="content">
        <div id="printarea">
            <h5>گزارش تفکیکی</h5>
            <table class="table table-bordered table-sm">
                <thead class="thead-light">
                    <tr>
                        <th width="8%">باربری</th>
                        <th width="45%">مالک حواله</th>
                        <th width="18%">مقدار</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($data as $tra => $row)
                    <tr>
                        <td rowspan="3">{{ $tra }}</td>
                        @foreach($row as $owner => $amount)
                        <tr>
                            <td>{{ $owner }}</td>
                            <td>{{ $amount }}</td>
                        </tr>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <button class="btn btn-primary" onclick="printPageArea('print')">چاپ</button>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        
    </script>
@endsection
