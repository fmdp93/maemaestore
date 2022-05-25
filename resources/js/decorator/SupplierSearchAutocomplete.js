export class SupplierSearchAutocomplete {
    constructor(DecoratedClass) {
        this.DecoratedClass = DecoratedClass;
        this.autocompleteData = {};
        this.source_list = [];

        this.triggerEvents();
    }

    triggerEvents() {
        // this.DecoratedClass.$supplier_search.on(
        //     "keyup",
        //     this.requestVendors.bind(this)
        // );
        this.setAutocompleteData();
        this.theAutocomplete();
    }

    setAutocompleteData() {
        this.autocompleteData = {
            minLength: 0,
            source: this.requestVendors,
            focus: function (event, ui) {
                this.DecoratedClass.$supplier_search.val(
                    `${ui.item.id}# ${ui.item.vendor}, ${ui.item.company_name}`
                );
                return false;
            }.bind(this),
            select: function (event, ui) {
                this.DecoratedClass.$vendor.val(ui.item.vendor);
                this.DecoratedClass.$company.val(ui.item.company_name);
                this.DecoratedClass.$contact.val(ui.item.contact_detail);
                this.DecoratedClass.$address.val(ui.item.address);
                this.DecoratedClass.$supplier_search_id.val(ui.item.id);
                return false;
            }.bind(this),
        };
    }

    requestVendors(request, response) {
        $.get(
            "/vendor/search",
            { q: request.term },
            function (get_response) {
                let parsed_response = JSON.parse(get_response);
                response(parsed_response.vendors);
            }
        )
    }

    theAutocomplete() {
        this.DecoratedClass.$supplier_search
            .autocomplete(this.autocompleteData)
            .autocomplete("instance")._renderItem = function (ul, item) {
                $(ul).addClass("border border-1 border-button-shadow rounded-1");
            return $("<li>")
                .append(
                    `<div>#${item.id} - ${item.vendor}, ${item.company_name}</div>`
                )
                .appendTo(ul);
        };
    }
}
