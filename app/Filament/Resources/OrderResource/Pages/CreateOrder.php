<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Default nilai jika form kosong atau tidak mengisi semua
        $data['shipping_method'] ??= 'default';
        $data['notes'] ??= '';
        $data['currency'] ??= 'idr';
        $data['payment_status'] ??= 'pending';
        $data['status'] ??= 'pending'; // Sesuaikan enum di database kamu (jangan 'new' jika enum-nya 'pending', 'paid', dll)

        // Pastikan items dalam bentuk array kosong jika belum diisi
        $items = $data['items'] ?? [];

        // Jika bukan array, jadikan array kosong
        if (!is_array($items)) {
            $items = [];
        }

        // Simpan items dalam bentuk json
        $data['items'] = json_encode($items);

        // Hitung total_price dari subtotal item (jika ada)
        $data['total_price'] = array_sum(array_column($items, 'subtotal'));

        return $data;
    }
}
