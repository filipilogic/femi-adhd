jQuery(document).ready(function ($) {

    // Init Lightbox Carousel

    const sliderCarousel = $('.carousel-main').flickity({
        // options
        cellAlign: 'left',
        contain: true,
        pageDots: false,
        draggable: false,
        hash: true,
        initialIndex: 1
    });

    // Slider popup

    const trigger = $(".il_lb_triggers a");
    const popup = $('.il_lb_carousel_wrap');
    const close = $('.il_lb_carousel_wrap .close');

    const openPopup = (e) => {
        e.preventDefault();
        let index = $(e.currentTarget).data('index');
        sliderCarousel.flickity('select', index);

        setTimeout(() => {
            popup.addClass('is-open');
        },200);
    }
    const closePopup = (e) => {
        e.preventDefault();
        popup.removeClass('is-open');
    }

    trigger.on('click', openPopup);
    close.on('click', closePopup);

});