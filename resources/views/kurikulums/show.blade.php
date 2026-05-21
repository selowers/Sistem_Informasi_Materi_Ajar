@extends('layouts.app')

@section('title', 'Detail Kurikulum')

@section('content')
  <div class="page-heading">
    <div class="page-heading-copy">
      <span class="page-icon"><i class="bi bi-journal-text" aria-hidden="true"></i></span>
      <div>
        <p class="eyebrow mb-1">Kurikulum</p>
        <h1 class="h3 mb-1">Detail Kurikulum</h1>
        <p class="text-muted mb-0">Lihat informasi lengkap kurikulum.</p>
      </div>
    </div>
    <div class="heading-actions">
      <a href="{{ route('kurikulums.index') }}" class="btn btn-outline-secondary btn-sm">Kembali</a>
      <a href="{{ route('kurikulums.edit', $kurikulum) }}" class="btn btn-primary btn-sm">Edit</a>
    </div>
  </div>

  <div class="panel mt-3">
    <div class="row g-3">
      <div class="col-md-6">
        <div class="mb-3">
          <h6 class="mb-1">Mata Pelajaran</h6>
          <p class="mb-0">{{ optional($kurikulum->mataPelajaran)->nama_mapel ?? '-' }}</p>
        </div>
        <div class="mb-3">
          <h6 class="mb-1">Kelas</h6>
          <p class="mb-0">{{ optional($kurikulum->kelas)->nama_kelas ?? '-' }}</p>
        </div>
      </div>
      <div class="col-md-6">
        <div class="mb-3">
          <h6 class="mb-1">Tahun Ajaran</h6>
          <p class="mb-0">{{ $kurikulum->tahun_ajaran }}</p>
        </div>
        <div class="mb-3">
          <h6 class="mb-1">Deskripsi</h6>
          <p class="mb-0">{{ $kurikulum->deskripsi ?? '-' }}</p>
        </div>
      </div>
    </div>
  </div>
@endsection
