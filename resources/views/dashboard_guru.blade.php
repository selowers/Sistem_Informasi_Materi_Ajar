@extends('layouts.app')

@section('title', 'Dashboard Guru')

@section('content')
  <div class="page-heading">
    <div class="page-heading-copy">
      <span class="page-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
      <div>
        <p class="eyebrow mb-1">Selamat datang</p>
        <h1 class="h3 mb-1">{{ Auth::user()->display_name }}</h1>
        <p class="text-muted mb-0">Lihat data dan kelola materi serta jurnal pembelajaran.</p>
      </div>
    </div>
  </div>

  <section class="row g-3 mt-1" aria-label="Dashboard guru metrics">
    <div class="col-12 col-sm-6 col-xl-3">
      <article class="metric-card metric-success">
        <div class="metric-top">
          <span class="metric-label">Materi</span>
          <span class="metric-icon"><i class="bi bi-book" aria-hidden="true"></i></span>
        </div>
        <div class="metric-value">{{ $materiCount }}</div>
        <div class="metric-meta"><span class="text-success">Materi aktif</span></div>
      </article>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
      <article class="metric-card metric-warning">
        <div class="metric-top">
          <span class="metric-label">Jurnal</span>
          <span class="metric-icon"><i class="bi bi-journal" aria-hidden="true"></i></span>
        </div>
        <div class="metric-value">{{ $jurnalCount }}</div>
        <div class="metric-meta"><span class="text-success">Catatan hari ini</span></div>
      </article>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
      <article class="metric-card metric-danger">
        <div class="metric-top">
          <span class="metric-label">Kelas</span>
          <span class="metric-icon"><i class="bi bi-building" aria-hidden="true"></i></span>
        </div>
        <div class="metric-value">{{ $kelasCount }}</div>
        <div class="metric-meta"><span class="text-danger">Lihat kelas</span></div>
      </article>
    </div>
  </section>

  <section class="row g-3 mt-1">
    <div class="col-12">
      <div class="panel">
        <div class="panel-header">
          <div>
            <h2 class="h5 mb-1 section-title"><i class="bi bi-grid-3x3-gap-fill" aria-hidden="true"></i><span>Menu Cepat</span></h2>
            <p class="text-muted mb-0">Akses cepat ke fitur yang boleh dikelola oleh guru.</p>
          </div>
        </div>
        <div class="panel-body">
          <div class="row g-3">
            <div class="col-12 col-md-4">
              <a href="{{ route('materis.index') }}" class="card card-link p-4 text-decoration-none">
                <div class="d-flex align-items-center justify-content-between">
                  <div>
                    <h3 class="h6 mb-1">Materi</h3>
                    <p class="mb-0 text-muted">Kelola materi pembelajaran.</p>
                  </div>
                  <i class="bi bi-book fs-2 text-success"></i>
                </div>
              </a>
            </div>
            <div class="col-12 col-md-4">
              <a href="{{ route('jurnal_pembelajarans.index') }}" class="card card-link p-4 text-decoration-none">
                <div class="d-flex align-items-center justify-content-between">
                  <div>
                    <h3 class="h6 mb-1">Jurnal</h3>
                    <p class="mb-0 text-muted">Catat pembelajaran harian.</p>
                  </div>
                  <i class="bi bi-journal fs-2 text-warning"></i>
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
