@extends('layouts.app')

@section('title', 'Detail Jurnal Pembelajaran')

@section('content')
  <div class="page-heading">
    <div class="page-heading-copy">
      <span class="page-icon"><i class="bi bi-journal" aria-hidden="true"></i></span>
      <div>
        <p class="eyebrow mb-1">Jurnal</p>
        <h1 class="h3 mb-1">Detail Jurnal Pembelajaran</h1>
        <p class="text-muted mb-0">Lihat informasi lengkap jurnal pembelajaran.</p>
      </div>
    </div>
    <div class="heading-actions">
      <a href="{{ route('jurnal_pembelajarans.index') }}" class="btn btn-outline-secondary btn-sm">Kembali</a>
      <a href="{{ route('jurnal_pembelajarans.edit', $jurnal_pembelajaran) }}" class="btn btn-primary btn-sm">Edit</a>
    </div>
  </div>

  <div class="panel mt-3">
    <div class="row g-3">
      <div class="col-md-6">
        <div class="mb-3">
          <h6 class="mb-1">Tanggal Pembelajaran</h6>
          <p class="mb-0">{{ $jurnal_pembelajaran->tanggal_pembelajaran ? \Carbon\Carbon::parse($jurnal_pembelajaran->tanggal_pembelajaran)->format('d M Y') : '-' }}</p>
        </div>
        <div class="mb-3">
          <h6 class="mb-1">Guru</h6>
          <p class="mb-0">{{ optional($jurnal_pembelajaran->guru)->nama_guru ?? '-' }}</p>
        </div>
        <div class="mb-3">
          <h6 class="mb-1">Mata Pelajaran</h6>
          <p class="mb-0">{{ optional($jurnal_pembelajaran->mataPelajaran)->nama_mapel ?? '-' }}</p>
        </div>
      </div>
      <div class="col-md-6">
        <div class="mb-3">
          <h6 class="mb-1">Kelas</h6>
          <p class="mb-0">{{ optional($jurnal_pembelajaran->kelas)->nama_kelas ?? '-' }}</p>
        </div>
        <div class="mb-3">
          <h6 class="mb-1">Materi Disampaikan</h6>
          <p class="mb-0">{{ $jurnal_pembelajaran->materi_disampaikan }}</p>
        </div>
        <div class="mb-3">
          <h6 class="mb-1">Hadir / Tidak Hadir</h6>
          <p class="mb-0">{{ $jurnal_pembelajaran->jumlah_hadir }} / {{ $jurnal_pembelajaran->jumlah_tidak_hadir }}</p>
        </div>
      </div>
      <div class="col-12">
        <div class="mb-3">
          <h6 class="mb-1">Catatan Pembelajaran</h6>
          <p class="mb-0">{{ $jurnal_pembelajaran->catatan_pembelajaran ?? '-' }}</p>
        </div>
        <div class="mb-3">
          <h6 class="mb-1">Kendala Pembelajaran</h6>
          <p class="mb-0">{{ $jurnal_pembelajaran->kendala_pembelajaran ?? '-' }}</p>
        </div>
      </div>
    </div>
  </div>
@endsection
