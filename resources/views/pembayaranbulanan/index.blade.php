@inject('carbon', 'Carbon\Carbon')
@extends('layouts.app_sign')
 
@section('title', 'Pembayaran Bulanan')

@push('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Pembayaran Bulanan</a></li>
@endpush

@push('breadcrumb')
    <li class="breadcrumb-item active"><a href="#">{{$year}}</a></li>
@endpush


 
@section('content')
    <!-- Basic Bootstrap Table -->

    <div class="btn-group mb-5">
        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            Choose Year
        </button>
        <ul class="dropdown-menu">
            @for ($year = $carbon->now()->format('Y'); $year >= $carbon->now()->subYears(10)->format('Y'); $year--)
                <li><a class="dropdown-item" href="{{route('bulanan.index', $year)}}">{{$year}}</a></li>
            @endfor
        </ul>
    </div>

    <div class="card">
    <h5 class="card-header">Pembayaran Bulanan @if (Route::is('bulanan.index')) <a href="{{route('bulanan.create.customer')}}" class="btn btn-primary float-end">Add Pembayaran Bulanan</a> @endif </h5>
    <div class="table-responsive text-nowrap">
        <table class="table">
        <thead>
            <tr>
                <th>Customer</th>
                @foreach($datas['periods_header'] as $key => $value)
                    <th>{{$value}}</th>
                @endforeach 
            </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            @foreach($datas['periods_data'] as $data)
                <tr>
                    <td><a href="{{route('bulanan.show', $data['customer']->id)}}">{{$data['customer']->name}}</a></td>
                    @foreach($data['payments_period_data'] as $key => $value)
                        <td>{!! $value ? "<i class='bx bx-check-circle'></i>" : "-" !!}</td>
                    @endforeach 

                </tr>
            @endforeach
        </tbody>
        </table>
    </div>
    </div>
    <!--/ Basic Bootstrap Table -->
@endsection