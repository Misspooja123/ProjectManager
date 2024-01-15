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
    <div class="container">
        <div class="card">
            <div class="card-header">
                My Project List
            </div></br>
            <div class="card-body">
                <select id="roles_assign" class="form-control filter-status" style="width: 150px">
                    <option value="">--AssignRole--</option>
                    <option value="1">Cordinator</option>
                    <option value="2">Employee</option>
                </select></br>
                <div class="table-container">
                    <table class="data-table">
                        {!! $dataTable->table(['class' => 'table table-bordered dt-responsive nowrap']) !!}
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $('#roles_assign').on('change', function(e) {
                var status = $(this).val();
                window.LaravelDataTables["projectlist-table"].column(4).search(status).draw();
                e.preventDefault();
            });
    </script>
@endpush
