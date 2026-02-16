<?php

namespace StructureKit\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use StructureKit\Services\StructureKitService;

class StructureKitController extends Controller
{
    protected StructureKitService $service;

    public function __construct(StructureKitService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('structure-kit::index');
    }

    public function generate(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'components' => 'required|array',
            'paths' => 'required|array',
        ]);

        $this->service->generateFromUI([
            'name' => $data['name'],
            'components' => $data['components'],
            'paths' => $data['paths'],
            'extra' => $request->input('extra', []),
        ]);

        return back()->with('success', 'Structure generated successfully!');
    }
}
