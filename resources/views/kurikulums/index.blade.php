@extends('layouts.app')

@section('title', 'Daftar Kurikulum')

@section('content')
  <div class="page-heading">
    <div class="page-heading-copy">
      <span class="page-icon"><i class="bi bi-journal-text" aria-hidden="true"></i></span>
      <div>
        <p class="eyebrow mb-1">Kurikulum</p>
        <h1 class="h3 mb-1">Daftar Kurikulum</h1>
        <p class="text-muted mb-0">Kelola kurikulum untuk setiap kelas dan mata pelajaran.</p>
      </div>
    </div>
    <div class="heading-actions"><a href="{{ route('kurikulums.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Tambah Kurikulum</a></div>
  </div>

  <div class="panel mt-3">
    <div class="table-responsive">
      <table class="table align-middle mb-0">
        <thead>
          <tr>
            <th>Mapel</th>
            <th>Kelas</th>
            <th>Tahun Ajaran</th>
            <th>Deskripsi</th>
            <th class="text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($kurikulums as $item)
            <tr>
              <td>{{ optional($item->mataPelajaran)->nama_mapel }}</td>
              <td>{{ optional($item->kelas)->nama_kelas }}</td>
              <td>{{ $item->tahun_ajaran }}</td>
              <td>{{ \Illuminate\Support\Str::limit($item->deskripsi, 50) }}</td>
              <td class="text-end">
                <a href="{{ route('kurikulums.show', $item) }}" class="btn btn-sm btn-outline-primary me-1">Detail</a>
              <a href="{{ route('kurikulums.edit', $item) }}" class="btn btn-sm btn-outline-secondary me-1">Edit</a>
                <form action="{{ route('kurikulums.destroy', $item) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Hapus kurikulum ini?');">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
              </td>
            </tr>
          @endforeach
          @if($kurikulums->isEmpty())
            <tr><td colspan="5" class="text-center">Belum ada data kurikulum.</td></tr>
          @endif
        </tbody>
      </table>
    </div>
  </div>
@endsection
