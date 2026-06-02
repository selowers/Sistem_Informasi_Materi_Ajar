@extends('layouts.app')

@section('title', 'Daftar Materi')

@section('content')
  <div class="page-heading mb-4 position-relative">
    <div class="row align-items-center gx-3">
      <div class="col">
        <div class="page-heading-copy d-flex align-items-start gap-3">
          <span class="page-icon"><i class="bi bi-book" aria-hidden="true"></i></span>
          <div>
            <p class="eyebrow mb-1">Materi Pembelajaran</p>
            <h1 class="h3 mb-1">Daftar Materi</h1>
            <p class="text-muted mb-0">Kelola materi pembelajaran yang tersedia untuk tiap mapel dan kelas.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="position-absolute top-0 end-0">
      <a href="{{ route('materis.create') }}" class="btn btn-primary btn-sm px-4 mt-2">
        <i class="bi bi-plus-lg me-1"></i> Tambah Materi
      </a>
    </div>
  </div>

  <div class="panel mt-3 p-3 shadow-sm rounded-3 border">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th class="fw-semibold">Judul Materi</th>
            <th class="fw-semibold">Mapel</th>
            <th class="fw-semibold">Kelas</th>
            <th class="fw-semibold">Guru</th>
            <th class="fw-semibold">File</th>
            <th class="text-end fw-semibold">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($materis as $materi)
            <tr>
              <td>{{ $materi->judul_materi }}</td>
              <td>{{ optional($materi->mataPelajaran)->nama_mapel }}</td>
              <td>{{ optional($materi->kelas)->nama_kelas }}</td>
              <td>{{ optional($materi->guru)->nama_guru }}</td>
              <td style="min-width: 220px; max-width: 280px;">
                @php
                  $files = json_decode($materi->file_materi, true);
                @endphp
                @if($files && is_array($files))
                  <div class="d-flex flex-column gap-1">
                    @foreach($files as $file)
                      <span class="badge bg-secondary text-truncate d-inline-block" style="max-width: 220px;">{{ $file['name'] ?? 'Unknown' }}</span>
                    @endforeach
                  </div>
                @else
                  <span class="text-muted">-</span>
                @endif
              </td>
              <td class="text-end">
                <div class="d-flex justify-content-end gap-2 flex-wrap">
                  <a href="{{ route('materis.show', $materi) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                  <a href="{{ route('materis.edit', $materi) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                  <form action="{{ route('materis.destroy', $materi) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Hapus materi ini?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Hapus</button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center text-muted py-4">Belum ada data materi.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection
