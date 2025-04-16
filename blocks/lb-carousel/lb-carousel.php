<?php ?>
<?php
$padding = get_field_object('padding');

if (have_rows('element')) : ?>
    <?php
    $class = 'lb_cb_nav_wrap il_block';
    if (!empty($padding)) {
        $class .=  ' ' . $padding['value'];
    }
    ?>
    <div class="il_lb_carousel_block">
        <div class="<?php echo $class; ?>">
            <?php get_template_part('components/background'); ?>
            <div class="container">
                <?php get_template_part('components/intro'); ?>
                <div class="il_lb_triggers">
                    <?php
                    $index = 0;
                    while (have_rows('element')) : the_row();
                    ?>
                        <?php $content_title = get_sub_field('content_title'); ?>
                        <a data-index="<?php echo $index; ?>" href="#<?php echo str_replace(' ', '', get_sub_field('content_title')); ?>"><span><svg xmlns="http://www.w3.org/2000/svg" width="26.43" height="26.43" viewBox="0 0 26.43 26.43">
                                    <path id="Path_1429" data-name="Path 1429" d="M26.43,10.694v5.042a.687.687,0,0,1-.687.687H16.423v9.319a.687.687,0,0,1-.687.687H10.694a.688.688,0,0,1-.687-.687V16.423H.687A.688.688,0,0,1,0,15.736V10.694a.687.687,0,0,1,.687-.687h9.319V.687A.688.688,0,0,1,10.694,0h5.042a.687.687,0,0,1,.687.687v9.319h9.319A.687.687,0,0,1,26.43,10.694Z" fill="#009688" />
                                </svg></span><?php echo $content_title; ?></a>
                    <?php
                        $index++;
                    endwhile;
                    ?>
                </div>
            </div>
        </div>
        <div class="il_lb_carousel_wrap">
            <span class="close"></span>
            <div class="il_lb_carousel carousel-main">
                <?php while (have_rows('element')) : the_row();

                    // Load sub field value.
                    $content_text = get_sub_field('content_text');
                    $content_title = get_sub_field('content_title'); ?>
                    <div class="il_lb_carousel_inner carousel-cell" id="<?php echo str_replace(' ', '', get_sub_field('content_title')); ?>">
                        <div class="il_lb_left">
                            <!-- Left empty intentionally to extend the block in the Theme version of it-->
                        </div>
                        <div class="il_lb_right">
                            <h2 class="title-style-1"><?php echo $content_title; ?></h2>
                            <div><?php echo $content_text; ?></div>
                            <?php get_template_part('components/buttons'); ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
<?php endif;
