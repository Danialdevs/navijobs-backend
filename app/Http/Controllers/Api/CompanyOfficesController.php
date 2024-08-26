<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Offices\CreateOfficeRequest;
use App\Models\CompanyOffice;
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
            $offices = $offices->where('company_id', $user->company_id);
        } elseif ($user->role === "office_admin" || $user->role === "office_manager" || $user->role === "worker") {
            $offices->where('id', $user->office_id);
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

    public function store(CreateOfficeRequest $request)
    {
        $office = CompanyOffice::create($request->all());
        return response()->json([
            "success" => true,
            "data" => $office
        ]);
    }

    public function show(Request $request, string $id)
    {
        $user = $request->user();
        $office = CompanyOffice::query()->findOrFail($id);

        if ($user->role === "company_admin" && $office->company_id === $user->company_id) {
            return response()->json([
                'success' => true,
                'data' => $office
            ]);
        } elseif (in_array($user->role, [
            'office_admin', 'office_manager', 'worker'
        ]) && $office->id === $user->office_id) {
            return response()->json([
                'success' => true,
                'data' => $office
            ]);
        } return response() -> json([
            'success' => false,
            'message' => "You don't have permission to access this page."
    ]);
    }

    public function update(Request $request, string $id)
    {
        $user = $request->user();
        $office = CompanyOffice::findOrFail($id);

        if ($user->role === "company_admin" && $user->company_id === $user->company_id) {
            $office->update($request->all());
            return response()->json([
                "success" => true,
                'data' => $office
            ]);
        } elseif ($user->role === "office_admin" && $office->id === $user->office_id) {
            $office->update($request->all());
            return response()->json([
                "success" => true,
                'data' => $office
            ]);
        } return response() -> json([
            'success' => false,
            'message' => "You don't have permission to access this page."
    ]);
    }

}
