<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Prices\CreateOrUpdatePriceRequest;
use App\Models\ApplicationPrice;


class ApplicationPriceController extends Controller
{

    /**
     * Store or update the price for a specific application.
     */
    public function storeOrUpdate(CreateOrUpdatePriceRequest $request, $application_id)
    {
        $user = $request->user();
        $priceData = $request->validated();


        if ($user->role === "company_admin" || $user->role === "office_admin") {
            $price = ApplicationPrice::updateOrCreate(
                ['application_id' => $application_id],
                $priceData
            );

            return response()->json([
                'success' => true,
                'data' => $price
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => "You don't have permission to access this page."
        ], 403);
    }
}



