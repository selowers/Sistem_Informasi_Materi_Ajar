@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
  <div class="page-heading">
    <div class="page-heading-copy">
      <span class="page-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
      <div>
        <p class="eyebrow mb-1">Overview</p>
        <h1 class="h3 mb-1">Dashboard {{ auth()->user()->isAdmin() ? 'Admin' : 'Guru' }}</h1>
        <p class="text-muted mb-0">Monitor performance, data, dan laporan dari satu workspace.</p>
      </div>
    </div>
  </div>

  <section class="row g-3 mt-1" aria-label="Dashboard metrics">
    <div class="col-12 col-sm-6 col-xl-3">
      <article class="metric-card metric-primary">
        <div class="metric-top">
          <span class="metric-label">Guru</span>
          <span class="metric-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
        </div>
        <div class="metric-value">{{ $guruCount }}</div>
        <div class="metric-meta"><span class="text-success">Data lengkap</span></div>
      </article>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
      <article class="metric-card metric-success">
        <div class="metric-top">
          <span class="metric-label">Kelas</span>
          <span class="metric-icon"><i class="bi bi-building" aria-hidden="true"></i></span>
        </div>
        <div class="metric-value">{{ $kelasCount }}</div>
        <div class="metric-meta"><span class="text-success">Terkelola</span></div>
      </article>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
      <article class="metric-card metric-warning">
        <div class="metric-top">
          <span class="metric-label">Materi</span>
          <span class="metric-icon"><i class="bi bi-book" aria-hidden="true"></i></span>
        </div>
        <div class="metric-value">{{ $materiCount }}</div>
        <div class="metric-meta"><span class="text-success">Siap dipakai</span></div>
      </article>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
      <article class="metric-card metric-danger">
        <div class="metric-top">
          <span class="metric-label">Jurnal</span>
          <span class="metric-icon"><i class="bi bi-journal" aria-hidden="true"></i></span>
        </div>
        <div class="metric-value">{{ $jurnalCount }}</div>
        <div class="metric-meta"><span class="text-danger">Update harian</span></div>
      </article>
    </div>
  </section>

  <section class="row g-3 mt-1">
    <div class="col-12">
      <div class="panel">
        <div class="panel-header">
          <div>
            <h2 class="h5 mb-1 section-title"><i class="bi bi-bar-chart-line" aria-hidden="true"></i><span>Monitor Performance</span></h2>
            <p class="text-muted mb-0">Grafik vertikal menunjukkan jumlah entitas saat ini.</p>
          </div>
          <a class="btn btn-light btn-sm" href="{{ route('dashboard') }}">Segarkan</a>
        </div>
        <div class="panel-body">
          @php
            $maxCount = max($guruCount, $kelasCount, $materiCount, $jurnalCount, 1);
          @endphp
          <div class="chart-bars">
            <div class="chart-column">
              <span style="--bar-size: {{ round($guruCount / $maxCount * 100) }}%; background: #2563eb;"></span>
              <div class="mt-2 text-center">
                <strong>{{ $guruCount }}</strong>
                <div class="text-muted small">Guru</div>
              </div>
            </div>
            <div class="chart-column">
              <span style="--bar-size: {{ round($kelasCount / $maxCount * 100) }}%; background: #0f766e;"></span>
              <div class="mt-2 text-center">
                <strong>{{ $kelasCount }}</strong>
                <div class="text-muted small">Kelas</div>
              </div>
            </div>
            <div class="chart-column">
              <span style="--bar-size: {{ round($materiCount / $maxCount * 100) }}%; background: #f59e0b;"></span>
              <div class="mt-2 text-center">
                <strong>{{ $materiCount }}</strong>
                <div class="text-muted small">Materi</div>
              </div>
            </div>
            <div class="chart-column">
              <span style="--bar-size: {{ round($jurnalCount / $maxCount * 100) }}%; background: #dc2626;"></span>
              <div class="mt-2 text-center">
                <strong>{{ $jurnalCount }}</strong>
                <div class="text-muted small">Jurnal</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
