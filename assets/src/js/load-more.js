jQuery(document).ready(function($) {
    $('.load-more-button').each(function() {
        var $button = $(this);
        var blockId = $button.data('block-id');
        var blockType = $button.data('block-type');
        var $section = $('[data-block-id="' + blockId + '"]');
        var $container = $section.find('.il_inner_posts_container');
        
        // Get block-specific data
        var blockData = window['loadMoreData_' + blockId];
        
        // Check if blockData exists before proceeding
        if (!blockData) {
            console.error('No data found for block:', blockId);
            return;
        }

        var state = {
            page: 1,
            loading: false,
            totalPosts: blockData.totalPosts,
            postsPerPage: blockData.postsPerPage,
            loadedPosts: blockData.postsPerPage
        };

        $button.on('click', function() {
            if (!state.loading && state.loadedPosts < state.totalPosts) {
                state.loading = true;
                state.page++;

                var ajaxData = {
                    action: blockType === 'blog' ? 'load_more_posts_blog_block' : 'load_more_posts_related_block',
                    block_id: blockId,
                    block_type: blockType,
                    page: state.page,
                    posts_per_page: state.postsPerPage
                };

                // Add block-specific data
                if (blockData.extraData) {
                    Object.assign(ajaxData, blockData.extraData);
                }

                $.ajax({
                    url: ajaxVars.ajaxurl,
                    type: 'post',
                    data: ajaxData,
                    success: function(response) {
                        if (response) {
                            $container.append(response);
                            state.loading = false;
                            state.loadedPosts += state.postsPerPage;
                            if (state.loadedPosts >= state.totalPosts) {
                                $button.hide();
                            }
                        } else {
                            $button.hide();
                        }
                    }
                });
            }
        });
    });
});
