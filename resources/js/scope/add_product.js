import {objBarcodeReader} from "/js/scope/barcode_reader.js";

class AddProduct {
    constructor() {
        // BarcodeReader vars
        this.$item_code = $("#item_code");
        this.objBarcodeReader = objBarcodeReader;
        this.objBarcodeReader.$item_code = this.$item_code;
        this.objBarcodeReader.then_callback = this.objBarcodeReader.changeItemCode;
        this.objBarcodeReader.done_callback = function(){};

        this.$new_item_code = $("#new_item_code");
    
        this.triggerEvents();        
    }

    triggerEvents() {
        this.$new_item_code.on("click", this.setCode);
    }    

    setCode(event){
        event.preventDefault();
        $.get('/product/get-item-code', {}, function(response){
            let parsed = JSON.parse(response);
            _this.$item_code.val(parsed.new_item_code);
        });
    }
}

let objAddProduct = new AddProduct();
const _this = objAddProduct;