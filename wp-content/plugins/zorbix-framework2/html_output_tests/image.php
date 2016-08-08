<?php
$str = <<<EOF

	<!-- Plain -->
	[image image_id=2276][/image]


	<!-- Circle -->
	[image image_id=2276 circle=true size="pixo_300_square"][/image]

	<!-- Size-->
	[image image_id=2276 size="pixo_300_square"][/image]


EOF;

echo( do_shortcode( $str ) );