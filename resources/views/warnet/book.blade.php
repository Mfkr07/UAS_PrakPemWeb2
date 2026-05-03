@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card card-custom">
            <div class="card-header bg-gradient-blue text-center py-4 border-0">
                <h4 class="mb-0 fw-bold">Booking {{ $computer->name }}</h4>
            </div>
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <p class="text-muted">Isi detail penyewaan di bawah ini.</p>
                </div>

                <form action="{{ route('warnet.store', $computer->id) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="customer_name" class="form-label fw-semibold">Nama Penulis/Penyewa</label>
                        <input type="text" name="customer_name" id="customer_name" class="form-control form-control-lg bg-light" placeholder="Masukkan nama..." required autofocus>
                    </div>

                    <div class="mb-4">
                        <label for="duration_hours" class="form-label fw-semibold">Durasi Bermain (Jam)</label>
                        <div class="input-group input-group-lg">
                            <input type="number" name="duration_hours" id="duration_hours" class="form-control bg-light" min="1" max="24" value="1" required>
                            <span class="input-group-text bg-white border-start-0 text-muted">Jam</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-primary-subtle rounded-3">
                        <span class="fw-semibold text-primary">Tarif per Jam:</span>
                        <span class="fw-bold text-primary" id="tarif" data-price="{{ $computer->price_per_hour }}">Rp {{ number_format($computer->price_per_hour, 0, ',', '.') }}</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4 px-1">
                        <span class="fw-bold fs-5">Total Bayar:</span>
                        <span class="fw-bold fs-4 text-primary" id="total_price">Rp {{ number_format($computer->price_per_hour, 0, ',', '.') }}</span>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-modern btn-lg bg-gradient-blue border-0">Konfirmasi Booking</button>
                        <a href="{{ route('dashboard') }}" class="btn btn-light btn-modern btn-lg text-muted">Kembali</a>
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
            // Format to Rupiah
            totalElement.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        });
    });
</script>
@endsection
