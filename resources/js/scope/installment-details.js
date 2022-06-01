import * as func from "/js/function.js";

class InstallmentDetails{
    constructor(){
        this.$pay_amount = $("#pay_amount");
        
        this.triggerEvents();
    }

    triggerEvents(){
        this.$pay_amount.on("keydown", func.preventPlusMinus);
    }
}

let objInstallmentDetails = new InstallmentDetails();
const _this = objInstallmentDetails;