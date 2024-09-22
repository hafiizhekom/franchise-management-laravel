 
@extends('layouts.app_sign')
 
@section('title', 'Set Dana DP')

@push('breadcrumb')
    <li class="breadcrumb-item active"><a href="{{route('customer.index')}}">Customer</a></li>
@endpush

@push('breadcrumb')
    <li class="breadcrumb-item active"><a href="{{route('customer.show', $data_customer->id)}}">{{$data_customer->name}}</a></li>
@endpush

@push('breadcrumb')
     <li class="breadcrumb-item active"><a href="#">Set Dana DP</a></li>
@endpush


@section('content')
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Set Dana DP</h5>
                <div class="card-body">
                    <form action="{{ route('danadp.store')}}" method="POST">
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
                        <input type="hidden" name="dana_komitmen_id" value="{{$data_customer->danakomitmen->id}}">
                        <button type="submit" class="btn btn-primary float-end">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection