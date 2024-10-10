<?php

namespace App\Http\Controllers;

use App\Models\PembayaranPerpanjangan;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StorePembayaranPerpanjanganRequest;

class PembayaranPerpanjanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        Log::info("View All Pembayaran Perpanjangan Page");
        try{
            $start_year = Carbon::now()->subYears(10)->format('Y');
            $end_year = Carbon::now()->format('Y');

            $pembayaran_perpanjangan = PembayaranPerpanjangan::whereBetween('year', [$start_year, $end_year])->get();

            $years = collect(range($start_year, $end_year))->map(function ($year) {
                return Carbon::create($year,1,1)->format('Y');
            });


            $years_data = $pembayaran_perpanjangan
                ->groupBy('customer_id')
                ->map(function ($customer_data, $customer_id) use ($years){

                    $year_status = collect($years)->mapWithKeys(function ($year_key) use ($customer_data) {
                        $has_payment_in_year = $customer_data->contains(function ($item) use ($year_key) {
                            return $item->year == $year_key;
                        });
                        
                        return [$year_key => $has_payment_in_year ? True : False];
                    });

                    $all_data = $customer_data->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'customer_id' => $item->customer_id,
                            'period' => $item->period,
                            'payment_date' => $item->payment_date,
                            'amount' => $item->amount,
                            'created_at' => $item->created_at,
                            'updated_at' => $item->updated_at,
                        ];
                    });

                    return array_merge(
                        ['customer' => Customer::where('id', $customer_id)->firstOrFail()],
                        ['payments_year_data' => $year_status->toArray()],
                        [
                            'payments_years_count' => count(array_filter($year_status->toArray())),
                            'all_data' => $all_data
                        ]
                    );

                })->values();

            $result = array_merge(
                ['years_header' => $years],
                ['years_data' => $years_data]
            );
                    
            return view('pembayaranperpanjangan.index')->with('datas', $result);
        } catch (\Exception $e){
            Log::error("Error: View All Pembayaran Perpanjangan Page Failed", [
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
    public function createCustomer()
    {
        Log::info("View Create Pembayaran Perpanjangan (Customer) Page");
        try{
            $customers = Customer::has('danakomitmen')->get();
            return view('pembayaranperpanjangan.create_customer')->with('data_customers', $customers);
        } catch (\Exception $e){
            Log::error("Error: View Create Pembayaran Perpanjangan (Customer) Page Failed", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'An error occurred while displaying data.')
                ->withInput();
        }
    }

    public function createPeriod(Customer $customer)
    {
        Log::info("View Create Pembayaran Perpanjangan (Period) Page");
        try{
            $last_year_payment = Carbon::createFromDate($customer->pembayaranperpanjangan()->max('year'),1,1);
            $next_year_payment = $last_year_payment->addYear(); // Adds 1 month to the date
            
            return view('pembayaranperpanjangan.create_period')->with('data_customer', $customer)->with('data_form_year', $next_year_payment);
        } catch (\Exception $e){
            Log::error("Error: View Create Pembayaran Perpanjangan (Period) Page Failed", [
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
    public function store(StorePembayaranPerpanjanganRequest $request)
    {
        //
        $request_id = uniqid('req_');

        Log::info("Start: Pembayaran Perpanjangan Store Process", [
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

            // Store customer
            $pembayaran_perpanjangan = PembayaranPerpanjangan::create($validatedData);
            $new_data = $pembayaran_perpanjangan->fresh()->toArray();
            
            Log::info("Pembayaran Perpanjangan Stored", [
                'request_id' => $request_id,
                'pembayaran_perpanjangan_id' => $pembayaran_perpanjangan->id,
                'changes' => $new_data
            ]);

            return redirect()->route('perpanjangan.show', $pembayaran_perpanjangan->customer->id)
                ->with('success', 'Pembayaran Perpanjangan data has been stored successfully');
        } catch (\Exception $e) {
            Log::error("Error: Pembayaran Perpanjangan Store Failed", [
                'request_id' => $request_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'An error occurred while updating the data.')
                ->withInput();
        } finally {
            Log::info("End: Pembayaran Perpanjangan Store Process", [
                'request_id' => $request_id
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
        Log::info("View Pembayaran Perpanjangan Detail Page");
        try{
            $last_period_payment= $customer->pembayaranperpanjangan()->max('year');
            return view('pembayaranperpanjangan.show')->with('data_customer', $customer)->with('data_last_year', $last_period_payment); 
        } catch (\Exception $e){
            Log::error("Error: View Pembayaran Perpanjangan Detail Page Failed", [
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PembayaranPerpanjangan $pembayaran_perpanjangan)
    {
         //
         $request_id = uniqid('req_');

         Log::info("Start: Pembayaran Perpanjangan Delete Process", [
             'request_id' => $request_id,
             'customer_id' => $pembayaran_perpanjangan->id,
             'user_id' => auth()->id() ?? 'unauthenticated'
         ]);
 
         try {
             $customer_id = $pembayaran_perpanjangan->customer->id;
             $customer_name = $pembayaran_perpanjangan->customer->name;
             $pembayaran_perpanjangan->delete();
 
             Log::info("Pembayaran Perpanjangan Deleted", [
                 'request_id' => $request_id,
                 'pembayaran_perpanjangan_id'=>$pembayaran_perpanjangan->id,
                 'customer_id' => $customer_id,
                 'customer_name' => $customer_name,
                 'period' => $pembayaran_perpanjangan->period
             ]);
 
             return redirect()->route('perpanjangan.show', $customer_id)
                 ->with('success', "Pembayaran Perpanjangan '{$customer_name}' & ".Carbon::parse($pembayaran_perpanjangan->period)->format('F Y')." has been deleted successfully");
         } catch (\Exception $e) {
             Log::error("Error: Pembayaran Perpanjangan Deletion Failed", [
                 'request_id' => $request_id,
                 'pembayaran_perpanjangan_id' => $pembayaran_perpanjangan->id,
                 'error' => $e->getMessage(),
                 'trace' => $e->getTraceAsString()
             ]);
 
             return redirect()->back()
                 ->with('error', 'An error occurred while deleting the pembayaran perpanjangan.');
         } finally {
             Log::info("End: Pembayaran Perpanjangan Deletion Process", [
                 'request_id' => $request_id,
                 'dana_pelunasan_id' => $pembayaran_perpanjangan->id
             ]);
         }
    }
}
