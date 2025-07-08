<?php

namespace App\Http\Controllers;

use App\Models\OrderProses;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class ExportOrderProsesController extends Controller
{
    public function export()
    {
        App::setLocale('id');
        Carbon::setLocale('id');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Order Proses');

        $sheet->setCellValue('B1', 'LAPORAN ORDER DO/PO/SO & TRUCKING');
        $sheet->mergeCells('B1:J1');
        $sheet->getStyle('B1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->setCellValue('B2', 'CV. Sarana Perintis Jaya');
        $sheet->mergeCells('B2:J2');
        $sheet->getStyle('B2')->applyFromArray([
            'font' => ['italic' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        $row = 4;
        $orderList = OrderProses::with([
            'orders.customers',
            'order_detail.trucks',
            'order_detail.drivers',
            'locations'
        ])->get();

        foreach ($orderList as $orderProses) {
            $sheet->setCellValue("B{$row}", 'DO Number:');
            $sheet->setCellValue("C{$row}", $orderProses->do_number ?? '-');
            $sheet->setCellValue("E{$row}", 'Customer:');
            $sheet->setCellValue("F{$row}", optional($orderProses->orders->customers)->name ?? '-');
            $row++;
            $sheet->setCellValue("B{$row}", 'PO Number:');
            $sheet->setCellValue("C{$row}", $orderProses->po_number ?? '-');
            $sheet->setCellValue("E{$row}", 'Item:');
            $sheet->setCellValue("F{$row}", $orderProses->item_proses);
            $row++;
            $sheet->setCellValue("B{$row}", 'SO Number:');
            $sheet->setCellValue("C{$row}", $orderProses->so_number ?? '-');
            $sheet->setCellValue("E{$row}", 'Tujuan:');
            $sheet->setCellValue("F{$row}", optional($orderProses->locations)->name ?? '-');
            $row += 2;

            $headerRow1 = $row;
            $headerRow2 = $row + 1;
            $sheet->setCellValue("B{$headerRow1}", 'Tanggal');
            $sheet->setCellValue("C{$headerRow1}", 'Truck');
            $sheet->setCellValue("D{$headerRow1}", 'Supir');
            $sheet->setCellValue("E{$headerRow1}", 'Bag');
            $sheet->mergeCells("E{$headerRow1}:F{$headerRow1}");
            $sheet->setCellValue("G{$headerRow1}", 'Bruto');
            $sheet->setCellValue("H{$headerRow1}", 'Tara');
            $sheet->setCellValue("I{$headerRow1}", 'Netto');
            $sheet->setCellValue("J{$headerRow1}", 'Keterangan');

            $sheet->setCellValue("E{$headerRow2}", 'Kirim');
            $sheet->setCellValue("F{$headerRow2}", 'Terima');

            foreach (['B','C','D','G','H','I','J'] as $col) {
                $sheet->mergeCells("{$col}{$headerRow1}:{$col}{$headerRow2}");
            }

            $sheet->getStyle("B{$headerRow1}:J{$headerRow2}")->applyFromArray([
                'font' => ['bold' => true],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true,
                ],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            ]);
            $row = $headerRow2 + 1;

            foreach ($orderProses->order_detail as $detail) {
                $tanggal = Carbon::parse($detail->date_detail)->translatedFormat('d F Y');
                $sheet->setCellValue("B{$row}", $tanggal);
                $sheet->setCellValue("C{$row}", optional($detail->trucks)->plate_number ?? '-');
                $sheet->setCellValue("D{$row}", optional($detail->drivers)->name ?? '-');
                $sheet->setCellValue("E{$row}", $detail->bag_send);
                $sheet->setCellValue("F{$row}", $detail->bag_received);
                $sheet->setCellValue("G{$row}", $detail->bruto);
                $sheet->setCellValue("H{$row}", $detail->tara);
                $sheet->setCellValue("I{$row}", $detail->netto);
                $sheet->setCellValue("J{$row}", $detail->note_detail);

                $sheet->getStyle("E{$row}:I{$row}")
                    ->getNumberFormat()
                    ->setFormatCode('#,##0');

                $sheet->getStyle("B{$row}:J{$row}")->applyFromArray([
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
                $row++;
            }

            $totalBagSend = $orderProses->order_detail->sum('bag_send');
            $totalBagReceived = $orderProses->order_detail->sum('bag_received');
            $totalBruto = $orderProses->order_detail->sum('bruto');
            $totalTara = $orderProses->order_detail->sum('tara');
            $totalNetto = $orderProses->order_detail->sum('netto');

            $sheet->setCellValue("B{$row}", 'TOTAL');
            $sheet->mergeCells("B{$row}:D{$row}");
            $sheet->setCellValue("E{$row}", $totalBagSend);
            $sheet->setCellValue("F{$row}", $totalBagReceived);
            $sheet->setCellValue("G{$row}", $totalBruto);
            $sheet->setCellValue("H{$row}", $totalTara);
            $sheet->setCellValue("I{$row}", $totalNetto);

            $sheet->getStyle("E{$row}:I{$row}")
                ->getNumberFormat()
                ->setFormatCode('#,##0');

            $sheet->getStyle("B{$row}:J{$row}")->applyFromArray([
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'FFFFCC'],
                ],
            ]);

            $row += 3;
        }

        foreach (range('B', 'J') as $col) {
            if (!in_array($col, ['E', 'F'])) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
        }

        $sheet->getColumnDimension('E')->setWidth(12);
        $sheet->getColumnDimension('F')->setWidth(12);

        // Export
        $writer = new Xlsx($spreadsheet);
        $filename = 'order_proses_export_all.xlsx';
        ob_start();
        $writer->save('php://output');
        $content = ob_get_clean();

        return Response::make($content, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => "attachment; filename={$filename}",
            'Cache-Control' => 'max-age=0',
        ]);
    }
}