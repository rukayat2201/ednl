<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Customer::query();
    
            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('firstname', 'like', '%' . $search . '%')
                      ->orWhere('lastname', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%')
                      ->orWhere('telephone', 'like', '%' . $search . '%');
                });
            }
            if ($request->has('firstname') && $request->firstname != '') {
                $query->where('firstname', $request->firstname);
            }
            if ($request->has('lastname') && $request->lastname != '') {
                $query->where('lastname', $request->lastname);
            }
            if ($request->has('email') && $request->email != '') {
                $query->where('email', $request->email);
            }
            if ($request->has('telephone') && $request->telephone != '') {
                $query->where('telephone', $request->telephone);
            }
    
            $customers = $query->paginate(10); 
    
            return response()->json([
                'status' => true,
                'message' => 'Customers fetched successfully',
                'data' => $customers,
            ], 200);

        } catch (\Exception $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
                'data' => null,
            ], 500);
        }
    }
    
    public function store(Request $request) 
    {
        try {
            DB::beginTransaction();
            $validated = $request->validate([
                'firstname' => 'required|string',
                'lastname' => 'required|string',
                'bvn' => 'required|string',
                'telephone' => 'required|string|min:11,max:11',
                'dob' => 'required|string',
                'residential_address' => 'required|string',
                'state' => 'required|string',
                'bank_code' => 'required|string',
                'accountnumber' => 'required|string|min:10,max:10',
                'company_id' => 'required|string',
                'email' => 'required|email|unique:customers',
                'city' => 'required|string',
                'country' =>  'required|string',
                'id_card' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
                'voters_card' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
                'drivers_license' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            ]);
    
            $files = ['id_card', 'voters_card', 'drivers_license'];
            foreach ($files as $file) {
                if ($request->hasFile($file)) {
                    $validated[$file] = $request->file($file)->store('uploads', 'public');
                }
            }

            $customer = Customer::create($validated);
               
            DB::commit();
    
            return response()->json([
                'status' => true,
                'message' => 'Customer created successfully',
                'data' => $customer,
            ], 200);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
                'data' => null,
            ], 500);
        }
    }
    
    public function update(Request $request, $customer_id)
    {
        try {
            DB::beginTransaction();
            
            $validated = $request->validate([
                'firstname' => 'required|string',
                'lastname' => 'required|string',
                'bvn' => 'required|string',
                'telephone' => 'required|string|min:11,max:11',
                'dob' => 'required|string',
                'residential_address' => 'required|string',
                'state' => 'required|string',
                'bank_code' => 'required|string',
                'accountnumber' => 'required|string|min:10,max:10',
                'company_id' => 'required|string',
                'email' => 'required|email|unique:customers,email,' . $customer_id,
                'city' => 'required|string',
                'country' => 'required|string',
                'id_card' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
                'voters_card' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
                'drivers_license' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
                'status' => 'required|string'
            ]);
            
            $customer = Customer::findOrFail($customer_id);

            $files = ['id_card', 'voters_card', 'drivers_license'];
            foreach ($files as $file) {
                if ($request->hasFile($file)) {
                    $validated[$file] = $request->file($file)->store('uploads', 'public');
                }
            }

            $customer->update($validated);
            
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Customer updated successfully',
                'data' => $customer,
            ], 200);

        } catch (\Exception $th) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
                'data' => null,
            ], 500);
        }
    }

}
