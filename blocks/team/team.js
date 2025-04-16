jQuery(document).ready(function ($) {
    
    $(".il_team_member.il_member_has_learn_more .member_image").click(function () {
        $(".il_team_member.il_member_has_learn_more .member_image").parent().not(this).next(".member_text.t-open").slideToggle().removeClass('t-open');
        $(this).parent().next(".member_text").slideToggle().toggleClass('t-open');
        let member_data = $(this).parent().data('member');
        let element_id = '#' + member_data;
        let element = $(element_id);
		var windowsize = $(window).width();
        if (windowsize < 768) {
			setTimeout(() => { 
				$([document.documentElement, document.body]).animate({
					scrollTop: element.offset().top - 100
				}, 100);
			}, 400);
        } else {
			setTimeout(() => { 
				$([document.documentElement, document.body]).animate({
					scrollTop: element.offset().top
				}, 100);
			}, 400);
		}
    });
    $(".member_text .close").click(function () {
        $(this).parents('.member_text').slideToggle().removeClass('t-open');
        let member_data = $(this).parents('.member_text').attr('id');
        let member_id = '#' + member_data + '_id';
        let member_view = $(member_id);
        console.log(member_view)
        $([document.documentElement, document.body]).animate({
            scrollTop: member_view.offset().top
        }, 100);
    });

});