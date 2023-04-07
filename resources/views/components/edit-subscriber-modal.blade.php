<div class="modal" id="subscriber-edit-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form class="modal-content" action="/subscribers/update" id="subscriber-edit-form">
            <div class="modal-header">
                <h5 class="modal-title">Edit subscriber</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" value="" name="id">
                <div class="mb-3">
                    <label for="name-input" class="form-label">Name</label>
                    <input type="text" name="name" id="name-input" class="form-control">
                </div>
                <div class="mb-3">
                    <select name="country" class="countrypicker form-control" title="Country"></select>
                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-primary" value="Save changes">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </form>
    </div>
</div>
