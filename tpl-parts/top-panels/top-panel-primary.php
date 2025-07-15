<?php
$thumb_id = get_post_thumbnail_id( get_the_ID() );

$page_banner = get_field('page_banner');
$type = isset($page_banner['type'])  ? $page_banner['type'] : 'primary';
$title = isset($page_banner['title'])  ? $page_banner['title'] : '';
$subtitle = isset($page_banner['subtitle'])  ? $page_banner['subtitle'] : '';
$button = isset($page_banner['button'])  ? $page_banner['button'] : '';
?>

<section class="top_panel top_panel__<?php echo esc_html($type); ?>">
	<?php if ( has_post_thumbnail( get_the_ID() ) ) : ?>
		<figure>
			<?php echo wp_get_attachment_image( $thumb_id, 'full', false, array( 'alt' => get_alt( $thumb_id ), 'class' => 'object_fit' ) ); ?>
		</figure>
	<?php endif; ?>

	<div class="container">
        <div class="container_grid">
            <div class="start_4_cols_6 text_center">
                <h1><?php echo $title ?: get_the_title(); ?></h1>

                <?php if ( $subtitle ) : ?>
                    <h2 class="subtitle"><?php echo $subtitle ?></h2>
                <?php endif; ?>
                
                <?php if ( $button ) : ?>
                    <a href="<?php echo esc_url( $button['url'] ); ?>" class="button" target="<?php echo $button['target'] ? : '_self'; ?>"><?php echo esc_html( $button['title'] ); ?></a>
                <?php endif; ?>
            </div>
        </div>
	</div>
</section>
