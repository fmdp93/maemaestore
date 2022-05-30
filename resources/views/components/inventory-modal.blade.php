@php
    use App\Http\Controllers\InventoryController;
@endphp
@if (count($half_stock_products))
    <div id="inventory-alert-modal">
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Inventory Alert</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="fs-3">Some of your product/s falls below half of max stock.
                        <p>
                            <a href="{{ action([InventoryController::class, 'purchaseOrder']) }}?request_half_stock=1"
                                class="btn btn-button px-4 py-3">Order products now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
