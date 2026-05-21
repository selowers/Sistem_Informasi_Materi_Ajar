@extends('layouts.app')

@section('title', 'Tambah Guru')

@section('content')
  <div class="page-heading">
    <div class="page-heading-copy">
      <span class="page-icon"><i class="bi bi-person-plus" aria-hidden="true"></i></span>
      <div>
        <p class="eyebrow mb-1">Tambah Guru</p>
        <h1 class="h3 mb-1">Form Tambah Guru</h1>
        <p class="text-muted mb-0">Isi data guru baru dan asosiasikan dengan mata pelajaran.</p>
      </div>
    </div>
  </div>

  <div class="panel mt-3">
    <form action="{{ route('gurus.store') }}" method="POST">
      @csrf
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Nama Guru</label>
          <input type="text" name="nama_guru" class="form-control" value="{{ old('nama_guru') }}" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Mata Pelajaran</label>
          <input type="text" name="mata_pelajaran_nama" class="form-control" value="{{ old('mata_pelajaran_nama') }}" placeholder="Tuliskan nama mata pelajaran" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Jenis Kelamin</label>
          <select name="jenis_kelamin" class="form-select" required>
            <option value="">Pilih jenis kelamin</option>
            <option value="Laki-laki" @selected(old('jenis_kelamin') == 'Laki-laki')>Laki-laki</option>
            <option value="Perempuan" @selected(old('jenis_kelamin') == 'Perempuan')>Perempuan</option>
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">No HP</label>
          <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Tempat Lahir</label>
          <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir') }}" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Tanggal Lahir</label>
          <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}" required>
        </div>
        <div class="col-12">
          <label class="form-label">Alamat</label>
          <textarea name="alamat" class="form-control" rows="3" required>{{ old('alamat') }}</textarea>
        </div>
      </div>
      <div class="mt-3">
        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('gurus.index') }}" class="btn btn-outline-secondary">Batal</a>
      </div>
    </form>
  </div>
@endsection
