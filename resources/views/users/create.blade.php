@extends('layouts.app')

@section('title', 'Tambah Akun Pengguna')

@section('content')
  <div class="page-heading">
    <div class="page-heading-copy">
      <span class="page-icon"><i class="bi bi-person-plus" aria-hidden="true"></i></span>
      <div>
        <p class="eyebrow mb-1">Tambah Akun</p>
        <h1 class="h3 mb-1">Form Tambah Akun Pengguna</h1>
        <p class="text-muted mb-0">Buat akun admin atau guru.</p>
      </div>
    </div>
  </div>

  <div class="panel mt-3">
    <form action="{{ route('users.store') }}" method="POST">
      @csrf
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Nama</label>
          <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Role</label>
          <select name="role" class="form-select" required>
            <option value="">Pilih role</option>
            <option value="admin" @selected(old('role') == 'admin')>Admin</option>
            <option value="guru" @selected(old('role') == 'guru')>Guru</option>
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Status</label>
          <select name="status" class="form-select" required>
            <option value="">Pilih status</option>
            <option value="aktif" @selected(old('status') == 'aktif')>Aktif</option>
            <option value="nonaktif" @selected(old('status') == 'nonaktif')>Nonaktif</option>
          </select>
        </div>
      </div>
      <div class="mt-3">
        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Batal</a>
      </div>
    </form>
  </div>
@endsection
