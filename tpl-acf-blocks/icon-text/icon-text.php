<?php $icon_text = get_field( 'icon_text' ); ?>

<div class="block__icon_text">
    <div class="container">
        <div class="container_grid">
            <div class="is_10 sm_start_1_cols_12">
	            <?php if ( $icon_text['title'] ) : ?>
                    <h2><?php echo esc_html($icon_text['title']); ?></h2>
	            <?php endif; ?>

                <div class="cards">
                    <?php foreach ($icon_text['cards'] as $card) : ?>
                        <div class="card">
	                        <?php if ( $card['icon'] ) :
		                        $img_id = $card['icon']['id'];
		                        $file_type = wp_check_filetype( get_attached_file( $img_id ) );
		                        $is_svg = $file_type['ext'] === 'svg';

		                        if ( $is_svg ) :
			                        $svg_data = file_get_contents( get_attached_file( $img_id ) ); ?>
                                    <figure class="card__icon">
				                        <?php echo $svg_data ?>
                                    </figure>
		                        <?php else : ?>
                                    <figure class="card__icon">
				                        <?php echo wp_get_attachment_image( $img_id, 'full', false, array( 'alt' => get_alt( $img_id ), 'class' => 'object_fit' ) ); ?>
                                    </figure>
		                        <?php endif; ?>
	                        <?php endif; ?>

                            <h4 class="card__title"><?php echo esc_html($card['title']); ?></h4>

                            <p class="card__text"><?php echo esc_html($card['text']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>