@inject('carbon', 'Carbon\Carbon')
@extends('layouts.app_sign')
 
@section('title', 'Set Pembayaran Bulanan')

@push('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Pembayaran Bulanan</a></li>
@endpush

@push('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('customer.show', $data_customer->id)}}">{{$data_customer->name}}</a></li>
@endpush

@push('breadcrumb')
     <li class="breadcrumb-item active"><a href="#">Set Period Pembayaran Bulanan</a></li>
@endpush


@section('content')
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Set Pembayaran Bulanan</h5>
                <div class="card-body">
                    <form action="{{ route('bulanan.store')}}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="form-label">Amount</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text">Rp.</span>
                                <input
                                type="number"
                                class="form-control"
                                placeholder="10000000"
                                aria-label="Amount (to the nearest dollar)"
                                name="amount" />
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="form-label">Period</label>
                            <figure class="mt-2">
                                <blockquote class="blockquote">
                                <p class="mb-0">{{$data_form_period->format('F Y')}}</p>
                                </blockquote>
                                <figcaption class="blockquote-footer">
                                Check your payment <cite title="Source Title"><a href="{{route('bulanan.show', $data_customer->id)}}">here</a></cite>
                                </figcaption>
                            </figure>
                            <input type="hidden" name="period" value="{{$data_form_period->format('M/Y')}}">
                        </div>

                        <div class="mb-4">
                            <label for="exampleFormControlSelect1" class="form-label">Payment Date</label>
                            <input class="form-control" type="date" name="payment_date" id="html5-date-input" />
                        </div>
                        <input type="hidden" name="customer_id" value="{{$data_customer->id}}">
                        <button type="submit" class="btn btn-primary float-end">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection