import { objBarcodeReader } from "/js/scope/barcode_reader.js";
import { objInventory } from "/js/scope/inventory.js";

class CashierInventory {
    constructor() {
        // BarcodeReader vars
        this.objBarcodeReader = objBarcodeReader;
        this.objBarcodeReader.$search = objInventory.$search;
        this.objBarcodeReader.then_callback = this.objBarcodeReader.changeSearch;
        this.objBarcodeReader.done_callback = objInventory.requestProduct;
    }
}

let objCashierInventory = new CashierInventory();
