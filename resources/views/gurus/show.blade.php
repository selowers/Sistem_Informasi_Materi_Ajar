@extends('layouts.app')

@section('title', 'Detail Guru')

@section('content')
  <div class="page-heading">
    <div class="page-heading-copy">
      <span class="page-icon"><i class="bi bi-person-lines-fill" aria-hidden="true"></i></span>
      <div>
        <p class="eyebrow mb-1">Guru</p>
        <h1 class="h3 mb-1">Detail Guru</h1>
        <p class="text-muted mb-0">Lihat informasi lengkap mengenai guru.</p>
      </div>
    </div>
    <div class="heading-actions">
      <a href="{{ route('gurus.index') }}" class="btn btn-outline-secondary btn-sm">Kembali</a>
      @if(auth()->user()->isAdmin())
        <a href="{{ route('gurus.edit', $guru) }}" class="btn btn-primary btn-sm">Edit</a>
      @endif
    </div>
  </div>

  <div class="panel mt-3">
    <div class="row g-3">
      <div class="col-md-6">
        <div class="mb-3">
          <h6 class="mb-1">Nama Guru</h6>
          <p class="mb-0">{{ $guru->nama_guru }}</p>
        </div>
        <div class="mb-3">
          <h6 class="mb-1">Mata Pelajaran</h6>
          <p class="mb-0">{{ optional($guru->mataPelajaran)->nama_mapel ?? '-' }}</p>
        </div>
        <div class="mb-3">
          <h6 class="mb-1">Jenis Kelamin</h6>
          <p class="mb-0">{{ $guru->jenis_kelamin }}</p>
        </div>
        <div class="mb-3">
          <h6 class="mb-1">Kontak</h6>
          <p class="mb-0">{{ $guru->no_hp }}</p>
        </div>
      </div>
      <div class="col-md-6">
        <div class="mb-3">
          <h6 class="mb-1">Tempat Lahir</h6>
          <p class="mb-0">{{ $guru->tempat_lahir }}</p>
        </div>
        <div class="mb-3">
          <h6 class="mb-1">Tanggal Lahir</h6>
          <p class="mb-0">{{ $guru->tanggal_lahir }}</p>
        </div>
        <div class="mb-3">
          <h6 class="mb-1">Alamat</h6>
          <p class="mb-0">{{ $guru->alamat }}</p>
        </div>
      </div>
    </div>
  </div>
@endsection
