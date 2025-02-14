<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Requests\Employee\StoreEmployeeRequest; // 
use App\Http\Requests\Employee\UpdateEmployeeRequest; // 
use App\Helpers\Helpers;
use App\Traits\UploadImageTrait;
class EmployeeController extends Controller
{

    use UploadImageTrait;
    /**
     * Display a listing of the employees.
     */
    public function index()
    {
        $employees = Employee::with('user')->get();
        return Helpers::jsonResponse(true, $employees);
    }

    /**
     * Store a newly created employee in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        $validated = $request->validated(); // StoreEmployeeRequest


// Handle image upload using the UploadImageTrait
if ($request->hasFile('image')) {
    $imagePath = $this->uploadImage($request->file('image'), 'employees'); // Specify the folder for storing images
    $validated['image'] = $imagePath;
}

        // Handle image upload and other logic

        $employee = Employee::create($validated);

        return Helpers::jsonResponse(true, $employee, 'Employee created successfully', 201);
    }

    /**
     * Display the specified employee.
     */
    public function show($id)
    {
        $employee = Employee::with('user')->find($id);

        if (!$employee) {
            return Helpers::jsonResponse(false, null, 'Employee not found', 404);
        }

        return Helpers::jsonResponse(true, $employee);
    }

    /**
     * Update the specified employee in storage.
     */
    public function update(UpdateEmployeeRequest $request, $id)
    {
        $employee->update($request->validated()); // updateEmployeeRequest

        if (!$employee) {
            return Helpers::jsonResponse(false, null, 'Employee not found', 404);
        }

        // Handle image upload and other logic
// Handle image upload using the UploadImageTrait
if ($request->hasFile('image')) {
    // Delete the old image
    if ($employee->image) {
        $this->deleteImage($employee->image, 'employees'); // Specify the folder for deleting images
    }

    $imagePath = $this->uploadImage($request->file('image'), 'employees'); // Specify the folder for storing images
    $validated['image'] = $imagePath;
}
        $employee->update($request->all());

        return Helpers::jsonResponse(true, $employee, 'Employee updated successfully');
    }

    /**
     * Remove the specified employee from storage.
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return Helpers::jsonResponse(false, null, 'Employee not found', 404);
        }
 // Delete the image
 if ($employee->image) {
    $this->deleteImage($employee->image, 'employees'); // Specify the folder for deleting images
}

$employee->delete();
        

        return Helpers::jsonResponse(true, null, 'Employee deleted successfully');
    }
}
