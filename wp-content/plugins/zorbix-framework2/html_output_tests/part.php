<?php
echo 'part';
ob_start();
?>

[part jump_num=1 bg_color="green"][/part]

[part jump_num=1 bg_color="green" image_id=2333][/part]

<?php echo( do_shortcode( ob_get_clean() ) );