<?php

namespace App\Http\Controllers;

use App\Http\Requests\Services\CreateServiceRequest;
use App\Http\Requests\Services\UpdateServiceRequest;
use App\Models\Company;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $companies = Company::all();
        $services = Service::all();
        return view('Pages.services.index', compact('services', 'companies'));
    }

    public function store(CreateServiceRequest $request) {
        $data = $request->all();

        // Check if an image is uploaded
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $destinationPath = public_path('images');
            $image->move($destinationPath, $imageName);
            $data['image'] = 'images/' . $imageName;
        }

        $data["company_id"] = 1;
        // Save the service data
        Service::create($data);

        return redirect()->back()->with('success', 'Service added successfully');
    }

    public function show($id)
    {
        $service = Service::findOrFail($id);

        return view('Pages.Services.show', compact('service'));
    }

    public function update(UpdateServiceRequest $request, $id)
    {
        $service = Service::findOrFail($id);

        $service->update($request->all());

        return redirect()->route('services-show', $service->id)->with('success', 'Service updated successfully.');
    }

    public function destroy($id) {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->route('services-index')->with('success', 'Service deleted successfully.');
    }
}
