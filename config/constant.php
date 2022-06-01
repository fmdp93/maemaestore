<?php 
defined('MODE_CASH') || define('MODE_CASH', 1);
defined('MODE_GCASH') || define('MODE_GCASH', 2);
defined('MODE_CREDIT_CARD') || define('MODE_CREDIT_CARD', 3);
defined('TERM_1_WEEK') || define('TERM_1_WEEK', 1);
defined('TERM_15_DAYS') || define('TERM_15_DAYS', 2);
defined('TERM_30_DAYS') || define('TERM_30_DAYS', 3);
defined('PATTERN_ID') || define('PATTERN_ID', '[0-9]+');

return [
  'per_page' => 10,
  'autocomplete_suggestion_count' => 5,
  'order_received' => 2,  
];