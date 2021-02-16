<div class="row">
    <div class="col-lg-6">
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">First Name:</label>
            <div class="col-lg-9">
                <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control">
                @error('first_name')
                <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                 </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Title:</label>
            <div class="col-lg-9">
                <select name="title" id="title" class="form-control">
                    <option value="Dr">Dr</option>
                    <option value="Mr">Mr</option>
                    <option value="Mrs">Mrs</option>
                    <option value="Ms">Ms</option>
                    <option value="Miss">Miss</option>
                    <option value="Prof">Professor</option>
                </select>
            </div>
        </div>

    </div>
    <div class="col-lg-6">

        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Last Name:</label>
            <div class="col-lg-9">
                <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control">
                @error('last_name')
                <span class="text-danger" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                        </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Email Address:</label>
            <div class="col-lg-9">
                <input type="text" name="email" value="{{ old('email') }}" class="form-control">
                @error('email')
                <span class="text-danger" role="alert">
                   <strong>{{ $message }}</strong>
                 </span>
                @enderror
            </div>
        </div>

    </div>
</div>
