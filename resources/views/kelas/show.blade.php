@extends('layouts.app')

@section('title', 'Detail Kelas')

@section('content')
  <div class="page-heading">
    <div class="page-heading-copy">
      <span class="page-icon"><i class="bi bi-building" aria-hidden="true"></i></span>
      <div>
        <p class="eyebrow mb-1">Kelas</p>
        <h1 class="h3 mb-1">Detail Kelas</h1>
        <p class="text-muted mb-0">Lihat informasi lengkap kelas dan wali kelas.</p>
      </div>
    </div>
    <div class="heading-actions">
      <a href="{{ route('kelas.index') }}" class="btn btn-outline-secondary btn-sm">Kembali</a>
      @if(auth()->user()->isAdmin())
        <a href="{{ route('kelas.edit', $kelas) }}" class="btn btn-primary btn-sm">Edit</a>
      @endif
    </div>
  </div>

  <div class="panel mt-3">
    <div class="row g-3">
      <div class="col-md-6">
        <div class="mb-3">
          <h6 class="mb-1">Nama Kelas</h6>
          <p class="mb-0">{{ $kelas->nama_kelas }}</p>
        </div>
        <div class="mb-3">
          <h6 class="mb-1">Wali Kelas</h6>
          <p class="mb-0">{{ optional($kelas->waliKelas)->nama_guru ?? '-' }}</p>
        </div>
      </div>
      <div class="col-md-6">
        <div class="mb-3">
          <h6 class="mb-1">Tahun Ajaran</h6>
          <p class="mb-0">{{ $kelas->tahun_ajaran }}</p>
        </div>
        <div class="mb-3">
          <h6 class="mb-1">Jumlah Santri</h6>
          <p class="mb-0">{{ $kelas->jumlah_santri }}</p>
        </div>
      </div>
    </div>
  </div>
@endsection
