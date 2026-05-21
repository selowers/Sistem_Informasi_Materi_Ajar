@extends('layouts.app')

@section('title', 'Edit Santri')

@section('content')
  <div class="page-heading">
    <div class="page-heading-copy">
      <span class="page-icon"><i class="bi bi-pencil-square" aria-hidden="true"></i></span>
      <div>
        <p class="eyebrow mb-1">Edit Santri</p>
        <h1 class="h3 mb-1">Perbarui Informasi Santri</h1>
        <p class="text-muted mb-0">Ubah data santri yang sudah terdaftar.</p>
      </div>
    </div>
  </div>

  <div class="panel mt-3">
    <form action="{{ route('santris.update', $santri) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Nama Santri</label>
          <input type="text" name="nama_santri" class="form-control" value="{{ old('nama_santri', $santri->nama_santri) }}" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Jenis Kelamin</label>
          <select name="jenis_kelamin" class="form-select" required>
            <option value="">Pilih jenis kelamin</option>
            <option value="Laki-laki" @selected(old('jenis_kelamin', $santri->jenis_kelamin) == 'Laki-laki')>Laki-laki</option>
            <option value="Perempuan" @selected(old('jenis_kelamin', $santri->jenis_kelamin) == 'Perempuan')>Perempuan</option>
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Kelas</label>
          <select name="kelas_id" class="form-select" required>
            <option value="">Pilih kelas</option>
            @foreach($kelas as $item)
              <option value="{{ $item->id }}" @selected(old('kelas_id', $santri->kelas_id) == $item->id)>{{ $item->nama_kelas }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Nama Orang Tua / Wali</label>
          <input type="text" name="nama_orang_tua" class="form-control" value="{{ old('nama_orang_tua', $santri->nama_orang_tua) }}" required>
        </div>
        <div class="col-12">
          <label class="form-label">Alamat</label>
          <textarea name="alamat" class="form-control" rows="3" required>{{ old('alamat', $santri->alamat) }}</textarea>
        </div>
      </div>
      <div class="mt-3">
        <button class="btn btn-primary">Perbarui</button>
        <a href="{{ route('santris.index') }}" class="btn btn-outline-secondary">Batal</a>
      </div>
    </form>
  </div>
@endsection
