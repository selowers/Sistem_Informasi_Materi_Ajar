@extends('layouts.app')

@section('title', 'Detail Santri')

@section('content')
  <div class="page-heading">
    <div class="page-heading-copy">
      <span class="page-icon"><i class="bi bi-person-badge" aria-hidden="true"></i></span>
      <div>
        <p class="eyebrow mb-1">Santri</p>
        <h1 class="h3 mb-1">Detail Santri</h1>
        <p class="text-muted mb-0">Lihat informasi lengkap dan kelas santri.</p>
      </div>
    </div>
    <div class="heading-actions">
      <a href="{{ route('santris.index') }}" class="btn btn-outline-secondary btn-sm">Kembali</a>
      @if(Auth::user()->isAdmin())
        <a href="{{ route('santris.edit', $santri) }}" class="btn btn-primary btn-sm">Edit</a>
      @endif
    </div>
  </div>

  <div class="panel mt-3">
    <div class="row g-3">
      <div class="col-md-6">
        <div class="mb-3">
          <h6 class="mb-1">Nama Santri</h6>
          <p class="mb-0">{{ $santri->nama_santri }}</p>
        </div>
        <div class="mb-3">
          <h6 class="mb-1">Kelas</h6>
          <p class="mb-0">{{ optional($santri->kelas)->nama_kelas ?? '-' }}</p>
        </div>
        <div class="mb-3">
          <h6 class="mb-1">Jenis Kelamin</h6>
          <p class="mb-0">{{ $santri->jenis_kelamin }}</p>
        </div>
      </div>
      <div class="col-md-6">
        <div class="mb-3">
          <h6 class="mb-1">Orang Tua / Wali</h6>
          <p class="mb-0">{{ $santri->nama_orang_tua }}</p>
        </div>
        <div class="mb-3">
          <h6 class="mb-1">Alamat</h6>
          <p class="mb-0">{{ $santri->alamat }}</p>
        </div>
      </div>
    </div>
  </div>
@endsection
