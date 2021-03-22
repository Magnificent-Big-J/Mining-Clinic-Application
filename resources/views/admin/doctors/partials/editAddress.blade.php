<div class="row">
    <div class="col-lg-6">
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Street:<i class="fa fa-asterisk text-danger"></i></label>
            <div class="col-lg-9">
                <input type="text" name="street"  class="form-control" value="{{$doctor->street}}">
                @error('street')
                <span class="text-danger" role="alert">
                       <strong>{{ $message }}</strong>
                  </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Complex:<i class="fa fa-asterisk text-danger"></i></label>
            <div class="col-lg-9">
                <input type="text" name="complex"  class="form-control" value="{{$doctor->complex}}">
                @error('complex')
                  <span class="text-danger" role="alert">
                       <strong>{{ $message }}</strong>
                  </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Suburb:<i class="fa fa-asterisk text-danger"></i></label>
            <div class="col-lg-9">
                <input type="text" name="suburb" id="suburb" class="form-control" value="{{$doctor->suburb}}">
                @error('suburb')
                  <span class="text-danger" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                @enderror
            </div>
        </div>

    </div>
    <div class="col-lg-6">

        <div class="form-group row">
            <label class="col-lg-3 col-form-label">City:<i class="fa fa-asterisk text-danger"></i></label>
            <div class="col-lg-9">
                <input type="text" name="city" class="form-control" value="{{$doctor->city}}" required>
                @error('city')
                  <span class="text-danger" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Postal Code:<i class="fa fa-asterisk text-danger"></i></label>
            <div class="col-lg-9">
                <input type="text" name="postal_code" class="form-control" value="{{$doctor->code}}" required>
                @error('postal_code')
                <span class="text-danger" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

    </div>
</div>
