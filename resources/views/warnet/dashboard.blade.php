@extends('layouts.app')

@section('content')
<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold text-dark">Dashboard PC</h2>
        <p class="text-muted">Pilih komputer yang tersedia untuk disewa.</p>
    </div>
</div>

<div class="row g-4">
    @foreach ($computers as $pc)
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card card-custom h-100 {{ $pc->status == 'available' ? 'border-primary' : 'border-secondary' }}">
                <div class="card-body text-center d-flex flex-column justify-content-between">
                    <div>
                        <div class="mb-3">
                            <i class="bi bi-display {{ $pc->status == 'available' ? 'text-primary' : 'text-secondary' }}" style="font-size: 3.5rem;"></i>
                        </div>
                        <h5 class="card-title fw-bold mb-1">{{ $pc->name }}</h5>
                        <p class="small text-muted mb-3">Rp {{ number_format($pc->price_per_hour, 0, ',', '.') }} / Jam</p>
                        
                        @if ($pc->status == 'available')
                            <span class="badge bg-primary-subtle text-primary mb-3 px-3 py-2 rounded-pill">Tersedia</span>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary mb-3 px-3 py-2 rounded-pill">Status: Digunakan</span>
                        @endif
                    </div>

                    <div class="mt-auto">
                        @if ($pc->status == 'available')
                            <a href="{{ route('warnet.book', $pc->id) }}" class="btn btn-primary btn-modern w-100">Booking Sekarang</a>
                        @else
                            <form action="{{ route('warnet.finish', $pc->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-secondary btn-modern w-100">Selesai/Checkout</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
