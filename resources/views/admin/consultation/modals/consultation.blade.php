<div class="modal fade custom-modal" id="consultation_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Consultation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route('admin.consultation.store')}}">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group ">
                                <label  for="">Name <small class="text-danger">*</small></label>
                                <input type="text" name="name" class="form-control" value="{{old('name')}}" required>
                                @error('name')
                                <span class="text-danger" role="alert">
                               <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group ">
                                <label for="">Consultation Type <small class="text-danger">*</small></label>
                                <br>
                                <select name="consultation_type" id="consultation-type" style="width: 100%" class="form-control select2-width" required>
                                    @foreach($consultationCategories as $consultationCategory)
                                        <option @if (old('consultation_type') === $consultationCategory->id) selected @endif  value="{{$consultationCategory->id}}">{{$consultationCategory->name}}</option>
                                    @endforeach
                                </select>
                                @error('consultation_type')
                                    <span class="text-danger" role="alert">
                                       <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="submit-section text-center">
                        <button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
