@extends('layouts.app')

@section('title', 'Daftar Materi')

@section('content')
  <div class="page-heading">
    <div class="page-heading-copy">
      <span class="page-icon"><i class="bi bi-book" aria-hidden="true"></i></span>
      <div>
        <p class="eyebrow mb-1">Materi Pembelajaran</p>
        <h1 class="h3 mb-1">Daftar Materi</h1>
        <p class="text-muted mb-0">Kelola materi pembelajaran yang tersedia untuk tiap mapel dan kelas.</p>
      </div>
    </div>
    <div class="heading-actions"><a href="{{ route('materis.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Tambah Materi</a></div>
  </div>

  <div class="panel mt-3">
    <div class="table-responsive">
      <table class="table align-middle mb-0">
        <thead>
          <tr>
            <th>Judul Materi</th>
            <th>Mapel</th>
            <th>Kelas</th>
            <th>Guru</th>
            <th>File</th>
            <th class="text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($materis as $materi)
            <tr>
              <td>{{ $materi->judul_materi }}</td>
              <td>{{ optional($materi->mataPelajaran)->nama_mapel }}</td>
              <td>{{ optional($materi->kelas)->nama_kelas }}</td>
              <td>{{ optional($materi->guru)->nama_guru }}</td>
              <td>{{ $materi->file_materi }}</td>
              <td class="text-end">
                <a href="{{ route('materis.show', $materi) }}" class="btn btn-sm btn-outline-primary me-1">Detail</a>
              <a href="{{ route('materis.edit', $materi) }}" class="btn btn-sm btn-outline-secondary me-1">Edit</a>
                <form action="{{ route('materis.destroy', $materi) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Hapus materi ini?');">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
              </td>
            </tr>
          @endforeach
          @if($materis->isEmpty())
            <tr><td colspan="6" class="text-center">Belum ada data materi.</td></tr>
          @endif
        </tbody>
      </table>
    </div>
  </div>
@endsection
