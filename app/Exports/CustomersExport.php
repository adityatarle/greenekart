<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CustomersExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(
        protected $customers
    ) {}

    public function collection()
    {
        return $this->customers;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Phone',
            'Orders',
            'Total Spent (₹)',
            'Joined',
        ];
    }

    public function map($customer): array
    {
        $totalSpent = $customer->agriculture_orders_sum_total_amount ?? 0;

        return [
            $customer->id,
            $customer->name,
            $customer->email,
            $customer->phone ?? 'N/A',
            $customer->agriculture_orders_count ?? 0,
            number_format($totalSpent, 2),
            $customer->created_at->format('Y-m-d H:i'),
        ];
    }
}
