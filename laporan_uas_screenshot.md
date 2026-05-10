# LAPORAN UAS - SCREENSHOT DOKUMENTASI
## Sistem Booking Warnet ASOY

---

## 1. Screenshot Tampilan UI

### Landing Page
![Landing Page](C:/Users/yoru/.gemini/antigravity/brain/9f667511-0be1-4bb3-ab1b-2a813d83665e/artifacts/01_landing_page.png)

### Halaman Login
![Login Page](C:/Users/yoru/.gemini/antigravity/brain/9f667511-0be1-4bb3-ab1b-2a813d83665e/artifacts/02_login_page.png)

### Halaman Register
![Register Page](C:/Users/yoru/.gemini/antigravity/brain/9f667511-0be1-4bb3-ab1b-2a813d83665e/artifacts/03_register_page.png)

### User - Dashboard Home
![User Home](C:/Users/yoru/.gemini/antigravity/brain/9f667511-0be1-4bb3-ab1b-2a813d83665e/artifacts/04_user_home.png)

### User - Billing / Booking PC
![User Billing](C:/Users/yoru/.gemini/antigravity/brain/9f667511-0be1-4bb3-ab1b-2a813d83665e/artifacts/05_user_billing.png)

### User - Riwayat Booking
![User History](C:/Users/yoru/.gemini/antigravity/brain/9f667511-0be1-4bb3-ab1b-2a813d83665e/artifacts/06_user_history.png)

### User - Informasi Akun / Profil
![User Profile](C:/Users/yoru/.gemini/antigravity/brain/9f667511-0be1-4bb3-ab1b-2a813d83665e/artifacts/07_user_profile.png)

### Admin - Dashboard Overview
![Admin Dashboard](C:/Users/yoru/.gemini/antigravity/brain/9f667511-0be1-4bb3-ab1b-2a813d83665e/artifacts/08_admin_dashboard.png)

### Admin - Manajemen PC
![Admin PC](C:/Users/yoru/.gemini/antigravity/brain/9f667511-0be1-4bb3-ab1b-2a813d83665e/artifacts/09_admin_pc.png)

### Admin - Riwayat Billing (Laporan)
![Admin Bookings](C:/Users/yoru/.gemini/antigravity/brain/9f667511-0be1-4bb3-ab1b-2a813d83665e/artifacts/10_admin_bookings.png)

### Admin - Manajemen Kantin
![Admin Canteen](C:/Users/yoru/.gemini/antigravity/brain/9f667511-0be1-4bb3-ab1b-2a813d83665e/artifacts/11_admin_canteen.png)

### Admin - Manajemen Akun
![Admin Users](C:/Users/yoru/.gemini/antigravity/brain/9f667511-0be1-4bb3-ab1b-2a813d83665e/artifacts/12_admin_users.png)

### Admin - Profil Admin
![Admin Profile](C:/Users/yoru/.gemini/antigravity/brain/9f667511-0be1-4bb3-ab1b-2a813d83665e/artifacts/13_admin_profile.png)

---

## 2. Screenshot Front-End Program (Blade Template)

### Login - `resources/views/auth/login.blade.php`
```php
@extends('layouts.auth')
@section('title', 'Masuk - WARNET ASOY')

@section('content')
    <div class="auth-container">
        <img src="{{ asset('images/hero_bg.png') }}" class="auth-bg" alt="Background">
        <div class="auth-overlay"></div>
        <div class="auth-content">
            <div class="auth-header">
                <h1>WARNET ASOY</h1>
                <p>Access Your Command Center</p>
            </div>
            <div class="auth-card">
                <div class="auth-tabs">
                    <button class="auth-tab active">Masuk</button>
                    <button class="auth-tab" onclick="window.location.href='{{ route('register') }}'">Daftar</button>
                </div>
                @if($errors->any())
                    <div class="alert-error">
                        <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif
                <form id="login-form" class="auth-form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-input"
                            placeholder="Masukkan Email Anda" value="{{ old('email') }}" required autofocus>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-input"
                            placeholder="••••••••" required>
                    </div>
                    <div class="form-group">
                        <input id="remember_me" type="checkbox" name="remember">
                        <label for="remember_me">Ingat Saya</label>
                    </div>
                    <button type="submit" class="btn-submit">Masuk →</button>
                </form>
            </div>
        </div>
    </div>
@endsection
```

### User Home - `resources/views/user/home.blade.php` (ringkasan)
```php
@extends('layouts.dashboard')
@section('content')
    <h1>Selamat Datang, {{ auth()->user()->name }}</h1>

    {{-- Booking Aktif --}}
    @forelse($activeBookings as $booking)
        <div class="booking-card">
            <span>#WA-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</span>
            <span>{{ $booking->computer->name }}</span>
            <span>{{ $booking->start_time->format('H:i') }} - {{ $booking->end_time->format('H:i') }}</span>
            <span class="status {{ $booking->status }}">{{ $booking->status }}</span>
        </div>
    @empty
        <p>Tidak Ada Booking Aktif</p>
        <a href="{{ route('billing') }}">+ BOOKING PC SEKARANG</a>
    @endforelse

    {{-- Riwayat Tiket --}}
    @foreach($historyBookings as $booking)
        <div class="ticket-card">...</div>
    @endforeach
@endsection
```

### User Billing - `resources/views/user/billing.blade.php` (ringkasan)
```php
@extends('layouts.dashboard')
@section('content')
    <h1>Booking Pc Sekarang</h1>
    <form method="POST" action="{{ route('billing.process') }}">
        @csrf
        {{-- Pilih PC --}}
        @foreach($computers as $pc)
            <div class="pc-card" data-price="{{ $pc->price_per_hour }}">
                <span>{{ $pc->name }}</span>
            </div>
        @endforeach

        {{-- Jadwal Main --}}
        <select name="booking_date">...</select>
        <input type="time" name="booking_time">
        <select name="duration">...</select>

        {{-- Pesanan Kantin --}}
        @foreach($canteenItems as $item)
            <input type="number" name="canteen_items[{{ $item->id }}]" min="0" value="0">
        @endforeach

        <button type="submit">KONFIRMASI & BAYAR</button>
    </form>
@endsection
```

### Admin Dashboard - `resources/views/admin/dashboard.blade.php` (ringkasan)
```php
@extends('layouts.admin')
@section('content')
    <h1>Overview Admin</h1>
    <div class="stats-grid">
        <div class="stat-card">Total Pendapatan: Rp {{ number_format($totalRevenue) }}</div>
        <div class="stat-card">Pesanan / Billing: {{ $totalBookings }}</div>
        <div class="stat-card">Total Pelanggan: {{ $totalUsers }}</div>
        <div class="stat-card">Unit PC Tersedia: {{ $totalPcs }}</div>
    </div>

    {{-- Revenue Chart --}}
    <canvas id="revenueChart"></canvas>
    <script>
        new Chart(document.getElementById('revenueChart'), {
            type: 'bar',
            data: { labels: @json($chartLabels), datasets: [{ data: @json($chartValues) }] }
        });
    </script>
@endsection
```

### Admin Booking Index - `resources/views/admin/booking_index.blade.php` (ringkasan)
```php
@extends('layouts.admin')
@section('content')
    <h1>Riwayat Billing</h1>
    <a href="{{ route('admin.bookings.export.excel') }}">EXPORT EXCEL</a>
    <a href="{{ route('admin.bookings.export.pdf') }}">EXPORT PDF</a>

    {{-- Filter --}}
    <form method="GET">
        <input type="date" name="date">
        <select name="pc_category">...</select>
        <select name="status">...</select>
        <button type="submit">TERAPKAN FILTER</button>
    </form>

    {{-- Tabel Data --}}
    <table>
        <tr><th>ID</th><th>Penyewa</th><th>PC</th><th>Status</th><th>Tarif</th><th>Waktu</th><th>Aksi</th></tr>
        @foreach($bookings as $b)
        <tr>
            <td>#WA-{{ str_pad($b->id, 4, '0', STR_PAD_LEFT) }}</td>
            <td>{{ $b->user->name }}</td>
            <td>{{ $b->computer->name }}</td>
            <td>{{ $b->status }}</td>
            <td>Rp {{ number_format($b->total_price) }}</td>
            <td>{{ $b->start_time }} - {{ $b->end_time }}</td>
            <td>
                @if($b->status == 'booked')
                    <form method="POST" action="{{ route('admin.bookings.checkin', $b->id) }}">@csrf
                        <button>CHECK-IN</button>
                    </form>
                @elseif($b->status == 'active')
                    <form method="POST" action="{{ route('admin.bookings.checkout', $b->id) }}">@csrf
                        <button>SELESAI</button>
                    </form>
                @endif
            </td>
        </tr>
        @endforeach
    </table>
@endsection
```

---

## 3. Screenshot Back-End Program (Controller & Routes)

### AuthenticatedSessionController.php
*Path: `app/Http/Controllers/Auth/AuthenticatedSessionController.php`*
```php
<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();
        if (Auth::user()->role === 'admin') {
            return redirect()->intended(route('admin.dashboard', absolute: false));
        }
        return redirect()->intended(route('home', absolute: false));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
```

### AdminController.php (CRUD & Laporan)
*Path: `app/Http/Controllers/AdminController.php`*
```php
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    // Dashboard
    public function dashboard() {
        $totalUsers = \App\Models\User::where('role', 'user')->count();
        $totalPcs = \App\Models\Computer::count();
        $totalBookings = \App\Models\Booking::count();
        $totalRevenue = \App\Models\Booking::sum('total_price');
        // ... chart data ...
        return view('admin.dashboard', compact('totalUsers', 'totalPcs', 'totalBookings', 'totalRevenue', 'chartLabels', 'chartValues'));
    }

    // CRUD PC
    public function pcStore(Request $request) {
        $request->validate(['name' => 'required|string', 'price_per_hour' => 'required|numeric']);
        \App\Models\Computer::create([
            'name' => $request->name, 'price_per_hour' => $request->price_per_hour, 'status' => 'available'
        ]);
        return redirect()->back()->with('success', 'PC berhasil ditambahkan.');
    }

    public function pcDestroy($id) {
        \App\Models\Computer::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'PC dihapus.');
    }

    // Laporan & Filter
    public function bookingIndex(Request $request) {
        $query = \App\Models\Booking::with(['user', 'computer', 'canteenItems'])->latest();
        if ($request->filled('date')) { $query->whereDate('created_at', $request->date); }
        if ($request->filled('pc_category')) {
            $query->whereHas('computer', fn($q) => $q->where('price_per_hour', $request->pc_category));
        }
        if ($request->filled('status')) { $query->where('status', $request->status); }
        $bookings = $query->get();
        return view('admin.booking_index', compact('bookings', 'categories'));
    }

    // Export PDF
    public function exportPdf(Request $request) {
        // ... filter logic ...
        $pdf = Pdf::loadView('admin.bookings_pdf', compact('bookings'));
        return $pdf->download('rekapitulasi_pendapatan.pdf');
    }

    // Check-In & Check-Out
    public function checkinBooking($id) {
        $booking = \App\Models\Booking::findOrFail($id);
        $booking->update(['status' => 'active']);
        if ($booking->computer) { $booking->computer->update(['status' => 'in_use']); }
        return redirect()->route('admin.bookings.index')->with('success', 'Check-In berhasil!');
    }

    public function checkoutBooking($id) {
        $booking = \App\Models\Booking::findOrFail($id);
        $booking->update(['status' => 'completed']);
        if ($booking->computer) { $booking->computer->update(['status' => 'available']); }
        return redirect()->route('admin.bookings.index')->with('success', 'Check-Out berhasil!');
    }

    // CRUD Kantin
    public function canteenStore(Request $request) {
        $request->validate(['name' => 'required|string', 'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048']);
        // ... image upload logic ...
        \App\Models\CanteenItem::create([...]);
        return redirect()->back()->with('success', 'Menu berhasil ditambahkan.');
    }

    public function canteenUpdate(Request $request, $id) { /* ... */ }
    public function canteenDestroy($id) { /* ... */ }
}
```

### UserController.php (Transaksi Booking)
*Path: `app/Http/Controllers/UserController.php`*
```php
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class UserController extends Controller
{
    public function processBilling(Request $request) {
        $request->validate([
            'pc_id' => 'required|exists:computers,id',
            'duration' => 'required',
            'booking_date' => 'required|date',
            'booking_time' => 'required',
        ]);

        $computer = \App\Models\Computer::findOrFail($request->pc_id);
        $bookingTime = \Carbon\Carbon::parse($request->booking_date . ' ' . $request->booking_time);
        $durationHours = (int) $request->duration;
        $price = $computer->price_per_hour * $durationHours;
        $endTime = $bookingTime->copy()->addHours($durationHours);

        // Cek overlapping
        $overlapping = \App\Models\Booking::where('computer_id', $computer->id)
            ->whereIn('status', ['booked', 'active'])
            ->where(fn($q) => $q->where('start_time', '<', $endTime)->where('end_time', '>', $bookingTime))
            ->exists();
        if ($overlapping) { return back()->with('error', 'PC sudah dipesan.'); }

        // Cek saldo wallet
        $user = auth()->user();
        if ($user->wallet_balance < $totalPrice) {
            return back()->with('error', 'Saldo Wallet tidak mencukupi.');
        }
        $user->wallet_balance -= $totalPrice;
        $user->save();

        $booking = \App\Models\Booking::create([
            'user_id' => $user->id, 'computer_id' => $computer->id,
            'duration_hours' => $durationHours, 'start_time' => $bookingTime,
            'end_time' => $endTime, 'total_price' => $totalPrice, 'status' => 'booked'
        ]);

        return redirect()->route('billing.success')->with('booking_id', $booking->id);
    }

    public function cancelBooking($id) {
        $booking = \App\Models\Booking::where('user_id', auth()->id())
            ->where('id', $id)->where('status', 'booked')->firstOrFail();
        $booking->update(['status' => 'cancelled']);
        return redirect()->route('home')->with('success', 'Booking berhasil dibatalkan.');
    }
}
```

### Routes - `routes/web.php`
```php
<?php
use App\Http\Controllers\{PublicController, UserController, AdminController, ProfileController};
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'landing'])->name('landing');

Route::middleware('auth')->group(function () {
    // User Routes
    Route::get('/home', [UserController::class, 'home'])->name('home');
    Route::get('/billing', [UserController::class, 'billing'])->name('billing');
    Route::post('/billing', [UserController::class, 'processBilling'])->name('billing.process');
    Route::get('/billing/success', [UserController::class, 'billingSuccess'])->name('billing.success');
    Route::get('/booking/{id}/receipt', [UserController::class, 'receiptView'])->name('booking.receipt');
    Route::get('/booking/{id}/receipt/pdf', [UserController::class, 'receiptPdf'])->name('booking.receipt.pdf');
    Route::post('/booking/{id}/cancel', [UserController::class, 'cancelBooking'])->name('booking.cancel');
    Route::get('/history', [UserController::class, 'history'])->name('history');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/profile/topup', [UserController::class, 'topup'])->name('profile.topup');

    // Admin Routes (middleware: admin)
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/computers', [AdminController::class, 'pcIndex'])->name('computers.index');
        Route::post('/computers', [AdminController::class, 'pcStore'])->name('computers.store');
        Route::delete('/computers/{id}', [AdminController::class, 'pcDestroy'])->name('computers.destroy');
        Route::get('/bookings', [AdminController::class, 'bookingIndex'])->name('bookings.index');
        Route::get('/bookings/export/pdf', [AdminController::class, 'exportPdf'])->name('bookings.export.pdf');
        Route::get('/bookings/export/excel', [AdminController::class, 'exportExcel'])->name('bookings.export.excel');
        Route::post('/bookings/{id}/checkin', [AdminController::class, 'checkinBooking'])->name('bookings.checkin');
        Route::post('/bookings/{id}/checkout', [AdminController::class, 'checkoutBooking'])->name('bookings.checkout');
        Route::get('/users', [AdminController::class, 'usersIndex'])->name('users.index');
        Route::delete('/users/{id}', [AdminController::class, 'usersDestroy'])->name('users.destroy');
        Route::get('/canteen', [AdminController::class, 'canteenIndex'])->name('canteen.index');
        Route::post('/canteen', [AdminController::class, 'canteenStore'])->name('canteen.store');
        Route::put('/canteen/{id}', [AdminController::class, 'canteenUpdate'])->name('canteen.update');
        Route::delete('/canteen/{id}', [AdminController::class, 'canteenDestroy'])->name('canteen.destroy');
    });
});

require __DIR__.'/auth.php';
```

### Routes - `routes/auth.php`
```php
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
```

---

## 4. Screenshot Database (phpMyAdmin)

### Struktur Database `warnet_db` - Daftar Tabel
![DB Structure](C:/Users/yoru/.gemini/antigravity/brain/9f667511-0be1-4bb3-ab1b-2a813d83665e/artifacts/14_db_structure.png)

### Tabel `users` (6 data)
![DB Users](C:/Users/yoru/.gemini/antigravity/brain/9f667511-0be1-4bb3-ab1b-2a813d83665e/artifacts/15_db_users.png)

### Tabel `bookings` (14 data)
![DB Bookings](C:/Users/yoru/.gemini/antigravity/brain/9f667511-0be1-4bb3-ab1b-2a813d83665e/artifacts/16_db_bookings.png)

### Tabel `computers` (10 data)
![DB Computers](C:/Users/yoru/.gemini/antigravity/brain/9f667511-0be1-4bb3-ab1b-2a813d83665e/artifacts/17_db_computers.png)

### Skema Database (dari Migration Files)

| Tabel | Kolom | Tipe | Keterangan |
|:---|:---|:---|:---|
| **users** | id | bigint unsigned | Primary Key |
| | name | varchar(255) | Nama pengguna |
| | email | varchar(255) | Email (unique) |
| | password | varchar(255) | Password (hashed) |
| | role | enum('admin','user') | Hak akses |
| | wallet_balance | decimal(10,2) | Saldo e-Wallet |
| **computers** | id | bigint unsigned | Primary Key |
| | name | varchar(255) | Nama PC |
| | status | enum('available','in_use') | Status PC |
| | price_per_hour | decimal(10,2) | Tarif per jam |
| **bookings** | id | bigint unsigned | Primary Key |
| | user_id | bigint unsigned | FK → users |
| | computer_id | bigint unsigned | FK → computers |
| | duration_hours | int | Durasi sewa (jam) |
| | start_time | timestamp | Waktu mulai |
| | end_time | timestamp | Waktu selesai |
| | total_price | decimal(10,2) | Total harga |
| | status | varchar(255) | booked/active/completed/cancelled |
| **canteen_items** | id | bigint unsigned | Primary Key |
| | name | varchar(255) | Nama menu |
| | price | decimal(10,2) | Harga |
| | image_path | varchar(255) | Path gambar |
| **booking_canteen_items** | id | bigint unsigned | Primary Key |
| | booking_id | bigint unsigned | FK → bookings |
| | canteen_item_id | bigint unsigned | FK → canteen_items |
| | quantity | int | Jumlah pesanan |
| | subtotal | decimal(10,2) | Subtotal harga |
