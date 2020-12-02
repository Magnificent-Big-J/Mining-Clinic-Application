<div class="row">
    <div class="col-lg-6">
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Entity Name:</label>
            <div class="col-lg-9">
                <input type="text" name="entity_name" value="{{ old('entity_name') }}" class="form-control">
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
                    <option @if(old('entity_status') == 'active') selected @endif value="active">Active</option>
                    <option @if(old('entity_status') == 'suspended') selected @endif value="suspended">suspended</option>

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
                <input type="text" name="practice_number" value="{{ old('practice_number') }}" class="form-control">
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
                <input type="text" name="tele_number" value="{{ old('tele_number') }}" class="form-control">

            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Address :</label>
            <div class="col-lg-9">
                <input type="text" name="address" value="{{ old('address') }}" class="form-control">
                @error('address')
                <span class="text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

    </div>
    <div class="col-lg-6">

        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Registration Number:</label>
            <div class="col-lg-9">
                <input type="text" name="reg_number" value="{{ old('reg_number') }}" class="form-control">
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
                <input type="text" name="entity_email" value="{{ old('entity_email') }}" class="form-control">
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
                <input type="text" name="vat_number" value="{{ old('vat_number') }}" class="form-control">
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
                <input type="text" name="fax_number" value="{{ old('fax_number') }}" class="form-control">
            </div>
        </div>
        <!--div class="form-group row">
            <label class="col-lg-3 col-form-label">Stock Scheme:</label>
            <div class="col-lg-9">
                <input type="text" name="stock_scheme" value="{{ old('stock_scheme') }}" class="form-control">
            </div>
        </div-->
        <div class="form-group row hidden">
            <label class="col-lg-3 col-form-label">Avatar:</label>
            <div class="col-lg-9">
                <input type="file" accept="image/gif, image/jpeg, image/png" name="avatar"  class="form-control">
            </div>
        </div>
    </div>
</div>
