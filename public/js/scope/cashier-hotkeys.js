import * as func from "/js/function.js";

hotkeys.filter = function (event) {
    return true;
};

hotkeys("f1, f2, f3, f9", function (event, handler) {
    // Prevent the default refresh event under WINDOWS system
    event.preventDefault();
    // console.log(hotkeys.getPressedKeyCodes());
    switch (handler.key) {
        case "f1":
            $("#cashier_nav a:nth-child(1)")[0].click();
            break;
        case "f2":
            $("#cashier_nav a:nth-child(2)")[0].click();
            break;
        case "f3":
            $("#cashier_nav a:nth-child(3)")[0].click();
            break;
        case "f9":
            $("#cashier_nav a:last-child")[0].click();
            break;
    }
});

hotkeys("*", function(event, handler){
    func.setPosHotkeys(event, handler);
});