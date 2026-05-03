@extends('layouts.dashboard')

@section('styles')
<style>
    .page-title { font-size: 1.5rem; font-weight: 800; margin-bottom: 0.25rem; letter-spacing: -0.5px; }
    .page-subtitle { font-size: 0.875rem; color: var(--text-muted); margin-bottom: 2.5rem; }

    .admin-grid {
        display: grid;
        grid-template-columns: 1fr 2.5fr;
        gap: 2rem;
    }

    .form-card {
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 2rem;
    }
    .form-title { font-size: 1.125rem; font-weight: 800; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem; border-bottom: 1px dashed rgba(255,255,255,0.1); padding-bottom: 1.25rem; letter-spacing: -0.5px;}
    
    .form-group { margin-bottom: 1.5rem; }
    .form-label { display: block; font-size: 0.75rem; color: var(--text-muted); font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem; }
    .form-control { width: 100%; background: rgba(0,0,0,0.2); border: 1px solid var(--border-color); color: var(--text-main); padding: 0.875rem 1rem; border-radius: 6px; font-size: 0.875rem; transition: all 0.2s; }
    .form-control:focus { outline: none; border-color: var(--purple-light); box-shadow: 0 0 0 3px rgba(168, 85, 247, 0.15); }
    
    .btn-submit { background: var(--purple-light); color: var(--bg-dark); border: none; padding: 0.875rem; width: 100%; border-radius: 6px; font-weight: 800; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; transition: background 0.2s; }
    .btn-submit:hover { background: #d8b4fe; }

    .data-card {
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        overflow: hidden;
    }
    .table { width: 100%; border-collapse: collapse; }
    .table th { background: rgba(255,255,255,0.02); padding: 1.25rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid var(--border-color); }
    .table td { padding: 1.25rem 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.05); font-size: 0.875rem; vertical-align: middle; }
    .table tr:last-child td { border-bottom: none; }
    .table tbody tr:hover { background: rgba(255,255,255,0.01); }

    .item-name { font-weight: 700; display: flex; align-items: center; gap: 1rem; color: var(--text-main); }
    .item-img { width: 48px; height: 48px; border-radius: 8px; object-fit: cover; border: 1px solid rgba(255,255,255,0.1); }
    .item-img-placeholder { width: 48px; height: 48px; border-radius: 8px; background: rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: center; font-size: 0.625rem; color: var(--text-muted); text-align: center; border: 1px dashed rgba(255,255,255,0.1); }

    .btn-delete { background: transparent; border: 1px solid rgba(239, 68, 68, 0.3); color: #ef4444; width: 36px; height: 36px; border-radius: 4px; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; }
    .btn-delete:hover { background: rgba(239, 68, 68, 0.1); border-color: #ef4444; }
    .btn-delete svg { width: 18px; height: 18px; fill: currentColor; }

    .btn-edit { background: transparent; border: 1px solid rgba(168, 85, 247, 0.3); color: var(--purple-light); width: 36px; height: 36px; border-radius: 4px; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; }
    .btn-edit:hover { background: rgba(168, 85, 247, 0.1); border-color: var(--purple-light); }
    .btn-edit svg { width: 18px; height: 18px; fill: currentColor; }

    @media (max-width: 1024px) {
        .admin-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<h1 class="page-title">Manajemen Kantin</h1>
<p class="page-subtitle">Kelola menu makanan dan minuman yang tersedia untuk dipesan pelanggan.</p>

@if(session('success'))
<div style="background: rgba(16, 185, 129, 0.1); color: #10b981; padding: 1rem; border-radius: 8px; margin-bottom: 2rem; font-size: 0.875rem; border: 1px solid rgba(16, 185, 129, 0.2);">
    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
</div>
@endif

<div class="admin-grid">
    <!-- Kolom Kiri: Form Tambah Menu -->
    <div>
        <div class="form-card">
            <div class="form-title">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="var(--purple-light)"><path d="M11 9H9V2H7v7H5V2H3v7c0 2.12 1.66 3.84 3.75 3.97V22h2.5v-9.03C11.34 12.84 13 11.12 13 9V2h-2v7zm5-3v8h2.5v8H21V2c-2.76 0-5 2.24-5 4z"/></svg>
                Tambah Menu Baru
            </div>
            <form action="{{ route('admin.canteen.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="form-label">Nama Menu</label>
                    <input type="text" name="name" class="form-control" placeholder="Mis. Indomie Goreng Spesial" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Harga (Rp)</label>
                    <input type="number" name="price" class="form-control" placeholder="Mis. 10000" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Gambar Menu</label>
                    <input type="file" name="image" class="form-control" accept="image/*" style="padding-top: 0.6rem;">
                </div>
                <button type="submit" class="btn-submit">Simpan Menu</button>
            </form>
        </div>
    </div>

    <!-- Kolom Kanan: Tabel Data Menu -->
    <div>
        <div class="data-card">
            <table class="table">
                <thead>
                    <tr>
                        <th>Item Menu</th>
                        <th>Harga</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($canteenItems as $item)
                        <tr>
                            <td>
                                <div class="item-name">
                                    @if($item->image_path)
                                        <img src="{{ $item->image_path }}" class="item-img" alt="{{ $item->name }}">
                                    @else
                                        <div class="item-img-placeholder">No Img</div>
                                    @endif
                                    {{ $item->name }}
                                </div>
                            </td>
                            <td style="color: #10b981; font-weight: 700;">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td style="text-align: right;">
                                <!-- Tombol Edit dengan JS prompt sederhana -->
                                <button type="button" class="btn-edit" title="Edit Harga Menu" onclick="editMenu({{ $item->id }}, '{{ $item->name }}', {{ $item->price }})">
                                    <svg viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                </button>
                                
                                <form action="{{ route('admin.canteen.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus menu ini?')" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete" title="Hapus Menu">
                                        <svg viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                                    </button>
                                </form>

                                <!-- Form Edit Tersembunyi (Akan disubmit via JS) -->
                                <form id="edit-form-{{ $item->id }}" action="{{ route('admin.canteen.update', $item->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="name" id="edit-name-{{ $item->id }}" value="{{ $item->name }}">
                                    <input type="hidden" name="price" id="edit-price-{{ $item->id }}" value="{{ $item->price }}">
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align: center; color: var(--text-muted); padding: 4rem;">
                                <svg viewBox="0 0 24 24" width="48" height="48" fill="rgba(255,255,255,0.05)" style="margin-bottom: 1rem;"><path d="M11 9H9V2H7v7H5V2H3v7c0 2.12 1.66 3.84 3.75 3.97V22h2.5v-9.03C11.34 12.84 13 11.12 13 9V2h-2v7zm5-3v8h2.5v8H21V2c-2.76 0-5 2.24-5 4z"/></svg>
                                <div>Kantin masih kosong. Tambahkan menu pertama Anda.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function editMenu(id, currentName, currentPrice) {
    let newPrice = prompt(`Update Harga untuk ${currentName} (Rp):`, currentPrice);
    if (newPrice != null && newPrice !== "") {
        document.getElementById(`edit-price-${id}`).value = newPrice;
        document.getElementById(`edit-form-${id}`).submit();
    }
}
</script>
@endsection
