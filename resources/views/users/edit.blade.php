@extends('layouts.app')

@section('title', 'Edit Akun Pengguna')

@section('content')
  <div class="page-heading">
    <div class="page-heading-copy">
      <span class="page-icon"><i class="bi bi-pencil-square" aria-hidden="true"></i></span>
      <div>
        <p class="eyebrow mb-1">Edit Akun</p>
        <h1 class="h3 mb-1">Perbarui Akun Pengguna</h1>
        <p class="text-muted mb-0">Perbarui detail akun pengguna.</p>
      </div>
    </div>
  </div>

  <div class="panel mt-3">
    <form action="{{ route('users.update', $user) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Nama</label>
          <input type="text" name="nama" class="form-control" value="{{ old('nama', $user->nama) }}" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Password (biarkan kosong jika tidak diubah)</label>
          <input type="password" name="password" class="form-control">
        </div>
        <div class="col-md-6">
          <label class="form-label">Role</label>
          <select name="role" class="form-select" required>
            <option value="admin" @selected(old('role', $user->role) == 'admin')>Admin</option>
            <option value="guru" @selected(old('role', $user->role) == 'guru')>Guru</option>
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Status</label>
          <select name="status" class="form-select" required>
            <option value="aktif" @selected(old('status', $user->status) == 'aktif')>Aktif</option>
            <option value="nonaktif" @selected(old('status', $user->status) == 'nonaktif')>Nonaktif</option>
          </select>
        </div>
      </div>
      <div class="mt-3">
        <button class="btn btn-primary">Perbarui</button>
        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Batal</a>
      </div>
    </form>
  </div>
@endsection
