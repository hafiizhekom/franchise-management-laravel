<?php

namespace App\Http\Controllers;

use App\Models\DanaKomitmen;
use App\Models\Customer;
use App\Http\Requests\StoreDanaKomitmenRequest;
use App\Http\Requests\UpdateDanaKomitmenRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

class DanaKomitmenController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create(Customer $customer)
    {
        //
        Log::info("View Create Dana Komitmen Page");
        try{
            return view('danakomitmen.create')->with('data_customer', $customer);
        } catch (\Exception $e){
            Log::error("Error: View Create Dana Komitmen Page Failed", [
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
    public function store(StoreDanaKomitmenRequest $request)
    {
        //
        $request_id = uniqid('req_');

        Log::info("Start: Dana Komitmen Store Process", [
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
            $dana_komitmen = DanaKomitmen::create($validatedData);
            $new_data = $dana_komitmen->fresh()->toArray();
            
            Log::info("Dana Komitmen Stored", [
                'request_id' => $request_id,
                'dana_komitmen_id' => $dana_komitmen->id,
                'changes' => $new_data
            ]);


            return redirect()->route('customer.show', $dana_komitmen->customer_id)
                ->with('success', 'Dana Komitmen data has been stored successfully');
        } catch (\Exception $e) {
            Log::error("Error: Dana Komitmen Store Failed", [
                'request_id' => $request_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'An error occurred while updating the data.')
                ->withInput();
        } finally {
            Log::info("End: Dana Komitmen Store Process", [
                'request_id' => $request_id
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DanaKomitmen $dana_komitmen)
    {
        //
        $request_id = uniqid('req_');

        Log::info("Start: Dana Komitmen Delete Process", [
            'request_id' => $request_id,
            'dana_komitmen_id' => $dana_komitmen->id,
            'user_id' => auth()->id() ?? 'unauthenticated'
        ]);

        try {
            $customer_id = $dana_komitmen->customer->id;
            $customer_name = $dana_komitmen->customer->name;
            $dana_komitmen->delete();

            Log::info("Dana Komitmen Deleted", [
                'request_id' => $request_id,
                'dana_komitmen_id'=>$dana_komitmen->id,
                'customer_id' => $customer_id,
                'customer_name' => $customer_name
            ]);

            return redirect()->route('customer.show', $customer_id)
                ->with('success', "Dana Komitmen '{$customer_name}' has been deleted successfully");
        } catch (\Exception $e) {
            Log::error("Error: Dana Komitmen Deletion Failed", [
                'request_id' => $request_id,
                'dana_komitmen_id' => $dana_komitmen->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'An error occurred while deleting the dana komitmen.');
        } finally {
            Log::info("End: Dana Komitmen Deletion Process", [
                'request_id' => $request_id,
                'dana_komitmen_id' => $dana_komitmen->id
            ]);
        }
    }
}
