<?php

namespace App\Http\Controllers;

use App\Models\DanaDP;
use App\Models\Customer;
use App\Http\Requests\StoreDanaDPRequest;
use App\Http\Requests\UpdateDanaDPRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

class DanaDPController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Customer $customer)
    {
        //
        return view('danadp.create')->with('data_customer', $customer);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDanaDPRequest $request)
    {
        //
        $request_id = uniqid('req_');

        Log::info("Start: Dana DP Store Process", [
            'request_id' => $request_id,
            'user_id' => auth()->id() ?? 'unauthenticated'
        ]);

        try{
        
            // Data sudah divalidasi oleh UpdateCustomerRequest
            $validatedData = $request->validated();

            Log::info("Validated Data", [
                'request_id' => $request_id,
                'data' => $validatedData
            ]);
            

            if (empty($validatedData)) {
                Log::warning("There are no valid data", [
                    'request_id' => $request_id,
                    'data' => $request->all()
                ]);

                return redirect()->back()
                    ->with('warning', 'There are no valid data')
                    ->withInput();
            }

            $validatedData['payment_date']=Carbon::now();

            // Store customer
            $dana_dp = DanaDP::create($validatedData);
            $newData = $dana_dp->fresh()->toArray();
            
            Log::info("Customer Stored", [
                'request_id' => $request_id,
                'customer_id' => $dana_dp->id,
                'changes' => $newData
            ]);


            return redirect()->route('customer.show', $dana_dp->danakomitmen->customer)
                ->with('success', 'Dana DP data has been stored successfully');
        } catch (\Exception $e) {
            Log::error("Error: Dana DP Store Failed", [
                'request_id' => $request_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'An error occurred while updating the data.')
                ->withInput();
        } finally {
            Log::info("End: Dana DP Store Process", [
                'request_id' => $request_id
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(DanaDP $dana_dp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DanaDP $dana_dp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDanaDPRequest $request, DanaDP $dana_dp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DanaDP $dana_dp)
    {
        //
        $request_id = uniqid('req_');

        Log::info("Start: Dana DP Delete Process", [
            'request_id' => $request_id,
            'customer_id' => $dana_dp->id,
            'user_id' => auth()->id() ?? 'unauthenticated'
        ]);

        try {
            $customer_id = $dana_dp->danakomitmen->customer->id;
            $customer_name = $dana_dp->danakomitmen->customer->name;
            $dana_dp->delete();

            Log::info("Dana DP Deleted", [
                'request_id' => $request_id,
                'dana_dp_id'=>$dana_dp->id,
                'customer_id' => $customer_id,
                'customer_name' => $customer_name
            ]);

            return redirect()->route('customer.show', $customer_id)
                ->with('success', "Dana DP '{$customer_name}' has been deleted successfully");
        } catch (\Exception $e) {
            Log::error("Error: Dana DP Deletion Failed", [
                'request_id' => $request_id,
                'dana_dp_id' => $dana_dp->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'An error occurred while deleting the dana komitmen.');
        } finally {
            Log::info("End: Dana DP Deletion Process", [
                'request_id' => $request_id,
                'dana_dp_id' => $dana_dp->id
            ]);
        }
    }
}
