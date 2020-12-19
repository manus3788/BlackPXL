<!DOCTYPE html>
<html>
<head>
</head>
<body>
    <p>Dear {{ $name }},</p>
    <p>{{ $body }}</p>
    <p>{{ $otherText }}</p>
     
    <p>Thank you,</p>
    {{Config::get('app.name')}}
</body>
</html>