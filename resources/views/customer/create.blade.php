 
@extends('layouts.app_sign')
 
@section('title', 'Add Customer')

@push('breadcrumb')
    <small class="text-muted ms-1"><a href="{{route('customer.index')}}">Customer</a> /</small>
@endpush

@push('breadcrumb')
    Create
@endpush


@section('content')
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Add Customer</h5>
                <div class="card-body">
                    <form action="{{ route('customer.store') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" id="exampleFormControlInput1" placeholder="Name" />
                        </div>

                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="form-label">Email address</label>
                            <input type="email" class="form-control" name="email" id="exampleFormControlInput1" placeholder="name@example.com" />
                        </div>

                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="form-label">Phone</label>
                            <input class="form-control" type="text" name="phone" value="" placeholde="08581234xxxx"/>
                        </div>

                        <div class="mb-4">
                            <label for="exampleFormControlSelect1" class="form-label">Gender</label>
                            <select class="form-select" name="gender" id="exampleFormControlSelect1" aria-label="Default select example">
                                <option selected>Open to select gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="exampleFormControlSelect1" class="form-label">Birthday</label>
                            <input class="form-control" type="date" name="birthday" id="html5-date-input" />
                        </div>

                        <div class="mb-4">
                            <label for="exampleFormControlTextarea1" class="form-label">Address</label>
                            <textarea class="form-control" name="address" id="exampleFormControlTextarea1" rows="3"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="form-label">City</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="City" name="city" />
                        </div>

                        <button type="submit" class="btn btn-primary float-end">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection