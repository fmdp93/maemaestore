export function toggletableEmpty($tbody, $table_empty) {
    if ($tbody.html() == false) {
        $table_empty.removeClass('d-none');
        $table_empty.addClass('d-block');
    } else {
        $table_empty.removeClass('d-block');
        $table_empty.addClass('d-none');
    }    
}
