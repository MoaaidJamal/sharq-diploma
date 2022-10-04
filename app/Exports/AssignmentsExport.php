<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class AssignmentsExport implements FromCollection, WithHeadings, WithEvents, WithColumnWidths, WithTitle
{
    public $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        $data = $this->data;
        $items = [];
        foreach ($data as $key => $item) {
            $items[$key]['name'] = $item->user->name ?? '-';
            $items[$key]['course'] = optional(optional($item->lecture)->course)->title ?? '-';
            $items[$key]['lecture'] = optional($item->lecture)->title ?? '-';
            $items[$key]['file'] = $item->file ?? '-';
            $items[$key]['created_at'] = Carbon::parse($item->created_at)->toDateTimeString();
        }
        return collect($items);
    }

    public function headings(): array {
        return [
            __('users.name'),
            __('courses.singular'),
            __('lectures.singular'),
            __('assignments.file'),
            __('assignments.created_at'),
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1:E1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(20);
                $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setWrapText(true);
                $styleArray = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => 'FFFF0000'],
                        ],
                    ],
                ];
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleArray);
            },
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 30,
            'C' => 30,
            'D' => 30,
            'E' => 30,
        ];
    }

    public function title(): string {
        return __('users.title');
    }
}
