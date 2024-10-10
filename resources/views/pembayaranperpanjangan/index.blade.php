@inject('carbon', 'Carbon\Carbon')
@extends('layouts.app_sign')
 
@section('title', 'Pembayaran Perpanjangan')

@push('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Pembayaran Perpanjangan</a></li>
@endpush


 
@section('content')
    <!-- Basic Bootstrap Table -->
    <div class="card">
    <h5 class="card-header">Pembayaran Perpanjangan @if (Route::is('perpanjangan.index')) <a href="{{route('perpanjangan.create.customer')}}" class="btn btn-primary float-end">Add Pembayaran Perpanjangan</a> @endif </h5>
    <div class="table-responsive text-nowrap">
        <table class="table">
        <thead>
            <tr>
                <th>Customer</th>
                @foreach($datas['years_header'] as $key => $value)
                    <th>{{$value}}</th>
                @endforeach 
            </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            @foreach($datas['years_data'] as $data)
                <tr>
                    <td><a href="{{route('perpanjangan.show', $data['customer']->id)}}">{{$data['customer']->name}}</a></td>
                    @foreach($data['payments_year_data'] as $key => $value)
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