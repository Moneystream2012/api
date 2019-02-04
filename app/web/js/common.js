$(document).ready(function() {
	//Preloader
	$('#preloader').fadeOut('slow',function(){$(this).remove();});

	// Img
	$("img, a").on("dragstart", function(event) { event.preventDefault(); });

	// Header full page
	function fullPageBg() {
		$("#full-height").css("height", $(window).height() - 50);
	};

	if($(window).width() > 767) {
		fullPageBg();
	}

	// Header full page
	function fullPageHeader() {
		$("#main-header").css("height", $(window).height());
	};

	fullPageHeader();
	
	$(window).resize(function() {
		fullPageHeader();
	});
	
		// navbar
	$(window).scroll(function(){

	    if ($(window).scrollTop() > 0) {
	        $('#main-navbar').addClass('fixed');
	    } else {
	    	$('#main-navbar').removeClass('fixed');
	    }
	});
	$(window).resize(function() {
		if($(window).width() > 767) {
			fullPageBg();
		} else {
			$("#full-height").css("height", "100%");
		}
	});

	// MatchHeight
	$('.park-item, .benefits-item').matchHeight();

	// Knob
	$(".circle").knob({
		readOnly: true,
		width: 100,
		height: 100,
		displayInput: false,
		fgColor: '#26C8A9',
		bgColor: '#308274',
		thickness: '.14'
	});

	$(".big-circle").knob({
		readOnly: true,
		width: 200,
		height: 200,
		displayInput: false,
		fgColor: '#fff',
		bgColor: 'rgba(255,255,255,.5)',
		thickness: '.14'
	});

	setTimeout(function(){
		$('.big-circle,.circle').each(function() {
	       var $this = $(this);
	       var myVal = $this.attr("rel");
	       $this.knob({
	       });
	       $({
	          value: 0
	       }).animate({
	          value: myVal
	       }, {
	          duration: 1500,
	          easing: 'swing',
	          step: function() {
	             $this.val(Math.ceil(this.value)).trigger('change');
	          }
	       });
	   });
	}, 100);


	// Chat
    $('.add-message').submit(function() {
		// var text = $('textarea').val();
		// var avatar = '<i class="material-icons">person</i>';

		// // date
		// var d = new Date();
		// var month = d.getMonth()+1;
		// var day = d.getDate();
		// var date = (day<10 ? '0' : '') + day + '.' +
		//     (month<10 ? '0' : '') + month + '.' +
		//     d.getFullYear();

		// // Time
		// var time = d.getHours() + ":" + d.getMinutes();
		
		// var message = '<div class="message-item">' + 
		// '<div class="avatar">' + avatar + '</div>' + 
		// '<div class="date">' + time + '</div>' +
		// '<div class="text">' + text + '</div>' + 
		// '</div>'

		// $('.message-area').append(message);
		// $('.message-area').animate({scrollTop:999999999},0);
		// // $('.message-area').scrollTop(999999999);
		// $(".add-message").trigger("reset");
		
		return false;
	});

	$("#chat-message").keypress(function(e) {
		if(e.which == 13) {
			// var text = $(this).val();
			// var avatar = '<i class="material-icons">person</i>';

			// // date
			// var d = new Date();
			// var month = d.getMonth()+1;
			// var day = d.getDate();
			// var date = (day<10 ? '0' : '') + day + '.' +
			//     (month<10 ? '0' : '') + month + '.' +
			//     d.getFullYear();

			// // Time
			// var time = d.getHours() + ":" + d.getMinutes();
			
			// var message = '<div class="message-item">' + 
			// '<div class="avatar">' + avatar + '</div>' + 
			// '<div class="date">' + time + '</div>' +
			// '<div class="text">' + text + '</div>' + 
			// '</div>'

			// $('.message-area').append(message);
			// $('.message-area').animate({scrollTop:999999999},0);
			// //$('.message-area').scrollTop(999999999);
			// $(".add-message").trigger("reset");
			
			return false;
		}
	});

	// $("#chat-message").keypress(function(e) {
	// 	if ((event.keyCode == 10 || event.keyCode == 13) && event.ctrlKey) {
	// 		var txt = $(this);
	// 		txt.val( txt.val() + '\n');
	// 	}
	// });

	// Park Coins Section 
	// $('.park-coins-section .close-button, .close-park-button').click(function() {
	// 	$('.park-section .call-section').css('display', 'block');
	// 	$('.park-section').css('padding-bottom', '40px');
	// 	$('.park-coins-section').css('display', 'none');
	// 	$('.park-section .park-item').removeClass('active');
	// });

	$('.park-section .call-section, .park-section .park-item').click(function() {
		$('.park-coins-section').css('display', 'block');
		$('.park-section .call-section').css('display', 'none');
		$('.park-section').css('padding-bottom', '20px');
		$(this).parent('.col-md-4').find('.park-item').addClass('active');
	});

	$('.park-section .button-1, .park-item.item-1').click(function() {
		$( "#radio1" ).prop( "checked", true );
		var counter = $('.park-section .park-item.item-1 .counter').text();
		$('.park-coins-section .park-coins-item .rate').html(counter);
	});

	$('.park-section .button-2, .park-item.item-2').click(function() {
		$( "#radio2" ).prop( "checked", true );
		var counter = $('.park-section .park-item.item-2 .counter').text();
		$('.park-coins-section .park-coins-item .rate').html(counter);
	});

	$('.park-section .button-3, .park-item.item-3').click(function() {
		$( "#radio3" ).prop( "checked", true );
		var counter = $('.park-section .park-item.item-3 .counter').text();
		$('.park-coins-section .park-coins-item .rate').html(counter);
	});

	$('#radio1, .park-item.item-1').click(function() {
		if ($('input[name="radios1"]').is(':checked')) { 
			$('.park-section .park-item').removeClass('active');
			$('.park-section .park-item.item-1').addClass('active');
			var counter = $('.park-section .park-item.item-1 .counter').text();
			$('.park-coins-section .park-coins-item .rate').html(counter);
        }
	});

	$('#radio2, .park-item.item-2').click(function() {
		if ($('input[name="radios1"]').is(':checked')) { 
			$('.park-section .park-item').removeClass('active');
			$('.park-section .park-item.item-2').addClass('active');
			var counter = $('.park-section .park-item.item-2 .counter').text();
			$('.park-coins-section .park-coins-item .rate').html(counter);
        }
	});

	$('#radio3, .park-item.item-3').click(function() {
		if ($('input[name="radios1"]').is(':checked')) { 
			$('.park-section .park-item').removeClass('active');
			$('.park-section .park-item.item-3').addClass('active');
			var counter = $('.park-section .park-item.item-3 .counter').text();
			$('.park-coins-section .park-coins-item .rate').html(counter);
        }
	});

	// Phone mask
    //$("#inputAmount").mask("9.?99999999");

 	// $("#inputAmount").on("change paste keyup", function(e) {
	// 	var inputAmount = $(this).val();
	// 	$('.park-coins-item .return').html(inputAmount);
	// });

	// Parking Rate Section 
	$('.parking-rate-item .change-button').click(function() {
		$(this).closest('.parking-rate-item').addClass('active');
	});

	$('.parking-rate-item .cancel-button').click(function() {
		$(this).closest('.parking-rate-item').removeClass('active');
	});

	$('.parking-confirm-button').click(function() {
		$('#parking-created').show();
	});
	// Menu
	if($(window).width() > 992 ) {

	} else {
		$("#navbar .login").appendTo("#sidenav");
		$("#navbar .status").appendTo("#sidenav");
		$("#navbar .info-block").appendTo("#sidenav");
		$("#sidebar .left-menu").appendTo("#sidenav");
		$("#navbar .log-out-link").appendTo("#sidenav");

	}

	$(window).resize(function() {
		if( $(window).width() > 992 ) {
			$("#sidenav .left-menu").appendTo("#sidebar");
			$("#sidenav .login").appendTo("#navbar .right-side");
			$("#sidenav .status").appendTo("#navbar .right-side");
			$("#sidenav .info-block").appendTo("#navbar .right-side");
			$("#sidenav .log-out-link").appendTo("#navbar .right-side");

		} else {
			$("#navbar .login").appendTo("#sidenav");
			$("#navbar .status").appendTo("#sidenav");
			$("#navbar .info-block").appendTo("#sidenav");
			$("#sidebar .left-menu").appendTo("#sidenav");
			$("#navbar .log-out-link").appendTo("#sidenav");
	
		}
		
	});

	// Menu Toggle
	$('.main-menu-toggle').click(function() {
		$(this).toggleClass("on");
		$("#sidenav").toggleClass("on");
	});

// });


	// Steps 
	$('.steps-number').click(function() {
		$('.steps-number').removeClass('active');
		$(this).addClass('active');
		$('.steps-descr').removeClass('active');
	});

	$('.steps-number-1').click(function() {
		$('.steps-descr-1').addClass('active');
	});

	$('.steps-number-2').click(function() {
		$('.steps-descr-2').addClass('active');
	});

	$('.steps-number-3').click(function() {
		$('.steps-descr-3').addClass('active');
	});

	$('.steps-number-4').click(function() {
		$('.steps-descr-4').addClass('active');
	});

	$('.steps-number-5').click(function() {
		$('.steps-descr-5').addClass('active');
	});

	$('.steps-number-6').click(function() {
		$('.steps-descr-6').addClass('active');
	});

	// Mobile Slider
	$('.mobile-carousel').owlCarousel({
		loop: true,
		margin: 0,
		nav: true,
		autoplay: true,
		items: 1,
		navText: ["",""],
		dots: true,
		smartSpeed: 1000,
		responsive:{
			0:{
	            nav: false
	        },
	        380:{
	            nav: false
	        },
	        480:{
	            nav: false
	        },
	        768:{
	        	
	        }
	    }
	});

	// Parallax
	if ($(window).width() > 767) {
		$('#main-header, #current').parallax({imageSrc: 'img/header-bg.jpg'});
	}

	// Menu Toggle
	$('.main-menu-toggle-2').click(function() {
		$(this).toggleClass("on");
		$('#main-navbar .right-side').slideToggle('slow');
	});

	// Wow animate init
	if ($(window).width() > 768) {
		wow = new WOW(
	    	{
	    		offset: 100
	    	});
	    wow.init();
	}

	// Next Prev
	$('#next').click(function() {
		if ($('.steps-number.active').next().is('.steps-number')) $('.steps-number.active').removeClass('active').next('.steps-number').addClass('active');
		if ($('.steps-descr.active').next().is('.steps-descr')) $('.steps-descr.active').removeClass('active').next('.steps-descr').addClass('active');
	});

	$('#prev').click(function() {
		if ($('.steps-number.active').prev().is('.steps-number')) $('.steps-number.active').removeClass('active').prev('.steps-number').addClass('active');
		if ($('.steps-descr.active').prev().is('.steps-descr')) $('.steps-descr.active').removeClass('active').prev('.steps-descr').addClass('active');
	});

	// Amount
	$("#input-pa-1").on("change paste keyup", function(e) {
		var inputAmount = $(this).val();
		// if (!Number.isInteger(inputAmount)) inputAmount = '0.00000000';
		$('#your-parking-amount').html(inputAmount + ' MNX');
		profitValue(inputAmount);
	});
	$("#input-pa-2").on("change paste keyup", function(e) {
		var inputAmount = $(this).val();
		// if (!Number.isInteger(inputAmount)) inputAmount = '0.00000000';
		$('#your-parking-amount').html(inputAmount + ' MNX');
		profitValue(inputAmount);
	});
	$("#input-pa-3").on("change paste keyup", function(e) {
		var inputAmount = $(this).val();
		 // if (!Number.isInteger(inputAmount)) inputAmount = '0.00000000';
		$('#your-parking-amount').html(inputAmount + ' MNX');
		profitValue(inputAmount);
	});

	$('.nav-tabs a[href=#tab1]').click(function() {
		$('#parking-duration').html('24 hours').attr('aria-valuenow', '16').css('width', '20%');
		$('#parking-rate').html(rates['0']+'%').attr('aria-valuenow', rates['0']).css('width', '10%');
		$("#input-pa-1").val('');
		$('#your-parking-amount').html('0.00000000 MNX');
		$('.progress-item .profit-value').html('0.00000000 MNX');
	});

	$('.nav-tabs a[href=#tab2]').click(function() {
		$('#parking-duration').html('7 days').attr('aria-valuenow', '7').css('width', '40%');
		$('#parking-rate').html(rates['1']+'%').attr('aria-valuenow', rates['1']).css('width', '25%');
		$("#input-pa-2").val('');
		$('#your-parking-amount').html('0.00000000 MNX');
		$('.progress-item .profit-value').html('0.00000000 MNX');
	});

	$('.nav-tabs a[href=#tab3]').click(function() {
		$('#parking-duration').html('365 days').attr('aria-valuenow', '100').css('width', '100%');
		$('#parking-rate').html(rates['2']+'%').attr('aria-valuenow', rates['2']).css('width', '70%');
		$("#input-pa-3").val('');
		$('#your-parking-amount').html('0.00000000 MNX');
		$('.progress-item .profit-value').html('0.00000000 MNX');
	});

	// $('#per-day-button').click(function() {
	// 	$('#parking-rate').html('5%').attr('aria-valuenow', '5').css('width', '10%');
	// });

	// $('#per-month-button').click(function() {
	// 	$('#parking-rate').html('10%').attr('aria-valuenow', '10').css('width', '25%');
	// });

	// $('#per-year-button').click(function() {
	// 	$('#parking-rate').html('54%').attr('aria-valuenow', '54').css('width', '54%');
	// });
	
	function profitValue(inputAmount) {
		var rate = parseFloat($('#parking-rate').attr('aria-valuenow'));
		var amount = parseFloat(inputAmount);
		var profit = (amount * rate/100).toFixed(8);
		if (isNaN(profit)) profit = '0.00000000';
		$('.progress-item .profit-value').html(profit + ' MNX');
	}

	// // Popup
	// $('.call-popup').magnificPopup({
	// 	type:"inline",
	//	mainClass: 'mfp-fade',
	//	showCloseBtn: false,
	//	closeBtnInside: true,
	//	removalDelay: 300
	// });

	// $('.close-popup').click(function() {
	// 	$.magnificPopup.close();
	// });

	// 	// Parking Rate Section 
	// $('.parking-rate-item .change-button').click(function() {
	// 	$(this).closest('.parking-rate-item').addClass('active');
	// });

	// $('.parking-rate-item .cancel-button').click(function() {
	// 	$(this).closest('.parking-rate-item').removeClass('active');
	// });

	// $('.parking-confirm-button').click(function() {
	// 	$('#parking-created').show();
	// });
	$('.work-carousel').owlCarousel({
		loop: true,
		margin: 0,
		nav: true,
		autoplay: true,
		autoplayTimeout: 3000,
		items: 1,
		navText: ["",""],
		dots: true,
		smartSpeed: 1000,
		responsive:{
			0:{nav: false},
			380:{nav: false},
			480:{nav: false},
			768:{}
	    }
	});


	// Copy button
	$("#copy-button").click(function(){
		$("#wordInput").select();
		document.execCommand('copy');
	});

	// Animate
	// hide our element on page load
	if ($(window).width() > 767) {
		$('.has-animation').css('opacity', 0);

		$('.has-animation').waypoint(function() {
			var animation = $(this).attr('data-animation');
			$(this).addClass(animation).addClass('animated').css('opacity', 1);
		}, { offset: '80%' });
	}

	$('.gif-img').waypoint(function() {
		$(this).attr("src", function() {
			return $(this).attr("src").replace(".png", ".gif");
		});
	}, { offset: '80%' });

	$('.circle-block').waypoint(function() {
		$('.big-circle').each(function() {
			var $this = $(this);
			var myVal = $this.attr("rel");
			$this.knob({});
			$({value: 0}).animate({value: myVal}, {
				duration: 2000,
				easing: 'swing',
				step: function() {
					$this.val(Math.ceil(this.value)).trigger('change');
				}
			});
		});
	}, {offset: '80%'});
});