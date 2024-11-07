
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>
    <b>{{ $judul }}</b>
    <br>
    @if (session()->has('error'))
        <div class="alert alert-danger">
            <strong>{{ session('error') }}</strong>
        </div>
    @endif
    <form action="{{ Route('backend.auth') }}" method="POST">
        @csrf
        <label>Username</label><br>
        <input type="text" name="email" id="" value="{{ old('email') }}" class="@error('email') is-invalid @enderror" placeholder="masukan email">
        @error('email')
        <span class="invalid-feedback alert-danger">{{ $message }}</span>
        @enderror
        <br>
        <label>Password</label><br>
        <input type="password" name="password" id="" value="{{ old('password') }}" class="@error('password') is-invalid @enderror" placeholder="masukan password">
        @error('password')
        <span class="invalid-feedback alert-danger">{{ $message }}</span>
        @enderror
        <br>
        <button type="submit">Masuk</button>

    </form>

</body>
</html>