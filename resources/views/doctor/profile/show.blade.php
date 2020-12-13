@extends('layouts.doctor')
@section('styles')
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/styles.css')}}">
@endsection
@section('content')

    <form action="{{route('doctor.profile.settings.save', $user->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Basic Information</h4>
                <div class="row form-row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="change-avatar">
                                <div class="profile-img">
                                    <img src="{{$user->profile}}" alt="User Image">
                                </div>

                                <div class="upload-img">
                                    <div class="change-photo-btn">
                                        <span><i class="fa fa-upload"></i> Upload Photo</span>
                                        <input type="file" class="upload" name="avatar">
                                    </div>
                                    <small class="form-text text-muted">Allowed JPG, GIF or PNG. Max size of 2MB</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="first_name" value="{{$user->first_name}}">
                            @error('first_name')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="last_name" value="{{$user->last_name}}">
                            @error('last_name')
                            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" autocomplete="new-password">
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Entity Information</h4>
                <div class="row form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Entity Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="entity_name" value="{{$user->doctor->entity_name}}">
                            @error('entity_name')
                            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Entity Status <span class="text-danger">*</span></label>
                            <select name="entity_status" id="entity_status" class="form-control">
                                <option @if($user->doctor->entity_status == 'active') selected @endif value="active">Active</option>
                                <option @if($user->doctor->entity_status == 'suspended') selected @endif value="suspended">suspended</option>
                            </select>
                            @error('entity_status')
                            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Practice Number<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="practice_number" value="{{$user->doctor->practice_number}}">
                            @error('practice_number')
                            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                           <label>Specialist<span class="text-danger">*</span></label>
                            <select name="specialist_name[]" id="specialist_name" style="width: 100%" class="form-control select2-width" required multiple="multiple">
                                @foreach($specialists as $specialist)
                                    <option  @if (in_array($specialist->id, $doc_specialists)) selected @endif value="{{$specialist->id}}">{{$specialist->name}}</option>
                                @endforeach
                            </select>
                        @error('specialist_name')
                        <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Registration Number<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="reg_number" value="{{$user->doctor->reg_number}}">
                            @error('reg_number')
                            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>VAT Number<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="vat_number" value="{{$user->doctor->vat_number}}">
                            @error('vat_number')
                            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Entity Email Address<span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" value="{{$user->doctor->email}}">
                            @error('email')
                            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Telephone Number</label>
                            <input type="text" class="form-control" name="tele_number" value="{{$user->doctor->tele_number}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>FAX Number</label>
                            <input type="text" class="form-control" name="fax_number" value="{{$user->doctor->fax_number}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Stock Scheme</label>
                            <input type="text" class="form-control" name="stock_scheme" value="{{$user->doctor->stock_scheme}}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Address<span class="text-danger">*</span></label>
                            <textarea name="address" class="form-control" id="address" cols="10" rows="1">{{$user->doctor->address}}</textarea>
                            @error('address')
                            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <div class="submit-section submit-btn-bottom">
            <button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
        </div>
    </form>

@endsection


@section('scripts')
    <script src="{{asset('js/select2.min.js')}}"></script>
    <script>
        $(function () {
            $('#specialist_name').select2({
                theme: "classic",
                width: "resolve"
            });

        });
    </script>
@endsection

