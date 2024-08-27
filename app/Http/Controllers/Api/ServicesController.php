<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Services\CreateServiceRequest;
use App\Http\Requests\Api\Services\UpdateServiceRequest;
use Illuminate\Http\Request;
use App\Models\Service;

class ServicesController extends Controller
{

    public function index(Request $request)
    {
        $services = Service::where('company_id', $request->user()->company_id)->get();
        return response()->json([
            'success' => true,
            'data' => $services,
        ]);
    }


    public function store(CreateServiceRequest $request)
    {
        $user = $request->user();

        if ($user->role === "company_admin") {
            $service = Service::create(array_merge($request->validated(), ['company_id' => $user->company_id]));
            return response()->json([
                "success" => true,
                "data" => $service,
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => "You don't have permission to access this page."
        ], 403);
    }


    public function show(Request $request, int $id)
    {
        $user = $request->user();

        $service = Service::findOrFail($id);

        if ($service->company_id === $user->company_id) {
            return response()->json([
                'success' => true,
                'data' => $service
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => "You don't have permission to access this page."
        ], 403);
    }


    public function update(UpdateServiceRequest $request, int $id)
    {
        $user = $request->user();

        $service = Service::findOrFail($id);


        if ($service->company_id !== $user->company_id) {
            return response()->json([
                'success' => false,
                'message' => "You don't have permission to access this page."
            ], 403);
        }


        $validated = $request->validated();

        $service->update($validated);

        return response()->json([
            'success' => true,
            'data' => $service,
        ], 200);
    }


    public function destroy(int $id)
    {
        $service = Service::findOrFail($id);


        if ($service->company_id !== request()->user()->company_id) {
            return response()->json([
                'success' => false,
                'message' => "You don't have permission to access this page."
            ], 403); /
        }

        $service->delete();

        return response()->json([
            'success' => true,
            'message' => 'Service deleted successfully.'
        ], 200);
    }
}
