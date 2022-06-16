export function toggletableEmpty($tbody, $table_empty) {
    if ($tbody.html() == false) {
        $table_empty.removeClass("d-none");
        $table_empty.addClass("d-block");
    } else {
        $table_empty.removeClass("d-block");
        $table_empty.addClass("d-none");
    }
}

export function preventPlusMinus(event) {
    let key = event.keyCode;
    let prevented_keys = [109, 107, 189, 187];
    if ($.inArray(key, prevented_keys) > -1) {
        return false;
    }
}

export function increaseNumByPercent(number, percent) {
    return number * (percent / 100 + 1);
}

export function percentageOfNum(number, percentage) {
    return number * (percentage / 100);
}

export function setPosHotkeys(event, handler) {
    if (hotkeys.isPressed(18) && hotkeys.isPressed("r")) {
        $("#btn-return-refund")[0].click();
    }

    if (hotkeys.isPressed(18) && hotkeys.isPressed("a")) {
        $("#add-item")[0].click();
    }
    if (hotkeys.isPressed(18) && hotkeys.isPressed("c")) {
        $("#clear-table")[0].click();
    }

    if (hotkeys.isPressed(18) && hotkeys.isPressed("t")) {
        $("#btn-transactions")[0].click();
    }
}

export function falsyToZero(x){
    return x ? x : 0;
}

let last = +new Date();

export function slowerRequest(func){    
    const now = +new Date();
    if (now - last > 1500) { // 5 seconds
        last = now;
        func();
    }
}

export function throttle(func, wait, options) {
    var context, args, result;
    var timeout = null;
    var previous = 0;
    if (!options) options = {};
    var later = function() {
      previous = options.leading === false ? 0 : Date.now();
      timeout = null;
      result = func.apply(context, args);
      if (!timeout) context = args = null;
    };
    return function() {
      var now = Date.now();
      if (!previous && options.leading === false) previous = now;
      var remaining = wait - (now - previous);
      context = this;
      args = arguments;
      if (remaining <= 0 || remaining > wait) {
        if (timeout) {
          clearTimeout(timeout);
          timeout = null;
        }
        previous = now;
        result = func.apply(context, args);
        if (!timeout) context = args = null;
      } else if (!timeout && options.trailing !== false) {
        timeout = setTimeout(later, remaining);
      }
      return result;
    };
  };