<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Login</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <!-- Favicons -->
    {{-- <link href="{{ asset('asset/assets/img/favicon.png') }}" rel="icon"> --}}
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
                                    <img src="{{ asset('asset/assets/img/logo.png') }}" alt="">
                                    <span class="d-none d-lg-block">Employee</span>
                                </a>
                            </div><!-- End Logo -->

                            <div class="card mb-3">

                                <div class="card-body">

                                    <div class="pt-4 pb-2">
                                        <h6 class="card-title text-center pb-0 fs-4">Login to Your Account</h6>
                                        <p class="text-center small">Enter your username & password to login</p>
                                    </div>

                                    @php if (isset($_COOKIE['email']) && isset($_COOKIE['password'])) {
                                            $login_email = $_COOKIE['email'];
                                            $login_pass = $_COOKIE['password'];
                                            $is_remember = "checked='checked'";
                                        } else {
                                            $login_email = '';
                                            $login_pass = '';
                                            $is_remember = '';
                                        }
                                    @endphp

                                    <form action="{{ route('login') }}" method="post"
                                        class="row g-3 needs-validation addAdmin" novalidate>
                                        @csrf

                                        <div class="col-12">
                                            <label for="yourEmail" class="form-label">Your Email</label>
                                            <input type="email" name="email" class="form-control" id="email" value="{{$login_email}}"
                                                required>
                                            <div class="invalid-feedback"></div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control" id="password" value="{{$login_pass}}"
                                                required>
                                            <div class="invalid-feedback notmatch"></div>
                                        </div>

                                        <div class="checkbox pull-right">
                                            <label>
                                                <input type="checkbox" name="rememberme" {{ $is_remember }}>
                                                Remember me </label>
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
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Include jQuery Validation Plugin -->
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.addAdmin').validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                    },
                    password: {
                        required: true,
                        minlength: 6,
                    },
                },
                messages: {
                    email: {
                        required: 'Please enter your email address.',
                        email: 'Please enter a valid email address.',
                    },
                    password: {
                        required: 'Please enter your password.',
                    },
                },
                errorElement: 'div',
                errorClass: 'invalid-feedback',
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function(form) {
                    // Clear existing error messages
                    $('.addAdmin .invalid-feedback').text('');
                    $('.addAdmin .invalid-feedback').hide();

                    $.ajax({
                        type: 'POST',
                        url: $(form).attr('action'),
                        data: $(form).serialize(),
                        success: function(response) {
                            // Handle success response
                            console.log(response);
                            if (response.redirect) {
                                window.location.href = response.redirect;
                            }
                        },
                        error: function(xhr, status, error) {
                            // Handle error response
                            console.error(xhr.responseText);
                            // Display the authentication error message
                            $('.addAdmin .notmatch').text(
                                'Invalid email or password. Please try again.');
                            $('.addAdmin .notmatch').show();
                        },
                    });
                },
            });
        });
    </script>

</body>

</html>
