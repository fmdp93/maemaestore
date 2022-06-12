import * as func from "/js/function.js";

export class ProductPrice{
    constructor(){
        this.$base_price = $("#base_price");
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
            let base_price = parseFloat(func.falsyToZero(_this.$base_price.val()));            
            let markup = parseFloat(func.falsyToZero(_this.$markup.val()));
            markup = func.percentageOfNum(base_price, markup);            
            selling_price = base_price + markup;
        });

        defer.resolve();
        filtered.done(function(){
            _this.$selling_price.val(sprintf("%.2f", selling_price));
        });        
    }
}