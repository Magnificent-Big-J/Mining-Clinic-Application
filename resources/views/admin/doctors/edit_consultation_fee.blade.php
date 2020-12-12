@extends('layouts.admindatatables')
@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Consultation Fee Management</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Update Consultation Fee Information</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div class="row">
            <div class="col-md-12">

                <!-- Recent Orders -->
                <div class="card">
                    <div class="card-body">
                        <div class="card flex-fill">
                            <div class="card-header">
                                <h4 class="card-title">Edit Consultation Fee</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{route('admin.consultation-fee.update', $consultationFee->id)}}" method="post" >
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group ">
                                                <label  for="">Consultation Fee <small class="text-danger">*</small></label>
                                                <input type="text" name="consultation_fee" class="form-control" value="{{$consultationFee->consultation_fee}}" required autocomplete="off">
                                                @error('consultation_fee')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group ">
                                                  <label for="">Consultation <small class="text-danger">*</small></label>
                                                  <br>
                                                  <select name="consultation" id="consultation-fee" style="width: 100%" class="form-control select2-width" required>
                                                      @foreach($consultations as $consultation)
                                                          <option @if (old('consultation') === $consultationFee->consultation_id) selected @endif  value="{{$consultation->id}}">{{$consultation->name}} -- {{$consultation->consultationCategory->name}}</option>
                                                      @endforeach
                                                  </select>
                                                  @error('consultation')
                                                     <span class="text-danger" role="alert">
                                                       <strong>{{ $message }}</strong>
                                                    </span>
                                                  @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <input type="submit" value="Update" class="btn btn-primary ">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Recent Orders -->

            </div>
        </div>
    </div>
@endsection

