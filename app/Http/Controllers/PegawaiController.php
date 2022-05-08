<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Pegawai;
use App\Models\Jabatan;

class PegawaiController extends Controller
{
    public function index()
    {
        return view('/pages/pegawai/index', [
            'data_pegawai' => Pegawai::all()
        ]);
    }

    public function create()
    {
        return view('/pages/pegawai/create', [
            'data_jabatan' => Jabatan::all()
        ]);
    }

    public function edit($id)
    {
        return view('/pages/pegawai/edit', [
            'data_jabatan' => Jabatan::all(),
            'data_pegawai' => Pegawai::findOrFail($id)
        ]);
    }

    public function detail($id)
    {
        return response()->json([
            'data' => Pegawai::with('jabatan')->findOrFail($id)
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|required',
            'email' => 'email|unique:pegawai|required',
            'password' => 'string|min:8|required',
            'jabatan_id' => 'integer|required',
            'role' => 'integer|required'
        ]);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator->errors());

        $data = Pegawai::create($request->all());
        $data->password = bcrypt($request->password);

        $data->save();
        $data->nomor_induk = date('ymd') . sprintf("%02d", $data->id);
        $data->save();

        return redirect()->route('pegawai')->with('message', 'CREATE_SUCCESS');
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|required',
            'email' => 'email|required',
            'jabatan_id' => 'integer|required',
            'role' => 'integer|required'
        ]);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator->errors());

        $data = Pegawai::findOrFail($id);
        $data->update($request->all());

        if (!empty($request->password)) {
            $data->password = bcrypt($request->password);
            $data->save();
        }

        return redirect()->route('pegawai')->with('message', 'CREATE_SUCCESS');
    }

    public function delete($id)
    {
        if ($id == auth()->user()->id)
            return response()->json([
                'status' => 'ERR_FORBIDDEN',
                'message' => 'Cannot delete pegawai that is currently used'
            ], 400);

        Pegawai::findOrFail($id)->delete();

        return response()->json([
            'status' => 'SUCCESS',
            'message' => 'Record has been deleted from database'
        ], 400);
    }
}
