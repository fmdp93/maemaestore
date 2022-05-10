$(function(){
    let $view_details = $("#inventory_orders .view-details");
    let $modal_body = $("#details-modal tbody");
    $view_details.on("click", loadModal)

    function loadModal(event){
        let io_id = $(this).data('io-id');
        $.get('/inventory/order-products', {io_id: io_id}, function(response){
            let parsed = JSON.parse(response);
            $modal_body.html(parsed.modal_content);
        });
    }
});