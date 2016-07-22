new WOW().init();

$(document).ready(function(){
	$(document).foundation();
	$(".gallery-icon a").colorbox({rel:"gallery"});
  
//	$(".youtube").colorbox({iframe:true, innerWidth:640, innerHeight:390});
/*
	var slider = $("#slider");
		slider.owlCarousel({
			autoPlay: false,
			pagination: false,
			navigation : false, // Show next and prev buttons
			slideSpeed : 300,
			paginationSpeed : 400,
			singleItem: true
	});  

	$(".slider-next").click(function(){
	  slider.trigger('owl.next');
	});
	$(".slider-prev").click(function(){
	  slider.trigger('owl.prev');
	});
*/

/*
	<a href="javascript:void(0);" 
		data-modal-content="<?php the_sub_field('full_story_content'); ?>" 
		data-modal-title="<?php the_sub_field('title'); ?>" 
		class="modal-pop"><i class="fa fa-comments"></i> LINK TEXT</a>																			


	$('body').on('click','.modal-pop',function(e) {
		e.preventDefault();
	
		var modal = $('#modal'),
			modalmsg = $(this).data('modal-content');
			modaltitle = $(this).data('modal-title');

		if (modaltitle !== '') {
			// add modal msg to body if it exists
			modal.find('#modal-body').empty().html(modalmsg).prepend('<h3>'+modaltitle+'</h3>');
		
		} else {
			// add modal msg to body if it exists
			modal.find('#modal-body').empty().html(modalmsg);
		
		}

			modal.foundation('reveal','open');																

		modal.on('closed', function(){ 
			$('.reveal-modal-bg').hide();
		}); // end on close

	}); // end oo-modal click function

*/

});  // end docready
