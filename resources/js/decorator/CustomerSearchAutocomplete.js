/**
 * Autocomplete for POS customer search
 */
export class CustomerSearchAutocomplete {
    constructor(DecoratedClass) {
        this.DecoratedClass = DecoratedClass;
        this.autocompleteData = {};
        this.source_list = [];

        this.triggerEvents();
    }

    triggerEvents() {
        this.setAutocompleteData();
        this.theAutocomplete();
    }

    setAutocompleteData() {
        this.autocompleteData = {
            minLength: 0,
            source: this.requestVendors.bind(this),
            focus: function (event, ui) {
                this.DecoratedClass.$customer_search.val(
                    `#${ui.item.id} - ${ui.item.name}, ${ui.item.contact_detail}`
                );
                return false;
            }.bind(this),
            select: function (event, ui) {           
                this.DecoratedClass.$customer_id.val(ui.item.id);                
                this.DecoratedClass.$customer_name.val(ui.item.name);                
                this.DecoratedClass.$customer_contact_detail.val(ui.item.contact_detail);
                this.DecoratedClass.$customer_address.val(ui.item.address);

                return false;
            }.bind(this),
        };        
    }

    requestVendors(request, response) {
        $.get(
            "/customer/search-for-pos",
            { q: request.term },
            function (get_response) {
                let parsed_response = JSON.parse(get_response);
                response(parsed_response.customers);                
            }
        )        
    }

    theAutocomplete() {
        this.DecoratedClass.$customer_search
            .autocomplete(this.autocompleteData)
            .autocomplete("instance")._renderItem = function (ul, item) {
                $(ul).addClass("border border-1 border-button-shadow rounded-1 higher-than-modal");
            return $("<li>")
                .append(
                    `<div>#${item.id} - ${item.name}, ${item.contact_detail}</div>`
                )
                .appendTo(ul);
        };
    }
}
