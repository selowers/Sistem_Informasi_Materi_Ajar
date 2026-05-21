@extends('layouts.app')

@section('title', 'Daftar Kelas')

@section('content')
  <div class="page-heading">
    <div class="page-heading-copy">
      <span class="page-icon"><i class="bi bi-building" aria-hidden="true"></i></span>
      <div>
        <p class="eyebrow mb-1">Kelas</p>
        <h1 class="h3 mb-1">Daftar Kelas</h1>
        <p class="text-muted mb-0">Kelola kelas diniyah dan wali kelas.</p>
      </div>
    </div>
    <div class="heading-actions">
      @if(auth()->user()->isAdmin())
        <a href="{{ route('kelas.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Tambah Kelas</a>
      @endif
    </div>
  </div>

  <div class="panel mt-3">
    <div class="table-responsive">
      <table class="table align-middle mb-0">
        <thead>
          <tr>
            <th>Nama Kelas</th>
            <th>Wali Kelas</th>
            <th>Tahun Ajaran</th>
            <th>Jumlah Santri</th>
            <th class="text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($kelas as $item)
            <tr>
              <td>{{ $item->nama_kelas }}</td>
              <td>{{ optional($item->waliKelas)->nama_guru ?? '-' }}</td>
              <td>{{ $item->tahun_ajaran }}</td>
              <td>{{ $item->jumlah_santri }}</td>
              <td class="text-end">
                <a href="{{ route('kelas.show', $item) }}" class="btn btn-sm btn-outline-primary me-1">Detail</a>
                @if(auth()->user()->isAdmin())
                  <a href="{{ route('kelas.edit', $item) }}" class="btn btn-sm btn-outline-secondary me-1">Edit</a>
                  <form action="{{ route('kelas.destroy', $item) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Hapus kelas ini?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Hapus</button>
                  </form>
                @endif
              </td>
            </tr>
          @endforeach
          @if($kelas->isEmpty())
            <tr><td colspan="5" class="text-center">Belum ada data kelas.</td></tr>
          @endif
        </tbody>
      </table>
    </div>
  </div>
@endsection
