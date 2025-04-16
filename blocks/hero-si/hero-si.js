jQuery(document).ready(function ($) {

    // Home Hero Triggers

    const siTrigger = $('.si_trigger');
    const slide = $('.il_slidein');
    const siContainer = $('.si_container');
    const siClose = $('.si_close');

    const siSlide = (e) => {
        e.preventDefault();
        let current = $(e.currentTarget);
        let currentIndex = current.data('index');
        let slides = current.closest(siContainer).find(slide);
        let triggers = current.closest(siContainer).find(siTrigger);

        if(current.hasClass('si_open')) return false;

        $.each(slides, (key, slide) => {
            let slideIndex = $(slide).data('index');
            if(currentIndex === slideIndex) {
                triggers.removeClass('si_open');
                current.addClass('si_open');
                slides.slideUp().removeClass('si_open');
                $(slide).slideDown('si_open');
            }
        });
    }

    siSlideDown =  (e) => {
        e.preventDefault();
        let current = $(e.currentTarget);
        let slides = current.closest(siContainer).find(slide);
        let triggers = current.closest(siContainer).find(siTrigger);
        slides.slideUp();
        slides.removeClass('si_open');
        triggers.removeClass('si_open');
    };

    siTrigger.on('click', siSlide);
    siClose.on('click', siSlideDown);

});