@extends('employee.layouts.master')

@section('content')
    </br></br></br>
    <div class="container">
        <div class="buttons-container mt-3">
            <a href="{{ route('my_task') }}"><button class="btn btn-info mr-4">My Task</button></a>
            <a href="{{ route('other_task') }}"><button class="btn btn-info mr-4">Other Task</button></a>
        </div>
    </div>
    </br>
@endsection

@push('scripts')

@endpush
