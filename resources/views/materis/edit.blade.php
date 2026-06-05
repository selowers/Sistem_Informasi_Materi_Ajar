@extends('layouts.app')

@section('title', 'Edit Materi')

@section('content')
  <div class="page-heading">
    <div class="page-heading-copy">
      <span class="page-icon"><i class="bi bi-pencil-square" aria-hidden="true"></i></span>
      <div>
        <p class="eyebrow mb-1">Edit Materi</p>
        <h1 class="h3 mb-1">Perbarui Materi</h1>
        <p class="text-muted mb-0">Ubah data materi pembelajaran yang sudah tersimpan.</p>
      </div>
    </div>
  </div>

  <div class="panel mt-3">
    <form action="{{ route('materis.update', $materi) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Judul Materi</label>
          <input type="text" name="judul_materi" class="form-control" value="{{ old('judul_materi', $materi->judul_materi) }}" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">File Materi</label>
          <input type="file" name="file_materi[]" class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif,.bmp" multiple>
          <small class="text-muted d-block mt-1">Tipe file: PDF, Word, Gambar (JPG, PNG, GIF, BMP). Bisa upload lebih dari 1 file. File lama akan tetap tersimpan. Maksimum 50 MB per file.</small>
          @php
            $files = json_decode($materi->file_materi, true);
          @endphp
          @if($files && is_array($files))
            <div class="mt-3">
              <label class="form-label">File yang Sudah Diupload:</label>
              <div class="mb-2">
                <button type="submit" form="bulk-delete-files-form" class="btn btn-sm btn-danger">Hapus Terpilih</button>
              </div>
              @foreach($files as $index => $file)
                @php $fileType = strtolower($file['type'] ?? ''); @endphp
                <div class="d-flex align-items-center justify-content-between p-2 border rounded mb-2" style="background-color: #f8f9fa;">
                  <div class="d-flex align-items-center gap-3">
                    <input type="checkbox" name="indexes[]" value="{{ $index }}" form="bulk-delete-files-form">
                    <div>
                      <div class="small fw-500">{{ $file['name'] ?? 'File' }}</div>
                      <small class="text-muted">{{ strtoupper($fileType) }}</small>
                    </div>
                  </div>
                  <div class="d-flex gap-2">
                    <a href="{{ route('materis.file.preview', ['materi' => $materi->id, 'index' => $index]) }}" target="_blank" class="btn btn-sm btn-outline-primary">Preview</a>
                    <a href="{{ route('materis.file.download', ['materi' => $materi->id, 'index' => $index]) }}" class="btn btn-sm btn-outline-secondary">Download</a>
                    <button class="btn btn-sm btn-danger" type="submit" form="delete-file-{{ $index }}">Hapus</button>
                  </div>
                </div>
              @endforeach
            </div>
          @endif
        </div>
        <div class="col-md-6">
          <label class="form-label">Mata Pelajaran</label>
          <select name="mata_pelajaran_id" class="form-select" required>
            <option value="">Pilih mapel</option>
            @foreach($mataPelajarans as $mapel)
              <option value="{{ $mapel->id }}" @selected(old('mata_pelajaran_id', $materi->mata_pelajaran_id) == $mapel->id)>{{ $mapel->nama_mapel }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Kelas</label>
          <select name="kelas_id" class="form-select" required>
            <option value="">Pilih kelas</option>
            @foreach($kelas as $item)
              <option value="{{ $item->id }}" @selected(old('kelas_id', $materi->kelas_id) == $item->id)>{{ $item->nama_kelas }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Guru Pengampu</label>
          @if(isset($currentGuru) && $currentGuru)
            <input type="text" class="form-control" value="{{ $currentGuru->nama_guru }}" readonly>
            <input type="hidden" name="guru_id" value="{{ $currentGuru->id }}">
          @else
            <select name="guru_id" class="form-select" required>
              <option value="">Pilih guru</option>
              @foreach($gurus as $guru)
                <option value="{{ $guru->id }}" @selected(old('guru_id', $materi->guru_id) == $guru->id)>{{ $guru->nama_guru }}</option>
              @endforeach
            </select>
          @endif
        </div>
        <div class="col-md-6">
          <label class="form-label">Materi Pertemuan</label>
          <input type="text" name="materi_pertemuan" class="form-control" value="{{ old('materi_pertemuan', $materi->materi_pertemuan) }}" placeholder="Masukkan materi pertemuan">
        </div>
        <div class="col-12">
          <label class="form-label">Deskripsi</label>
          <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $materi->deskripsi) }}</textarea>
        </div>
      </div>
      <div class="mt-3">
        <button class="btn btn-primary">Perbarui</button>
        <a href="{{ route('materis.index') }}" class="btn btn-outline-secondary">Batal</a>
      </div>
    </form>

    @if($files && is_array($files))
      <form id="bulk-delete-files-form" action="{{ route('materis.files.destroy', $materi) }}" method="POST" onsubmit="return confirm('Hapus file terpilih?');">
        @csrf
      </form>
      @foreach($files as $index => $file)
        <form id="delete-file-{{ $index }}" action="{{ route('materis.file.destroy', ['materi' => $materi->id, 'index' => $index]) }}" method="POST" onsubmit="return confirm('Hapus file ini?');">
          @csrf
          @method('DELETE')
        </form>
      @endforeach
    @endif
  </div>
@endsection
