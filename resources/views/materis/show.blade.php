@extends('layouts.app')

@section('title', 'Detail Materi')

@section('content')
  <div class="page-heading">
    <div class="page-heading-copy">
      <span class="page-icon"><i class="bi bi-book" aria-hidden="true"></i></span>
      <div>
        <p class="eyebrow mb-1">Materi</p>
        <h1 class="h3 mb-1">Detail Materi</h1>
        <p class="text-muted mb-0">Lihat informasi lengkap materi pembelajaran.</p>
      </div>
    </div>
    <div class="heading-actions">
      <a href="{{ route('materis.index') }}" class="btn btn-outline-secondary btn-sm">Kembali</a>
      <a href="{{ route('materis.edit', $materi) }}" class="btn btn-primary btn-sm">Edit</a>
    </div>
  </div>

  <div class="panel mt-3">
    <div class="row g-3">
      <div class="col-md-6">
        <div class="mb-3">
          <h6 class="mb-1">Judul Materi</h6>
          <p class="mb-0">{{ $materi->judul_materi }}</p>
        </div>
        <div class="mb-3">
          <h6 class="mb-1">Mata Pelajaran</h6>
          <p class="mb-0">{{ optional($materi->mataPelajaran)->nama_mapel ?? '-' }}</p>
        </div>
        <div class="mb-3">
          <h6 class="mb-1">Kelas</h6>
          <p class="mb-0">{{ optional($materi->kelas)->nama_kelas ?? '-' }}</p>
        </div>
      </div>
      <div class="col-md-6">
        <div class="mb-3">
          <h6 class="mb-1">Guru</h6>
          <p class="mb-0">{{ optional($materi->guru)->nama_guru ?? '-' }}</p>
        </div>
        <div class="mb-3">
          <h6 class="mb-1">File Materi</h6>
          <p class="mb-0">{{ $materi->file_materi }}</p>
        </div>
        <div class="mb-3">
          <h6 class="mb-1">Tipe File</h6>
          <p class="mb-0">{{ $materi->tipe_file ?? '-' }}</p>
        </div>
        <div class="mb-3">
          <h6 class="mb-1">Deskripsi</h6>
          <p class="mb-0">{{ $materi->deskripsi ?? '-' }}</p>
        </div>
      </div>
    </div>
  </div>
@endsection
