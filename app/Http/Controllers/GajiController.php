<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use App\Helpers\DataManipulationHelper;
use App\Helpers\CalendarHelper;

use App\Models\Pegawai;
use App\Models\Absensi;

class GajiController extends Controller
{
    public function index()
    {
        return view('/pages/gaji/index', [
            'data_pegawai' => (auth()->user()->role == 2 ? Pegawai::all() : [auth()->user()])
        ]);
    }

    public function gather($id, $month)
    {
        $date = '';
        if ($month <= 1) // For January, take data from december
            $date = Carbon::parse((intval(date('Y')) - 1) . "-12-01");
        else $date = Carbon::parse(date('Y') . "-" . (intval($month) - 1) . "-01");

        if ($id == 'all' && auth()->user()->role == 2) {
            $data = array();

            foreach (Pegawai::with('jabatan')->get() as $pegawai) {
                $temp_arr = [
                    'data_pegawai' => $pegawai,
                    'data_gaji' => $this->calculateGaji($pegawai, $date)
                ];

                array_push($data, $temp_arr);
            }

            return response()->json([
                'data' => $data
            ], 200);
        }

        $pegawai = (auth()->user()->role == 2 ? Pegawai::findOrFail($id) : auth()->user());

        return response()->json([
            'data_pegawai' => $pegawai,
            'data_gaji' => $this->calculateGaji($pegawai, $date)
        ], 200);
    }

    public function printAll($month)
    {
        $date = '';
        if ($month <= 1) // For January, take data from december
            $date = Carbon::parse((intval(date('Y')) - 1) . "-12-01");
        else $date = Carbon::parse(date('Y') . "-" . (intval($month) - 1) . "-01");

        $fileName = "Laporan Gaji Pegawai - " . date('F-Ymd', strtotime($date . '+1 month'));

        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $rowCount = 1;

        $sheet->mergeCells("A{$rowCount}:G{$rowCount}");
        $sheet->setCellValue('A'.$rowCount, "LAPORAN GAJI PEGAWAI");
        $sheet->getStyle('A'.$rowCount)->getFont()->setSize(16);
        $sheet->getStyle('A'.$rowCount)->getFont()->setBold(true);
        $this->setCellToCenter($sheet->getStyle('A'.$rowCount));
        $rowCount++;

        $sheet->mergeCells("A{$rowCount}:G{$rowCount}");
        $sheet->setCellValue('A'.$rowCount, "WAREHOUSE DC PARUNG");
        $sheet->getStyle('A'.$rowCount)->getFont()->setSize(16);
        $sheet->getStyle('A'.$rowCount)->getFont()->setBold(true);
        $this->setCellToCenter($sheet->getStyle('A'.$rowCount));
        $rowCount++;

        $sheet->mergeCells("A{$rowCount}:G{$rowCount}");
        $sheet->setCellValue('A'.$rowCount, "TAHUN ANGGARAN " . date("Y"));
        $sheet->getStyle('A'.$rowCount)->getFont()->setSize(14);
        $this->setCellToCenter($sheet->getStyle('A'.$rowCount));
        $rowCount++;

        $sheet->mergeCells("A{$rowCount}:G{$rowCount}");
        $sheet->setCellValue('A'.$rowCount, "BULAN " . date('F', strtotime($date . '+1 month')));
        $sheet->getStyle('A'.$rowCount)->getFont()->setSize(12);
        $this->setCellToCenter($sheet->getStyle('A'.$rowCount));
        $rowCount += 2;

        $stock_table_index = $rowCount;

        $sheet->setCellValue("A".$rowCount, "No. Induk Pegawai");
        $sheet->setCellValue("B".$rowCount, "Pegawai");
        $sheet->setCellValue("C".$rowCount, "Gaji Pokok");
        $sheet->setCellValue("D".$rowCount, "Pajak");
        $sheet->setCellValue("E".$rowCount, "Upah Lemburan");
        $sheet->setCellValue("F".$rowCount, "Total");
        $sheet->setCellValue("G".$rowCount, "No. Rekening");

        $sheet->getStyle('A'.$rowCount)->getFont()->setBold(true);
        $sheet->getStyle('B'.$rowCount)->getFont()->setBold(true);
        $sheet->getStyle('C'.$rowCount)->getFont()->setBold(true);
        $sheet->getStyle('D'.$rowCount)->getFont()->setBold(true);
        $sheet->getStyle('E'.$rowCount)->getFont()->setBold(true);
        $sheet->getStyle('F'.$rowCount)->getFont()->setBold(true);
        $sheet->getStyle('G'.$rowCount)->getFont()->setBold(true);

        $this->setCellToCenter($sheet->getStyle('A'.$rowCount));
        $this->setCellToCenter($sheet->getStyle('B'.$rowCount));
        $this->setCellToCenter($sheet->getStyle('C'.$rowCount));
        $this->setCellToCenter($sheet->getStyle('D'.$rowCount));
        $this->setCellToCenter($sheet->getStyle('E'.$rowCount));
        $this->setCellToCenter($sheet->getStyle('F'.$rowCount));
        $this->setCellToCenter($sheet->getStyle('G'.$rowCount));

        $sheet->getStyle("A{$rowCount}:G{$rowCount}")->getFont()->getColor()->setARGB("FFFFFFFF");
        $sheet->getStyle("A{$rowCount}:G{$rowCount}")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB("FF283593");

        $rowCount += 2;

        $index = 1;

        foreach (Pegawai::all() as $pegawai) {
            $data_gaji = $this->calculateGaji($pegawai, $date);

            $sheet->setCellValue("A".$rowCount, $pegawai->nomor_induk);
            $sheet->setCellValue("B".$rowCount, $pegawai->name);
            $sheet->setCellValue("C".$rowCount, 'Rp. ' . number_format($data_gaji->gaji_pokok));
            $sheet->setCellValue("D".$rowCount, '-');
            $sheet->setCellValue("E".$rowCount, 'Rp. ' . number_format($data_gaji->gaji_lembur));
            $sheet->setCellValue("F".$rowCount, 'Rp. ' . number_format($data_gaji->gaji_lembur + $data_gaji->gaji_pokok));
            $sheet->setCellValue("G".$rowCount, $pegawai->no_rek);

            $rowCount++; $index++;
        }

        $sheet->getStyle("A{$stock_table_index}:G{$rowCount}")->applyFromArray($this->styleAllBorder());

        $rowCount += 2;

        foreach (range("A", $sheet->getHighestDataColumn()) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . urlencode($fileName) . '.xlsx"');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    private function setCellToCenter($style) {
        $style->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    }

    private function styleAllBorder() {
        return array(
            'borders' => array(
                'top' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
                'bottom' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
                'left' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
                'right' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
            )
        );
    }

    private function calculateGaji($pegawai, $date)
    {
        $calc_data = [
            'gaji_pokok' => $pegawai->jabatan->gaji_pokok,
            'gaji_lembur' => 0,
            'lemburan' => array()
        ];
        $absen_data = Absensi::where('pegawai_id', $pegawai->id)->where('status', '>=', 3)->where('keterangan', 2)
                        ->whereMonth('created_at', $date)->whereYear('created_at', $date)->get();

        foreach ($absen_data as $absen) {
            $holiday_data = CalendarHelper::getSpecifiedHolidayData($absen->created_at);
            $calc_item = [
                'date' => date('l, j F', strtotime($absen->created_at)) . ' (' . $holiday_data->name . ')',
                'additional_pay' => 0
            ];

            // Sum Lembur Wage
            $calc_item['additional_pay'] = intval(5 * 2 * (1 / 173) * $calc_data['gaji_pokok']); // First 5 Hours
            $calc_item['additional_pay'] += intval(1 * 3 * (1 / 173) * $calc_data['gaji_pokok']); // At 6 Hours
            $calc_item['additional_pay'] += intval(2 * 4 * (1 / 173) * $calc_data['gaji_pokok']); // At 7 $ 8 Hours

            // Add to total
            $calc_data['gaji_lembur'] += $calc_item['additional_pay'];

            // Push item to collection
            array_push($calc_data['lemburan'], $calc_item);
        }

        return DataManipulationHelper::turnArraytoJson($calc_data);
    }
}
