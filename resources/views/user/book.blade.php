@extends('layouts.dashboard')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card card-custom border-0 shadow">
            <div class="card-header bg-gradient-blue text-center py-4 border-0">
                <h4 class="mb-0 fw-bold text-white">Booking {{ $computer->name }}</h4>
            </div>
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <p class="text-muted">Isi detail durasi penyewaan PC Anda.</p>
                </div>

                <form action="{{ route('user.store', $computer->id) }}" method="POST">
                    @csrf
                    <!-- Nama dipatenkan ikut User ter-login -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-muted">Nama Penyewa</label>
                        <input type="text" class="form-control bg-light" value="{{ auth()->user()->name }}" readonly disabled>
                        <div class="form-text"><i class="bi bi-info-circle me-1"></i>Tagihan akan masuk ke akun Anda.</div>
                    </div>

                    <div class="mb-4">
                        <label for="duration_hours" class="form-label fw-semibold text-muted">Durasi Bermain (Jam)</label>
                        <div class="input-group input-group-lg">
                            <input type="number" name="duration_hours" id="duration_hours" class="form-control font-monospace border-primary bg-light" min="1" max="24" value="1" required>
                            <span class="input-group-text bg-white text-muted">Jam</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-primary-subtle rounded-3">
                        <span class="fw-semibold text-primary">Tarif per Jam:</span>
                        <span class="fw-bold text-primary" id="tarif" data-price="{{ $computer->price_per_hour }}">Rp {{ number_format($computer->price_per_hour, 0, ',', '.') }}</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4 px-1 py-3 border-top border-bottom">
                        <span class="fw-bold fs-5 text-dark">Total Tagihan:</span>
                        <span class="fw-bold fs-3 text-primary" id="total_price">Rp {{ number_format($computer->price_per_hour, 0, ',', '.') }}</span>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-modern btn-lg bg-gradient-blue border-0 shadow-sm">Konfirmasi Booking</button>
                        <a href="{{ route('home') }}" class="btn btn-light btn-modern btn-lg text-muted fw-semibold">Batalkan</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const durationInput = document.getElementById('duration_hours');
        const tarifElement = document.getElementById('tarif');
        const totalElement = document.getElementById('total_price');
        const pricePerHour = parseInt(tarifElement.getAttribute('data-price'));

        durationInput.addEventListener('input', function() {
            let duration = parseInt(this.value);
            if(isNaN(duration) || duration < 1) duration = 0;
            
            const total = duration * pricePerHour;
            totalElement.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        });
    });
</script>
@endsection
