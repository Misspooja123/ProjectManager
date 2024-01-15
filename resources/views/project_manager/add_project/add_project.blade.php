@extends('project_manager.layouts.master')

@section('content')
    <style>
        .table-container {
            max-width: 100%;
            overflow-x: auto;
        }
    </style>
    </br></br></br>
    <div class="container">
        <div class="card">
            <div class="card-header">
                Manage Project
                <button id="addProjectButton" class="btn btn-primary float-right">Add Project</button>
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

    <!-- Add Project Modal -->
    <div class="modal" id="addProjectModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Project</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closed">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="addProjectForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Project Name</label>
                            <input type="text" class="form-control" id="project_name" name="project_name" required>
                            <div class="error-message text-danger"></div>
                            <span class="error-msg-input text-danger"></span>
                        </div>

                        <div class="form-group">
                            <label for="user_id">User</label>
                            <select class="form-control" id="user_id" name="user_id[]" multiple required>

                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            <div class="error-message text-danger"></div>
                            <span class="error-msg-input text-danger"></span>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#roles_assign').on('change', function(e) {
                var status = $(this).val();
                window.LaravelDataTables["projectuser-table"].column(4).search(status).draw();
                e.preventDefault();
            });

            $(document).ready(function() {
                function resetForm() {
                    // Reset form fields
                    $('#addProjectForm')[0].reset();
                    // Clear validation error messages
                    $('#addProjectForm .error-message').text('');
                }
                $('#addProjectButton').click(function() {
                    $('#addProjectModal').modal('show');
                });
                $('#addProjectModal').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $('#close').click(function() {
                    $('#addProjectModal').modal('hide');
                    resetForm();
                });

                $('#closed').click(function() {
                    $('#addProjectModal').modal('hide');
                    resetForm();
                });

                $("#addProjectForm").validate({
                    errorPlacement: function(error, element) {
                        error.appendTo(element.parent().find('.error-message'));
                    },
                    rules: {
                        project_name: {
                            required: true,
                        },
                        user_id: {
                            required: true,
                        }
                    },
                    messages: {
                        project_name: {
                            required: "Please enter a Project name.",
                        },
                        user_id: {
                            required: "Please Select User name",
                        }
                    },
                    submitHandler: function(form) {
                        $.ajax({
                            url: "{{ route('add_project.store') }}",
                            method: "POST",
                            data: $(form).serialize(),
                            success: function(response) {
                                $("#addProjectModal").modal('hide');
                                Swal.fire('Success',
                                    'Project added successfully...',
                                    'success');
                                var dataTable = $('#projectuser-table')
                                    .DataTable();
                                dataTable.ajax.reload();
                                resetForm();

                            },
                            error: function(error) {
                                Swal.fire('Error',
                                    'An error occurred while processing your request.',
                                    'error');
                            }

                        });
                    }
                });
            });

            //cordinator button code
            $(document).on('click', '.cordinator_btn', function() {
                var cordinateBtn = $(this);
                var projectId = $(this).data('id');
                $.ajax({
                    type: 'POST',
                    url: "{{ route('project.cordinator', ':id') }}".replace(':id',
                        projectId),
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        Swal.fire('Success',
                            'Project Cordinator',
                            'success');
                        cordinateBtn.hide();
                        var dataTable = $('#projectuser-table').DataTable();
                        dataTable.ajax.reload();
                    },
                    error: function(error) {
                        Swal.fire('Error',
                            'An error occurred while processing your request.',
                            'error');
                    }
                });
            });

            //employee button code
            $(document).on('click', '.employee_btn', function() {
                var empBtn = $(this);
                var projectId = $(this).data('id');
                $.ajax({
                    type: 'POST',
                    url: "{{ route('project.employee', ':id') }}".replace(':id',
                        projectId),
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        Swal.fire('Success',
                            'Project Employee',
                            'success');
                        empBtn.hide();
                        var dataTable = $('#projectuser-table').DataTable();
                        dataTable.ajax.reload();
                    },
                    error: function(error) {
                        Swal.fire('Error',
                            'An error occurred while processing your request.',
                            'error');
                    }
                });
            });


        });
    </script>
@endpush
