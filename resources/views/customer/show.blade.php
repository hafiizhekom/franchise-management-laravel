 
@inject('carbon', 'Carbon\Carbon')
@extends('layouts.app_sign')
 
@section('title', 'Customer')

@push('breadcrumb')
   <li class="breadcrumb-item"><a href="{{route('customer.index')}}">Customer</a></li>
@endpush

@push('breadcrumb')
    <li class="breadcrumb-item active"><a href="#">Show</a></li>
@endpush
 
@section('content')
    <!-- Basic Bootstrap Table -->
    <div class="card">
        <h5 class="card-header">Customer Detail 
            <button type="button" class="btn btn-icon me-2 btn-danger float-end" data-bs-toggle="modal" data-bs-target="#deleteModal">
                <span class="tf-icons bx bx-trash bx-22px"></span>
            </button>
            <a href="{{ route('customer.edit', $data->id) }}" class="btn btn-icon me-2 btn-outline-primary float-end">
                <span class="tf-icons bx bx-edit bx-22px"></span>
            </a>
            
        </h5>
        <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="form-label">Name</label>
                            <input type="text" placeholder="Name" value="{{$data->name}}" readonly class="form-control-plaintext"/>
                        </div>

                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="form-label">Email address</label>
                            <input type="email" class="form-control-plaintext" placeholder="name@example.com" readonly value="{{$data->email}}" />
                        </div>

                        <div class="mb-4">
                            <label for="exampleFormControlTextarea1" class="form-label">Address</label>
                            <input class="form-control-plaintext" type="text" value="{{$data->address}}">
                        </div>

                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="form-label">City</label>
                            <input type="text" class="form-control-plaintext" placeholder="City" value="{{$data->city}}" />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-4">
                            <label for="exampleFormControlSelect1" class="form-label">Gender</label>
                        <input class="form-control-plaintext" readonly type="text" value="{{ucfirst($data->gender)}}"/>
                        </div>

                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="form-label">Birthday</label>
                            <input class="form-control-plaintext" readonly type="text" value="{{$carbon::parse($data->birthday)->format('d-m-Y')}}"/>
                        </div>

                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="form-label">Phone</label>
                            <input class="form-control-plaintext" readonly type="text" value="{{$data->phone}}" placeholder="08581234xxxx"/>
                        </div>
                    </div>
                </div>
        </div>
    </div>

    <div class="card mt-5">
        <h5 class="card-header">Dana Detail 
        </h5>
        <div class="card-body">
            <div class="row">
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        
                        <tbody class="table-border-bottom-0">
                            <tr>
                                <td>DK (Dana Komitmen)</td>
                                <td>
                                    {!!
                                        optional(
                                            $data->danakomitmen
                                        )->amount ?
                                        'Jumlah Pembayaran: Rp.'.number_format(optional($data->danakomitmen)->amount, 0, ',', '.')
                                        : 
                                        'Jumlah Pembayaran: <a href="'.route('customer.danakomitmen.create', $data->id).'">Set DK</a>' 
                                    !!}
                                </td>
                                <td>
                                    {!!
                                        optional(
                                            $data->danakomitmen
                                        )->payment_date ?
                                        'Tanggal Pembayaran:'.$carbon::parse(optional($data->danakomitmen)->payment_date)->format('d M Y')
                                        : 
                                        'Tanggal Pembayaran: <a href="'.route('customer.danakomitmen.create', $data->id).'">Set DK</a>' 
                                    !!}
                                </td>
                                <td>
                                    @if(
                                        !optional($data->danakomitmen)->danadp
                                        &&
                                        $data->danakomitmen
                                    )
                                    <button type="button" class="btn btn-icon me-2 btn-danger float-end" data-bs-toggle="modal" data-bs-target="#deleteDanakomitmenModal">
                                        <span class="tf-icons bx bx-trash bx-22px"></span>
                                    </button>
                                    @endif
                                </td>
                            </tr>

                            {{-- DANA DK HARUS ADA DULU --}}
                            @if($data->danakomitmen)
                                <tr>
                                    <td>DP (Dana DP)</td>
                                    <td>
                                        {!!
                                            optional(optional($data->danakomitmen)->danadp)->amount ?
                                            'Jumlah Pembayaran: Rp.'.number_format(optional(optional($data->danakomitmen)->danadp)->amount, 0, ',', '.')
                                            : 
                                            'Jumlah Pembayaran: <a href="'.route('customer.danadp.create', $data->id).'">Set Dana DP</a>' 
                                        !!}
                                    </td>
                                    <td>
                                        {!!
                                            optional(optional($data->danakomitmen)->danadp)->payment_date ?
                                            'Tanggal Pembayaran:'.$carbon::parse(optional(optional($data->danakomitmen)->danadp)->payment_date)->format('d M Y')
                                            : 
                                            'Tanggal Pembayaran: <a href="'.route('customer.danadp.create', $data->id).'">Set Dana DP</a>' 
                                        !!}
                                    </td>
                                    <td>
                                        @if(
                                            !optional(optional($data->danakomitmen)->danadp)->danapelunasan
                                            &&
                                            optional($data->danakomitmen)->danadp
                                        )
                                        <button type="button" class="btn btn-icon me-2 btn-danger float-end" data-bs-toggle="modal" data-bs-target="#deleteDanadpModal">
                                            <span class="tf-icons bx bx-trash bx-22px"></span>
                                        </button>
                                        @endif
                                    </td>
                                </tr>
                            @endif

                            {{-- DANA DP HARUS ADA DULU --}}
                            @if(optional($data->danakomitmen)->danadp)
                                <tr>
                                    <td>Dana Pelunasan</td>
                                    <td>
                                        {!!
                                            optional(optional(optional($data->danakomitmen)->danadp)->danapelunasan)->amount ?
                                            'Jumlah Pembayaran: Rp.'.number_format(optional(optional(optional($data->danakomitmen)->danadp)->danapelunasan)->amount, 0, ',', '.')
                                            : 
                                            'Jumlah Pembayaran: <a href="'.route('customer.danapelunasan.create', $data->id).'">Set Dana Pelunasan</a>' 
                                        !!}
                                    </td>
                                    <td>
                                        {!!
                                            optional(optional(optional($data->danakomitmen)->danadp)->danapelunasan)->payment_date ?
                                            'Tanggal Pembayaran:'.$carbon::parse(optional(optional(optional($data->danakomitmen)->danadp)->danapelunasan)->payment_date)->format('d M Y')
                                            : 
                                            'Tanggal Pembayaran: <a href="'.route('customer.danapelunasan.create', $data->id).'">Set Dana Pelunasan</a>' 
                                        !!}
                                    </td>
                                    <td>
                                        @if(
                                            optional(optional($data->danakomitmen)->danadp)->danapelunasan
                                        )
                                        <button type="button" class="btn btn-icon me-2 btn-danger float-end" data-bs-toggle="modal" data-bs-target="#deleteDanapelunasanModal">
                                            <span class="tf-icons bx bx-trash bx-22px"></span>
                                        </button>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>        
        </div>
    </div>
@endsection


@if($data->danakomitmen)
    @push('modal')
    <!-- Small Modal -->
    <div class="modal fade" id="deleteDanakomitmenModal" tabindex="-1" aria-hidden="true">
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
                <form action="{{ route('danakomitmen.destroy', $data->danakomitmen->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i class="bx bx-trash me-1"></i> Delete</button>
                </form>
            </div>
            </div>
        </div>
    </div>
    @endpush
@endif

@if(optional($data->danakomitmen)->danadp)
    @push('modal')
    <!-- Small Modal -->
    <div class="modal fade" id="deleteDanadpModal" tabindex="-1" aria-hidden="true">
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
                <form action="{{ route('danadp.destroy', $data->danakomitmen->danadp->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i class="bx bx-trash me-1"></i> Delete</button>
                </form>
            </div>
            </div>
        </div>
    </div>
    @endpush
@endif

@if(optional(optional($data->danakomitmen)->danadp)->danapelunasan)
    @push('modal')
    <!-- Small Modal -->
    <div class="modal fade" id="deleteDanapelunasanModal" tabindex="-1" aria-hidden="true">
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
                <form action="{{ route('danapelunasan.destroy', $data->danakomitmen->danadp->danapelunasan) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i class="bx bx-trash me-1"></i> Delete</button>
                </form>
            </div>
            </div>
        </div>
    </div>
    @endpush
@endif




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
                <form action="{{ route('customer.destroy', $data->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i class="bx bx-trash me-1"></i> Delete</button>
                </form>
            </div>
            </div>
        </div>
    </div>
@endpush