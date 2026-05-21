@extends('layouts.app')

@section('title', 'Edit Kelas')

@section('content')
  <div class="page-heading">
    <div class="page-heading-copy">
      <span class="page-icon"><i class="bi bi-pencil-square" aria-hidden="true"></i></span>
      <div>
        <p class="eyebrow mb-1">Edit Kelas</p>
        <h1 class="h3 mb-1">Perbarui Informasi Kelas</h1>
        <p class="text-muted mb-0">Ubah data kelas sesuai kebutuhan.</p>
      </div>
    </div>
  </div>

  <div class="panel mt-3">
    <form action="{{ route('kelas.update', $kelas) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Nama Kelas</label>
          <input type="text" name="nama_kelas" class="form-control" value="{{ old('nama_kelas', $kelas->nama_kelas) }}" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Tahun Ajaran</label>
          <input type="text" name="tahun_ajaran" class="form-control" value="{{ old('tahun_ajaran', $kelas->tahun_ajaran) }}" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Wali Kelas (opsional)</label>
          <select name="wali_kelas_id" class="form-select">
            <option value="">Pilih wali kelas</option>
            @foreach($gurus as $guru)
              <option value="{{ $guru->id }}" @selected(old('wali_kelas_id', $kelas->wali_kelas_id) == $guru->id)>{{ $guru->nama_guru }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Jumlah Santri</label>
          <input type="number" name="jumlah_santri" class="form-control" value="{{ old('jumlah_santri', $kelas->jumlah_santri) }}" min="0" required>
        </div>
      </div>
      <div class="mt-3">
        <button class="btn btn-primary">Perbarui</button>
        <a href="{{ route('kelas.index') }}" class="btn btn-outline-secondary">Batal</a>
      </div>
    </form>
  </div>
@endsection
