@extends('layouts.dashboard')

@section('styles')
<style>
    .page-title { font-size: 1.5rem; font-weight: 800; margin-bottom: 0.25rem; letter-spacing: -0.5px; }
    .page-subtitle { font-size: 0.875rem; color: var(--text-muted); margin-bottom: 2.5rem; }

    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    .metric-card {
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        position: relative;
        overflow: hidden;
    }
    
    .metric-icon {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
    }
    .metric-icon.purple { background-color: rgba(168, 85, 247, 0.1); color: var(--purple-light); }
    .metric-icon.cyan { background-color: rgba(6, 182, 212, 0.1); color: #06b6d4; }
    .metric-icon.green { background-color: rgba(16, 185, 129, 0.1); color: #10b981; }
    .metric-icon.yellow { background-color: rgba(245, 158, 11, 0.1); color: #f59e0b; }
    
    .metric-icon svg { width: 24px; height: 24px; fill: currentColor; }

    .metric-label { font-size: 0.75rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem; }
    .metric-value { font-size: 1.75rem; font-weight: 800; color: var(--text-main); }

    .info-panel {
        background: linear-gradient(135deg, rgba(168, 85, 247, 0.1) 0%, rgba(21, 17, 28, 1) 100%);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 3rem;
        display: flex;
        align-items: center;
        gap: 3rem;
    }
    .info-panel-icon {
        width: 80px; height: 80px; border-radius: 50%; background: rgba(168, 85, 247, 0.2);
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 0 30px rgba(168, 85, 247, 0.3);
        flex-shrink: 0;
    }
    .info-panel-icon svg { width: 40px; height: 40px; fill: var(--purple-light); }
    .info-content h2 { font-size: 1.5rem; font-weight: 800; margin-bottom: 0.5rem; letter-spacing: -0.5px;}
    .info-content p { color: var(--text-muted); font-size: 0.875rem; line-height: 1.6; max-width: 600px; }
</style>
@endsection

@section('content')
<h1 class="page-title">Overview Admin</h1>
<p class="page-subtitle">Ringkasan performa dan metrik operasional harian.</p>

<div class="metrics-grid">
    <div class="metric-card">
        <div class="metric-icon purple">
            <svg viewBox="0 0 24 24"><path d="M21 18v1c0 1.1-.9 2-2 2H5c-1.11 0-2-.9-2-2V5c0-1.1.89-2 2-2h14c1.1 0 2 .9 2 2v1h-9c-1.11 0-2 .9-2 2v8c0 1.1.89 2 2 2h9zm-9-2h10V8H12v8zm4-2.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/></svg>
        </div>
        <div class="metric-label">Total Pendapatan</div>
        <div class="metric-value">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</div>
    </div>
    
    <div class="metric-card">
        <div class="metric-icon cyan">
            <svg viewBox="0 0 24 24"><path d="M18 17H6v-2h12v2zm0-4H6v-2h12v2zm0-4H6V7h12v2zM3 22l1.5-1.5L6 22l1.5-1.5L9 22l1.5-1.5L12 22l1.5-1.5L15 22l1.5-1.5L18 22l1.5-1.5L21 22V2l-1.5 1.5L18 2l-1.5 1.5L15 2l-1.5 1.5L12 2l-1.5 1.5L9 2 7.5 3.5 6 2 4.5 3.5 3 2v20z"/></svg>
        </div>
        <div class="metric-label">Pesanan / Billing</div>
        <div class="metric-value">{{ $totalBookings ?? 0 }}</div>
    </div>
    
    <div class="metric-card">
        <div class="metric-icon green">
            <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
        </div>
        <div class="metric-label">Total Pelanggan</div>
        <div class="metric-value">{{ $totalUsers ?? 0 }}</div>
    </div>
    
    <div class="metric-card">
        <div class="metric-icon yellow">
            <svg viewBox="0 0 24 24"><path d="M21 2H3c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h7v2H8v2h8v-2h-2v-2h7c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H3V4h18v12z"/></svg>
        </div>
        <div class="metric-label">Unit PC Tersedia</div>
        <div class="metric-value">{{ $totalPcs ?? 0 }}</div>
    </div>
</div>

<div class="info-panel" style="margin-bottom: 3rem;">
    <div class="info-panel-icon">
        <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
    </div>
    <div class="info-content">
        <h2>Sistem Monitoring Aktif</h2>
        <p>Sistem ini dioptimalkan untuk memonitoring setiap aktivitas stasiun pertempuran. Gunakan navigasi sidebar untuk mengecek riwayat tagihan terbaru dan mengelola inventaris PC yang tersedia.</p>
    </div>
</div>

<div style="background-color: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; padding: 2rem;">
    <h3 style="font-size: 1.125rem; font-weight: 800; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem; letter-spacing: -0.5px;">
        <svg viewBox="0 0 24 24" width="20" height="20" fill="var(--purple-light)"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
        Tren Pendapatan 7 Hari Terakhir
    </h3>
    <canvas id="revenueChart" height="80"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: {!! json_encode($chartValues) !!},
                    borderColor: '#a855f7',
                    backgroundColor: 'rgba(168, 85, 247, 0.1)',
                    borderWidth: 3,
                    pointBackgroundColor: '#a855f7',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { 
                        beginAtZero: true, 
                        grid: { color: 'rgba(255,255,255,0.05)', drawBorder: false }, 
                        ticks: { color: '#9ca3af', font: { family: 'Inter, sans-serif' } } 
                    },
                    x: { 
                        grid: { display: false }, 
                        ticks: { color: '#9ca3af', font: { family: 'Inter, sans-serif' } } 
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1f1a24',
                        titleColor: '#fff',
                        bodyColor: '#a855f7',
                        borderColor: 'rgba(168, 85, 247, 0.3)',
                        borderWidth: 1,
                        padding: 12,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                let value = context.parsed.y;
                                return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
