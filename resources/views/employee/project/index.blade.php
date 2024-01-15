@extends('employee.layouts.master')

@section('content')
</br></br></br>
    <div class="container">
        <div class="buttons-container mt-3">
            <a href="{{ route('my_projectlist') }}"><button class="btn btn-info mr-4">My ProjectList</button></a>
            <a href="{{ route('all_projectlist') }}"> <button class="btn btn-info">All ProjectList</button></a>
        </div>
    </div>
</br>
@endsection

@push('scripts')

@endpush
