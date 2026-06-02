@extends('layouts.app')

@section('title', 'Tambah Materi')

@section('content')
  <div class="page-heading">
    <div class="page-heading-copy">
      <span class="page-icon"><i class="bi bi-plus-square" aria-hidden="true"></i></span>
      <div>
        <p class="eyebrow mb-1">Tambah Materi</p>
        <h1 class="h3 mb-1">Form Tambah Materi</h1>
        <p class="text-muted mb-0">Tambah materi pembelajaran baru untuk kelas dan mapel tertentu.</p>
      </div>
    </div>
  </div>

  <div class="panel mt-3">
    <form action="{{ route('materis.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Judul Materi</label>
          <input type="text" name="judul_materi" class="form-control" value="{{ old('judul_materi') }}" required>
        </div>
        <div class="col-12">
          <label class="form-label">File Materi</label>
          <input type="file" name="file_materi[]" class="form-control" id="fileInput" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif,.bmp" multiple required>
          <small class="text-muted d-block mt-1">Tipe file: PDF, Word, Gambar (JPG, PNG, GIF, BMP). Bisa upload lebih dari 1 file. Maksimum 50 MB per file.</small>
          <div id="filePreview" class="mt-3"></div>
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
        <div class="col-md-6">
          <label class="form-label">Guru Pengampu</label>
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
          <label class="form-label">Materi Pertemuan</label>
          <input type="text" name="materi_pertemuan" class="form-control" value="{{ old('materi_pertemuan') }}" placeholder="Masukkan materi pertemuan">
        </div>
        <div class="col-12">
          <label class="form-label">Deskripsi</label>
          <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi') }}</textarea>
        </div>
      </div>
      <div class="mt-3">
        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('materis.index') }}" class="btn btn-outline-secondary">Batal</a>
      </div>
    </form>
  </div>

  <script>
    (function(){
      const input = document.getElementById('fileInput');
      if (!input) return;
      input.addEventListener('change', function(e) {
        const preview = document.getElementById('filePreview');
        preview.innerHTML = '';

        const files = Array.from(e.target.files || []);
        if (files.length === 0) return;

        const list = document.createElement('div');
        list.innerHTML = '<label class="form-label">Preview File (klik "Preview" untuk membuka di tab baru):</label>';

        files.forEach(function(file, idx) {
          const fileExt = file.name.split('.').pop().toLowerCase();
          const row = document.createElement('div');
          row.className = 'd-flex align-items-center justify-content-between p-2 border rounded mb-2';
          row.style.backgroundColor = '#f8f9fa';

          const left = document.createElement('div');
          left.innerHTML = '<div class="small fw-500">' + file.name + '</div>' +
                           '<small class="text-muted">' + fileExt.toUpperCase() + ' • ' + (file.size/1024).toFixed(2) + ' KB</small>';

          const btns = document.createElement('div');
          btns.className = 'd-flex gap-2';

          const previewBtn = document.createElement('button');
          previewBtn.type = 'button';
          previewBtn.className = 'btn btn-sm btn-outline-primary';
          previewBtn.textContent = 'Preview';
          previewBtn.addEventListener('click', function() {
            const url = URL.createObjectURL(file);
            window.open(url, '_blank');
            // revoke after a while
            setTimeout(function(){ URL.revokeObjectURL(url); }, 10000);
          });

          btns.appendChild(previewBtn);

          row.appendChild(left);
          row.appendChild(btns);
          list.appendChild(row);
        });

        preview.appendChild(list);
      });
    })();
  </script>
@endsection
