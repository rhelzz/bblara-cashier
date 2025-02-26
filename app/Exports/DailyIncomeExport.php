<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DailyIncomeExport implements FromView, WithTitle, WithStyles, ShouldAutoSize
{
    protected $dailyReports;
    protected $totalData;
    protected $startDate;
    protected $endDate;

    public function __construct($dailyReports, $totalData, $startDate, $endDate)
    {
        $this->dailyReports = $dailyReports;
        $this->totalData = $totalData;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function view(): View
    {
        return view('owner.report.export', [
            'dailyReports' => $this->dailyReports,
            'totalData' => $this->totalData,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate
        ]);
    }

    public function title(): string
    {
        return 'Laporan Pendapatan Harian';
    }

    public function styles(Worksheet $sheet)
    {
        // Set the header row styles
        $sheet->getStyle('A1:G1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4472C4'],
            ],
        ]);

        // Set the border for all cells with data
        $lastRow = count($this->dailyReports) + 2; // Header row + data rows + total row
        $sheet->getStyle('A1:G' . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        // Style for the total row
        $sheet->getStyle('A' . $lastRow . ':G' . $lastRow)->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E2EFDA'],
            ],
        ]);

        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}