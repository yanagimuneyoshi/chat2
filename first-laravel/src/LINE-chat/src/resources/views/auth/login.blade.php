<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="{{ asset('css/login.css') }}" />
</head>

<body>
  <div class="login-container">
    <h1>Login</h1>
    <form method="POST" action="{{ route('login') }}">
      @csrf
      <div class="form-group">
        <input type="email" name="email" placeholder="Email" required>
      </div>
      <div class="form-group">
        <input type="password" name="password" placeholder="Password" required>
      </div>
      <button type="submit" class="login-button">Login</button>
    </form>
  </div>
</body>

</html>