<div class="row">
    <div class="col-lg-6">
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">First Name:<span class="text-danger">*</span></label>
            <div class="col-lg-9">
                <input type="text" name="first_name"  class="form-control" required>
                <small id="first-name-error" class="text-danger"></small>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Title:<span class="text-danger">*</span></label>
            <div class="col-lg-9">
                <select name="title" id="title" class="form-control" required>
                    <option value="Dr">Dr</option>
                    <option value="Mr">Mr</option>
                    <option value="Mrs">Mrs</option>
                    <option value="Ms">Ms</option>
                    <option value="Miss">Miss</option>
                    <option value="Prof">Professor</option>
                </select>
                <small id="title-name-error" class="text-danger"></small>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Practice Number:<span class="text-danger">*</span></label>
            <div class="col-lg-9">
                <input type="text" name="practice_number" class="form-control" required>
                <small id="practice-number-error" class="text-danger"></small>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Registration Number:<span class="text-danger">*</span></label>
            <div class="col-lg-9">
                <input type="text" name="reg_number" class="form-control">
                <small id="reg-number-error" class="text-danger"></small>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">FAX Number:</label>
            <div class="col-lg-9">
                <input type="text" name="fax_number"  class="form-control" >

            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Telephone Number:</label>
            <div class="col-lg-9">
                <input type="text" name="tele_number"  class="form-control">

            </div>
        </div>
    </div>
    <div class="col-lg-6">

        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Last Name:<span class="text-danger">*</span></label>
            <div class="col-lg-9">
                <input type="text" name="last_name"  class="form-control" required>
                <small id="last-name-error" class="text-danger"></small>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Email Address:<span class="text-danger">*</span></label>
            <div class="col-lg-9">
                <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                <small id="email-error" class="text-danger"></small>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Speciality:<span class="text-danger">*</span></label>
            <div class="col-lg-9">
                <select name="specialist_name[]" id="specialist_name" class="form-control" style="width: 100%" class="form-control select2-width" required multiple="multiple">
                    @foreach($specialists as $specialist)
                        <option value="{{$specialist->id}}">{{$specialist->name}}</option>
                    @endforeach
                        <small id="specialist-name-error" class="text-danger"></small>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">VAT Number:</label>
            <div class="col-lg-9">
                <input type="text" name="vat_number"  class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Avatar:</label>
            <div class="col-lg-9">
                <input type="file" accept="image/gif, image/jpeg, image/png" name="avatar"  class="form-control">

            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Have Entity:</label>
            <div class="col-lg-9">
                <input type="checkbox" name="has_entity" id="has-entity" >
            </div>
        </div>
    </div>
</div>
