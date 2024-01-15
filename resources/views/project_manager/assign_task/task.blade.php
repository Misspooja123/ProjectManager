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
                Manage Task
                <button id="assignTaskButton" class="btn btn-primary float-right">Assign Task</button>
            </div></br>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-2">
                        <select id="roles_assign" class="form-control filter-status" style="width: 150px">
                            <option value="">--AssignRole--</option>
                            <option value="1">Cordinator</option>
                            <option value="2">Employee</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <select id="status_select" class="form-control filter-status col-sm-4" style="width: 150px">
                            <option value="">--Status--</option>
                            <option value="0">Pending</option>
                            <option value="1">Complete</option>
                            <option value="2">Closed</option>
                        </select>
                    </div>
                </div></br>
                <div class="table-container">
                    <table class="data-table">
                        {!! $dataTable->table(['class' => 'table table-bordered dt-responsive nowrap']) !!}
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Task Modal -->
    <div class="modal" id="assignTaskModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Project</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closed">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="assignTaskForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="user_id">Project Name</label>
                            <select class="form-control" id="project_id" name="project_id" required>
                                <option value="">Select Project</option>
                                @foreach ($projects as $value)
                                    <option value="{{ $value->id }}">{{ $value->project_name }}</option>
                                @endforeach
                            </select>
                            <div class="error-message text-danger"></div>
                            <span class="error-msg-input text-danger"></span>
                        </div>

                        <div class="form-group">
                            <label for="name">Task Name</label>
                            <input type="text" class="form-control" id="task_name" name="task_name" required>
                            <div class="error-message text-danger"></div>
                            <span class="error-msg-input text-danger"></span>
                        </div>

                        <div class="form-group">
                            <label for="user_id">User Name</label>
                            <select class="form-control" id="user_id" name="user_id" required>
                                <option value="">Select User</option>
                                <!-- Options will be dynamically populated via AJAX -->
                            </select>
                            <div class="error-message text-danger"></div>
                            <span class="error-msg-input text-danger"></span>
                        </div>

                        <div class="form-group">
                            <label for="roles">Roles</label>
                            <select class="form-control" id="roles" name="roles" required>
                                <!-- Options will be dynamically populated via AJAX -->
                            </select>
                            <div class="error-message text-danger"></div>
                            <span class="error-msg-input text-danger"></span>
                        </div>

                        <!-- Add this script to handle the change event and update the user dropdown -->
                        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

                        <script>
                            $(document).on('change', '#project_id, #user_id', function() {
                                var projectId = $('#project_id').val();
                                console.log(projectId);
                                var userId = $('#user_id').val();
                                console.log(userId);
                                var rolesDropdown = $('#roles');

                                if (projectId && userId) {
                                    $.ajax({
                                        type: 'GET',
                                        url: "{{ route('get.roles.by.project.user') }}",
                                        data: {
                                            project_id: projectId,
                                            user_id: userId
                                        },
                                        success: function(response) {
                                            rolesDropdown.empty();
                                            if (response.roles == 1) {
                                                rolesDropdown.append('<option value="1">Cordinator</option>');
                                            } else if (response.roles == 2) {
                                                rolesDropdown.append('<option value="2">Employee</option>');
                                            } else {
                                                rolesDropdown.append('<option value="">Select Role</option>');
                                            }
                                        },
                                        error: function(error) {
                                            console.error('Error fetching roles:', error);
                                        }
                                    });
                                }
                            });
                        </script>

                        <script>
                            $(document).on('change', '#project_id', function() {
                                var projectId = $(this).val();
                                var userDropdown = $('#user_id');
                                console.log(userDropdown);
                                userDropdown.empty().append('<option value="">Select User</option>');
                                if (projectId) {
                                    $.ajax({
                                        type: 'GET',
                                        url: "{{ route('users.by-project', ':projectId') }}".replace(':projectId', projectId),

                                        success: function(response) {
                                            console.log(response);
                                            $.each(response.users, function(index, user) {
                                                userDropdown.append('<option value="' + user.id + '">' + user.name +
                                                    '</option>');
                                            });
                                        },
                                        error: function(error) {
                                            console.error('Error fetching users:', error);
                                        }
                                    });
                                }
                            });
                        </script>

                        <div class="form-group">
                            <label for="name">Start Date</label>
                            <input type="date" class="form-control" id="startdate" name="startdate" required>
                            <div class="error-message text-danger"></div>
                            <span class="error-msg-input text-danger"></span>
                        </div>

                        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                        <script>
                            $(document).ready(function() {
                                // Get the current date in the format YYYY-MM-DD
                                var currentDate = new Date().toISOString().split('T')[0];
                                // Set the min attribute of the start date input
                                $('#startdate').attr('min', currentDate);
                            });
                        </script>
                        <script>
                            $(document).ready(function() {
                                // Function to update the min attribute of the end date input based on the selected start date
                                function updateEndDateMin() {
                                    var startDateValue = $('#startdate').val();
                                    $('#enddate').attr('min', startDateValue);
                                }
                                // Attach an event listener to the start date input
                                $('#startdate').on('change', function() {
                                    updateEndDateMin();
                                });
                                // Initial call to set the min attribute based on the initial value of the start date input
                                updateEndDateMin();
                            });
                        </script>

                        <div class="form-group">
                            <label for="name">End Date</label>
                            <input type="date" class="form-control" id="enddate" name="enddate" required>
                            <div class="error-message text-danger"></div>
                            <span class="error-msg-input text-danger"></span>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close">Close</button>
                        <button type="submit" class="btn btn-primary">Assign Task</button>
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
                window.LaravelDataTables["task-table"].column(7).search(status).draw();
                e.preventDefault();
            });

            $('#status_select').on('change', function(e) {
                var status = $(this).val();
                window.LaravelDataTables["task-table"].column(8).search(status).draw();
                e.preventDefault();
            });

            $(document).ready(function() {
                function resetForm() {
                    // Reset form fields
                    $('#assignTaskForm')[0].reset();
                    // Clear validation error messages
                    $('#assignTaskForm .error-message').text('');
                    $('#user_id').empty().append('<option value="">Select User</option>');

                    $('#roles').empty().append('<option value="">Select Role</option>');
                }
                $('#assignTaskButton').click(function() {
                    $('#assignTaskModal').modal('show');
                });
                $('#assignTaskModal').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $('#close').click(function() {
                    $('#assignTaskModal').modal('hide');
                    resetForm();
                });

                $('#closed').click(function() {
                    $('#assignTaskModal').modal('hide');
                    resetForm();
                });

                $("#assignTaskForm").validate({
                    errorPlacement: function(error, element) {
                        error.appendTo(element.parent().find('.error-message'));
                    },
                    rules: {
                        project_id: {
                            required: true,
                        },
                        task_name: {
                            required: true,
                        },
                        user_id: {
                            required: true,
                        },
                        startdate: {
                            required: true,
                        },
                        enddate: {
                            required: true,
                        }
                    },
                    messages: {
                        project_id: {
                            required: "Please select project name",
                        },
                        task_name: {
                            required: "Please enter task name",
                        },
                        user_id: {
                            required: "Please select user name",
                        },
                        startdate: {
                            required: "Please select start date",
                        },
                        enddate: {
                            required: "Please select end date",
                        }
                    },
                    submitHandler: function(form) {
                        $.ajax({
                            url: "{{ route('task.store') }}",
                            method: "POST",
                            data: $(form).serialize(),
                            success: function(response) {
                                $("#assignTaskModal").modal('hide');
                                Swal.fire('Success',
                                    'Task added successfully...',
                                    'success');
                                var dataTable = $('#task-table')
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
        });
    </script>
@endpush
