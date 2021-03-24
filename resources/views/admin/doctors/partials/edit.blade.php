<div class="row">
    <div class="col-lg-6">

        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Specialist:<span class="text-danger">*</span></label>
            <div class="col-lg-9">
                <select name="specialist_name" id="specialist-name-update" class="form-control" style="width: 100%" class="form-control select2-width" required multiple="multiple">
                    @foreach($specialists as $specialist)
                        <option @if(in_array($specialist->id, $specialitiesIds)) selected @endif value="{{$specialist->id}}">{{$specialist->name}}</option>
                    @endforeach
                </select>
                @error('specialist_name')
                  <span class="text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Practice Number:<span class="text-danger">*</span></label>
            <div class="col-lg-9">
                <input type="text" name="practice_number" value="{{ $doctor->practice_number }}" class="form-control">
                @error('practice_number')
                 <span class="text-danger" role="alert">
                   <strong>{{ $message }}</strong>
                 </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Telephone Number:</label>
            <div class="col-lg-9">
                <input type="text" name="tele_number" value="{{ $doctor->tele_number }}" class="form-control">

            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">FAX Number:</label>
            <div class="col-lg-9">
                <input type="text" name="fax_number" value="{{ $doctor->fax_number }}" class="form-control">

            </div>
        </div>

    </div>
    <div class="col-lg-6">

        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Registration Number:<span class="text-danger">*</span></label>
            <div class="col-lg-9">
                <input type="text" name="reg_number" value="{{ $doctor->reg_number }}" class="form-control">
                @error('reg_number')
                 <span class="text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                 </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Email Address:<span class="text-danger">*</span></i></label>
            <div class="col-lg-9">
                <input type="email" name="email" value="{{ $doctor->email }}" class="form-control">
                @error('email')
                <span class="text-danger" role="alert">
                   <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">VAT Number:</label>
            <div class="col-lg-9">
                <input type="text" name="vat_number" value="{{ $doctor->vat_number }}" class="form-control">

            </div>
        </div>
    </div>
</div>

