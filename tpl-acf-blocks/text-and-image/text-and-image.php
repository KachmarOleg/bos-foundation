<?php
$text_and_image = get_field( 'text_and_image' );

if ( $text_and_image && $text_and_image['position'] === 'img_right' ) {
	$text_classes = 'block__txt_img__text start_2_cols_4 sm_start_1_cols_5';
	$image_classes = 'block__txt_img__image start_7_cols_5 sm_start_7_cols_6';
} else {
	$text_classes = 'block__txt_img__text start_8_cols_4 sm_start_8_cols_5';
	$image_classes = 'block__txt_img__image start_2_cols_5 sm_start_1_cols_5';
}

$position = isset($text_and_image['position']) && $text_and_image['position'] === 'img_right' ? '' : ' reverse';

$image_1 = !empty($text_and_image['images']['image_1']) ? $text_and_image['images']['image_1'] : false;
$image_2 = !empty($text_and_image['images']['image_2']) ? $text_and_image['images']['image_2'] : false;
$img_amount = !empty($text_and_image['images']['amount_of_images']) ? $text_and_image['images']['amount_of_images'] : 'one';

$image_1_class = $img_amount === 'two' ? 'image_1 object_fit' : 'object_fit';

$button = $text_and_image['text_content']['btn'];
?>

<div class="block__txt_img">
    <div class="container">
        <div class="container_grid<?php echo esc_attr($position); ?>">
            <div class="<?php echo esc_attr($text_classes); ?>">
                <div class="last_no_spacing">
	                <?php echo wp_kses_post($text_and_image['text_content']['text']); ?>
                </div>

                <?php if ( $button ) : ?>
                    <a href="<?php echo esc_url( $button['url'] ); ?>" class="button secondary" target="<?php echo $button['target'] ? : '_self'; ?>"><?php echo esc_html( $button['title'] ); ?></a>
                <?php endif; ?>
            </div>

            <div class="<?php echo esc_attr($image_classes); ?>">
				<?php if ( $image_1 ) :
					$img_id_1 = $image_1['id'];
					?>
                    <figure class="<?php echo ($image_2 && $img_amount === 'two') ? 'two_images' : 'one_image'; ?>">
						<?php echo wp_get_attachment_image( $img_id_1, 'full', false, array(
							'alt' => get_alt( $img_id_1 ),
							'class' => esc_attr($image_1_class)
						) ); ?>

						<?php if ( $image_2 && $img_amount === 'two' ) :
							$img_id_2 = $image_2['id'];
							echo wp_get_attachment_image( $img_id_2, 'full', false, array(
								'alt' => get_alt( $img_id_2 ),
								'class' => 'image_2 object_fit'
							) );
						endif; ?>
                    </figure>
				<?php endif; ?>
            </div>
        </div>
    </div>
</div>