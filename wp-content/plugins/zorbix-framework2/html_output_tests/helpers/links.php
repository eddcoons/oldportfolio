
<?php

// get_opening_anchor / get_closing_anchor - 'http://google.co.uk||_blank||hello'
$link = 'http://google.co.uk||_blank||hello';
echo zorbix_sc::get_opening_anchor( $link );
echo zorbix_sc::get_closing_anchor( $link );

echo "\n";
// get_opening_anchor / get_closing_anchor - 'http://google.co.uk||_blank||hello'
$link = 'http://google.co.uk||_blank||hello';
zorbix_sc::print_opening_anchor( $link );
zorbix_sc::print_closing_anchor( $link );
