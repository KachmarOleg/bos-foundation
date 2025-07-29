<?php
// get fields
$custom_gallery   = get_field( 'custom_gallery' );
$gallery_title    = get_field( 'gallery_title' );
$gallery_subtitle = get_field( 'gallery_subtitle' );
if ( $custom_gallery ) :
?>
    <div class="custom_gallery">
        <div class="container">
            <div class="container_grid">

                <div class="start_2_cols_10 sm_start_1_cols_12">
	                <?php if ( $gallery_title ) : ?>
                        <h2><?php echo esc_html($gallery_title); ?></h2>
	                <?php endif; ?>

	                <?php if ( $gallery_subtitle ) : ?>
                        <p><?php echo esc_html($gallery_subtitle); ?></p>
	                <?php endif; ?>

                    <div class="block__custom_gallery">
		                <?php $g_i = 1; foreach ( $custom_gallery as $image ) : ?>
                            <figure class="block__custom_gallery_item">
                                <a href="<?php echo esc_url( $image['url'] ); ?>" data-fancybox="custom-gallery" aria-label="Open image <?php echo $g_i++; ?>">
					                <?php echo wp_get_attachment_image( $image['id'], 'full', false, array( 'class' => 'object_fit', 'alt' => get_alt( $image['id'] ) ) ); ?>
                                </a>
                            </figure>
		                <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>