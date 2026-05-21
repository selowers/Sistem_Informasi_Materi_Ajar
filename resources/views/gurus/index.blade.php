@extends('layouts.app')

@section('title', 'Daftar Guru')

@section('content')
  <div class="page-heading">
    <div class="page-heading-copy">
      <span class="page-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
      <div>
        <p class="eyebrow mb-1">Guru</p>
        <h1 class="h3 mb-1">Daftar Guru</h1>
        <p class="text-muted mb-0">Kelola data guru, mata pelajaran, dan akun pengguna terkait.</p>
      </div>
    </div>
    <div class="heading-actions">
      @if(auth()->user()->isAdmin())
        <a href="{{ route('gurus.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Tambah Guru</a>
      @endif
    </div>
  </div>

  <div class="panel mt-3">
    <div class="table-responsive">
      <table class="table align-middle mb-0 table-fit">
        <thead>
          <tr>
            <th>Nama Guru</th>
            <th>Mapel</th>
            <th>Jenis Kelamin</th>
            <th>Kontak</th>
            <th class="text-end action-column">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($gurus as $guru)
            <tr>
              <td>{{ $guru->nama_guru }}</td>
              <td>{{ optional($guru->mataPelajaran)->nama_mapel }}</td>
              <td>{{ $guru->jenis_kelamin }}</td>
              <td>{{ $guru->no_hp }}</td>
              <td class="text-end action-column">
                <a href="{{ route('gurus.show', $guru) }}" class="btn btn-sm btn-outline-primary me-1">Detail</a>
                @if(auth()->user()->isAdmin())
                  <a href="{{ route('gurus.edit', $guru) }}" class="btn btn-sm btn-outline-secondary me-1">Edit</a>
                  <form action="{{ route('gurus.destroy', $guru) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Hapus guru ini?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Hapus</button>
                  </form>
                @endif
              </td>
            </tr>
          @endforeach
          @if($gurus->isEmpty())
            <tr><td colspan="5" class="text-center">Belum ada data guru.</td></tr>
          @endif
        </tbody>
      </table>
    </div>
  </div>
@endsection
