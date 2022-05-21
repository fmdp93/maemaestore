import { toggletableEmpty } from "/js/function.js";

class ArchiveInvItems{
    constructor(){
        // Search variables
        this.ObjectSearch = new Search(search_url);
        this.$search = $("#search");
        this.$table = $("#archive_inv_item_list");
        this.$tbody = $("#archive_inv_item_list tbody");
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
            unarchive_inv_item_action: unarchive_inv_item_action,
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

let objArchiveInvItems = new ArchiveInvItems();
const _this = objArchiveInvItems;