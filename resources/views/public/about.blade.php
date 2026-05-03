@extends('layouts.public')

@section('content')
<div class="container py-5 my-md-4">
    <div class="row justify-content-center text-center mb-5">
        <div class="col-lg-8">
            <h1 class="display-4 fw-bold mb-3">Tentang <span class="text-primary">BlueNet</span></h1>
            <p class="lead text-muted">Warnet kekinian dengan komitmen menghadirkan pengalaman e-sports terbaik bagi para gamer profesional dan kasual.</p>
        </div>
    </div>
    <div class="row g-4 align-items-center">
        <div class="col-md-6">
            <img src="https://images.unsplash.com/photo-1511512578047-dfb367046420?q=80&w=2071&auto=format&fit=crop" class="img-fluid rounded-4 shadow" alt="Gaming Setup">
        </div>
        <div class="col-md-6 ps-md-5">
            <h3 class="fw-bold mb-4">Visi & Misi Kami</h3>
            <p class="text-muted mb-4">Membangun komunitas gamer yang sehat. BlueNet bukan sekadar tempat menyewa komputer, melainkan arena di mana *skill* diasah dan persahabatan E-sports terjalin.</p>
            <ul class="list-unstyled mb-0">
                <li class="d-flex align-items-start mb-3">
                    <i class="bi bi-check-circle-fill text-primary fs-5 me-3"></i>
                    <div>
                        <h5 class="fw-bold mb-1">PC Spesifikasi Tinggi</h5>
                        <p class="text-muted small">Ditenagai oleh prosesor dan grafis terbaru untuk jaminan frame rate tinggi.</p>
                    </div>
                </li>
                <li class="d-flex align-items-start mb-3">
                    <i class="bi bi-check-circle-fill text-primary fs-5 me-3"></i>
                    <div>
                        <h5 class="fw-bold mb-1">Koneksi Tanpa Lag</h5>
                        <p class="text-muted small">Ping super rendah ke server Asia Tenggara maupun lokal.</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
