					<form class="search-form" method="get" action="<?php echo esc_url( home_url() ) ?>/">
						<input class="search-box" type="text"
						       placeholder="<?php esc_html_e('Search...', 'pixo' ); ?>" id="s" name="s"
						       value="<?php the_search_query(); ?>"/>
						<button class="search-button" type="submit" value="Search"><i class="fa fa-search"></i></button>
					</form>
