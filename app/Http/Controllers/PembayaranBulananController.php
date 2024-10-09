<?php

namespace App\Http\Controllers;

use App\Models\PembayaranBulanan;
use App\Models\Customer;
use App\Http\Requests\StorePembayaranBulananRequest;
use App\Http\Requests\UpdatePembayaranBulananRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use PDO;

class PembayaranBulananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($year)
    {
        //
        Log::info("View All Pembayaran Bulanan Page");
        try{
            
            $start_date = Carbon::create($year, 1, 1)->format('Y-m-d');
            $end_date = Carbon::create($year, 12, 31)->format('Y-m-d');

            $pembayaran_bulanan = PembayaranBulanan::whereBetween('period', [$start_date, $end_date])
                ->get();

            $periods = collect(range(1, 12))->mapWithKeys(function ($month) use ($year) {
                return [
                    Carbon::create($year, $month, 1)->format('Y-m-d') => Carbon::create($year, $month, 1)->format('F Y')
                ];
            })->toArray();

            $periods_data = $pembayaran_bulanan
                ->groupBy('customer_id')
                ->map(function ($customer_data, $customer_id) use ($periods, $year) {
                    $period_status = collect($periods)->mapWithKeys(function ($period_name, $period_key) use ($customer_data) {
                        $has_payment_in_period = $customer_data->contains(function ($item) use ($period_key) {
                            return Carbon::parse($item->period)->format('d/m/Y') == Carbon::parse($period_key)->format('d/m/Y');
                        });
                        
                        return [$period_name => $has_payment_in_period ? True : False];
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

                    $payments_periods_count = $customer_data->filter(function ($item) use ($year) {
                        return strpos($item->period, $year) !== false;
                    })->count();

                    return array_merge(
                        ['customer' => Customer::where('id', $customer_id)->firstOrFail()],
                        ['payments_period_data' => $period_status->toArray()],
                        [
                            'payments_periods_count' => $payments_periods_count,
                            'all_data' => $all_data
                        ]
                    );
                })->values();

            $result = array_merge(
                ['periods_header' => $periods],
                ['periods_data' => $periods_data]
            );

            return view('pembayaranbulanan.index')->with('datas', $result)->with('year', $year);
        } catch (\Exception $e){
            Log::error("Error: View All Pembayaran Bulanan Page Failed", [
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
        Log::info("View Create Pembayaran Bulanan (Customer) Page");
        try{
            $customers = Customer::has('danakomitmen')->get();
            return view('pembayaranbulanan.create_customer')->with('data_customers', $customers);
        } catch (\Exception $e){
            Log::error("Error: View Create Pembayaran Bulanan (Customer) Page Failed", [
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
        Log::info("View Create Pembayaran Bulanan (Period) Page");
        try{
            $last_period_payment = Carbon::parse($customer->pembayaranbulanan->max('period'));
            $next_period_payment = $last_period_payment->addMonth(); // Adds 1 month to the date
            
            return view('pembayaranbulanan.create_period')->with('data_customer', $customer)->with('data_form_period', $next_period_payment);
        } catch (\Exception $e){
            Log::error("Error: View Create Pembayaran Bulanan (Period) Page Failed", [
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
    public function store(StorePembayaranBulananRequest $request)
    {
        //
        $request_id = uniqid('req_');

        Log::info("Start: Pembayaran Bulanan Store Process", [
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
            $pembayaran_bulanan = PembayaranBulanan::create($validatedData);
            $new_data = $pembayaran_bulanan->fresh()->toArray();
            
            Log::info("Pembayaran Bulanan Stored", [
                'request_id' => $request_id,
                'pembayaran_bulanan_id' => $pembayaran_bulanan->id,
                'changes' => $new_data
            ]);

            return redirect()->route('bulanan.show', $pembayaran_bulanan->customer->id)
                ->with('success', 'Pembayaran Bulanan data has been stored successfully');
        } catch (\Exception $e) {
            Log::error("Error: Pembayaran Bulanan Store Failed", [
                'request_id' => $request_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'An error occurred while updating the data.')
                ->withInput();
        } finally {
            Log::info("End: Pembayaran Bulanan Store Process", [
                'request_id' => $request_id
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        Log::info("View Pembayaran Bulanan Detail Page");
        try{
            $last_period_payment= $customer->pembayaranbulanan()->max('period');
            return view('pembayaranbulanan.show')->with('data_customer', $customer)->with('data_last_period', $last_period_payment); 
        } catch (\Exception $e){
            Log::error("Error: View Pembayaran Bulanan Detail Page Failed", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'An error occurred while displaying data.')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PembayaranBulanan $pembayaran_bulanan)
    {
        //
        $request_id = uniqid('req_');

        Log::info("Start: Pembayaran Bulanan Delete Process", [
            'request_id' => $request_id,
            'customer_id' => $pembayaran_bulanan->id,
            'user_id' => auth()->id() ?? 'unauthenticated'
        ]);

        try {
            $customer_id = $pembayaran_bulanan->customer->id;
            $customer_name = $pembayaran_bulanan->customer->name;
            $pembayaran_bulanan->delete();

            Log::info("Pembayaran Bulanan Deleted", [
                'request_id' => $request_id,
                'pembayaran_bulanan_id'=>$pembayaran_bulanan->id,
                'customer_id' => $customer_id,
                'customer_name' => $customer_name,
                'period' => $pembayaran_bulanan->period
            ]);

            return redirect()->route('bulanan.show', $customer_id)
                ->with('success', "Pembayaran Bulanan '{$customer_name}' & ".Carbon::parse($pembayaran_bulanan->period)->format('F Y')." has been deleted successfully");
        } catch (\Exception $e) {
            Log::error("Error: Pembayaran Bulanan Deletion Failed", [
                'request_id' => $request_id,
                'pembayaran_bulanan_id' => $pembayaran_bulanan->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'An error occurred while deleting the pembayaran bulanan.');
        } finally {
            Log::info("End: Pembayaran Bulanan Deletion Process", [
                'request_id' => $request_id,
                'dana_pelunasan_id' => $pembayaran_bulanan->id
            ]);
        }
    }
}
