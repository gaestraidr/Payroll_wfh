<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use GuzzleHttp\Client;

use App\Helpers\AccessLookupHelper;
use App\Helpers\CalendarHelper;
use App\Helpers\DataManipulationHelper;

use App\Models\Absensi;
use App\Models\Pegawai;

class AbsensiController extends Controller
{

    public function index()
    {
        return view('/pages/absen/index', [
            'check_absen' => DataManipulationHelper::turnArraytoJson($this->checkAbsenCondition()),
            'absen_today' => Absensi::where('pegawai_id', auth()->user()->id)->whereDate('created_at', Carbon::today())->get()
        ]);
    }

    public function detail($id = NULL)
    {
        return view('/pages/absen/detail', [
            'data_pegawai' => (auth()->user()->role == 2 && !empty($id) ? Pegawai::findOrFail($id) : auth()->user()),
            'data_pegawai_list' => (auth()->user()->role == 2 ? Pegawai::all() : '')
        ]);
    }

    public function monthly($month, $id = NULL)
    {
        $date = Carbon::parse(date('Y') . "-" . intval($month) . "-01");

        return response()->json([
            'data' => Absensi::where('pegawai_id', (auth()->user()->role == 2 && !empty($id) ? $id : auth()->user()->id))
                ->whereMonth('created_at', $date)->whereYear('created_at', $date)->get()
        ], 200);
    }

    public function holiday()
    {
        return response()->json(CalendarHelper::getHolidayData(), 200);
    }

    public function check()
    {
        $condition = DataManipulationHelper::turnArraytoJson($this->checkAbsenCondition());

        return response()->json([
            'status' => $condition->status,
            'message' => $condition->message
        ], ($condition->status == "ABSENSI_ALLOWED" ? 200 : 400));
    }

    public function print($month, $id = NULL)
    {
        $date = Carbon::parse(date('Y') . "-" . intval($month) . "-01");
        $user = (auth()->user()->role == 2 && !empty($id) ? Pegawai::findOrFail($id) : auth()->user());
        $data = Absensi::where('pegawai_id', (auth()->user()->role == 2 && !empty($id) ? $id : auth()->user()->id))
            ->whereMonth('created_at', $date)->whereYear('created_at', $date)->get();

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('app/public/absensi_template.docx'));

        $templateProcessor->setValues([
            'date' => date('F, Y', strtotime(date('Y-') . $month . '-1')),
            'name' => $user->name,
            'email' => $user->email,
            'jabatan' => $user->jabatan->nama_jabatan
        ]);

        $period = new \DatePeriod( new \DateTime(date('Y-') . $month . '-1'), new \DateInterval('P1D'), new \DateTime(date('Y-') . $month . '-31'));

        foreach ($period as $date) {
            $holiday_data = CalendarHelper::getSpecifiedHolidayData($date->format('Y-m-d'));
            $placeholder = $holiday_data != NULL ? '-Libur ' . $holiday_data->name . '-' : ($date->format('Y-m-d') < date('Y-m-d') ? '-Tidak Absen-' : '-');
            $range[$date->format('Y-m-d')]['absen_masuk'] = [
                'pukul' => $placeholder,
                'keterangan' => $placeholder
            ];
            $range[$date->format('Y-m-d')]['absen_pulang'] = [
                'pukul' => $placeholder,
                'keterangan' => $placeholder
            ];
        }

        foreach ($data as $val) {
            $range[date('Y-m-d', strtotime($val->created_at))][($val->status % 2 == 0 ? 'absen_pulang' : 'absen_masuk')] = [
                'pukul' => date('g:i A', strtotime($val->created_at)),
                'keterangan' => ($val->status >= 3 ? ('Absen Lembur: ' . CalendarHelper::getSpecifiedHolidayData($val->created_at)->name) : '-')
            ];
        }


        for ($i = 1; $i <= 30; $i++) {
            $sel_date = date('Y-') . str_pad($month, 2, '0', STR_PAD_LEFT) . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);
            $templateProcessor->setValues([
                'pukul_masuk' . $i => $range[$sel_date]['absen_masuk']['pukul'],
                'pukul_keluar' . $i => $range[$sel_date]['absen_pulang']['pukul'],
                'keterangan' . $i => $range[$sel_date]['absen_pulang']['keterangan']
            ]);
        }

        header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
        header("Content-Disposition: attachment; filename=Rekapan Document Absensi-"
            . date('Y-m') . '_' . $user->name .".docx");

        $templateProcessor->saveAs('php://output');
    }

    public function store()
    {
        $condition = DataManipulationHelper::turnArraytoJson($this->checkAbsenCondition());;

        if ($condition->status != "ABSENSI_ALLOWED")
            return response()->json([
                'status' => $condition->status,
                'message' => $condition->message,
                'count' => $condition->count
            ], 400);

        $data = new Absensi();

        $data->keterangan = ($condition->count == 0 ? 1 : 2);

        $isNotWfh = AccessLookupHelper::isInternalAccess();

        if (CalendarHelper::isTodayHoliday())
            $data->status = ($isNotWfh ? 3 : 4);
        else $data->status = ($isNotWfh ? 1 : 2);

        $data->pegawai_id = auth()->user()->id;

        $data->save();

        return response()->json([
            'status' => 'SUCCESS',
            'message' =>  'Record has been created succesfully!',
            'data' => $data
        ], 200);
    }

    private function checkAbsenCondition()
    {
        $data = Absensi::where('pegawai_id', auth()->user()->id)->whereDate('created_at', Carbon::today())->get();

        if (count($data) >= 2)
            return [
                'status' => 'ERR_LIMIT',
                'message' => 'Has reach limit of absensi (Maximum of 2)',
                'count' => count($data)
            ];

        if (count($data) == 1 && strtotime(now()) < strtotime($data[0]->created_at . '+8 hours'))
            return [
                'status' => 'WARN_WAIT',
                'message' => 'Absensi stil not pass 8 hours, please wait',
                'count' => count($data)
            ];

        if (!AccessLookupHelper::isInternalAccess() && (auth()->user()->jabatan->remote_absen == 1
            || (auth()->user()->jabatan->remote_absen == 3 && intval(date('d')) > 10)))
            return [
                'status' => 'ERR_FORBIDDEN',
                'message' => 'Cannot do absensi for this user',
                'count' => count($data)
            ];

        return [
            'status' => 'ABSENSI_ALLOWED',
            'message' => 'Absensi is available',
            'count' => count($data)
        ];
    }
}
