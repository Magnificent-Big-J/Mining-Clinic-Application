<div class="row">
    <div class="col-lg-6">
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Entity Name:</label>
            <div class="col-lg-9">
                <input type="text" name="entity_name" value="{{ $doctor->entity_name }}" class="form-control">
                @error('entity_name')
                <span class="text-danger" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                        </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Specialist:</label>
            <div class="col-lg-9">
                <select name="specialist_name" id="specialist_name" class="form-control">
                    @foreach($specialists as $specialist)
                        <option @if(old('specialist_name') === $specialist->id) selected @endif value="{{$specialist->id}}">{{$specialist->name}}</option>
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
            <label class="col-lg-3 col-form-label">Entity Status:</label>
            <div class="col-lg-9">
                <select name="entity_status" id="entity_status" class="form-control">
                    <option @if($doctor->entity_status == 'active') selected @endif value="active">Active</option>
                    <option @if($doctor->entity_status == 'suspended') selected @endif value="suspended">suspended</option>

                </select>
                @error('entity_status')
                <span class="text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Practice Number:</label>
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


    </div>
    <div class="col-lg-6">

        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Registration Number:</label>
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
            <label class="col-lg-3 col-form-label">Email Address:</label>
            <div class="col-lg-9">
                <input type="email" name="entity_email" value="{{ $doctor->email }}" class="form-control">
                @error('entity_email')
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
                @error('vat_number')
                <span class="text-danger" role="alert">
                   <strong>{{ $message }}</strong>
                 </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">FAX Number:</label>
            <div class="col-lg-9">
                <input type="text" name="fax_number" value="{{ $doctor->fax_number }}" class="form-control">

            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Stock Scheme:</label>
            <div class="col-lg-9">
                <input type="text" name="stock_scheme" value="{{ $doctor->stock_scheme }}" class="form-control">
                @error('stock_scheme')
                <span class="text-danger" role="alert">
                   <strong>{{ $message }}</strong>
                 </span>
                @enderror
            </div>
        </div>

    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="form-group row">
            <label class="col-lg-2 col-form-label">Address :</label>
            <div class="col-lg-10">
                <textarea name="address" id="vs" cols="2" class="form-control">{{ $doctor->address}}</textarea>
                @error('address')
                <span class="text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
    </div>
</div>
