@extends('layouts.admindatatables')
@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Specialist Management</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Specialist</li>
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
                                <h4 class="card-title"> Specialist

                                </h4>
                            </div>
                            <div class="card-body">
                                <form action="{{route('admin.specialists.store')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Specialist Name: <strong class="text-danger">*</strong></label>
                                        <div class="col-lg-9">
                                            <input type="text" name="specialist_name" value="{{ old('specialist_name') }}" class="form-control">
                                            @error('specialist_name')
                                            <span class="text-danger" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Specialist Image: <strong class="text-danger">*</strong></label>
                                        <div class="col-lg-9">
                                            <input type="file" accept="image/gif, image/jpeg, image/png" name="specialist_image"  class="form-control">
                                            @error('specialist_image')
                                            <span class="text-danger" role="alert">
                                                             <strong>{{ $message }}</strong>
                                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <input type="submit" value="Submit" class="btn btn-primary ">
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

