@extends('layouts.app')

@section('title', 'Daftar Santri')

@section('content')
  <div class="page-heading">
    <div class="page-heading-copy">
      <span class="page-icon"><i class="bi bi-person-badge" aria-hidden="true"></i></span>
      <div>
        <p class="eyebrow mb-1">Santri</p>
        <h1 class="h3 mb-1">Daftar Santri</h1>
        <p class="text-muted mb-0">Kelola data santri dan kelasnya.</p>
      </div>
    </div>
    <div class="heading-actions">
      @if(Auth::user()->isAdmin())
        <a href="{{ route('santris.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Tambah Santri</a>
      @endif
    </div>
  </div>

  <div class="panel mt-3">
    <div class="table-responsive">
      <table class="table align-middle mb-0">
        <thead>
          <tr>
            <th>Nama Santri</th>
            <th>Kelas</th>
            <th>Jenis Kelamin</th>
            <th>Orang Tua / Wali</th>
            <th class="text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($santris as $santri)
            <tr>
              <td>{{ $santri->nama_santri }}</td>
              <td>{{ optional($santri->kelas)->nama_kelas }}</td>
              <td>{{ $santri->jenis_kelamin }}</td>
              <td>{{ $santri->nama_orang_tua }}</td>
              <td class="text-end">
                <a href="{{ route('santris.show', $santri) }}" class="btn btn-sm btn-outline-primary me-1">Detail</a>
                @if(auth()->user()->isAdmin())
                  <a href="{{ route('santris.edit', $santri) }}" class="btn btn-sm btn-outline-secondary me-1">Edit</a>
                  <form action="{{ route('santris.destroy', $santri) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Hapus santri ini?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Hapus</button>
                  </form>
                @endif
              </td>
            </tr>
          @endforeach
          @if($santris->isEmpty())
            <tr><td colspan="5" class="text-center">Belum ada data santri.</td></tr>
          @endif
        </tbody>
      </table>
    </div>
  </div>
@endsection
