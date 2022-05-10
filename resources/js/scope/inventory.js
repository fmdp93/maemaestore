import { toggletableEmpty } from "/js/function.js";

class Inventory {
    constructor() {
        this.$table = $("#inventory_list");
        this.$tbody = $("#inventory_list tbody");
        this.$table_empty = $(".table-empty");
        this.$pages = $("#pages");
        this.$search = $("#search");
        this.$category = $("#category_id");
        this.$stock_filter = $("input[name='stock_filter']");
        this.$normal_stock = $("#normal-stock");
        this.$half_stock = $("#half-stock");
        this.$low_stock = $("#low-stock");
        this.ObjectSearch = new Search("/inventory/search");

        this.triggerEvents();
    }

    triggerEvents() {
        $(function () {
            _this.onLoad();
        });
        this.search();
        this.searchCategory();
        this.$normal_stock.on(
            "click",
            "",
            { table_color: "" },
            this.filterStock
        );
        this.$half_stock.on(
            "click",
            "",
            { table_color: "table-half" },
            this.filterStock
        );
        this.$low_stock.on(
            "click",
            "",
            { table_color: "table-low" },
            this.filterStock
        );
    }

    onLoad(event) {
        // loads the Inventory alert modal
        let elemModal = document.querySelector(
            "#inventory-alert-modal > .modal"
        );

        if (elemModal) {
            this.modal = new bootstrap.Modal(elemModal);
            this.modal.show();
        }
    }

    filterStock(event) {
        let stock_filter = $(this).data("filter");
        let table_color = event.data.table_color;

        let objSearchParam = {
            stock_filter: stock_filter,
            table_color: table_color,
        };
        _this.ObjectSearch.appendParam(objSearchParam);

        _this.makeRequest(event);
    }

    searchCategory() {
        this.$category.on("change", this.makeRequest);
    }

    search() {
        let stock_filter = this.$stock_filter.val();
        this.setTableColor(stock_filter);

        let objSearchParam = {
            stock_filter: stock_filter,
            table_color: this.table_color,
        };
        this.ObjectSearch.appendParam(objSearchParam);

        this.$search.on("keyup", this.makeRequest);
    }

    setTableColor(stock_filter) {
        this.table_color = "";
        if (stock_filter == "low") {
            this.table_color = "table-low";
        } else if (stock_filter == "half") {
            this.table_color = "table-half";
        }
    }

    makeRequest(event) {
        let category_id = _this.$category.val();

        let objSearchParam = {
            q: _this.$search.val(),
            category_id: category_id,
        };

        _this.ObjectSearch.appendParam(objSearchParam);

        $.get(
            _this.ObjectSearch.url,
            _this.ObjectSearch.param,
            function (response) {
                _this.requestProduct(response);
            }
        );
    }

    requestProduct(response) {
        response = JSON.parse(response);
        console.log(response);
        this.$tbody.html(response.rows_html);
        this.$pages.html(response.links_html);
        toggletableEmpty(_this.$tbody, _this.$table_empty);

        this.$table.removeClass("table-half table-low");
        if (response.table_color) {
            this.$table.addClass(response.table_color);
        }
    }
}

let objInventory = new Inventory();
const _this = objInventory;
