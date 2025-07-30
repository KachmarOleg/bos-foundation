<?php
get_header();
/* Template Name: Narrow */
?>

<?php get_template_part( 'tpl-parts/top-panels/top-panel', 'primary' ); ?>

<div class="container">
	<div class="container_grid">
		<div class="is_6 sm_start_2_cols_10">
			<?php get_template_part( 'tpl-parts/gutenberg' ); ?>
		</div>
	</div>
</div>

<?php

$file_name = basename( __FILE__, '.php' );
tpl_style( $file_name );

get_footer();
?>
