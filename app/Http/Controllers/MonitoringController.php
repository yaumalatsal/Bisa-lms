<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Monitoring;
use Illuminate\Support\Facades\Storage;

class MonitoringController extends Controller
{
    public function index()
    {
        $data = Monitoring::all();
        return view('monitoring.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'business_process' => 'required',
            'value' => 'required|numeric',
            'product' => 'required',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'date' => 'required|date',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx', // Validation for file upload
        ]);

        // Handle file upload
        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('uploads', 'public');
        }

        // Create new monitoring record
        Monitoring::create([
            'business_process' => $request->input('business_process'),
            'value' => $request->input('value'),
            'product' => $request->input('product'),
            'quantity' => $request->input('quantity'),
            'price' => $request->input('price'),
            'date' => $request->input('date'),
            'file_path' => $filePath,
        ]);

        return redirect()->route('monitoring.index')
                         ->with('success', 'Monitoring data added successfully.');
    }
}
