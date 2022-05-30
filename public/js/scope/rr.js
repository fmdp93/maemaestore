import { toggletableEmpty } from "/js/function.js";

var tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
);
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
});

class RR {
    constructor() {
        // const _this = this;
        this.$item_code = $("#item_code");
        this.$s_item_name = $("#name");
        this.$quantity = $("#s_quantity");
        this.quantityTooltip;
        this.$tbody = $("#products_list tbody");
        this.$table_empty = $(".table-empty");
        this.$products_list = $("#products_list");
        this.$add_item = $("#add-item");
        this.$s_total = $("#s_total");
        this.$total = $("#total");
        this.$form = $("#rr");
        this.$input_total = this.$total.find("input");
        this.$clear_table = $("#clear-table");
        this.$pay_cash = $("#pay-cash");
        this.$submit_pos = $("#submit_pos");
        this.$change = $("#change");
        this.$initial_load = $("#initial_load");
        this.$form_submitted = false;
        this.triggerEvents();
    }

    triggerEvents() {
        this.$s_item_name.on(
            "change keyup",
            "",
            {
                response: this.requestProductResponse,
            },
            this.requestProduct
        );

        this.$item_code.on("change keyup", this.requestProductById);

        this.$add_item.on("click", this.addProductToForm);
        this.$quantity.on(
            "change keydown",
            "",
            {
                response: this.updateSearchSubtotal,
            },
            this.requestProduct
        );
        $("#products_list").on(
            "change keyup",
            "input[name='quantity[]']",
            this.updateForm
        );
        $("#products_list").on(
            "keydown",
            "input[name='quantity[]']",
            this.quantityPreventNegative
        );
        $(document).on("click", ".delete-item", this.deleteItem);
        this.$clear_table.on("click", this.clearTable);
        this.$form.on("submit", this.setInitialInput);
    }

    setInitialInput(event) {
        _this.$initial_load.val("1");
    }

    preventPlusMinus(event) {
        if (_this.isPlusMinus(event.keyCode)) {
            return false;
        }
    }

    updateSearchSubtotal(response) {
        let parsed = JSON.parse(response);
        let quantity = _this.$quantity.val();
        _this.quantityTooltip?.dispose();

        if (parsed.result?.p_id) {
            let price = parsed.result.price;
            _this.$s_total.val(sprintf("%.2f", price * quantity));
        }
    }

    clearTable(event) {
        // event.preventDefault();
        _this.$tbody.html("");
        toggletableEmpty(_this.$tbody, _this.$table_empty);
    }

    deleteItem(event) {
        event.preventDefault();
        $(this).parents("tr").remove().promise().done(_this.updateTotal);
        toggletableEmpty(_this.$tbody, _this.$table_empty);
    }

    quantityPreventNegative(event) {
        if (_this.isPlusMinus(event.keyCode)) {
            return false;
        }
    }

    updateForm(event) {
        let $this = $(this);
        let parentTable = "#products_list";
        let price = $this
            .parents(parentTable)
            .find("input[name='price[]']")
            .val();
        let quantity = $this.val();
        let subtotal = price * quantity;

        let data = {
            $this: $this,
            parentTable: parentTable,
            price: price,
            quantity: quantity,
            subtotal: subtotal,
        };

        _this.updateSubtotal(event, data);
        _this.updateTotal();
    }

    updateSubtotal(event, data) {
        data.$this
            .parents("tr")
            .find(".subtotal")
            .html(sprintf("%.2f", data.subtotal));
    }

    requestProduct(event) {
        if (_this.isPlusMinus(event.keyCode)) {
            return false;
        }

        let response = event.data.response;
        $.get(
            "/rr/inventory-search",
            { item_name: _this.$s_item_name.val() },
            response
        );
    }

    isPlusMinus(key) {
        let prevented_keys = [109, 107, 189, 187];
        if ($.inArray(key, prevented_keys) > -1) {
            return true;
        }
    }
    requestProductById() {
        $.get(
            "/rr/inventory-search",
            { item_code: _this.$item_code.val() },
            _this.requestProductByIdResponse
        );
    }

    addProductToForm(event) {
        event.preventDefault();
        $.get(
            "/rr/get-table-row",
            {
                item_name: _this.$s_item_name.val(),
                quantity: _this.$quantity.val(),
                form: _this.$form.attr("id"),
            },
            _this.addItemBtnResponse
        )
            .promise()
            .then(_this.updateTotal)
            .done(_this.isAmountValid);
    }

    addItemBtnResponse(response) {
        let parsed_response = JSON.parse(response);

        if (parsed_response?.tbody) {
            _this.$tbody.append(parsed_response.tbody);

            toggletableEmpty(_this.$tbody, _this.$table_empty);
        }
    }

    requestProductResponse(response) {
        let parsed_response = JSON.parse(response);

        _this.$quantity.val("");
        _this.$s_total.val("");
        if (parsed_response?.result?.p_id) {
            let result = parsed_response.result;
            _this.$item_code.val(result.item_code);
            $("#description").val(result.description);
            $("#s_price").val(result.price);
            $("#s_stock").val(result.i_stock);
        } else {
            _this.$item_code.val("");
            $("#description").val("");
            $("#s_price").val("");
            $("#s_stock").val("");
        }
    }

    requestProductByIdResponse(response) {
        let parsed_response = JSON.parse(response);

        _this.$quantity.val("");
        _this.$s_total.val("");
        if (parsed_response?.result?.p_id) {
            let result = parsed_response.result;
            $("#name").val(result.p_name);
            $("#description").val(result.description);
            $("#s_price").val(result.price);
            $("#s_stock").val(result.i_stock);
        } else {
            $("#name").val("");
            $("#description").val("");
            $("#s_price").val("");
            $("#s_stock").val("");
        }
    }

    updateTotal() {
        let total = 0;
        $("#products_list input[name='quantity[]']").each(function () {
            let price = parseFloat(
                $(this).parents("tr").find("input[name='price[]']").val()
            );
            let quantity = parseFloat($(this).val() || 0);
            total += price * quantity;
        });

        _this.$input_total.val(sprintf("%.2f", total));
        _this.$total.find("span").html(sprintf("%.2f", total));
    }
}

let objRR = new RR();
const _this = objRR;

// Prevent back button reload
$(document).ready(function () {
    setTimeout(function () {        
        if($("#initial_load").val() == 1){
            location.reload();
        }
    }, 500);
});
