<div class="modal fade custom-modal" id="product_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Product Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route('admin.product.store')}}">
                    @csrf

                    <div class="form-group">
                        <label for="">Name:<strong class="text-danger">*</strong></label>
                        <input type="text" name="name" class="form-control" value="{{old('name')}}" required>
                        @error('name')
                        <span class="text-danger" role="alert">
                               <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="submit-section text-center">
                        <button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
