@inject('carbon', 'Carbon\Carbon')
@extends('layouts_sneat.app_sign')
 
@section('title', 'Dana Komitmen')

@push('breadcrumb')
    <li class="breadcrumb-item active"><a href="#">Dana Komitmen</a></li>
@endpush


 
@section('content')
    <!-- Basic Bootstrap Table -->
    <div class="card">
    <h5 class="card-header">Dana Komitmen @if (Route::is('danakomitmen.index')) <a href="{{route('danakomitmen.create')}}" class="btn btn-primary float-end">Add Dana Komitmen</a> @endif </h5>
    <div class="table-responsive text-nowrap">
        <table class="table">
        <thead>
            <tr>
            <th>Customer</th>
            <th>Payment Date</th>
            <th>Amount</th>
            <th>Action</th>
            </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            @foreach($datas as $data)
                <tr>
                    <td><a href="{{route('customer.show', $data->customer->id)}}">{{$data->customer->name}}</a></td>
                    <td>{{$carbon::parse($data->payment_date)->format('d-m-Y')}}</td>
                    <td>Rp. {{ number_format($data->amount, 0, ',', '.') }}</td>
                    <td>
                        <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('danakomitmen.show', $data->id) }}"
                            ><i class="bx bx-book-open me-1"></i> Detail</a
                            >
                            <a class="dropdown-item" href="{{ route('danakomitmen.edit', $data->id) }}"
                            ><i class="bx bx-edit-alt me-1"></i> Edit</a
                            >
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal{{$data->id}}"
                            ><i class="bx bx-trash me-1"></i> Delete</a
                            >
                        </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
        </table>
    </div>
    </div>
    <!--/ Basic Bootstrap Table -->
@endsection

@foreach($datas as $data)
    @push('modal')
        <!-- Small Modal -->
        <div class="modal fade" id="deleteModal{{$data->id}}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">Warning</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5>Are you sure want to delete danakomitmen "{{$data->name}}"?</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('danakomitmen.destroy', $data->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"><i class="bx bx-trash me-1"></i> Delete</button>
                    </form>
                </div>
                </div>
            </div>
        </div>
        <!--/ Basic Bootstrap Table -->
    @endpush
@endforeach