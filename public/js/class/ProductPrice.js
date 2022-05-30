import * as func from "/js/function.js";

export class ProductPrice{
    constructor(){
        this.$base_price = $("#base_price");
        this.$tax = $("#tax");
        this.$markup = $("#markup");
        this.$selling_price = $("#selling_price");     
        
        this.triggerEvents();
    }
    triggerEvents(){
        let _this = this;
        this.$base_price.on("keydown change", function (event) {
            if(func.preventPlusMinus(event) == false){
                return false;
            }

            _this.updateSellingPrice(event);
        });
        this.$tax.on("keydown change", function (event) {
            if(func.preventPlusMinus(event) == false){
                return false;
            }

            _this.updateSellingPrice(event);
        });
        this.$markup.on("keydown change", function (event) {
            if(func.preventPlusMinus(event) == false){
                return false;
            }
            
            _this.updateSellingPrice(event);
        });
        this.$selling_price.on("keydown", function (event) {
            if(func.preventPlusMinus(event) == false){
                return false;
            }
        });
    }

    updateSellingPrice(event) {
        let _this = this;
        let defer = $.Deferred();
        let selling_price = 0;
        let filtered = defer.then(function () {
            let base_price = parseFloat(_this.$base_price.val()) || 0;
            let tax = parseFloat(_this.$tax.val()) || 0;
            let markup = parseFloat(_this.$markup.val()) || 0;
            markup = func.percentageOfNum(base_price, markup);
            let price_with_tax = func.increaseNumByPercent(base_price, tax);
            selling_price = price_with_tax + markup;
        });

        defer.resolve();
        filtered.done(function(){
            _this.$selling_price.val(sprintf("%.2f", selling_price));
        });        
    }
}