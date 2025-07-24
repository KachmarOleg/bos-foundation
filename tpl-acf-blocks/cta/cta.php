<?php $cta = get_field( 'cta' ); ?>

<div class="block__cta">
    <div class="container">
        <div class="container_grid">
            <div class="is_10 sm_start_1_cols_12">
                <div class="inner">
                    <?php if ( $cta['title'] ) : ?>
                        <h2><?php echo esc_html($cta['title']); ?></h2>
                    <?php endif; ?>

                    <?php if ( $cta['text'] ) : ?>
                        <p><?php echo esc_html($cta['text']); ?></p>
                    <?php endif; ?>

                    <?php if ( $cta['button'] ) : ?>
                        <a href="<?php echo esc_url( $cta['button']['url'] ); ?>" class="button secondary" target="<?php echo $cta['button']['target'] ? : '_self'; ?>"><?php echo esc_html( $cta['button']['title'] ); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>