<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        Log::info("View All Customers Page");
        try{
            $customers = Customer::all()->map(function (Customer $customer) {
                $customer->gender = ucfirst($customer->gender);
                return $customer;
            });

            return view('customer.index')->with('data_customers', $customers);
        } catch (\Exception $e){
            Log::error("Error: View All Customers Page Failed", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'An error occurred while displaying data.')
                ->withInput();
        }
    }

    public function indexActive()
    {
        //
        Log::info("View Active Customers Page");
        try{
            $customers = Customer::has('danakomitmen')->get()->map(function (Customer $customer) {
                $customer->gender = ucfirst($customer->gender);
                $customer->birthday = Carbon::parse($customer->birthday)->format('d F Y');
                return $customer;
            });

            return view('customer.index')->with('data_customers', $customers);
        } catch (\Exception $e){
            Log::error("Error: View Active Customers Page Failed", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'An error occurred while displaying data.')
                ->withInput();
        }
    }

    public function indexCandidate()
    {
        //
        Log::info("View Candidate Customers Page");
        try{
            $customers = Customer::doesntHave('danakomitmen')->get()->map(function (Customer $customer) {
                $customer->gender = ucfirst($customer->gender);
                $customer->birthday = Carbon::parse($customer->birthday)->format('d F Y');
                return $customer;
            });

            return view('customer.index')->with('data_customers', $customers);
        } catch (\Exception $e){
            Log::error("Error: View Candidate Customers Page Failed", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'An error occurred while displaying data.')
                ->withInput();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        Log::info("View Create Customer Page");
        try{
            return view('customer.create');
        } catch (\Exception $e){
            Log::error("Error: View Create Customer Page Failed", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'An error occurred while displaying data.')
                ->withInput();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        //

        $requestId = uniqid('req_');

        Log::info("Start: Customer Store Process", [
            'request_id' => $requestId,
            'user_id' => auth()->id() ?? 'unauthenticated'
        ]);

        try{
        
            // Data sudah divalidasi oleh UpdateCustomerRequest
            $validatedData = $request->validated();

            Log::info("Validated Data", [
                'request_id' => $requestId,
                'data' => $validatedData
            ]);
            

            if (empty($validatedData)) {
                Log::warning("There are no valid data", [
                    'request_id' => $requestId,
                    'data' => $request->all()
                ]);

                return redirect()->back()
                    ->with('warning', 'There are no valid data')
                    ->withInput();
            }

            // Store customer
            $customer = Customer::create($validatedData);
            $new_data = $customer->fresh()->toArray();
            
            Log::info("Customer Stored", [
                'request_id' => $requestId,
                'customer_id' => $customer->id,
                'changes' => $new_data
            ]);


            return redirect()->route('customer.show', $customer->id)
                ->with('success', 'Customer data has been stored successfully');
        } catch (\Exception $e) {
            Log::error("Error: Customer Store Failed", [
                'request_id' => $requestId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'An error occurred while updating the data.')
                ->withInput();
        } finally {
            Log::info("End: Customer Store Process", [
                'request_id' => $requestId
            ]);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        Log::info("View Create Customer Detail Page");
        try{
            return view('customer.show')->with('data', $customer);
        } catch (\Exception $e){
            Log::error("Error: View Create Customer Detail Page Failed", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'An error occurred while displaying data.')
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        Log::info("View Create Customer Edit Page");
        try{
            return view('customer.edit')->with('data', $customer);
        } catch (\Exception $e){
            Log::error("Error: View Create Customer Edit Page Failed", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'An error occurred while displaying data.')
                ->withInput();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $requestId = uniqid('req_');

        Log::info("Start: Customer Update Process", [
            'request_id' => $requestId,
            'customer_id' => $customer->id,
            'user_id' => auth()->id() ?? 'unauthenticated'
        ]);

        try{
        
            // Data sudah divalidasi oleh UpdateCustomerRequest
            $validatedData = $request->validated();

            Log::info("Validated Data", [
                'request_id' => $requestId,
                'data' => $validatedData
            ]);
            

            if (empty($validatedData)) {
                Log::warning("There are no valid data changes", [
                    'request_id' => $requestId,
                    'data' => $request->all()
                ]);

                return redirect()->back()
                    ->with('warning', 'There are no valid data changes')
                    ->withInput();
            }

            // Update customer
            $oldData = $customer->toArray();
            $customer->update($validatedData);
            $new_data = $customer->fresh()->toArray();

            Log::info("Customer Updated", [
                'request_id' => $requestId,
                'customer_id' => $customer->id,
                'changes' => array_diff_assoc($new_data, $oldData)
            ]);


            return redirect()->route('customer.show', $customer->id)
                ->with('success', 'Customer data has been updated successfully');
        } catch (\Exception $e) {
            Log::error("Error: Customer Update Failed", [
                'request_id' => $requestId,
                'customer_id' => $customer->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui data.')
                ->withInput();
        } finally {
            Log::info("End: Customer Update Process", [
                'request_id' => $requestId,
                'customer_id' => $customer->id
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $requestId = uniqid('req_');

        Log::info("Start: Customer Delete Process", [
            'request_id' => $requestId,
            'customer_id' => $customer->id,
            'user_id' => auth()->id() ?? 'unauthenticated'
        ]);

        try {
            $customer_name = $customer->name;
            $customer->delete();

            Log::info("Customer Deleted", [
                'request_id' => $requestId,
                'customer_id' => $customer->id,
                'customer_name' => $customer_name
            ]);

            return redirect()->route('customer.index')
                ->with('success', "Customer '{$customer_name}' has been deleted successfully");
        } catch (\Exception $e) {
            Log::error("Error: Customer Deletion Failed", [
                'request_id' => $requestId,
                'customer_id' => $customer->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'An error occurred while deleting the customer.');
        } finally {
            Log::info("End: Customer Deletion Process", [
                'request_id' => $requestId,
                'customer_id' => $customer->id
            ]);
        }
    }
}
