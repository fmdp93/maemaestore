export function toggletableEmpty($tbody, $table_empty) {
    if ($tbody.html() == false) {
        $table_empty.removeClass('d-none');
        $table_empty.addClass('d-block');
    } else {
        $table_empty.removeClass('d-block');
        $table_empty.addClass('d-none');
    }    
}

export function preventPlusMinus(event) {
    let key = event.keyCode;
    let prevented_keys = [109, 107, 189, 187];
    if ($.inArray(key, prevented_keys) > -1) {        
        return false;
    }
}

export function increaseNumByPercent(number, percent){
    return number * (percent / 100 + 1);
}

export function percentageOfNum(number, percentage){
    return number * (percentage / 100)
}