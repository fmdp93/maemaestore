export class DecorSupplier {
    constructor(DecoratedClass) {
        this.DecoratedClass = DecoratedClass;        
        this.triggerEvents();
    }

    triggerEvents() {
        this.DecoratedClass.$supplier.on("change", this.getSupplierDetails.bind(this));
    }

    getSupplierDetails() {
        $.get(
            "/product/add-item-search-vendor",
            { supplier_id: this.DecoratedClass.$supplier.val() },
            function (response) {
                let parsed_response = JSON.parse(response);
                this.DecoratedClass.$vendor.val(parsed_response.supplier.vendor);
                this.DecoratedClass.$company.val(parsed_response.supplier.company_name);
                this.DecoratedClass.$contact.val(parsed_response.supplier.contact_detail);
                this.DecoratedClass.$address.val(parsed_response.supplier.address);                
            }.bind(this)
        )
    }

    
}
