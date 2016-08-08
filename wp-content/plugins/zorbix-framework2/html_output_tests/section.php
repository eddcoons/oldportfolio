<?php ob_start(); ?>

<!-- Tint -->
[section tint="tint-black"][/section]




<!-- Fullscreen -->
	[section full_height=true]

<!-- Center Contents-->

	[section center_contents=true]

	<!-- Padding Top & Bottom -->
	[section type="sect" padding="100px 0 100px"]

	<!-- Padding & bg -->
	[section bg_id="2333" padding="100px 0 100px"][/section]

	[section bg_id="2333" tint="tint-blue-black" padding="100px 0 100px"]


	<!-- Padding -->
	[section type="sect" padding="90px"]
	[section padding="100px 200px"][/section]

	[section type="sect" padding_top="90px"]

	[section type="sect" bg_size=contain ]
	[section type="sect" bg_size=contain ]


	[section full_height="true" bg_size="bg-size-cover" video_type="upload" youtube_link="http://www.youtube.com/watch?v=sK2e42jzohk" mp4_url="4200"][/section]

<?php echo( do_shortcode( ob_get_clean() ) );
