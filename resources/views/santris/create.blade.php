@extends('layouts.app')

@section('title', 'Tambah Santri')

@section('content')
  <div class="page-heading">
    <div class="page-heading-copy">
      <span class="page-icon"><i class="bi bi-person-plus" aria-hidden="true"></i></span>
      <div>
        <p class="eyebrow mb-1">Tambah Santri</p>
        <h1 class="h3 mb-1">Form Tambah Santri</h1>
        <p class="text-muted mb-0">Masukkan data santri baru lengkap dengan kelas.</p>
      </div>
    </div>
  </div>

  <div class="panel mt-3">
    <form action="{{ route('santris.store') }}" method="POST">
      @csrf
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Nama Santri</label>
          <input type="text" name="nama_santri" class="form-control" value="{{ old('nama_santri') }}" required>
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
          <label class="form-label">Kelas</label>
          <select name="kelas_id" class="form-select" required>
            <option value="">Pilih kelas</option>
            @foreach($kelas as $item)
              <option value="{{ $item->id }}" @selected(old('kelas_id') == $item->id)>{{ $item->nama_kelas }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Nama Orang Tua / Wali</label>
          <input type="text" name="nama_orang_tua" class="form-control" value="{{ old('nama_orang_tua') }}" required>
        </div>
        <div class="col-12">
          <label class="form-label">Alamat</label>
          <textarea name="alamat" class="form-control" rows="3" required>{{ old('alamat') }}</textarea>
        </div>
      </div>
      <div class="mt-3">
        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('santris.index') }}" class="btn btn-outline-secondary">Batal</a>
      </div>
    </form>
  </div>
@endsection
