<?php
// get fields
$text_and_image = get_field( 'text_and_image' );
if ( $text_and_image['position'] === 'img_right' ) {
    $text_classes = 'block__txt_img__text start_2_cols_4 sm_start_1_cols_5';
    $image_classes = 'block__txt_img__image start_7_cols_5 sm_start_7_cols_6';
} else {
	$text_classes = 'block__txt_img__text start_8_cols_4 sm_start_8_cols_5';
	$image_classes = 'block__txt_img__image start_2_cols_5 sm_start_1_cols_5';
}
$position = $text_and_image['position'] === 'img_right' ? '' : ' reverse' ;
?>


<div class="block__txt_img">
    <div class="container">
        <div class="container_grid<?php echo esc_html($position); ?>">
            <div class="<?php echo esc_html($text_classes); ?>">
	            <?php echo wp_kses_post($text_and_image['text']); ?>
            </div>

            <div class="<?php echo esc_html($image_classes); ?>">
                <?php if ( $text_and_image['image'] ) :
                    $img_id = $text_and_image['image']['id']; ?>
                    <figure>
                        <?php echo wp_get_attachment_image( $img_id, 'full', false, array( 'alt' => get_alt( $img_id ), 'class' => 'object_fit' ) ); ?>
                    </figure>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>