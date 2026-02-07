<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DealersExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(
        protected $registrations
    ) {}

    public function collection()
    {
        return $this->registrations;
    }

    public function headings(): array
    {
        return [
            'Business Name',
            'Business Type',
            'Contact Person',
            'Contact Email',
            'Contact Phone',
            'GST Number',
            'Status',
            'Submitted At',
        ];
    }

    public function map($registration): array
    {
        return [
            $registration->business_name,
            $registration->business_type ?? 'N/A',
            $registration->contact_person,
            $registration->contact_email,
            $registration->contact_phone ?? 'N/A',
            $registration->gst_number ?? 'N/A',
            ucfirst($registration->status),
            $registration->created_at->format('Y-m-d H:i'),
        ];
    }
}
