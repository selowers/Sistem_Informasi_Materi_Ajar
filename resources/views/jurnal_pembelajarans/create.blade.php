@extends('layouts.app')

@section('title', 'Tambah Jurnal Pembelajaran')

@section('content')
  <div class="page-heading">
    <div class="page-heading-copy">
      <span class="page-icon"><i class="bi bi-plus-square" aria-hidden="true"></i></span>
      <div>
        <p class="eyebrow mb-1">Tambah Jurnal</p>
        <h1 class="h3 mb-1">Form Tambah Jurnal Pembelajaran</h1>
        <p class="text-muted mb-0">Buat catatan pembelajaran baru.</p>
      </div>
    </div>
  </div>

  <div class="panel mt-3">
    <form action="{{ route('jurnal_pembelajarans.store') }}" method="POST">
      @csrf
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Tanggal Pembelajaran</label>
          <input type="date" name="tanggal_pembelajaran" class="form-control" value="{{ old('tanggal_pembelajaran') }}" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Guru</label>
          @if(isset($currentGuru) && $currentGuru)
            <input type="text" class="form-control" value="{{ $currentGuru->nama_guru }}" readonly>
            <input type="hidden" name="guru_id" value="{{ $currentGuru->id }}">
          @else
            <select name="guru_id" class="form-select" required>
              <option value="">Pilih guru</option>
              @foreach($gurus as $guru)
                <option value="{{ $guru->id }}" @selected(old('guru_id') == $guru->id)>{{ $guru->nama_guru }}</option>
              @endforeach
            </select>
          @endif
        </div>
        <div class="col-md-6">
          <label class="form-label">Mata Pelajaran</label>
          <select name="mata_pelajaran_id" class="form-select" required>
            <option value="">Pilih mapel</option>
            @foreach($mataPelajarans as $mapel)
              <option value="{{ $mapel->id }}" @selected(old('mata_pelajaran_id') == $mapel->id)>{{ $mapel->nama_mapel }}</option>
            @endforeach
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
        <div class="col-12">
          <label class="form-label">Materi Disampaikan</label>
          <textarea name="materi_disampaikan" class="form-control" rows="3" required>{{ old('materi_disampaikan') }}</textarea>
        </div>
        <div class="col-md-6">
          <label class="form-label">Jumlah Hadir</label>
          <input type="number" name="jumlah_hadir" class="form-control" value="{{ old('jumlah_hadir', 0) }}" min="0" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Jumlah Tidak Hadir</label>
          <input type="number" name="jumlah_tidak_hadir" class="form-control" value="{{ old('jumlah_tidak_hadir', 0) }}" min="0" required>
        </div>
        <div class="col-12">
          <label class="form-label">Catatan Pembelajaran</label>
          <textarea name="catatan_pembelajaran" class="form-control" rows="3">{{ old('catatan_pembelajaran') }}</textarea>
        </div>
        <div class="col-12">
          <label class="form-label">Kendala Pembelajaran</label>
          <textarea name="kendala_pembelajaran" class="form-control" rows="3">{{ old('kendala_pembelajaran') }}</textarea>
        </div>
      </div>
      <div class="mt-3">
        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('jurnal_pembelajarans.index') }}" class="btn btn-outline-secondary">Batal</a>
      </div>
    </form>
  </div>
@endsection
