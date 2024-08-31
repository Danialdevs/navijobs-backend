<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Applications\UpdateApplicationRequest;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ApplicationsController extends Controller
{
    public function getApplicationsByOffice(Request $request, $office_id){
        $user = $request->user();

        if ($user-> role !=='company_admin' && $user-> role !== 'office_manager') {
            return response()->json([
                'success' => false,
                'message' => 'You are not allowed to access this page.'
            ], 403);
        }

        $applications = Application::where('office_id', $office_id) -> get();

        return response()->json([
            'success' => true,
            'applications' => $applications
        ]);
    }

    public function getApplicationsByCompany(Request $request, $company_id){
        $user = $request->user();

        if ($user-> role !=='company_admin' || !$user-> isCompanyAdmin($company_id)) {
            return response()->json([
                'success' => false,
                'message' => 'You are not allowed to access this page.'
            ], 403);
        }

            $companyApplications = Application::where ('company_id', $company_id) -> get();
            return response()->json([
                'success' => true,
                'applications' => $companyApplications
            ]);
        }

        public function getApplication(Request $request, $application_id){
        $user = $request->user();
        $application = Application::findOrFail($application_id);

        if (!$application) {
            return response()->json([
                'success' => false,
                'message' => 'Application not found.'
            ], 404);
        }

        if ($user -> role == 'company_admin') {
            return response()->json([
                'success' => true,
                'application' => $application
            ]);
        }

        if ($user-> role == 'office_admin' || $user-> role == 'office_manager' && $user -> office_id == $application -> office_id ) {
            return response()->json([
                'success' => true,
                'application' => $application
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'You are not allowed to access this page.'
        ], 403);
        }

        public function updateApplicationStatus(UpdateApplicationRequest $request, $application_id){
        $user = $request->user();

            $application = Application::findOrFail($application_id);

            if (!$application) {
                return response()->json([
                    'success' => false,
                    'message' => 'Application not found.'
                ], 404);
            }

            if (
                ($user -> role === 'company_admin') ||
                ($user -> role === 'office_admin' && $user->office_id === $application->office_id) ||
                ($user -> role === 'office_manager' && $user->office_id === $application->office_id)
            ) {
                $application->status=$request->input('status');
                $application->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Application status updated successfully.',
                    'application' => $application
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => 'You are not allowed to access this page.'
            ], 403);
        }


}
