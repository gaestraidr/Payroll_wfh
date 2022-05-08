<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Helpers\UploadHelper;

use App\Models\Izin;

class IzinController extends Controller
{
    public function index()
    {
        return view('/pages/izin/index', [
            'data_izin' => auth()->user()->izins
        ]);
    }

    public function moderate()
    {
        return view('/pages/izin/moderate', [
            'data_izin' => Izin::where('approval', 0)->get()
        ]);
    }

    public function detail($id)
    {
        $izin = Izin::with('pegawai')->findOrFail($id);
        return response()->json([
            'data' => $izin,
            'approval_allowed' => !(intval(date('d')) > 10 || $izin->approval !== 0)
        ], 200);
    }

    public function viewPhoto($id)
    {
        $izin = Izin::findOrFail($id);

        $data_path = storage_path('app/izin_photo/' . $izin->photo);

        if (auth()->user()->role != 2 && $izin->pegawai_id != auth()->user()->id)
            return response()->json([
                'status' => 'ERR_FORBIDDEN',
                'message' => 'Unauthorized access to photo'
            ], 401);

        if (!file_exists($data_path))
            return response()->json([
                'status' => 'ERR_NOTFOUND',
                'message' => 'Photo not found'
            ], 404);

        return response()->file($data_path);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'keterangan' => 'string|required',
            'photo' => 'image|required'
        ]);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator->errors());

        $data = new Izin();

        $data->keterangan = $request->keterangan;
        $data->tanggal_izin = $request->tanggal_izin;
        $data->sampai_tanggal = $request->sampai_tanggal;
        $data->photo = UploadHelper::uploadImage($request->file('photo'), 'izin_photo');
        $data->pegawai_id = auth()->user()->id;
        $data->approval = 0;

        $data->save();

        return redirect()->back()->with('message', 'SUCCESS');
    }

    public function approval($id, $approval)
    {
        if (!filter_var($approval, FILTER_VALIDATE_INT))
            return response()->json([
                'status' => 'ERR_INVALID',
                'message' => 'Approval Code passed is not valid'
            ], 400);

        $izin = Izin::findOrFail($id);

        if (intval(date('d')) > 10 || $izin->approval !== 0)
            return response()->json([
                'status' => 'ERR_FORBIDDEN',
                'message' => 'Cannot give approval on Data Izin selected'
            ], 400);

        $izin->approval = $approval;
        $izin->save();

        return response()->json([
            'status' => 'SUCCESS',
            'message' => 'Approval has been submitted to the data',
            'data' => $izin
        ], 200);
    }
}
