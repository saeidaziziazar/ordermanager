@extends('homepage')

@section('content')
    <div class="content">
        <div width="160" height="100">
            {!! $chartjs->render() !!}
        </div>
    </div>
@endsection