 @inject('carbon', 'Carbon\Carbon')
@extends('layouts_sneat.app_sign')
 
@section('title', 'Customer')

@push('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('perpanjangan.index')}}">Pembayaran Perpanjangan</a></li>
@endpush

@push('breadcrumb')
    <li class="breadcrumb-item active"><a href="#">{{$data_customer->name}}</a></li>
@endpush


 
@section('content')
    <!-- Basic Bootstrap Table -->
    <div class="card">
    <h5 class="card-header">Pembayaran Perpanjangan - {{$data_customer->name}} </h5>
    <div class="table-responsive text-nowrap">
        <table class="table">
        <thead>
            <tr>
                <th>Year</th>
                <th>Amount</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            @if($data_customer->pembayaranperpanjangan->count()==0)
                <tr><td colspan="3">No Record</td></tr>
            @endif

            @foreach($data_customer->pembayaranperpanjangan->sortBy('year') as $pembayaran)
                <tr>
                    <td>{{$carbon->createFromDate($pembayaran->year,1,1)->format('Y')}}</td>
                    <td>Rp.{{number_format($pembayaran->amount, 0, ',', '.')}}</td>
                    <td>
                    @if($pembayaran->year == $data_last_year)
                        @php
                            $id_last_pembayaran = $pembayaran->id;
                        @endphp
                        <button type="button" class="btn btn-icon me-2 btn-danger" data-bs-toggle="modal" data-bs-target="#deletePembayaranPerpanjanganModal">
                            <span class="tf-icons bx bx-trash bx-22px"></span>
                        </button>
                    @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
        </table>
    </div>
    </div>
    <!--/ Basic Bootstrap Table -->
@endsection

@if(isset($id_last_pembayaran))
@push('modal')
    <!-- Small Modal -->
    <div class="modal fade" id="deletePembayaranPerpanjanganModal" tabindex="-1" aria-hidden="true">
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
                <form action="{{ route('perpanjangan.destroy', $id_last_pembayaran) }}" method="POST">
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