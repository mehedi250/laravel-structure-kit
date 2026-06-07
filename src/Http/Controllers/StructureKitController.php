<?php

namespace StructureKit\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Routing\Controller;
use StructureKit\Services\StructureKitService;
use StructureKit\StructureKitServiceProvider;

class StructureKitController extends Controller
{
    protected StructureKitService $service;

    public function __construct(StructureKitService $service)
    {
        if (!App::environment('local')) {
            abort(403, 'Structure Kit is only accessible in the local environment. Ensure APP_ENV=local in your .env file.');
        }
        $this->service = $service;
    }

    public function index()
    {
        return view('structure-kit::index', ['version' => StructureKitServiceProvider::VERSION]);
    }

    public function generate(Request $request)
    {
        try {
            $data = $request->validate([
                'name'          => 'required|string|max:255',
                'components'    => 'required|array',
                'components.*'  => 'string|in:model,controller,service,service_interface,repository,repository_interface,migration',
                'paths'         => 'required|array',
                'paths.*'       => 'string|max:500|starts_with:app/',
            ]);

            $this->service->generateFromUI([
                'name'       => $data['name'],
                'components' => $data['components'],
                'paths'      => $data['paths'],
                'extra'      => ['force' => false],
            ]);

            return response()->json(['message' => 'Structure generated successfully!']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'errors'  => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
