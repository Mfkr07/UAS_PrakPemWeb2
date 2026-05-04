<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BookingsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $bookings;

    public function __construct($bookings)
    {
        $this->bookings = $bookings;
    }

    public function collection()
    {
        return $this->bookings;
    }

    public function headings(): array
    {
        return [
            'ID Order',
            'Penyewa',
            'Rig / PC',
            'Durasi (Jam)',
            'Tarif Terbayar',
            'Waktu Mulai',
            'Waktu Selesai',
            'Status'
        ];
    }

    public function map($booking): array
    {
        return [
            '#WA-' . str_pad($booking->id, 4, '0', STR_PAD_LEFT),
            $booking->user->name ?? 'Guest',
            $booking->computer->name ?? 'Dihapus',
            $booking->duration_hours,
            'Rp ' . number_format($booking->total_price, 0, ',', '.'),
            $booking->start_time ? $booking->start_time->format('Y-m-d H:i:s') : '-',
            $booking->end_time ? $booking->end_time->format('Y-m-d H:i:s') : '-',
            ucfirst($booking->status)
        ];
    }
}
