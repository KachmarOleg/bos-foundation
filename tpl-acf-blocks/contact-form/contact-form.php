<?php $contact_form = get_field( 'contact_form' ); ?>

<div class="block__contact_form">
    <div class="container">
        <div class="container_grid">
            <div class="is_6 sm_start_2_cols_10">
	            <?php if ( $contact_form['text'] ) : ?>
                    <div class="content last_no_spacing">
			            <?php echo wp_kses_post($contact_form['text']); ?>
                    </div>
	            <?php endif; ?>

	            <?php if ( $contact_form['shortcode'] ) : ?>
		            <?php echo do_shortcode( $contact_form['shortcode'] ); ?>
	            <?php endif; ?>
            </div>
        </div>
    </div>
</div>