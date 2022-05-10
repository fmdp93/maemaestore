class Products {
    constructor() {
        this.$products_list = $("#products_list tbody");
        this.$pages = $("#pages");
        this.ObjectSearch = new ModuleSearch(
            "/product/search",
            this.requestProduct
        );
        
        this.ObjectSearch.appendParam(JSON.stringify(this));
    }

    requestProduct(response) {
        response = JSON.parse(response);
        response._this.$products_list.html(response.rows_html);
        response._this.$pages.html(response.links_html);
        // console.log(response);
    }
}

Products = new Products();

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
