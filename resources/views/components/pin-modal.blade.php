<div id="pin-modal-container">
    <div class="modal" id="pin-modal" tabindex="-1" aria-labelledby="pin-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pin-modal-label">Enter PIN</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="pin-modal-error" class="d-none rounded-1 bg-danger p-xl-3 text-primary mb-xl-2">
                        Invalid PIN
                    </div>
                    <form action="#" id="delete-item-form">
                        <label for="pin">Enter PIN</label>
                        <input name="pin" id="pin" class="form-control form-control-xl mb-xl-3" type="password"
                            aria-label="pin">
                        <button id="pin-submit" class="form-control btn btn-danger text-primary py-xl-2 px-xl-5"
                            type="submit">OK</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
