<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    register
    <form action="{{route('register')}}" method="post">
        @csrf

        <input type="text" value="name" name="name">
        @error('name')
        <b>{{ $message }}</b>
         @enderror
        <input type="text" value="joel@mailasd.com" name="email">
        @error('email')
        <b>{{ $message }}</b>
         @enderror
        <input type="text" value="123456789" name="password">
        @error('password')
        <b>{{ $message }}</b>
         @enderror
        <input type="text" value="123456789" name="password_confirmation">

        <input type="submit" value='enviar'>
    </form>
</body>
</html>