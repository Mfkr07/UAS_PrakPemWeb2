@extends('layouts.public')

@section('content')
<div class="container py-5 my-md-4">
    <div class="row justify-content-center text-center mb-5">
        <div class="col-lg-8">
            <h1 class="display-4 fw-bold mb-3">Hubungi Kami</h1>
            <p class="lead text-muted">Beri tahu kami jika Anda memiliki pertanyaan, keluhan, maupun masukan untuk BlueNet.</p>
        </div>
    </div>
    
    <div class="row justify-content-center">
        <div class="col-md-5 mb-4">
            <div class="card card-custom h-100 bg-blue-gradient text-white">
                <div class="card-body p-5 text-center">
                    <i class="bi bi-geo-alt fs-1 mb-3 d-block"></i>
                    <h4 class="fw-bold mb-3">Lokasi Warnet</h4>
                    <p class="opacity-75 mb-4">Jl. Teknologi No. 404, Jakarta<br>Indonesia, 11220</p>
                    
                    <i class="bi bi-envelope fs-1 mb-3 d-block"></i>
                    <h4 class="fw-bold mb-3">Email</h4>
                    <p class="opacity-75">hello@bluenet.com<br>support@bluenet.com</p>
                </div>
            </div>
        </div>
        <div class="col-md-7 mb-4">
            <div class="card card-custom h-100 p-4">
                <div class="card-body">
                    <h4 class="fw-bold mb-4">Kirim Pesan</h4>
                    <form>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-semibold">Nama Lengkap</label>
                                <input type="text" class="form-control bg-light border-0 py-2" placeholder="Nama Anda">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-semibold">Alamat Email</label>
                                <input type="email" class="form-control bg-light border-0 py-2" placeholder="nama@email.com">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-muted small fw-semibold">Isi Pesan</label>
                            <textarea class="form-control bg-light border-0 py-2" rows="5" placeholder="Tulis masukan Anda di sini..."></textarea>
                        </div>
                        <button type="button" class="btn btn-primary btn-modern w-100">Kirim Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
