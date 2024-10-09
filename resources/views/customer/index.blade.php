 @inject('carbon', 'Carbon\Carbon')
@extends('layouts.app_sign')
 
@section('title', 'Customer')

@push('breadcrumb')
    <li class="breadcrumb-item active"><a href="#">Customer</a></li>
@endpush


 
@section('content')
    <!-- Basic Bootstrap Table -->
    <div class="card">
    <h5 class="card-header">Customer @if (Route::is('customer.index')) <a href="{{route('customer.create')}}" class="btn btn-primary float-end">Add Customer</a> @endif </h5>
    <div class="table-responsive text-nowrap">
        <table class="table">
        <thead>
            <tr>
            <th>Name</th>
            <th>Phone</th>
            <th>DK</th>
            <th>DP</th>
            <th>Pelunasan</th>
            <th>Action</th>
            </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            @foreach($data_customers as $data)
                <tr>
                    <td><a href="{{ route('customer.show', $data->id) }}">{{$data->name}}</a></td>
                    <td>{{$data->phone}}</td>

                    <td>
                        @if($data->danakomitmen)
                            <i class="menu-icon tf-icons bx bx-check text-primary" data-bs-toggle="tooltip"
                            data-bs-offset="0,4"
                            data-bs-placement="left"
                            data-bs-html="true"
                            title="<i class=\'bx bx-money bx-xs\' ></i> <span>Rp. {{number_format(optional($data->danakomitmen)->amount, 0, ',', '.')}}
                            </span>"></i>
                            {{$carbon::parse(optional($data->danakomitmen)->payment_date)->format('d M Y')}}
                        @else
                            <a href="{{route('danakomitmen.create', $data->id)}}">Set DK</a>
                        @endif
                    </td>

                    <td>
                        @if(optional($data->danakomitmen)->danadp)
                            <i class="menu-icon tf-icons bx bx-check text-primary" data-bs-toggle="tooltip"
                            data-bs-offset="0,4"
                            data-bs-placement="left"
                            data-bs-html="true"
                            title="<i class=\'bx bx-money bx-xs\' ></i> <span>Rp. {{number_format(optional($data->danakomitmen->danadp)->amount, 0, ',', '.')}}
                            </span>"></i>
                            {{$carbon::parse(optional($data->danakomitmen->danadp)->payment_date)->format('d M Y')}}
                        @elseif($data->danakomitmen)
                            <a href="{{route('danadp.create', $data->id)}}">Set DP</a>
                        @else
                            -
                        @endif
                    </td>
                  
                    <td>
                        @if(optional(optional($data->danakomitmen)->danadp)->danapelunasan)
                            <i class="menu-icon tf-icons bx bx-check text-primary" data-bs-toggle="tooltip"
                            data-bs-offset="0,4"
                            data-bs-placement="left"
                            data-bs-html="true"
                            title="<i class=\'bx bx-money bx-xs\' ></i> <span>Rp. {{number_format(optional($data->danakomitmen->danadp->danapelunasan)->amount, 0, ',', '.')}}
                            </span>"></i>
                            {{$carbon::parse(optional($data->danakomitmen->danadp->danapelunasan)->payment_date)->format('d M Y')}}
                        @elseif(optional($data->danakomitmen)->danadp)
                            <a href="{{route('danapelunasan.create', $data->id)}}">Set Pelunasan</a>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('customer.show', $data->id) }}"
                            ><i class="bx bx-book-open me-1"></i> Detail</a
                            >
                            {{-- <a class="dropdown-item" href="{{ route('customer.edit', $data->id) }}"
                            ><i class="bx bx-edit-alt me-1"></i> Edit</a
                            > --}}
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

@foreach($data_customers as $data)
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
                    <h5>Are you sure want to delete customer "{{$data->name}}"?</h5>
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
        <!--/ Basic Bootstrap Table -->
    @endpush
@endforeach