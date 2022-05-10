import { objBarcodeReader } from "/js/scope/barcode_reader.js";
import { toggletableEmpty } from "/js/function.js";

class Products {
    constructor() {
        // Table Empty vars
        this.$tbody = $("#products_list tbody");
        this.$table_empty = $(".table-empty");

        // Class vars
        this.$pages = $("#pages");
        this.$search = $("#search");
        this.$category = $("#category_id");
        this.ObjectSearch = new Search(product_search_url);
        this.$action = $("#action");
        this.$action_print_barcode = $("#action_print_barcode");

        // BarcodeReader vars
        this.$item_code = $("#item_code");
        this.objBarcodeReader = objBarcodeReader;
        this.objBarcodeReader.$search = this.$search;
        this.objBarcodeReader.then_callback = this.objBarcodeReader.changeSearch;
        this.objBarcodeReader.done_callback = this.requestProduct;

        this.triggerEvents();
    }   

    triggerEvents() {
        this.search();
        this.searchCategory();
    }

    searchCategory() {
        this.$category.on("change", "", { this: this }, this.requestProduct);
    }

    search() {
        this.$search.on("keyup", "", { this: this }, this.requestProduct);
    }

    requestProduct(event) {        
        let category_id = _this.$category.val();

        let objSearchParam = {
            q: _this.$search.val(),
            category_id: category_id,
            action: _this.$action.val(),
            action_print_barcode: _this.$action_print_barcode.val(),
        };

        _this.ObjectSearch.appendParam(objSearchParam);

        $.get(
            _this.ObjectSearch.url,
            _this.ObjectSearch.param,
            _this.requestProductResponse
        );
    }

    requestProductResponse(response) {
        response = JSON.parse(response);
        _this.$tbody.html(response.rows_html);
        _this.$pages.html(response.links_html);
        toggletableEmpty(_this.$tbody, _this.$table_empty);
    }
}

let objProducts = new Products();
const _this = objProducts;

$(function () {
    let deleteClicked = false;

    $(".delete-cell button").on("click", function () {
        deleteClicked = true;
    });

    $("#products_list").on("click", "tbody tr", function (event) {
        if (deleteClicked) {
            deleteClicked = false;
            return;
        }

        $("#product_id").val($(this).find("input[name='product_id']").val());
        $("#item_code").val($(this).find("input[name='item_code']").val());
        $("#item_name").val($(this).find("input[name='p_name']").val());
        $("#price").val($(this).find("input[name='price']").val());
        $("#expiration_date").val(
            $(this).find("input[name='expiration_date']").val()
        );
    });
});
