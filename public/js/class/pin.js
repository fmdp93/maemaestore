// Decorator
export class Pin {
    constructor(page) {
        this.page = page;
        this.$pin = $("#pin");
        this.elemPinModal = $("#pin-modal-container > .modal")[0];
        this.pinModal = new bootstrap.Modal(this.elemPinModal);
        this.$pin_modal_container = $("#pin-modal-container");
        this.$pin_modal_error = $("#pin-modal-error");
    }

    shown() {
        $(document).on(
            "shown.bs.modal",
            "#pin-modal",
            function (event) {
                this.$triggeredDeleteButton = $(event.relatedTarget);
            }.bind(this)
        );
    }

    isPinCorrect(cb) {
        let pin = $("#pin").val();
        $.get(
            "/pin/validate-pin",
            { pin: pin },
            function (response) {
                let parsed = JSON.parse(response);
                if (parsed?.valid) {
                    cb();
                    this.$pin_modal_error.addClass("d-none");
                } else {
                    this.$pin_modal_error.removeClass("d-none");
                }
            }.bind(this)
        )
            .promise()
            .done(this.afterValidation.bind(this));
    }

    afterValidation() {
        $(".modal-backdrop").remove();
        this.pinModal.toggle();
        this.$pin.val("");
    }
}
