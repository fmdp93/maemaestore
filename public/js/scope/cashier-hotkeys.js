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

hotkeys("*", function (event, handler) {    
    if (hotkeys.isPressed(18) && hotkeys.isPressed("r")) {
        $("#btn-return-refund")[0].click();
    }
    
    if (hotkeys.isPressed(18) && hotkeys.isPressed("a")) {
        $("#add-item")[0].click();
    }
    if (hotkeys.isPressed(18) && hotkeys.isPressed("c")) {
        $("#clear-table")[0].click();
    }
});
