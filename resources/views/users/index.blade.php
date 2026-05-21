@extends('layouts.app')

@section('title', 'Daftar Pengguna')

@section('content')
  <div class="page-heading">
    <div class="page-heading-copy">
      <span class="page-icon"><i class="bi bi-people-fill" aria-hidden="true"></i></span>
      <div>
        <p class="eyebrow mb-1">Akun Pengguna</p>
        <h1 class="h3 mb-1">Daftar Pengguna</h1>
        <p class="text-muted mb-0">Kelola akun administrator dan guru.</p>
      </div>
    </div>
    <div class="heading-actions"><a href="{{ route('users.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Tambah Akun</a></div>
  </div>

  <div class="panel mt-3">
    <div class="table-responsive">
      <table class="table align-middle mb-0">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th class="text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($users as $user)
            <tr>
              <td>{{ $user->nama }}</td>
              <td>{{ $user->email }}</td>
              <td>{{ ucfirst($user->role) }}</td>
              <td>{{ ucfirst($user->status) }}</td>
              <td class="text-end">
                <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Hapus akun ini?');">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
              </td>
            </tr>
          @endforeach
          @if($users->isEmpty())
            <tr><td colspan="5" class="text-center">Belum ada akun pengguna.</td></tr>
          @endif
        </tbody>
      </table>
    </div>
  </div>
@endsection
