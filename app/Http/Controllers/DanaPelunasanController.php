<?php

namespace App\Http\Controllers;

use App\Models\DanaPelunasan;
use App\Models\Customer;
use App\Http\Requests\StoreDanaPelunasanRequest;
use App\Http\Requests\UpdateDanaPelunasanRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

class DanaPelunasanController extends Controller
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
        return view('danapelunasan.create')->with('data_customer', $customer);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDanaPelunasanRequest $request)
    {
        //
        $request_id = uniqid('req_');

        Log::info("Start: Dana Pelunasan Store Process", [
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
            $dana_pelunasan = DanaPelunasan::create($validatedData);
            $newData = $dana_pelunasan->fresh()->toArray();
            
            Log::info("Customer Stored", [
                'request_id' => $request_id,
                'customer_id' => $dana_pelunasan->id,
                'changes' => $newData
            ]);


            return redirect()->route('customer.show', $dana_pelunasan->danadp->danakomitmen->customer)
                ->with('success', 'Dana Pelunasan data has been stored successfully');
        } catch (\Exception $e) {
            Log::error("Error: Dana Pelunasan Store Failed", [
                'request_id' => $request_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'An error occurred while updating the data.')
                ->withInput();
        } finally {
            Log::info("End: Dana Pelunasan Store Process", [
                'request_id' => $request_id
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(DanaPelunasan $danaPelunasan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DanaPelunasan $dana_pelunasan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDanaPelunasanRequest $request, DanaPelunasan $dana_pelunasan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DanaPelunasan $dana_pelunasan)
    {
        //
        $request_id = uniqid('req_');

        Log::info("Start: Dana Pelunasan Delete Process", [
            'request_id' => $request_id,
            'customer_id' => $dana_pelunasan->id,
            'user_id' => auth()->id() ?? 'unauthenticated'
        ]);

        try {
            $customer_id = $dana_pelunasan->danadp->danakomitmen->customer->id;
            $customer_name = $dana_pelunasan->danadp->danakomitmen->customer->name;
            $dana_pelunasan->delete();

            Log::info("Dana Pelunasan Deleted", [
                'request_id' => $request_id,
                'dana_pelunasan_id'=>$dana_pelunasan->id,
                'customer_id' => $customer_id,
                'customer_name' => $customer_name
            ]);

            return redirect()->route('customer.show', $customer_id)
                ->with('success', "Dana Pelunasan '{$customer_name}' has been deleted successfully");
        } catch (\Exception $e) {
            Log::error("Error: Dana Pelunasan Deletion Failed", [
                'request_id' => $request_id,
                'dana_pelunasan_id' => $dana_pelunasan->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'An error occurred while deleting the dana pelunasan.');
        } finally {
            Log::info("End: Dana Pelunasan Deletion Process", [
                'request_id' => $request_id,
                'dana_pelunasan_id' => $dana_pelunasan->id
            ]);
        }
    }
}
