@extends('layouts.app')

@section('title', 'Edit Kurikulum')

@section('content')
  <div class="page-heading">
    <div class="page-heading-copy">
      <span class="page-icon"><i class="bi bi-pencil-square" aria-hidden="true"></i></span>
      <div>
        <p class="eyebrow mb-1">Edit Kurikulum</p>
        <h1 class="h3 mb-1">Perbarui Kurikulum</h1>
        <p class="text-muted mb-0">Ubah data kurikulum yang tersimpan.</p>
      </div>
    </div>
  </div>

  <div class="panel mt-3">
    <form action="{{ route('kurikulums.update', $kurikulum) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Mata Pelajaran</label>
          <select name="mata_pelajaran_id" class="form-select" required>
            <option value="">Pilih mapel</option>
            @foreach($mataPelajarans as $mapel)
              <option value="{{ $mapel->id }}" @selected(old('mata_pelajaran_id', $kurikulum->mata_pelajaran_id) == $mapel->id)>{{ $mapel->nama_mapel }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Kelas</label>
          <select name="kelas_id" class="form-select" required>
            <option value="">Pilih kelas</option>
            @foreach($kelas as $item)
              <option value="{{ $item->id }}" @selected(old('kelas_id', $kurikulum->kelas_id) == $item->id)>{{ $item->nama_kelas }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Tahun Ajaran</label>
          <input type="text" name="tahun_ajaran" class="form-control" value="{{ old('tahun_ajaran', $kurikulum->tahun_ajaran) }}" required>
        </div>
        <div class="col-12">
          <label class="form-label">Deskripsi</label>
          <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $kurikulum->deskripsi) }}</textarea>
        </div>
      </div>
      <div class="mt-3">
        <button class="btn btn-primary">Perbarui</button>
        <a href="{{ route('kurikulums.index') }}" class="btn btn-outline-secondary">Batal</a>
      </div>
    </form>
  </div>
@endsection
