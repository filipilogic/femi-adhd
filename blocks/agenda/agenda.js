jQuery(document).ready(function ($) {

    // Tabs
    $('.il_tabs_nav li:first-child').addClass('active');
    $('.il_tabs_nav a').click(function (e) {

        e.preventDefault();
        // Check for active
        let tabLabels =  $(this.closest('.container')).find('.il_tabs_nav li');
        tabLabels.removeClass('active');
        $(this).parent().addClass('active');

        // Display active tab
        let currentTab = $(this).data('tab');
        let currentsTabContent = $(this.closest('.container')).find('.il_tab');
        currentsTabContent.hide();
        $.each(currentsTabContent, (key, tab) => {
            let tabContentIndex = $(tab).data('tab');
            if(tabContentIndex === currentTab ) {
                $(tab).show();
            }
        });

        return false;
    });

});