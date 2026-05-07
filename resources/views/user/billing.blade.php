@extends('layouts.dashboard')

@section('styles')
    <style>
        .page-title {
            font-size: 1.5rem;
            font-weight: 800;
            margin-bottom: 0.25rem;
            letter-spacing: -0.5px;
        }

        .page-subtitle {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin-bottom: 2.5rem;
        }

        .billing-layout {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 3rem;
        }

        .section-title {
            font-size: 1.125rem;
            font-weight: 700;
            margin-bottom: 1.25rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .section-legend {
            display: flex;
            gap: 1rem;
            font-size: 0.625rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }

        .legend-box {
            width: 8px;
            height: 8px;
            border-radius: 2px;
        }

        /* PC Grid */
        .pc-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 1rem;
            margin-bottom: 3rem;
        }

        .pc-box {
            background-color: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 1.5rem 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .pc-box:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }

        .pc-box.selected {
            border-color: var(--purple-light);
            background-color: rgba(168, 85, 247, 0.1);
            box-shadow: 0 0 15px rgba(168, 85, 247, 0.2);
        }

        .pc-box.in-use {
            border-color: rgba(239, 68, 68, 0.3);
            background-color: rgba(239, 68, 68, 0.05);
        }

        .pc-box svg {
            width: 24px;
            height: 24px;
            fill: var(--text-muted);
        }

        .pc-box.selected svg {
            fill: var(--purple-light);
        }

        .pc-box span {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text-muted);
        }

        .pc-box.selected span {
            color: var(--purple-light);
        }

        .pc-box.in-use svg {
            fill: #ef4444;
        }

        .pc-box.in-use span {
            color: #ef4444;
        }

        /* Duration Select */
        .dur-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 3rem;
        }

        .dur-box {
            background-color: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 1.25rem;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
        }

        .dur-box:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }

        .dur-box.selected {
            border-color: var(--purple-light);
            background-color: rgba(168, 85, 247, 0.1);
        }

        .dur-title {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--text-main);
        }

        .dur-price {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .dur-time {
            font-size: 0.625rem;
            color: #f59e0b;
            margin-top: 0.25rem;
            display: block;
            font-weight: 700;
        }

        .radio-circle {
            position: absolute;
            right: 1rem;
            top: 1.25rem;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 2px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dur-box.selected .radio-circle {
            border-color: var(--purple-light);
        }

        .dur-box.selected .radio-circle::after {
            content: '';
            width: 8px;
            height: 8px;
            background-color: var(--purple-light);
            border-radius: 50%;
        }

        /* Amunisi */
        .amunisi-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .amu-box {
            background-color: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .amu-box.selected {
            border-color: var(--purple-light);
            background-color: rgba(168, 85, 247, 0.05);
        }

        .amu-img {
            width: 60px;
            height: 60px;
            border-radius: 4px;
            object-fit: cover;
        }

        .amu-info {
            flex-grow: 1;
        }

        .amu-title {
            font-size: 0.875rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .amu-price {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-bottom: 0.5rem;
        }

        .amu-action {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-qty {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: var(--text-main);
            width: 24px;
            height: 24px;
            border-radius: 2px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
            font-weight: bold;
        }

        .btn-qty.purple {
            background: var(--purple-light);
            color: var(--bg-dark);
        }

        .amu-val {
            font-size: 0.875rem;
            font-weight: 700;
            width: 20px;
            text-align: center;
        }

        .btn-add {
            background: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-muted);
            font-size: 0.625rem;
            font-weight: 700;
            padding: 0.35rem 0.75rem;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-add:hover {
            background: rgba(255, 255, 255, 0.1);
            color: var(--text-main);
        }

        /* Summary Card */
        .summary-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 2rem;
            position: sticky;
            top: 2rem;
        }

        .summary-title {
            font-size: 1.125rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            letter-spacing: -0.5px;
        }

        .summary-title svg {
            width: 18px;
            height: 18px;
            fill: var(--purple-light);
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            font-size: 0.875rem;
        }

        .summary-row.border-bottom {
            border-bottom: 1px dashed rgba(255, 255, 255, 0.1);
            padding-bottom: 1.25rem;
            margin-bottom: 1.25rem;
        }

        .summary-label {
            color: var(--text-muted);
        }

        .summary-val {
            font-weight: 700;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 2rem;
            margin-bottom: 1.5rem;
        }

        .total-label {
            font-size: 0.75rem;
            color: var(--text-muted);
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .total-val {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--purple-light);
            line-height: 1;
        }

        .btn-confirm {
            background-color: var(--purple-light);
            color: var(--bg-dark);
            border: none;
            padding: 1rem;
            border-radius: 4px;
            font-weight: 800;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            width: 100%;
            transition: background 0.2s;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-confirm:hover {
            background-color: #d8b4fe;
        }

        .btn-confirm:disabled {
            background-color: rgba(255, 255, 255, 0.1);
            color: var(--text-muted);
            cursor: not-allowed;
        }

        .wallet-info {
            text-align: right;
            font-size: 0.625rem;
            color: var(--text-muted);
            margin-top: 0.75rem;
            font-weight: 700;
        }

        .link-kantin {
            font-size: 0.625rem;
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: color 0.2s;
        }

        .link-kantin:hover {
            color: var(--purple-light);
        }

        .error-msg {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            font-size: 0.875rem;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        @media (max-width: 1024px) {
            .billing-layout {
                grid-template-columns: 1fr;
            }

            .summary-card {
                position: static;
            }
        }
    </style>
@endsection

@section('content')
    <h1 class="page-title">Booking Pc Sekarang</h1>
    <p class="page-subtitle">Pilih Pc, atur waktu, dan siapkan amunisi.</p>

    @if(session('error'))
        <div class="error-msg">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('billing.process') }}" class="billing-layout" id="billingForm">
        @csrf
        <input type="hidden" name="pc_id" id="input_pc_id" required>
        <input type="hidden" name="duration" id="input_duration" value="1" required>

        <!-- Left Column: Forms -->
        <div>
            <div class="section-title">
                Pilih PC
                <div class="section-legend">
                    <div class="legend-item">
                        <div class="legend-box" style="background: rgba(255,255,255,0.2);"></div> Tersedia
                    </div>
                    <div class="legend-item">
                        <div class="legend-box" style="background: #ef4444;"></div> Digunakan
                    </div>
                    <div class="legend-item">
                        <div class="legend-box" style="background: var(--purple-light);"></div> Dipilih
                    </div>
                </div>
            </div>

            <div class="pc-grid">
                @foreach ($computers as $pc)
                    <div class="pc-box {{ $pc->status === 'in_use' ? 'in-use' : '' }}"
                        onclick="selectPc({{ $pc->id }}, '{{ $pc->name }}', {{ $pc->price_per_hour }})"
                        id="pc_{{ $pc->id }}">
                        <svg viewBox="0 0 24 24">
                            <path
                                d="M21 2H3c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h7v2H8v2h8v-2h-2v-2h7c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H3V4h18v12z" />
                        </svg>
                        <span>{{ $pc->name }}</span>
                    </div>
                @endforeach
            </div>

            <div class="section-title">Jadwal Main</div>
            <div style="margin-bottom: 2.5rem; display: flex; gap: 1rem; flex-wrap: wrap;">
                <div style="flex: 1; min-width: 200px;">
                    <label
                        style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.5rem; display: block; font-weight: 800; letter-spacing: 1px; text-transform: uppercase;">Pilih
                        Tanggal</label>
                    <select name="booking_date" id="booking_date" required
                        style="width: 100%; background: rgba(255,255,255,0.02); border: 1px solid var(--border-color); color: var(--text-main); padding: 1rem; border-radius: 8px; font-family: inherit; cursor: pointer;">
                        <option value="{{ now()->format('Y-m-d') }}"
                            style="background: var(--bg-card); color: var(--text-main);">Hari Ini
                            ({{ now()->format('d M') }})</option>
                        <option value="{{ now()->addDay()->format('Y-m-d') }}"
                            style="background: var(--bg-card); color: var(--text-main);">Besok
                            ({{ now()->addDay()->format('d M') }})</option>
                        <option value="{{ now()->addDays(2)->format('Y-m-d') }}"
                            style="background: var(--bg-card); color: var(--text-main);">Lusa
                            ({{ now()->addDays(2)->format('d M') }})</option>
                    </select>
                </div>
                <div style="flex: 1; min-width: 200px;">
                    <label
                        style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.5rem; display: block; font-weight: 800; letter-spacing: 1px; text-transform: uppercase;">Waktu
                        Mulai (HH:MM)</label>
                    <input type="time" name="booking_time" id="booking_time" required
                        style="width: 100%; background: rgba(255,255,255,0.02); border: 1px solid var(--border-color); color: var(--text-main); padding: 1rem; border-radius: 8px; font-family: inherit; color-scheme: dark;">
                </div>
            </div>
            <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: -1.5rem; margin-bottom: 3rem;">Silakan datang ke warnet sesuai jadwal. Admin akan melakukan check-in saat Anda tiba.</div>

            <div class="section-title">Durasi Main</div>
            <div class="dur-grid">
                <div class="dur-box selected" id="dur_1" onclick="selectDuration('1', 1, '1 Jam')">
                    <div class="radio-circle"></div>
                    <div class="dur-title">1 Jam</div>
                    <div class="dur-price" id="dur_price_1">Rp 0</div>
                </div>
                <div class="dur-box" id="dur_3" onclick="selectDuration('3', 3, '3 Jam')">
                    <div class="radio-circle"></div>
                    <div class="dur-title">3 Jam</div>
                    <div class="dur-price" id="dur_price_3">Rp 0</div>
                </div>

            </div>

            <div class="section-title">
                Amunisi
                <a href="#" class="link-kantin">Menu Kantin</a>
            </div>
            <div class="amunisi-grid">
                @foreach($canteenItems as $item)
                    <div class="amu-box" id="amu_box_{{ $item->id }}">
                        <img src="{{ asset($item->image_path ?? 'images/indomie.png') }}" class="amu-img"
                            onerror="this.src='https://via.placeholder.com/60/15111c/a855f7?text=Food'">
                        <div class="amu-info">
                            <div class="amu-title">{{ $item->name }}</div>
                            <div class="amu-price">Rp {{ number_format($item->price, 0, ',', '.') }}</div>

                            <div class="amu-action" id="amu_action_{{ $item->id }}" style="display: none;">
                                <button type="button" class="btn-qty"
                                    onclick="updateQty({{ $item->id }}, -1, {{ $item->price }}, '{{ $item->name }}')">-</button>
                                <div class="amu-val" id="amu_val_{{ $item->id }}">1</div>
                                <button type="button" class="btn-qty purple"
                                    onclick="updateQty({{ $item->id }}, 1, {{ $item->price }}, '{{ $item->name }}')">+</button>
                            </div>
                            <button type="button" class="btn-add" id="btn_add_{{ $item->id }}"
                                onclick="addItem({{ $item->id }}, {{ $item->price }}, '{{ $item->name }}')">+ Tambah</button>
                        </div>
                        <input type="hidden" name="canteen_items[{{ $item->id }}]" id="input_amu_{{ $item->id }}" value="0">
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Right Column: Summary -->
        <div>
            <div class="summary-card">
                <div class="summary-title">
                    <svg viewBox="0 0 24 24">
                        <path
                            d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z" />
                    </svg>
                    Ringkasan bill
                </div>

                <div class="summary-row border-bottom">
                    <span class="summary-label">Pc Terpilih</span>
                    <span class="summary-val" id="sum_pc">-</span>
                </div>

                <div class="summary-row">
                    <span class="summary-label" id="sum_dur_label">Durasi (-)</span>
                    <span class="summary-val" id="sum_dur_price">-</span>
                </div>

                <div id="canteen_summary_container" class="border-bottom"
                    style="padding-bottom: 1.25rem; margin-bottom: 1.25rem; margin-top: 1rem;">
                    <!-- Canteen items injected here -->
                </div>

                <div class="summary-total">
                    <div class="total-label">TOTAL BAYAR</div>
                    <div class="total-val" id="sum_total">Rp 0</div>
                </div>

                <button type="submit" class="btn-confirm" id="btn_confirm" disabled>
                    PILIH PC DULU
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor">
                        <path
                            d="M3.4 22L2 20.6l3.3-3.3H2v-2h6v6H6v-3.3L3.4 22zm10.6 0v-6h6v2h-3.3l3.3 3.3-1.4 1.4-3.3-3.3V22h-2zm-3.3-8.7L12 12l1.3 1.3L12 14.6l-1.3-1.3zm1.3-2.7L10.7 9.3 12 8l1.3 1.3L12 10.6zM9.3 13.3L8 12l1.3-1.3L10.6 12l-1.3 1.3zm5.4 0L13.4 12l1.3-1.3L16 12l-1.3 1.3zM2 9.3L3.4 8l3.3 3.3V8h2v6H2v-2h3.3L2 9.3zm18.6 0H17.3L20.6 6 19.2 4.6l-3.2 3.2V4.6h-2v6h6V9.3z" />
                    </svg>
                </button>
                <div class="wallet-info">Saldo Wallet: Rp {{ number_format(auth()->user()->wallet_balance, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </form>

    <script>
        const userBalance = {{ auth()->user()->wallet_balance }};

        let currentPcId = null;
        let currentPcPrice = 0;

        let currentDurationId = '1';
        let currentDurationHours = 1;
        let currentDurationName = '1 Jam';
        let currentDurationFlatPrice = null; // for night package

        let canteenCart = {};

        function selectPc(id, name, pricePerHour) {

            document.querySelectorAll('.pc-box').forEach(el => el.classList.remove('selected'));
            document.getElementById('pc_' + id).classList.add('selected');

            document.getElementById('input_pc_id').value = id;

            currentPcId = id;
            currentPcPrice = pricePerHour;

            // Update UI
            document.getElementById('sum_pc').innerText = name;

            // Update Duration Prices based on PC
            document.getElementById('dur_price_1').innerText = formatRupiah(pricePerHour * 1);
            document.getElementById('dur_price_3').innerText = formatRupiah(pricePerHour * 3);

            calculateTotal();
        }

        function selectDuration(id, hours, name, flatPrice = null) {
            document.querySelectorAll('.dur-box').forEach(el => el.classList.remove('selected'));
            document.getElementById('dur_' + id).classList.add('selected');

            document.getElementById('input_duration').value = id;

            currentDurationId = id;
            currentDurationHours = hours;
            currentDurationName = name;
            currentDurationFlatPrice = flatPrice;

            calculateTotal();
        }

        function addItem(id, price, name) {
            document.getElementById('btn_add_' + id).style.display = 'none';
            document.getElementById('amu_action_' + id).style.display = 'flex';
            document.getElementById('amu_box_' + id).classList.add('selected');

            canteenCart[id] = { qty: 1, price: price, name: name };
            document.getElementById('input_amu_' + id).value = 1;
            document.getElementById('amu_val_' + id).innerText = 1;

            calculateTotal();
        }

        function updateQty(id, change, price, name) {
            if (!canteenCart[id]) return;

            let newQty = canteenCart[id].qty + change;
            if (newQty <= 0) {
                delete canteenCart[id];
                document.getElementById('btn_add_' + id).style.display = 'block';
                document.getElementById('amu_action_' + id).style.display = 'none';
                document.getElementById('amu_box_' + id).classList.remove('selected');
                document.getElementById('input_amu_' + id).value = 0;
            } else {
                canteenCart[id].qty = newQty;
                document.getElementById('input_amu_' + id).value = newQty;
                document.getElementById('amu_val_' + id).innerText = newQty;
            }

            calculateTotal();
        }

        function calculateTotal() {
            if (!currentPcId) return;

            // Calc Duration Price
            let durationCost = 0;
            if (currentDurationFlatPrice !== null) {
                durationCost = currentDurationFlatPrice;
            } else {
                durationCost = currentPcPrice * currentDurationHours;
            }

            document.getElementById('sum_dur_label').innerText = 'Durasi (' + currentDurationName + ')';
            document.getElementById('sum_dur_price').innerText = formatRupiah(durationCost);

            // Calc Canteen Price
            let canteenCost = 0;
            let canteenHtml = '';
            for (let id in canteenCart) {
                let item = canteenCart[id];
                let sub = item.qty * item.price;
                canteenCost += sub;
                canteenHtml += `
                                    <div class="summary-row" style="margin-bottom: 0.5rem; margin-top:0.5rem;">
                                        <span class="summary-label">${item.qty}x ${item.name}</span>
                                        <span class="summary-val">${formatRupiah(sub)}</span>
                                    </div>`;
            }
            document.getElementById('canteen_summary_container').innerHTML = canteenHtml;

            let total = durationCost + canteenCost;
            document.getElementById('sum_total').innerText = formatRupiah(total);

            let btnConfirm = document.getElementById('btn_confirm');
            if (total > userBalance) {
                btnConfirm.disabled = true;
                btnConfirm.innerHTML = 'SALDO TIDAK CUKUP';
                document.getElementById('sum_total').style.color = '#ef4444';
            } else {
                btnConfirm.disabled = false;
                btnConfirm.innerHTML = `KONFIRMASI BAYAR <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M3.4 22L2 20.6l3.3-3.3H2v-2h6v6H6v-3.3L3.4 22zm10.6 0v-6h6v2h-3.3l3.3 3.3-1.4 1.4-3.3-3.3V22h-2zm-3.3-8.7L12 12l1.3 1.3L12 14.6l-1.3-1.3zm1.3-2.7L10.7 9.3 12 8l1.3 1.3L12 10.6zM9.3 13.3L8 12l1.3-1.3L10.6 12l-1.3 1.3zm5.4 0L13.4 12l1.3-1.3L16 12l-1.3 1.3zM2 9.3L3.4 8l3.3 3.3V8h2v6H2v-2h3.3L2 9.3zm18.6 0H17.3L20.6 6 19.2 4.6l-3.2 3.2V4.6h-2v6h6V9.3z"/></svg>`;
                document.getElementById('sum_total').style.color = 'var(--purple-light)';
            }
        }

        function formatRupiah(number) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
        }

        // Set default time for booking to current time
        window.addEventListener('DOMContentLoaded', () => {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            document.getElementById('booking_time').value = `${hours}:${minutes}`;
        });
    </script>
@endsection