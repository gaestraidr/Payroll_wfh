<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Pegawai;
use App\Models\Absensi;
use App\Models\Izin;

class DashboardController extends Controller
{
    public function index()
    {
        $range = array();

        if (auth()->user()->role == 2) {
            $pegawai_count = Pegawai::count();

            for ($i = 1; $i <= 12; $i++) {
                $date = Carbon::parse(date('Y') . "-" . $i . "-01");
                $absen_pile = 0;

                foreach (Pegawai::all() as $pegawai) {
                    $fetch_data = Absensi::where('pegawai_id', $pegawai->id)->whereYear("created_at", '=', $date)->whereMonth("created_at", '=', $date)->orderBy('created_at')->get();
                    $absen_pile += $this->countAbsensiData($fetch_data);
                }

                $fetch_data = Absensi::where('pegawai_id', auth()->user()->id)->whereYear("created_at", '=', $date)->whereMonth("created_at", '=', $date)->orderBy('created_at')->get();
                $range['total_days'][$i - 1] = cal_days_in_month(CAL_GREGORIAN, $i, intval(date('Y')));
                $range['have_absensi'][$i - 1] = intval(($absen_pile / ($range['total_days'][$i - 1] * $pegawai_count)) * $range['total_days'][$i - 1]);
            }

            $date = Carbon::parse(date('Y-m') . "-01");

            $jan_mar = $this->getMonthlyAbsensiRangePercentage($range, 0, 3);
            $apr_jun = $this->getMonthlyAbsensiRangePercentage($range, 3, 3);
            $jul_sep = $this->getMonthlyAbsensiRangePercentage($range, 6, 3);
            $oct_dec = $this->getMonthlyAbsensiRangePercentage($range, 9, 3);

            $data_diff = $this->getAbsenStateBefore($range);

            return view('/pages/index-admin', [
                'data_pegawai_problematic' => Pegawai::where('jumlah_cuti', '<', 0)->get(),
                'jml_pegawai' => $pegawai_count,
                'jml_absensi_month' => Absensi::whereYear("created_at", '=', $date)->whereMonth("created_at", '=', $date)->count(),
                'jml_izin_month' => Izin::whereYear("created_at", '=', $date)->whereMonth("created_at", '=', $date)->count(),
                'jml_pegawai_izin' => Izin::whereYear("created_at", '=', $date)->whereMonth("created_at", '=', $date)->get()->unique('pegawai_id')->count(),
                'absen_state' => $data_diff['state'],
                'absen_diff_percentage' => intval($data_diff['percentage']),
                'data_monthly_absensi' => $range,
                'jan_mar' => intval($jan_mar),
                'apr_jun' => intval($apr_jun),
                'jul_sep' => intval($jul_sep),
                'oct_dec' => intval($oct_dec)
            ]);
        }
        else {
            for ($i = 1; $i <= 12; $i++) {
                $date = Carbon::parse(date('Y') . "-" . $i . "-01");
                $fetch_data = Absensi::where('pegawai_id', auth()->user()->id)->whereYear("created_at", '=', $date)->whereMonth("created_at", '=', $date)->orderBy('created_at')->get();
                $range['have_absensi'][$i - 1] = $this->countAbsensiData($fetch_data);
                $range['total_days'][$i - 1] = cal_days_in_month(CAL_GREGORIAN, $i, intval(date('Y')));
            }

            $jan_mar = $this->getMonthlyAbsensiRangePercentage($range, 0, 3);
            $apr_jun = $this->getMonthlyAbsensiRangePercentage($range, 3, 3);
            $jul_sep = $this->getMonthlyAbsensiRangePercentage($range, 6, 3);
            $oct_dec = $this->getMonthlyAbsensiRangePercentage($range, 9, 3);

            return view('/pages/index', [
                'jml_user' => (auth()->user()->role == 2 ? Pegawai::count() : 0),
                'jml_absen' => Absensi::count(),
                'quota_absensi' => Absensi::where('pegawai_id', auth()->user()->id)->whereDate('created_at', Carbon::now())->count(),
                'data_monthly_absensi' => $range,
                'jan_mar' => intval($jan_mar),
                'apr_jun' => intval($apr_jun),
                'jul_sep' => intval($jul_sep),
                'oct_dec' => intval($oct_dec)
            ]);
        }
    }

    private function getMonthlyAbsensiRangePercentage($range, $start, $count) {
        $data_count = 0;
        $total_data = 0;

        for ($i = $start; $i < ($start + $count); $i++) {
            $data_count += $range['have_absensi'][$i];
            $total_data += $range['total_days'][$i];
        }

        return ($data_count / $total_data) * 100;
    }

    private function countAbsensiData($arr) {
        $count = 0;
        $dupe_check = array();

        foreach ($arr as $data) {
            if (empty($dupe_check[date("Y-m-d", strtotime($data->created_at))])) {
                $dupe_check[date("Y-m-d", strtotime($data->created_at))] = "Fill";
                $count++;
            }
        }

        return $count;
    }

    private function getAbsenStateBefore($range) {
        $month = intval(date('m'));
        $percentage_now = $month > 1 ? ($range['have_absensi'][$month - 1] / $range['total_days'][$month - 1]) * 100 : 100;
        $percentage_before = $month > 1 ? ($range['have_absensi'][$month - 2] / $range['total_days'][$month - 2]) * 100 : 100;

        $data_ret['state'] = 0;

        if ($percentage_now > $percentage_before)
            $data_ret['state'] = 1;
        else if ($percentage_now < $percentage_before)
            $data_ret['state'] = -1;

        $data_ret['percentage'] = $percentage_now;

        return $data_ret;
    }
}
