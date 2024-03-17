<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = Transaksi::all();

        // return $data;
        return $this->sendResponse($data, 'Transaksi berhasil ditampilkan');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $input = $request->all();

        $validator = Validator::make($input, [
            'status'=> 'required|string|in:proses,selesai',
            'tanggal' => 'required',
            'total' => 'required',
            'id_users' => 'required',
            'details' => 'required|array',
            'details.*.id_produk' => 'required',
            'details.*.harga' => 'required',
            'details.*.qty' => 'required',
            'details.*.total' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation error', $validator->errors(), 422);
        }

        try {
            
            $input['inv'] = 'INV-'.time().'-' . Str::random(4);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $data = Transaksi::find($id);

        return $this->sendResponse($data, 'Data transaksi');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $data = Transaksi::find($id);
        try {
            //code...
            $data->delete();
            return $this->sendResponse([], 'Transaksi berhasil di hapus');
        } catch (\Throwable $e) {
            //throw $th;
            return $this->sendError('Error ' . $e->getMessage(), 400);
        }
    }
}
