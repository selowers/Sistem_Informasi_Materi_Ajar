<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="adminHMD authentication page">
  <title>Login | adminHMD</title>

  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body class="auth-body">
  <button class="icon-button theme-toggle auth-theme-toggle" type="button" data-theme-toggle aria-label="Switch color theme" title="Switch color theme">
    <i class="bi bi-moon-stars" data-theme-icon aria-hidden="true"></i>
  </button>

  <main class="auth-page">
    <section class="auth-card">
      @if($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form class="needs-validation" novalidate method="POST" action="{{ route('login') }}">
        @csrf
        <div class="text-center mb-4">
          <h1 class="h3 mb-1">Login</h1>
        </div>

        <div class="mb-3">
          <label class="form-label" for="loginEmail">Email address</label>
          <input class="form-control" id="loginEmail" type="email" name="email" value="{{ old('email') }}" required>
          <div class="invalid-feedback">Enter a valid email.</div>
        </div>

        <div class="mb-3">
          <div class="d-flex justify-content-between">
            <label class="form-label" for="loginPassword">Password</label>
            <a class="small fw-semibold" href="#">Forgot?</a>
          </div>
          <input class="form-control" id="loginPassword" type="password" name="password" minlength="6" required>
          <div class="invalid-feedback">Password must be at least 6 characters.</div>
        </div>

        <div class="mb-3">
          <label class="form-label">Masuk sebagai</label>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="role" id="roleAdmin" value="admin" {{ old('role') === 'admin' ? 'checked' : '' }}>
            <label class="form-check-label" for="roleAdmin">Admin</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="role" id="roleGuru" value="guru" {{ old('role') === 'guru' ? 'checked' : '' }}>
            <label class="form-check-label" for="roleGuru">Guru</label>
          </div>
          @error('role')
            <div class="text-danger small mt-1">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-check mb-4">
          <input class="form-check-input" type="checkbox" id="remember" name="remember">
          <label class="form-check-label" for="remember">Remember me</label>
        </div>

        <button class="btn btn-primary w-100" type="submit"><i class="bi bi-box-arrow-in-right" aria-hidden="true"></i> Sign In</button>
      </form>

      <div class="auth-footer">New here? <a href="#">Create an account</a></div>
    </section>
  </main>

  <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>
