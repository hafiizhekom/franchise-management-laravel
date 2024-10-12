 
@inject('carbon', 'Carbon\Carbon')
@extends('layouts_sneat.app_sign')
 
@section('title', 'Customer')

@push('breadcrumb')
   <li class="breadcrumb-item"><a href="{{route('customer.index')}}">Customer</a></li>
@endpush

@push('breadcrumb')
    <li class="breadcrumb-item active"><a href="{{route('customer.show', $data->id)}}">{{$data->name}}</a></li>
@endpush

@push('breadcrumb')
    <li class="breadcrumb-item active"><a href="#">Edit</a></li>
@endpush

 
@section('content')
    <!-- Basic Bootstrap Table -->
    <div class="card">
        <h5 class="card-header">Edit Customer</h5>
        <div class="card-body">
            <form action="{{ route('customer.update', $data->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    
                    <div class="col-sm-6">
                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="form-label">Name</label>
                            <input type="text" placeholder="Name" name="name" value="{{$data->name}}" class="form-control"/>
                            @error('name')
                                <div id="defaultFormControlHelp" class="form-text">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="form-label">Email address</label>
                            <input type="email" class="form-control" name="email" placeholder="name@example.com" value="@error('any') is-invalid @enderror {{$data->email}}" />
                            @error('email')
                                <div id="defaultFormControlHelp" class="form-text">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="exampleFormControlTextarea1" class="form-label">Address</label>
                            <textarea class="form-control" name="address" id="exampleFormControlTextarea1" rows="3">{{$data->address}}</textarea>
                            @error('address')
                                <div id="defaultFormControlHelp" class="form-text">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="form-label">City</label>
                            <input type="text" class="form-control" placeholder="City" name="city" value="{{$data->city}}" />
                            @error('city')
                                <div id="defaultFormControlHelp" class="form-text">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-4">
                            <label for="exampleFormControlSelect1" class="form-label">Gender</label>
                            <select class="form-select" id="exampleFormControlSelect1" name="gender" aria-label="Default select example">
                                <option @if($data->gender == "male") selected @endif value="male">Male</option>
                                <option @if($data->gender == "female") selected @endif value="female">Female</option>
                            </select>
                            @error('gender')
                                <div id="defaultFormControlHelp" class="form-text">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="form-label">Phone</label>
                            <input class="form-control" type="text" value="{{$data->phone}}" name="phone" placeholder="08581234xxxx"/>
                            @error('birthday')
                                <div id="defaultFormControlHelp" class="form-text">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="exampleFormControlSelect1" class="form-label">Birthday</label>
                            <input class="form-control" type="date" name="birthday" value="{{$carbon::parse($data->birthday)->format('Y-m-d')}}" />
                        </div>
                    </div>
                
                </div>

                <button type="submit" class="btn btn-primary float-end">Save</button>
            </form>
        </div>
    </div>
    <!--/ Basic Bootstrap Table -->
@endsection