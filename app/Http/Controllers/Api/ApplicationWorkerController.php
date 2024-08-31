<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Workers\CreateWorkerRequest;
use App\Models\ApplicationWorker;

class ApplicationWorkerController extends Controller
{

    /**
     * Store a newly created worker in the system.
     */
    public function store(CreateWorkerRequest $request)
    {
        $user = $request->user();

        if ($user->role === "company_admin" || $user->role === "office_admin") {
            $worker = ApplicationWorker::create($request->validated());

            return response()->json([
                'success' => true,
                'data' => $worker
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => "You don't have permission to access this page."
        ], 403);
    }
}


