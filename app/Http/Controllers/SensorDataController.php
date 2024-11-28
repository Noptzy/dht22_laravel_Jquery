<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorData;

class SensorDataController extends Controller
{
    /**
     * Menyimpan data sensor (temperature dan humidity) ke database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validasi data yang diterima dari request
        $validated = $request->validate([
            'temperature' => 'required|numeric', // Temperature harus berupa angka
            'humidity' => 'required|numeric',    // Humidity harus berupa angka
        ]);

        // Simpan data ke tabel sensor_data
        $sensorData = SensorData::create([
            'temperature' => $validated['temperature'], // Simpan suhu
            'humidity' => $validated['humidity'],       // Simpan kelembaban
        ]);

        // Kembalikan respons JSON dengan status 201 (Created)
        return response()->json([
            'message' => 'Data berhasil disimpan',
            'data' => $sensorData
        ], 201);
    }

    /**
     * Mengambil semua data sensor dari database.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Mengambil semua data sensor dari tabel sensor_data
        $sensorData = SensorData::orderBy('created_at', 'asc')->get(); // Data diurutkan berdasarkan waktu

        // Kembalikan data dalam format JSON
        return response()->json($sensorData);
    }

    public function showData()
    {
        // Ambil semua data dari tabel sensor_data
        $sensorData = SensorData::all();
    
        // Kirim data ke view 'sensor-data' bukan 'sensor'
        return view('sensor-data', compact('sensorData'));
    }
    
    
}
