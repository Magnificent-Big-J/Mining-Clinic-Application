<div class="row">
    <div class="col-lg-6">
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Entity Name:<i class="fa fa-asterisk text-danger"></i></label>
            <div class="col-lg-9">
                <input type="text" name="entity_name"  class="form-control" value="{{$doctor->doctorEntity->entity_name}}">
                @error('entity_name')
                  <span class="text-danger" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                @enderror
            </div>
        </div>

    </div>
    <div class="col-lg-6">
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">Entity Status:<i class="fa fa-asterisk text-danger"></i></label>
            <div class="col-lg-9">
                <select name="entity_status" id="entity_status" class="form-control" >
                    <option @if($doctor->doctorEntity->entity_status === \App\Models\DoctorEntity::ACTIVE_STATUS) selected @endif  value="active">Active</option>
                    <option @if($doctor->doctorEntity->entity_status === \App\Models\DoctorEntity::SUSPENDED_STATUS) selected @endif value="suspended">suspended</option>
                </select>
                @error('xray')
                  <span class="text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
            </div>
        </div>

    </div>
</div>
