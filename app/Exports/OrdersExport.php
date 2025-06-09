<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Database\Eloquent\Collection;

class OrdersExport implements FromCollection, WithHeadings
{
    protected ?array $filters;

    public function __construct(?array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    { 
        $query = Order::query();

        if (isset($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        // Tambah filter lain sesuai kebutuhan

        return $query->select('id', 'customer_name', 'status', 'total', 'created_at')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Customer Name', 'Status', 'Total', 'Created At'];
    }
}