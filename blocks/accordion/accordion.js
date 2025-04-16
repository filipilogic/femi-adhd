jQuery(document).ready(function ($) {

  // Accordion
  $(".il_accordion-header").click(function () {
    $(this).siblings(".il_accordion-body").slideToggle();
    $(this).parent('.il_accordion-item ').toggleClass('open')
});

});