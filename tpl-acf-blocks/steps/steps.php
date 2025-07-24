<?php $steps = get_field( 'steps' ); ?>

<div class="block__steps">
    <div class="container">
        <div class="container_grid">
            <div class="is_10 sm_start_1_cols_12">
                <h2><?php echo esc_html($steps['title']); ?></h2>

                <?php if ( $steps['items'] ) : ?>
                    <div class="step_items">
		                <?php foreach ($steps['items'] as $step) : ?>
                            <div class="step_item">
                                <h3 class="step_item__title h4"><?php echo esc_html($step['title']); ?></h3>
                                <p><?php echo esc_html($step['description']); ?></p>
                            </div>
		                <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>