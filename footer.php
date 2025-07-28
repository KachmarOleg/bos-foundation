</main>

<?php
$footer = get_field('footer', 'option');
$phone_raw = $footer['contact_details']['phone_number'];
$phone_clean = sanitize_phone_for_tel( $phone_raw );

$locations = get_nav_menu_locations();

$menu_quick_links = '';
$menu_policies = '';

if ( isset( $locations['quick_links'] ) ) {
	$menu_obj = wp_get_nav_menu_object( $locations['quick_links'] );
	if ( $menu_obj && ! is_wp_error( $menu_obj ) ) {
		$menu_quick_links = $menu_obj->name;
	}
}

if ( isset( $locations['policies'] ) ) {
	$menu_obj = wp_get_nav_menu_object( $locations['policies'] );
	if ( $menu_obj && ! is_wp_error( $menu_obj ) ) {
		$menu_policies = $menu_obj->name;
	}
}
?>

<footer class="footer">
    <div class="container flex">
        <div class="container_grid">
            <div class="start_2_cols_3 sm_start_1_cols_6">
				<?php if ( $footer['logo'] ) :
					$img_id = $footer['logo']['id']; ?>
                    <figure class="footer__logo">
						<?php echo wp_get_attachment_image( $img_id, 'full', false, array( 'alt' => get_alt( $img_id ), 'class' => 'object_fit' ) ); ?>
                    </figure>
				<?php endif; ?>

                <div class="social_and_contacts">
	                <?php echo wp_kses_post( so_me() ); ?>

                    <div class="contact_details">
	                    <?php if ( $footer['contact_details']['email'] ) : ?>
                            <span>
                                <a href="mailto:<?php echo esc_url( $footer['contact_details']['email'] ); ?>" class="" target="_blank"><?php echo esc_html( $footer['contact_details']['email'] ); ?></a>
                            </span>
	                    <?php endif; ?>

	                    <?php if ( $footer['contact_details']['phone_number'] ) : ?>
                            <span>
                                <a href="tel:<?php echo esc_attr( $phone_clean ); ?>" class="" target="_blank"><?php echo esc_html( $footer['contact_details']['phone_number'] ); ?></a>
                            </span>
	                    <?php endif; ?>

                        <?php if ( $footer['contact_details']['address'] ) : ?>
                            <a href="<?php echo esc_url( $footer['contact_details']['address']['url'] ); ?>" class="" target="<?php echo $footer['contact_details']['address']['target'] ? : '_self'; ?>"><?php echo esc_html( $footer['contact_details']['address']['title'] ); ?></a>
                        <?php endif; ?>
                    </div>

                </div>
            </div>

            <div class="start_7_cols_5 sm_start_7_cols_6">
                <div class="footer__menus">

                    <div class="footer__menu">
						<?php if ( $menu_quick_links ) : ?>
                            <h5><?php echo esc_html( $menu_quick_links ); ?></h5>
						<?php endif; ?>

						<?php wp_nav_menu( array(
							'container'      => false,
							'items_wrap'     => '<ul class="">%3$s</ul>',
							'theme_location' => 'quick_links'
						) ); ?>
                    </div>

                    <div class="footer__menu">
						<?php if ( $menu_policies ) : ?>
                            <h5><?php echo esc_html( $menu_policies ); ?></h5>
						<?php endif; ?>

						<?php wp_nav_menu( array(
							'container'      => false,
							'items_wrap'     => '<ul class="">%3$s</ul>',
							'theme_location' => 'policies'
						) ); ?>
                    </div>

                </div>
            </div>
        </div>

        <!--	    <div class="copy_right">© --><?php // bloginfo(); ?><!-- --><?php // echo esc_html( date( 'Y' ) ); ?><!--</div>-->

    </div>
</footer>

<?php wp_footer(); ?>

</body>
</html>