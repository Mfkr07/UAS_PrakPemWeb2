# LAPORAN UAS - WARNET ASOY (Part 2: Admin)
## Format Per-Halaman: UI → Front-End → Back-End → Database

---

# 6. Admin - Dashboard Overview

### 6.1 Tampilan UI
![Admin Dashboard](C:/Users/yoru/.gemini/antigravity/brain/9f667511-0be1-4bb3-ab1b-2a813d83665e/artifacts/08_admin_dashboard.png)

### 6.2 Front-End Program
*File: `resources/views/admin/dashboard.blade.php`*
```php
@extends('layouts.dashboard')
@section('content')
<h1>Overview Admin</h1>
<p>Ringkasan performa dan metrik operasional harian.</p>

<div class="metrics-grid">
    <div class="metric-card">
        <div class="metric-label">Total Pendapatan</div>
        <div class="metric-value">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</div>
    </div>
    <div class="metric-card">
        <div class="metric-label">Pesanan / Billing</div>
        <div class="metric-value">{{ $totalBookings ?? 0 }}</div>
    </div>
    <div class="metric-card">
        <div class="metric-label">Total Pelanggan</div>
        <div class="metric-value">{{ $totalUsers ?? 0 }}</div>
    </div>
    <div class="metric-card">
        <div class="metric-label">Unit PC Tersedia</div>
        <div class="metric-value">{{ $totalPcs ?? 0 }}</div>
    </div>
</div>

{{-- Grafik Pendapatan --}}
<canvas id="revenueChart"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: {!! json_encode($chartValues) !!},
                borderColor: '#a855f7',
                fill: true, tension: 0.4
            }]
        }
    });
</script>
@endsection
```

### 6.3 Back-End Program
*File: `app/Http/Controllers/AdminController.php`*
```php
public function dashboard()
{
    $totalUsers = \App\Models\User::where('role', 'user')->count();
    $totalPcs = \App\Models\Computer::count();
    $totalBookings = \App\Models\Booking::count();
    $totalRevenue = \App\Models\Booking::sum('total_price');

    $revenueData = \App\Models\Booking::selectRaw('DATE(created_at) as date, SUM(total_price) as revenue')
        ->where('created_at', '>=', now()->subDays(7))
        ->groupBy('date')->orderBy('date', 'ASC')->get();

    $chartLabels = $revenueData->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d M'))->toArray();
    $chartValues = $revenueData->pluck('revenue')->toArray();

    return view('admin.dashboard', compact('totalUsers','totalPcs','totalBookings','totalRevenue','chartLabels','chartValues'));
}
```
*File: `routes/web.php`*
```php
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
});
```

### 6.4 Database
![DB Structure](C:/Users/yoru/.gemini/antigravity/brain/9f667511-0be1-4bb3-ab1b-2a813d83665e/artifacts/14_db_structure.png)
*Struktur database `warnet_db` — Data diambil dari tabel `users`, `computers`, dan `bookings`*

---

# 7. Admin - Manajemen PC

### 7.1 Tampilan UI
![Admin PC](C:/Users/yoru/.gemini/antigravity/brain/9f667511-0be1-4bb3-ab1b-2a813d83665e/artifacts/09_admin_pc.png)

### 7.2 Front-End Program
*File: `resources/views/admin/pc_index.blade.php`*
```php
@extends('layouts.dashboard')
@section('content')
<h1>Manajemen Komputer (PC)</h1>

{{-- Form Tambah PC --}}
<form action="{{ route('admin.computers.store') }}" method="POST">
    @csrf
    <label>Nama Identifikasi PC</label>
    <input type="text" name="name" placeholder="Mis. PC VIP-01" required>
    <label>Tarif Sewa Per Jam (Rp)</label>
    <input type="number" name="price_per_hour" value="5000" required>
    <button type="submit">Simpan PC</button>
</form>

{{-- Tabel Data PC --}}
<table class="table">
    <tr><th>Nama PC</th><th>Tarif/Jam</th><th>Status</th><th>Jadwal</th><th>Aksi</th></tr>
    @foreach($computers as $pc)
    <tr>
        <td>{{ $pc->name }}</td>
        <td>Rp {{ number_format($pc->price_per_hour, 0, ',', '.') }}</td>
        <td>
            @if($pc->status == 'available')
                <span class="status-badge status-available">Kosong</span>
            @else
                <span class="status-badge status-in-use">Digunakan</span>
            @endif
        </td>
        <td>
            <form action="{{ route('admin.computers.destroy', $pc->id) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="btn-delete">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection
```

### 7.3 Back-End Program
*File: `app/Http/Controllers/AdminController.php`*
```php
public function pcStore(Request $request)
{
    $request->validate(['name' => 'required|string', 'price_per_hour' => 'required|numeric']);
    \App\Models\Computer::create([
        'name' => $request->name,
        'price_per_hour' => $request->price_per_hour,
        'status' => 'available'
    ]);
    return redirect()->back()->with('success', 'PC berhasil ditambahkan.');
}

public function pcDestroy($id)
{
    \App\Models\Computer::findOrFail($id)->delete();
    return redirect()->back()->with('success', 'PC dihapus.');
}
```
*File: `routes/web.php`*
```php
Route::get('/computers', [AdminController::class, 'pcIndex'])->name('computers.index');
Route::post('/computers', [AdminController::class, 'pcStore'])->name('computers.store');
Route::delete('/computers/{id}', [AdminController::class, 'pcDestroy'])->name('computers.destroy');
```

### 7.4 Database
![DB Computers](C:/Users/yoru/.gemini/antigravity/brain/9f667511-0be1-4bb3-ab1b-2a813d83665e/artifacts/17_db_computers.png)
*Tabel `computers`: Menyimpan data PC (nama, status, tarif per jam)*

---

# 8. Admin - Riwayat Billing (Laporan & Export)

### 8.1 Tampilan UI
![Admin Bookings](C:/Users/yoru/.gemini/antigravity/brain/9f667511-0be1-4bb3-ab1b-2a813d83665e/artifacts/10_admin_bookings.png)

### 8.2 Front-End Program
*File: `resources/views/admin/booking_index.blade.php`*
```php
@extends('layouts.dashboard')
@section('content')
<h1>Riwayat Billing</h1>
<a href="{{ route('admin.bookings.export.excel') }}">Export Excel</a>
<a href="{{ route('admin.bookings.export.pdf') }}">Export PDF</a>

{{-- Filter --}}
<form method="GET" action="{{ route('admin.bookings.index') }}">
    <input type="date" name="date" value="{{ request('date') }}">
    <select name="pc_category">
        <option value="">Semua Kategori</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->price_per_hour }}">Rp {{ number_format($cat->price_per_hour) }}/jam</option>
        @endforeach
    </select>
    <select name="status">
        <option value="">Semua Status</option>
        <option value="booked">Booked</option>
        <option value="active">Active</option>
        <option value="completed">Completed</option>
        <option value="cancelled">Cancelled</option>
    </select>
    <button type="submit">Terapkan Filter</button>
</form>

{{-- Tabel + Aksi Check-In/Out --}}
<table>
    @foreach($bookings as $booking)
    <tr>
        <td>#WA-{{ str_pad($booking->id,4,'0',STR_PAD_LEFT) }}</td>
        <td>{{ $booking->user->name }}</td>
        <td>{{ $booking->computer->name }}</td>
        <td><span class="status-badge status-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span></td>
        <td>Rp {{ number_format($booking->total_price) }}</td>
        <td>
            @if($booking->status === 'booked')
                <form method="POST" action="{{ route('admin.bookings.checkin', $booking->id) }}">
                    @csrf <button>Check-In</button>
                </form>
            @elseif($booking->status === 'active')
                <form method="POST" action="{{ route('admin.bookings.checkout', $booking->id) }}">
                    @csrf <button>Check-Out</button>
                </form>
            @endif
        </td>
    </tr>
    @endforeach
</table>
@endsection
```

### 8.3 Back-End Program
*File: `app/Http/Controllers/AdminController.php`*
```php
public function bookingIndex(Request $request)
{
    $query = \App\Models\Booking::with(['user', 'computer', 'canteenItems'])->latest();
    if ($request->filled('date')) { $query->whereDate('created_at', $request->date); }
    if ($request->filled('pc_category')) {
        $query->whereHas('computer', fn($q) => $q->where('price_per_hour', $request->pc_category));
    }
    if ($request->filled('status')) { $query->where('status', $request->status); }
    $bookings = $query->get();
    return view('admin.booking_index', compact('bookings', 'categories'));
}

public function checkinBooking($id)
{
    $booking = \App\Models\Booking::findOrFail($id);
    $booking->update(['status' => 'active']);
    if ($booking->computer) { $booking->computer->update(['status' => 'in_use']); }
    return redirect()->route('admin.bookings.index')->with('success', 'Check-In berhasil!');
}

public function checkoutBooking($id)
{
    $booking = \App\Models\Booking::findOrFail($id);
    $booking->update(['status' => 'completed']);
    if ($booking->computer) { $booking->computer->update(['status' => 'available']); }
    return redirect()->route('admin.bookings.index')->with('success', 'Check-Out berhasil!');
}

public function exportPdf(Request $request)
{
    $bookings = \App\Models\Booking::with(['user','computer','canteenItems'])->latest()->get();
    $pdf = Pdf::loadView('admin.bookings_pdf', compact('bookings'));
    return $pdf->download('rekapitulasi_pendapatan.pdf');
}
```
*File: `routes/web.php`*
```php
Route::get('/bookings', [AdminController::class, 'bookingIndex'])->name('bookings.index');
Route::get('/bookings/export/pdf', [AdminController::class, 'exportPdf'])->name('bookings.export.pdf');
Route::get('/bookings/export/excel', [AdminController::class, 'exportExcel'])->name('bookings.export.excel');
Route::post('/bookings/{id}/checkin', [AdminController::class, 'checkinBooking'])->name('bookings.checkin');
Route::post('/bookings/{id}/checkout', [AdminController::class, 'checkoutBooking'])->name('bookings.checkout');
```

### 8.4 Database
![DB Bookings](C:/Users/yoru/.gemini/antigravity/brain/9f667511-0be1-4bb3-ab1b-2a813d83665e/artifacts/16_db_bookings.png)
*Tabel `bookings`: Data transaksi lengkap (user, PC, durasi, harga, status, waktu)*

---

# 9. Admin - Manajemen Kantin

### 9.1 Tampilan UI
![Admin Canteen](C:/Users/yoru/.gemini/antigravity/brain/9f667511-0be1-4bb3-ab1b-2a813d83665e/artifacts/11_admin_canteen.png)

### 9.2 Front-End Program
*File: `resources/views/admin/canteen_index.blade.php`*
```php
@extends('layouts.dashboard')
@section('content')
<h1>Manajemen Kantin</h1>

{{-- Form Tambah Menu --}}
<form action="{{ route('admin.canteen.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="text" name="name" placeholder="Nama Menu" required>
    <input type="number" name="price" placeholder="Harga (Rp)" required>
    <input type="file" name="image" accept="image/*">
    <button type="submit">Simpan Menu</button>
</form>

{{-- Tabel Menu --}}
<table>
    @foreach($canteenItems as $item)
    <tr>
        <td><img src="{{ asset($item->image_path) }}"> {{ $item->name }}</td>
        <td>Rp {{ number_format($item->price) }}</td>
        <td>
            <button onclick="editItem({{ $item->id }})">Edit</button>
            <form method="POST" action="{{ route('admin.canteen.destroy', $item->id) }}">
                @csrf @method('DELETE') <button>Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection
```

### 9.3 Back-End Program
*File: `app/Http/Controllers/AdminController.php`*
```php
public function canteenStore(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'price' => 'required|numeric',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);
    // ... image upload logic ...
    \App\Models\CanteenItem::create([
        'name' => $request->name, 'price' => $request->price, 'image_path' => $imagePath
    ]);
    return redirect()->back()->with('success', 'Menu berhasil ditambahkan.');
}

public function canteenUpdate(Request $request, $id) { /* validasi + update */ }
public function canteenDestroy($id) {
    \App\Models\CanteenItem::findOrFail($id)->delete();
    return redirect()->back()->with('success', 'Menu berhasil dihapus.');
}
```
*File: `routes/web.php`*
```php
Route::get('/canteen', [AdminController::class, 'canteenIndex'])->name('canteen.index');
Route::post('/canteen', [AdminController::class, 'canteenStore'])->name('canteen.store');
Route::put('/canteen/{id}', [AdminController::class, 'canteenUpdate'])->name('canteen.update');
Route::delete('/canteen/{id}', [AdminController::class, 'canteenDestroy'])->name('canteen.destroy');
```

### 9.4 Database
![DB Structure](C:/Users/yoru/.gemini/antigravity/brain/9f667511-0be1-4bb3-ab1b-2a813d83665e/artifacts/14_db_structure.png)
*Tabel `canteen_items`: Menyimpan menu kantin (nama, harga, gambar) — 2 data*

---

# 10. Admin - Manajemen Akun User

### 10.1 Tampilan UI
![Admin Users](C:/Users/yoru/.gemini/antigravity/brain/9f667511-0be1-4bb3-ab1b-2a813d83665e/artifacts/12_admin_users.png)

### 10.2 Front-End Program
*File: `resources/views/admin/users_index.blade.php`*
```php
@extends('layouts.dashboard')
@section('content')
<h1>Manajemen Akun</h1>
<p>Kelola data pelanggan yang terdaftar di sistem.</p>

<table>
    <tr><th>Pelanggan</th><th>Tanggal Daftar</th><th>Saldo Wallet</th><th>Aksi</th></tr>
    @foreach($users as $user)
    <tr>
        <td>{{ $user->name }} — {{ $user->email }}</td>
        <td>{{ $user->created_at->format('d M Y') }}</td>
        <td>Rp {{ number_format($user->wallet_balance, 0, ',', '.') }}</td>
        <td>
            <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}">
                @csrf @method('DELETE')
                <button onclick="return confirm('Hapus akun?')">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection
```

### 10.3 Back-End Program
*File: `app/Http/Controllers/AdminController.php`*
```php
public function usersIndex()
{
    $users = \App\Models\User::where('role', 'user')->latest()->get();
    return view('admin.users_index', compact('users'));
}

public function usersDestroy($id)
{
    $user = \App\Models\User::findOrFail($id);
    if ($user->role === 'admin') {
        return redirect()->back()->with('error', 'Tidak bisa menghapus admin.');
    }
    $user->delete();
    return redirect()->back()->with('success', 'Akun berhasil dihapus.');
}
```
*File: `routes/web.php`*
```php
Route::get('/users', [AdminController::class, 'usersIndex'])->name('users.index');
Route::delete('/users/{id}', [AdminController::class, 'usersDestroy'])->name('users.destroy');
```

### 10.4 Database
![DB Users](C:/Users/yoru/.gemini/antigravity/brain/9f667511-0be1-4bb3-ab1b-2a813d83665e/artifacts/15_db_users.png)
*Tabel `users`: 6 akun terdaftar (1 admin + 5 pelanggan) dengan saldo wallet*
