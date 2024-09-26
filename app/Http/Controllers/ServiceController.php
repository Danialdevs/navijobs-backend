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

    public function store(CreateServiceRequest $request){

        $data = $request->all();

        // Check if an image is uploaded

        if ($request->hasFile('image')) {
            // Get the uploaded file
            $image = $request->file('image');
            // Define the path to the public/images directory
            $destinationPath = public_path('images');
            // Define a unique name for the image
            $imageName = time() . '_' . $image->getClientOriginalName();
            // Move the image to the public/images directory
            $image->move($destinationPath, $imageName);
            // Save the path in the database
            $data['image'] = 'images/' . $imageName;
        }
        Service::create($data);

        return redirect()->back()->with('success', 'Worker added successfully');
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
