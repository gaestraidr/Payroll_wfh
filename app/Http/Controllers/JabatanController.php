<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Jabatan;

class JabatanController extends Controller
{
    public function __construct()
    {
        setlocale(LC_MONETARY, 'en_US');
    }

    public function index()
    {
        return view('/pages/jabatan/index', [
            'data_jabatan' => Jabatan::all()
        ]);
    }

    public function create()
    {
        return view('/pages/jabatan/create');
    }

    public function edit($id)
    {
        return view('/pages/jabatan/edit', [
            'data_jabatan' => Jabatan::findOrFail($id)
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_jabatan' => 'string|required',
            'gaji_pokok' => 'integer|required',
            'remote_absen' => 'integer|required'
        ]);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator->errors());

        Jabatan::create($request->all());

        return redirect()->route('jabatan')->with('message', 'CREATE_SUCCESS');
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_jabatan' => 'string|required',
            'gaji_pokok' => 'integer|required',
            'remote_absen' => 'integer|required'
        ]);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator->errors());

        Jabatan::findOrFail($id)->update($request->all());

        return redirect()->route('jabatan')->with('message', 'CREATE_SUCCESS');
    }

    public function delete($id)
    {
        Jabatan::findOrFail($id)->delete();

        return response()->json([
            'status' => 'SUCCESS',
            'message' => 'Record has been deleted from database'
        ], 400);
    }
}
