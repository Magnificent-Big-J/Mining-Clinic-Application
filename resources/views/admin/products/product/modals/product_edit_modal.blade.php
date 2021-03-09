    <div class="modal fade custom-modal" id="product-update-category-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Product </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="product-edit-form" id="product-edit-form" method="post">
                    @csrf
                    <div class="product-result">

                    </div>
                    <div class="submit-section text-center">
                        <button type="submit" class="btn btn-primary product-edit-btn">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
