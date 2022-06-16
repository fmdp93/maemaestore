import { toggletableEmpty } from "/js/function.js";

class PosTransaction{
    constructor(){
        // Search variables
        this.ObjectSearch = new Search(search_url);
        this.$search = $("#search");
        this.$table = $("#pos_transaction_list");
        this.$tbody = $("#pos_transaction_list tbody");
        this.$table_empty = $(".table-empty");
        this.$pages = $("#pages");
        
        this.triggerEvents();
    }

    triggerEvents(){
        this.$search.on("keyup", this.requestProduct);        
    }
    
    requestProduct(event) {
        let objSearchParam = {
            q: _this.$search.val(),
        };

        _this.ObjectSearch.appendParam(objSearchParam);

        $.get(
            _this.ObjectSearch.url,
            _this.ObjectSearch.param,
            function (response) {
                _this.requestProductResponse(response);
            }
        );
    }

    requestProductResponse(response) {
        response = JSON.parse(response);
        this.$tbody.html(response.rows_html);
        this.$pages.html(response.links_html);
        toggletableEmpty(_this.$tbody, _this.$table_empty);
    }
}

let objPosTransaction = new PosTransaction();
const _this = objPosTransaction;