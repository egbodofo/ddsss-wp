<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="text" class="sf-input" name="s" value="<?php echo get_search_query() ?>" placeholder="<?php echo esc_attr_x( 'Search..', 'text input', 'lava' ); ?>">
	<button type="submit" class="sf-submit" aria-label="<?php echo esc_attr_x( 'Submit', 'submit button', 'lava' ); ?>"><i class="material-icons">search</i></button>
</form>