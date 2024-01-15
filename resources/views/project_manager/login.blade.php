<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Project Manager</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <!-- Favicons -->
    <link href="{{ asset('asset/assets/img/favicon.png') }}" rel="icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <link href="{{ asset('asset/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('asset/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('asset/assets/css/style.css') }}" rel="stylesheet">

<body>
    <main>
        <div class="container">
            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="index.html" class="logo d-flex align-items-center w-auto">
                                    <img src="assets/img/logo.png" alt="">
                                    <span class="d-none d-lg-block">Admin</span>
                                </a>
                            </div><!-- End Logo -->

                            <div class="card mb-3">

                                <div class="card-body">

                                    <div class="pt-4 pb-2">
                                        <h6 class="card-title text-center pb-0 fs-4">Login to Your Account</h6>
                                        <p class="text-center small">Enter your username & password to login</p>
                                    </div>

                                    <form action="{{ url('admin/login') }}" method="post"
                                        class="row g-3 needs-validation addAdmin" novalidate>
                                        @csrf
                                        @if ($errors->any())
                                            <div class="alert alert-danger home">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        @if (Session::has('error_message'))
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>Error :</strong> {{ Session::get('error_message') }}
                                                <button type="button" class="close" data-dismiss="alert"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endif
                                        <div class="col-12">
                                            <label for="yourUsername" class="form-label">Username</label>
                                            <div class="input-group has-validation">
                                                <input type="text" name="email" class="form-control" id="email"
                                                    placeholder="Enter Username" required>
                                                <span class="input-group-text" id="inputGroupAppend">@</span>
                                            </div>
                                        </div>


                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">Password</label>
                                            <div class="input-group has-validation">
                                                <input type="password" name="password" class="form-control"
                                                    placeholder="Enter Password" id="password" required>
                                                <span class="input-group-text toggle-password" id="inputGroupPrepend">
                                                    <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                                </span>

                                                {{-- <div class="error-message text-danger"></div> --}}
                                            </div>
                                            <script src="https://code.jquery.com/jquery-3.5.1.min.js"
                                                integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
                                            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>

                                            <script>
                                                $(document).ready(function() {
                                                    const passwordField = $('#password');
                                                    const togglePassword = $('.toggle-password');

                                                    // Toggle password visibility
                                                    togglePassword.click(function() {
                                                        const fieldType = passwordField.attr('type');
                                                        if (fieldType === 'password') {
                                                            passwordField.attr('type', 'text');
                                                            togglePassword.html('<i class="fa fa-eye" aria-hidden="true"></i>');
                                                        } else {
                                                            passwordField.attr('type', 'password');
                                                            togglePassword.html('<i class="fa fa-eye-slash" aria-hidden="true"></i>');
                                                        }
                                                    });
                                                });

                                                $(".addAdmin").validate({
                                                    // errorPlacement: function(error, element) {
                                                    //     error.appendTo(element.parent().find('.error-message'));
                                                    // },
                                                    rules: {
                                                        email: {
                                                            required: true,
                                                            email: true,
                                                        },
                                                        password: {
                                                            required: true,
                                                        }
                                                    },
                                                    messages: {
                                                        email: {
                                                            required: "Please enter email",
                                                        },
                                                        password: {
                                                            required: "Please enter password",
                                                        }
                                                    },
                                                    errorElement: 'span',
                                                    errorPlacement: function(error, element) {
                                                        error.addClass('invalid-feedback');
                                                        element.closest('.input-group').append(error);
                                                    },
                                                    highlight: function(element, errorClass, validClass) {
                                                        $(element).addClass('is-invalid');
                                                    },
                                                    unhighlight: function(element, errorClass, validClass) {
                                                        $(element).removeClass('is-invalid');
                                                    }
                                                });
                                            </script>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">Login</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main><!-- End #main -->
</body>

</html>
