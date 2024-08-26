<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->user()->role != 'worker') {
            $services = Service::query();
            if ($request->user()->role === 'company_admin') {
                $services->where('company_id', $request->user()->company_id);
            }
            elseif ($request->user()->role === 'office_admin') {
                $services->where('company_id', $request->user()->company_id);
            }
            elseif ($request->user()->role === 'office_manager') {
                $services->where('company_id', $request->user()->company_id);
            }

            return response()->json([
                'success' => true,
                'data' => $services->get()
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'You can\'t access this page'
            ]);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'company_id' => 'required|exists:companies,id',
            'price' => 'required|numeric|min:0',
        ]);

        $service = Service::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'company_id' => $validated['company_id'],
            'price' => $validated['price'],
        ]);

        return response()->json([
            'success' => true,
            'data' => $service
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
                'data' => $service
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Service not found'
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return response()->json([
            'success' => false,
            'message' => 'Not applicable for API controller'
        ], 405);
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
                'data' => $service
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Service not found'
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        $service = Service::findOrFail($id);

        if ($request->user()->role === 'company_admin') {

            if ($service->company_id === $request->user()->company_id) {
                $service->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'You don\'t have permission to delete this service.'
                ], 403);
            }
        } elseif ($request->user()->role === 'office_admin') {
            /
            if ($service->company_id === $request->user()->company_id) {
                $service->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'You don\'t have permission to delete this service.'
                ], 403);
            }
        } elseif ($request->user()->role === 'office_manager') {

            if ($service->company_id === $request->user()->company_id) {
                $service->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'You don\'t have permission to delete this service.'
                ], 403);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'You can\'t access this page'
            ], 403);
        }


        return response()->json([
            'success' => true,
            'message' => 'The service was successfully deleted!'
        ]);
    }
}
