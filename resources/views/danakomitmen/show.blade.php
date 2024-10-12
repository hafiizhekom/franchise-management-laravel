 
@inject('carbon', 'Carbon\Carbon')
@extends('layouts_sneat.app_sign')
 
@section('title', 'Dana Komitmen')

@push('breadcrumb')
   <li class="breadcrumb-item"><a href="{{route('danakomitmen.index')}}">Dana Komitmen</a></li>
@endpush

@push('breadcrumb')
    <li class="breadcrumb-item active"><a href="#">Show</a></li>
@endpush
 
@section('content')
    <!-- Basic Bootstrap Table -->
    <div class="card">
        <h5 class="card-header">Dana Komitmen Detail 
            <button type="button" class="btn btn-icon me-2 btn-danger float-end" data-bs-toggle="modal" data-bs-target="#deleteModal">
                <span class="tf-icons bx bx-trash bx-22px"></span>
            </button>
            <a href="{{ route('danakomitmen.edit', $data->id) }}" class="btn btn-icon me-2 btn-outline-primary float-end">
                <span class="tf-icons bx bx-edit bx-22px"></span>
            </a>
            
        </h5>
        <div class="card-body">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="form-label">Customer</label>
                            <input type="text" placeholder="Name" value="{{$data->name}}" readonly class="form-control-plaintext"/>
                        </div>

                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="form-label">Payment Date</label>
                            <input class="form-control-plaintext" readonly type="text" value="{{$carbon::parse($data->payment_date)->format('d-m-Y')}}"/>
                        </div>

                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="form-label">Amount</label>
                            <input class="form-control-plaintext" readonly type="text" value="{{$data->amount}}" placeholder="08581234xxxx"/>
                        </div>
                    </div>
                </div>

                
            </div>
        </div>
    </div>
@endsection


@push('modal')
    <!-- Small Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Warning</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5>Are you sure want to delete?</h5>
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