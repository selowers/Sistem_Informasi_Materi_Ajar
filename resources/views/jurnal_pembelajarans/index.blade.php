@extends('layouts.app')

@section('title', 'Daftar Jurnal Pembelajaran')

@section('content')
  <div class="page-heading">
    <div class="page-heading-copy">
      <span class="page-icon"><i class="bi bi-journal" aria-hidden="true"></i></span>
      <div>
        <p class="eyebrow mb-1">Jurnal Pembelajaran</p>
        <h1 class="h3 mb-1">Daftar Jurnal Pembelajaran</h1>
        <p class="text-muted mb-0">Kelola catatan pembelajaran harian guru.</p>
      </div>
    </div>
    <div class="heading-actions">
      <a href="{{ route('jurnal_pembelajarans.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg"></i> Tambah Jurnal
      </a>
    </div>
  </div>

  <div class="panel mt-3">
    <div class="table-responsive">
      <table class="table align-middle mb-0">
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>Guru</th>
            <th>Mapel</th>
            <th>Kelas</th>
            <th>Materi</th>
            <th>Hadir/Tidak</th>
            <th class="text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($jurnals as $jurnal)
            <tr>
              <td>{{ $jurnal->tanggal_pembelajaran ? \Carbon\Carbon::parse($jurnal->tanggal_pembelajaran)->format('d M Y') : '-' }}</td>
              <td>{{ optional($jurnal->guru)->nama_guru }}</td>
              <td>{{ optional($jurnal->mataPelajaran)->nama_mapel }}</td>
              <td>{{ optional($jurnal->kelas)->nama_kelas }}</td>
              <td>{{ \Illuminate\Support\Str::limit($jurnal->materi_disampaikan, 40) }}</td>
              <td>{{ $jurnal->jumlah_hadir }} / {{ $jurnal->jumlah_tidak_hadir }}</td>
              <td class="text-end">
                <a href="{{ route('jurnal_pembelajarans.show', $jurnal) }}" class="btn btn-sm btn-outline-primary me-1">Detail</a>
                <a href="{{ route('jurnal_pembelajarans.edit', $jurnal) }}" class="btn btn-sm btn-outline-secondary me-1">Edit</a>
                <form action="{{ route('jurnal_pembelajarans.destroy', $jurnal) }}" method="POST"
                      class="d-inline-block" onsubmit="return confirm('Hapus jurnal ini?');">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center text-muted py-4">Belum ada jurnal pembelajaran.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Pagination --}}
    @if($jurnals->hasPages())
      <div class="d-flex justify-content-between align-items-center px-3 py-2 border-top flex-wrap gap-2">
        <small class="text-muted">
          Menampilkan {{ $jurnals->firstItem() }}–{{ $jurnals->lastItem() }}
          dari {{ $jurnals->total() }} data
        </small>
        {{ $jurnals->withQueryString()->links() }}
      </div>
    @endif
  </div>
@endsection