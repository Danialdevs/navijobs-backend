<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\ApplicationWorker;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RequestsController extends Controller
{
    public function index()
    {
        // Check if the user is a worker
        if (auth()->user()->role === 'worker') {
            // Fetch only requests assigned to the logged-in worker
            $applications = Application::whereHas('assignedWorker', function($query) {
                $query->where('user_id', auth()->user()->id); // Only assigned to this worker
            })->with(['client', 'applicationPrices', 'service'])->get();
        } else {
            // Fetch all requests for admins, office admins, office managers
            $applications = Application::with(['client', 'applicationPrices', 'assignedWorker.user', 'service'])->get();
        }

        // Fetch workers for assignment if needed
        $workers = User::where('role', 'worker')->get();

        return view('Pages.requests.index', compact('applications', 'workers'));
    }



    public function changeStatus(Request $request, $id)
    {
        // Validate the status value to ensure it's one of the valid options
        $request->validate([
            'status' => 'required|in:awaiting,full-done,canceled',
        ]);

        // Find the application
        $application = Application::findOrFail($id);

        // Update the status using the value from the form
        $application->status = $request->input('status');
        $application->save();

        return redirect()->back()->with('success', 'Status changed successfully.');
    }


    public function assignWorker(Request $request, $id)
    {
        // Validate request to ensure worker_id is provided
        $request->validate([
            'worker_id' => 'required|exists:users,id',
        ]);

        // Assign the worker to the application
        ApplicationWorker::create([
            'user_id' => $request->worker_id,
            'application_id' => $id,
        ]);

        return redirect()->back()->with('success', 'Worker assigned successfully');
    }

}
