<!DOCTYPE html>
<html>
<head>
    <title>Employee add</title>
</head>
<body>
    <p>Hello {{ $employee->name }},</p>
    <p>This is your Email and Password to login System.</p>
    <ul>
        {{-- <li>Name: {{ $employee->name }}</li> --}}
        <li>Email: {{ $employee->email }}</li>
        <li>Password: {{ $employee->password }}</li>

    </ul>
</body>
</html>
