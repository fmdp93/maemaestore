hotkeys.filter = function (event) {
    return true;
};

hotkeys("f1, f2, f3, f4, f8, f9", function (event, handler) {
    // Prevent the default refresh event under WINDOWS system
    event.preventDefault();
    // console.log(hotkeys.getPressedKeyCodes());
    switch (handler.key) {
        case "f1":
            $("#admin_nav a:nth-child(1)")[0].click();
            break;
        case "f2":
            $("#admin_nav a:nth-child(2)")[0].click();
            break;
        case "f3":
            $("#admin_nav a:nth-child(3)")[0].click();
            break;
        case "f4":
            $("#admin_nav a:nth-child(4)")[0].click();
            break;
        case "f8":
            $("#admin_nav a:nth-child(5)")[0].click();
            break;
        case "f9":
            $("#admin_nav a:nth-child(6)")[0].click();
            break;
    }
});

hotkeys("*", function (event, handler) {
    if (hotkeys.isPressed(18) && hotkeys.isPressed("v")) {
        $("#btn-deliveries")[0].click();
    }
});