@extends('layouts.dashboard')

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
                        <th class="py-3 text-secondary fw-semibold">Status PC</th>
                        <th class="py-3 pe-4 text-end text-secondary fw-semibold">Total Tagihan</th>
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
                                @if($booking->computer && $booking->computer->status == 'in_use')
                                    <span class="badge bg-warning text-dark px-2 py-1"><i class="bi bi-clock-history me-1"></i>Sedang Main</span>
                                @else
                                    <span class="badge bg-success bg-opacity-10 text-success px-2 py-1"><i class="bi bi-check-circle me-1"></i>Selesai</span>
                                @endif
                            </td>
                            <td class="pe-4 text-end fw-bold text-dark">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
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
