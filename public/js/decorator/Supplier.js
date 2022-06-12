export class DecorSupplier {
    constructor(DecoratedClass) {
        this.DecoratedClass = DecoratedClass;
        this.triggerEvents();
    }

    triggerEvents() {
        this.$supplier.on("change", this.getSupplierDetails);
    }

    getSupplierDetails(request, response) {
        $.get(
            "/vendor/search",
            { supplier_id: _this.$supplier.val() },
            function (response) {
                let parsed_response = JSON.parse(response);
                this.DecoratedClass.$vendor.val(parsed_response.supplier.vendor);
                this.DecoratedClass.$company.val(parsed_response.supplier.company_name);
                this.DecoratedClass.$contact.val(parsed_response.supplier.contact_detail);
                this.DecoratedClass.$address.val(parsed_response.supplier.address);
                this.DecoratedClass.$supplier_search_id.val(parsed_response.supplier.id);                
            }
        )
    }

    
}
