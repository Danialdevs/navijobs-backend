<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Offices\CreateOfficeRequest;
use App\Http\Requests\Api\Offices\UpdateOfficeRequest;
use App\Models\CompanyOffice;
use App\Models\Service;
use Illuminate\Http\Request;

class CompanyOfficesController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $offices = CompanyOffice::query();

        if ($user->role === "company_admin") {
            $offices->where('company_id', $user->company_id);
        } else {
            return response()->json([
                'success' => false,
                'message' => "You don't have permission to access this page."
            ]);
        }

        return response()->json([
            'success' => true,
            'offices' => $offices->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateOfficeRequest $request)
    {
        $user = $request->user();

        if ($user->role === "company_admin") {
            $office = CompanyOffice::create($request->all());
        } else {
            return response()->json([
                'success' => false,
                'message' => "You don't have permission to access this page."
            ]);
        }

        return response()->json([
            "success" => true,
            "data" => $office
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, int $id)
    {
        $user = $request->user();
        $office = CompanyOffice::findOrFail($id);

        if ($user->role === "company_admin" && $office->company_id === $user->company_id) {
            return response()->json([
                'success' => true,
                'data' => $office
            ]);
        } elseif (in_array($user->role, ['office_admin', 'office_manager', 'worker']) && $office->id === $user->office_id) {
            return response()->json([
                'success' => true,
                'data' => $office
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
    public function update(UpdateOfficeRequest $request, int $id)
    {
        $user = $request->user();
        $office = CompanyOffice::findOrFail($id);

        if ($user->role === "company_admin" && $office->company_id === $user->company_id) {
            $office->update($request->all());
            return response()->json([
                "success" => true,
                'data' => $office
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => "You don't have permission to access this page."
        ]);
    }

    public function destroy(Request $request, int $id) {
        $user = $request->user();
        $office = CompanyOffice::findOrFail($id);

        if ($user->role === 'company_admin' &&
            $office->company_id === $request->user()->company_id) {
            $office->delete();

            return response()->json([
                'success' => true,
                'message' => 'The office was successfully deleted!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'You don\'t have permission to delete this office.',
            ], 403);
        }
    }


}
