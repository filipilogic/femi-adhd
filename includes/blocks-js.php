<?php

/* Load the JS for the blocks we use on the page */ 

add_action('wp_enqueue_scripts', 'load_blocks_scripts');

function load_blocks_scripts() {
    if (function_exists('get_field')) {
        if (is_singular()) {
            $current_page_object = get_queried_object();
            if ($current_page_object && is_object($current_page_object) && property_exists($current_page_object, 'post_type')) {
                $post_content = $current_page_object->post_content;
                $blocks = parse_blocks($post_content);
                $blocks_slugs_unique = [];
 
                if ($blocks) {
                    foreach ($blocks as $block) {
                        $block_name = $block['blockName'];
                        $block_type_name = explode('/', $block_name);
                        
                        if (count($block_type_name) >= 2) {
                            $block_type = $block_type_name[0];
                            $block_slug = $block_type_name[1];
 
                            if ($block_type === 'acf') {
                                $blocks_slugs_unique[$block_slug] = $block_slug;
                            }

                            if ($block_slug === 'group') {
                                // Fetch inner blocks
                                $inner_blocks = $block['innerBlocks'];
                                foreach ($inner_blocks as $inner_block) {
                                    $inner_block_name = $inner_block['blockName'];
                                    $inner_block_type_name = explode('/', $inner_block_name);

                                    if (count($inner_block_type_name) >= 2) {
                                        $inner_block_slug = $inner_block_type_name[1];
                                        $blocks_slugs_unique[$inner_block_slug] = $inner_block_slug;
                                    }
                                }
                            }
                        }
                    }
 
                    if ($blocks_slugs_unique) {
                        foreach ($blocks_slugs_unique as $block_unique_slug) {
                            $script_path = get_stylesheet_directory() . '/blocks/' . $block_unique_slug . '/' . $block_unique_slug . '.js';
                            $script_uri = get_stylesheet_directory_uri() . '/blocks/' . $block_unique_slug . '/' . $block_unique_slug . '.js';
                            if (file_exists($script_path)) {
                                wp_enqueue_script($block_unique_slug . "-script", $script_uri, array('jquery'), '1.0', true);
                            }
                        }
                    }
                }
            }
        }
    }
}
 