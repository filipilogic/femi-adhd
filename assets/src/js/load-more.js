jQuery(document).ready(function ($) {
  // Blog block category filter buttons (when "Show categories list" is on)
  $('[data-block-type="blog"]').each(function () {
    var blockId = $(this).data('block-id')
    var blockData = window['loadMoreData_' + blockId]
    if (!blockData || !blockData.showCategoriesList) return
    var $section = $(this)
    var $container = $section.find('.il_inner_posts_container')
    var $filters = $section.find('.blog-block-filters .filter-btn')
    if (!$filters.length) return
    $filters.on('click', function () {
      var $btn = $(this)
      var categoryId = parseInt($btn.data('category'), 10) || 0
      $filters.removeClass('active')
      $btn.addClass('active')
      $container.addClass('loading')
      var ajaxData = {
        action: 'load_more_posts_blog_block',
        block_id: blockId,
        block_type: 'blog',
        page: 1,
        posts_per_page: blockData.postsPerPage,
      }
      if (blockData.extraData) {
        Object.assign(ajaxData, blockData.extraData)
      }
      ajaxData.filter_category = categoryId
      ajaxData.return_json = 1
      $.ajax({
        url: ajaxVars.ajaxurl,
        type: 'post',
        data: ajaxData,
        success: function (response) {
          var html = ''
          var totalPosts = blockData.totalPosts
          var totalPages = blockData.totalPages
          if (response && response.success && response.data && response.data.html !== undefined) {
            html = response.data.html
            if (typeof response.data.totalPosts === 'number') totalPosts = response.data.totalPosts
            if (typeof response.data.totalPages === 'number') totalPages = response.data.totalPages
            blockData.totalPosts = totalPosts
            blockData.totalPages = totalPages
          } else if (response) {
            html = response
          }
          if (html !== '') {
            var $buttonsAfter = $container.find('.buttons-after-blog').detach()
            $container.html(html)
            if ($buttonsAfter.length) {
              $container.append($buttonsAfter)
            }
          }
          // Update Load More button visibility and state so it uses new totals
          var $loadMoreBtn = $section.find('.load-more-button')
          if ($loadMoreBtn.length) {
            var loadMoreState = $section.data('loadMoreState')
            if (loadMoreState) {
              loadMoreState.totalPosts = totalPosts
              loadMoreState.loadedPosts = blockData.postsPerPage
              loadMoreState.page = 1
            }
            if (totalPosts <= blockData.postsPerPage) {
              $loadMoreBtn.hide()
            } else {
              $loadMoreBtn.show()
            }
          }
          // Update numbered pagination
          var $paginationContainer = $section.find('.numbered-pagination-container')
          if ($paginationContainer.length && totalPages >= 0) {
            var paginationState = $paginationContainer.data('numberedPaginationState')
            if (paginationState) {
              paginationState.totalPages = totalPages
              paginationState.currentPage = 1
            }
            $paginationContainer.data('total-pages', totalPages)
            var $pageNumbers = $paginationContainer.find('.pagination-numbers')
            $pageNumbers.empty()
            for (var p = 1; p <= totalPages; p++) {
              $pageNumbers.append(
                $('<button class="pagination-number' + (p === 1 ? ' active' : '') + '" data-page="' + p + '">' + p + '</button>')
              )
            }
            $paginationContainer.find('.pagination-prev').prop('disabled', true)
            $paginationContainer.find('.pagination-next').prop('disabled', totalPages <= 1)
          }
          $container.removeClass('loading')
        },
        error: function () {
          $container.removeClass('loading')
        },
      })
    })
  })

  // Load More Button functionality
  $('.load-more-button').each(function () {
    var $button = $(this)
    var blockId = $button.data('block-id')
    var blockType = $button.data('block-type')
    var $section = $('[data-block-id="' + blockId + '"]')
    var $container = $section.find('.il_inner_posts_container')

    // Get block-specific data
    var blockData = window['loadMoreData_' + blockId]

    // Check if blockData exists before proceeding
    if (!blockData) {
      console.error('No data found for block:', blockId)
      return
    }

    var state = {
      page: 1,
      loading: false,
      totalPosts: blockData.totalPosts,
      postsPerPage: blockData.postsPerPage,
      loadedPosts: blockData.postsPerPage,
    }
    $section.data('loadMoreState', state)

    $button.on('click', function () {
      if (!state.loading && state.loadedPosts < state.totalPosts) {
        state.loading = true
        state.page++

        var ajaxData = {
          action:
            blockType === 'blog'
              ? 'load_more_posts_blog_block'
              : 'load_more_posts_related_block',
          block_id: blockId,
          block_type: blockType,
          page: state.page,
          posts_per_page: state.postsPerPage,
        }
        // Add block-specific data first, then set filter so it cannot be overwritten
        if (blockData.extraData) {
          Object.assign(ajaxData, blockData.extraData)
        }
        if (blockType === 'blog' && $section.find('.blog-block-filters .filter-btn.active').length) {
          ajaxData.filter_category = parseInt($section.find('.blog-block-filters .filter-btn.active').data('category'), 10) || 0
        }

        $.ajax({
          url: ajaxVars.ajaxurl,
          type: 'post',
          data: ajaxData,
          success: function (response) {
            if (response) {
              $container.append(response)
              state.loading = false
              state.loadedPosts += state.postsPerPage
              if (state.loadedPosts >= state.totalPosts) {
                $button.hide()
              }
            } else {
              $button.hide()
            }
          },
        })
      }
    })
  })

  // Numbered Pagination functionality
  $('.numbered-pagination-container').each(function () {
    var $paginationContainer = $(this)
    var blockId = $paginationContainer.data('block-id')
    var totalPages = parseInt($paginationContainer.data('total-pages'))
    var $section = $('[data-block-id="' + blockId + '"]').first()
    var $postsContainer = $section.find('.il_inner_posts_container')
    var $prevButton = $paginationContainer.find('.pagination-prev')
    var $nextButton = $paginationContainer.find('.pagination-next')
    var $pageNumbers = $paginationContainer.find('.pagination-numbers')

    // Get block-specific data
    var blockData = window['loadMoreData_' + blockId]

    if (!blockData) {
      console.error('No data found for block:', blockId)
      return
    }

    var state = {
      currentPage: 1,
      loading: false,
      totalPages: totalPages,
      postsPerPage: blockData.postsPerPage,
    }
    $paginationContainer.data('numberedPaginationState', state)

    // Update pagination UI
    function updatePaginationUI() {
      // Update active page number
      $pageNumbers.find('.pagination-number').removeClass('active')
      $pageNumbers
        .find('.pagination-number[data-page="' + state.currentPage + '"]')
        .addClass('active')

      // Update prev/next button states
      $prevButton.prop('disabled', state.currentPage === 1)
      $nextButton.prop('disabled', state.currentPage === state.totalPages)

      // Update data attribute
      $paginationContainer.data('current-page', state.currentPage)
    }

    // Load page content
    function loadPage(page) {
      if (
        state.loading ||
        page < 1 ||
        page > state.totalPages ||
        page === state.currentPage
      ) {
        return
      }

      state.loading = true
      state.currentPage = page

      // Add loading state
      $postsContainer.addClass('loading')

      var ajaxData = {
        action: 'load_more_posts_blog_block',
        block_id: blockId,
        block_type: 'blog',
        page: page,
        posts_per_page: state.postsPerPage,
        pagination_type: 'numbered',
      }
      // Add block-specific data first, then set filter so it cannot be overwritten
      if (blockData.extraData) {
        Object.assign(ajaxData, blockData.extraData)
      }
      if ($section.find('.blog-block-filters .filter-btn.active').length) {
        ajaxData.filter_category = parseInt($section.find('.blog-block-filters .filter-btn.active').data('category'), 10) || 0
      }

      $.ajax({
        url: ajaxVars.ajaxurl,
        type: 'post',
        data: ajaxData,
        success: function (response) {
          if (response) {
            // Replace content instead of appending
            // Keep buttons-after-blog if exists
            var $buttonsAfter = $postsContainer
              .find('.buttons-after-blog')
              .detach()
            $postsContainer.html(response)
            if ($buttonsAfter.length) {
              $postsContainer.append($buttonsAfter)
            }

            updatePaginationUI()

            // Scroll to top of block
            $('html, body').animate(
              {
                scrollTop: $section.offset().top - 100,
              },
              300
            )
          }
          state.loading = false
          $postsContainer.removeClass('loading')
        },
        error: function () {
          state.loading = false
          $postsContainer.removeClass('loading')
        },
      })
    }

    // Event handlers
    $prevButton.on('click', function () {
      loadPage(state.currentPage - 1)
    })

    $nextButton.on('click', function () {
      loadPage(state.currentPage + 1)
    })

    $pageNumbers.on('click', '.pagination-number', function () {
      var page = parseInt($(this).data('page'))
      loadPage(page)
    })

    // Initialize UI state
    updatePaginationUI()
  })
})
