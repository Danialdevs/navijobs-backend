<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Services\CreateServiceRequest;
use Illuminate\Http\Request;
use App\Models\Service;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $services = Service::where('company_id', $request->user()->company_id)->get();
        return response()->json([
                'success' => true,
                'data' => $services,
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateServiceRequest $request)
    {
        $user = $request->user();
        if($user->role === "company_admin"){
            $service = Service::create($request->all());
        }
        return response()->json([
            'success' => true,
            'data' => $service,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $service = Service::find($id);

        if ($service) {
            return response()->json([
                'success' => true,
                'data' => $service,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Service not found',
            ], 404);
        }
    }

    public function show(Request $request, int $id)
    {
        $user = $request->user();
        $service = Service::findOrFail($id);

        if ($service->company_id === $user->company_id) {
            return response()->json([
                'success' => true,
                'data' => $service
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => "You don't have permission to access this page."
        ]);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'company_id' => 'sometimes|required|exists:companies,id',
            'price' => 'sometimes|required|numeric|min:0',
        ]);

        $service = Service::find($id);

        if ($service) {
            $service->update(array_filter($validated));

            return response()->json([
                'success' => true,
                'data' => $service,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Service not found',
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        $service = Service::findOrFail($id);

        if (in_array($request->user()->role, ['company_admin', 'office_admin', 'office_manager']) &&
            $service->company_id === $request->user()->company_id) {
            $service->delete();

            return response()->json([
                'success' => true,
                'message' => 'The service was successfully deleted!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'You don\'t have permission to delete this service.',
            ], 403);
        }
    }
}
