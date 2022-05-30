import { objBarcodeReader } from "/js/scope/barcode_reader.js";
import { toggletableEmpty } from "/js/function.js";
import { SupplierSearchAutocomplete } from "/js/decorator/SupplierSearchAutocomplete.js";

class PurchaseOrder {
    constructor() {
        // const _this = this;
        this.$total = $("#total");
        this.$input_total = this.$total.find("input");
        this.$shipping_fee = $("#shipping_fee");
        this.$tax = $("#tax");

        this.$vendor = $("#vendor");
        this.$company = $("#company");
        this.$contact = $("#contact");
        this.$address = $("#address");
        this.$supplier_search_id = $("#supplier_search_id");

        // autocomplete
        this.$supplier_search = $("#supplier_search");           
        this.objSupplierSearchAutocomplete = new SupplierSearchAutocomplete(this);        

        this.triggerEvents();
    }

    triggerEvents() {
        this.$shipping_fee.on("keyup change", this.updateTotal);
        this.$tax.on("keyup change", this.updateTotal);    
    }

    updateTotal() {
        let total = 0;
        let shipping_fee = parseFloat(_this.$shipping_fee.val()) || 0;
        let tax = parseFloat(_this.$tax.val()) || 0;
       
        total += shipping_fee + tax;
        _this.$input_total.val(sprintf("%.2f", total));
        _this.$total.find("span").html(sprintf("%.2f", total));
    }
}

let objPurchaseOrder = new PurchaseOrder();
const _this = objPurchaseOrder;