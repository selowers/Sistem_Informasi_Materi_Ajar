@extends('layouts.app')

@section('title', 'Edit Guru')

@section('content')
  <div class="page-heading">
    <div class="page-heading-copy">
      <span class="page-icon"><i class="bi bi-pencil-square" aria-hidden="true"></i></span>
      <div>
        <p class="eyebrow mb-1">Edit Guru</p>
        <h1 class="h3 mb-1">Perbarui Informasi Guru</h1>
        <p class="text-muted mb-0">Ubah data guru sesuai kebutuhan.</p>
      </div>
    </div>
  </div>

  <div class="panel mt-3">
    <form action="{{ route('gurus.update', $guru) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Nama Guru</label>
          <input type="text" name="nama_guru" class="form-control" value="{{ old('nama_guru', $guru->nama_guru) }}" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Mata Pelajaran</label>
          <input type="text" name="mata_pelajaran_nama" class="form-control" value="{{ old('mata_pelajaran_nama', optional($guru->mataPelajaran)->nama_mapel) }}" placeholder="Tuliskan nama mata pelajaran" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Jenis Kelamin</label>
          <select name="jenis_kelamin" class="form-select" required>
            <option value="">Pilih jenis kelamin</option>
            <option value="Laki-laki" @selected(old('jenis_kelamin', $guru->jenis_kelamin) == 'Laki-laki')>Laki-laki</option>
            <option value="Perempuan" @selected(old('jenis_kelamin', $guru->jenis_kelamin) == 'Perempuan')>Perempuan</option>
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">No HP</label>
          <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $guru->no_hp) }}" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Tempat Lahir</label>
          <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $guru->tempat_lahir) }}" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Tanggal Lahir</label>
          <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $guru->tanggal_lahir) }}" required>
        </div>
        <div class="col-12">
          <label class="form-label">Alamat</label>
          <textarea name="alamat" class="form-control" rows="3" required>{{ old('alamat', $guru->alamat) }}</textarea>
        </div>
      </div>
      <div class="mt-3">
        <button class="btn btn-primary">Perbarui</button>
        <a href="{{ route('gurus.index') }}" class="btn btn-outline-secondary">Batal</a>
      </div>
    </form>
  </div>
@endsection
