@extends('layouts.dashboard')

@section('styles')
    <style>
        .btn-receipt {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.4rem 0.75rem;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .btn-receipt-view {
            background: rgba(168, 85, 247, 0.1);
            color: #c084fc;
            border: 1px solid rgba(168, 85, 247, 0.2);
        }

        .btn-receipt-view:hover {
            background: rgba(168, 85, 247, 0.2);
            color: #d8b4fe;
        }

        .btn-receipt-pdf {
            background: rgba(6, 182, 212, 0.1);
            color: #06b6d4;
            border: 1px solid rgba(6, 182, 212, 0.2);
        }

        .btn-receipt-pdf:hover {
            background: rgba(6, 182, 212, 0.2);
            color: #22d3ee;
        }

        .btn-receipt svg {
            width: 12px;
            height: 12px;
            fill: currentColor;
        }
    </style>
@endsection

@section('content')
<div class="row align-items-center mb-4">
    <div class="col-md-8">
        <h2 class="fw-bold text-dark mb-0">Riwayat Sewa Saya</h2>
        <p class="text-muted mt-1">Daftar semua billing dan pesanan Anda beserta detail tagihan.</p>
    </div>
</div>

<div class="card card-custom border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="py-3 ps-4 text-secondary fw-semibold">ID</th>
                        <th class="py-3 text-secondary fw-semibold">Komputer</th>
                        <th class="py-3 text-secondary fw-semibold">Waktu Mulai</th>
                        <th class="py-3 text-secondary fw-semibold">Durasi</th>
                        <th class="py-3 text-secondary fw-semibold">Status</th>
                        <th class="py-3 text-secondary fw-semibold">Total Tagihan</th>
                        <th class="py-3 pe-4 text-end text-secondary fw-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($bookings as $booking)
                        <tr>
                            <td class="ps-4 fw-medium text-muted">#{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded px-2 py-1 me-2">
                                        <i class="bi bi-pc-display"></i>
                                    </div>
                                    <span class="fw-bold">{{ $booking->computer->name ?? 'PC Dihapus' }}</span>
                                </div>
                            </td>
                            <td>{{ $booking->start_time->format('d M Y, H:i') }}</td>
                            <td>{{ $booking->duration_hours }} Jam</td>
                            <td>
                                @if($booking->status === 'booked')
                                    <span class="badge bg-warning text-dark px-2 py-1">Booked</span>
                                @elseif($booking->status === 'active')
                                    <span class="badge bg-info text-white px-2 py-1">Aktif</span>
                                @elseif($booking->status === 'completed')
                                    <span class="badge bg-success bg-opacity-10 text-success px-2 py-1">Selesai</span>
                                @elseif($booking->status === 'cancelled')
                                    <span class="badge bg-danger bg-opacity-10 text-danger px-2 py-1">Dibatalkan</span>
                                @endif
                            </td>
                            <td class="fw-bold text-dark">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                            <td class="pe-4 text-end">
                                <div style="display: flex; gap: 0.35rem; justify-content: flex-end;">
                                    <a href="{{ route('booking.receipt', $booking->id) }}" class="btn-receipt btn-receipt-view" title="Lihat Struk">
                                        <svg viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/></svg>
                                        Struk
                                    </a>
                                    <a href="{{ route('booking.receipt.pdf', $booking->id) }}" class="btn-receipt btn-receipt-pdf" title="Download PDF">
                                        <svg viewBox="0 0 24 24"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
                                        PDF
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="bi bi-journal-x text-muted" style="font-size: 3rem;"></i>
                                <p class="text-muted mt-3 mb-0">Belum ada riwayat pesanan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

