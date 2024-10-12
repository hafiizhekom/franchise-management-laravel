@inject('carbon', 'Carbon\Carbon')
@extends('layouts_sneat.app_sign')
 
@section('title', 'Set Pembayaran Bulanan')

@push('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('bulanan.index', $carbon->now()->format('Y'))}}">Pembayaran Bulanan</a></li>
@endpush

@push('breadcrumb')
     <li class="breadcrumb-item active"><a href="#">Set Customer Pembayaran Bulanan</a></li>
@endpush


@section('content')
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Set Customer Pembayaran Bulanan</h5>
                <div class="card-body">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Choose Customer
                        </button>
                        <ul class="dropdown-menu">
                            @foreach($data_customers as $customer)
                                <li><a class="dropdown-item" href="{{route('bulanan.create.period', $customer->id)}}">{{$customer->name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection