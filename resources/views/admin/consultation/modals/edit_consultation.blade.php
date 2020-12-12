<div class="modal fade custom-modal" id="consultation_update_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Consultation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="update-consultation">
                    <div id="loader"></div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group ">
                                <label  for="">Name: <strong class="text-danger">*</strong></label>
                                <input type="text" name="name" class="form-control" value="{{old('name')}}" required>

                        </div>
                        <div class="col-lg-12">
                            <div class="form-group ">
                                <label for="">Consultation Type: <strong class="text-danger">*</strong></label>
                                <br>
                                <select name="consultation_type" id="consultation-type" style="width: 100%" class="form-control select2-width" required>
                                    @foreach($consultationCategories as $consultationCategory)
                                        <option  value="{{$consultationCategory->id}}">{{$consultationCategory->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="submit-section text-center">
                        <button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
