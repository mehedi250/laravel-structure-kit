<?php

namespace StructureKit\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use StructureKit\Services\StructureKitService;

class StructureKitController extends Controller
{
    protected StructureKitService $service;

    public function __construct(StructureKitService $service)
    {
        $this->service = $service;
        // Only allow access in local environment
        if (!App::environment('local')) {
            response(
                '<!DOCTYPE html>
                <html>
                <head>
                    <title>Access Denied</title>
                    <style>
                        body { 
                            font-family: Arial, sans-serif; 
                            background-color: #f8f9fa; 
                            color: #333; 
                            display: flex; 
                            justify-content: center; 
                            align-items: center; 
                            height: 100vh; 
                            margin: 0;
                        }
                        .message { 
                            background: #fff; 
                            padding: 30px; 
                            border-radius: 10px; 
                            box-shadow: 0 4px 6px rgba(0,0,0,0.1); 
                            text-align: center; 
                        }
                        h1 { color: #e74c3c; margin-bottom: 10px; }
                        p { font-size: 16px; }
                        code { background: #eee; padding: 2px 6px; border-radius: 4px; }
                    </style>
                </head>
                <body>
                    <div class="message">
                        <h1>Access Denied</h1>
                        <p>Structure Kit is only accessible in the <strong>local environment</strong>.</p>
                        <p>Please ensure your <code>.env</code> file has:</p>
                        <p><code>APP_ENV=local</code></p>
                    </div>
                </body>
                </html>',
                403
            )->send();

            exit;
        }
    }

    public function index()
    {
        $version = 'v0.1.5';
        return view('structure-kit::index', ['version' => $version]);
    }

    public function generate(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string',
                'components' => 'required|array',
                'paths' => 'required|array'
            ]);

            $this->service->generateFromUI([
                'name' => $data['name'],
                'components' => $data['components'],
                'paths' => $data['paths'],
                'extra' => $request->input('extra', []),
            ]);

            return response()->json(['message' => 'Structure generated successfully!']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
