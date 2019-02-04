$(document).ready(function() {

	//Preloader
	setTimeout(function(){
		$('#preloader').fadeOut('slow',function(){$(this).remove();});
	}, 100);

	// Img
	$("img, a").on("dragstart", function(event) { event.preventDefault(); });

	// Header full page
	function fullPageBg() {
		$("#full-height").css("height", $(window).height() - 50);
	};

	if($(window).width() > 767) {
		fullPageBg();
	}
	
	$(window).resize(function() {
		if($(window).width() > 767) {
			fullPageBg();
		} else {
			$("#full-height").css("height", "100%");
		}
	});

	// MatchHeight
	$('.park-item').matchHeight();


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

	setTimeout(function(){
		$('.circle').each(function() {
	       var $this = $(this);
	       var myVal = $this.attr("rel");
	       $this.knob({
	       });
	       $({
	          value: 0
	       }).animate({
	          value: myVal
	       }, {
	          duration: 2000,
	          easing: 'swing',
	          step: function() {
	             $this.val(Math.ceil(this.value)).trigger('change');
	          }
	       });
	   });
	}, 1000);

	// Popup
	$('.call-popup').magnificPopup({
		type:"inline",
        mainClass: 'mfp-fade',
        showCloseBtn: false,
        closeBtnInside: true,
        removalDelay: 300
	});

	$('.close-popup').click(function() {
		$.magnificPopup.close();
	});

	// Chat
    $('.add-message').submit(function() {
		var text = $('textarea').val();
		var avatar = '<i class="material-icons">person</i>';

		// date
		var d = new Date();
		var month = d.getMonth()+1;
		var day = d.getDate();
		var date = (day<10 ? '0' : '') + day + '.' +
		    (month<10 ? '0' : '') + month + '.' +
		    d.getFullYear();

		// Time
		var time = d.getHours() + ":" + d.getMinutes();
		
		var message = '<div class="message-item">' + 
		'<div class="avatar">' + avatar + '</div>' + 
		'<div class="date">' + time + '</div>' +
		'<div class="text">' + text + '</div>' + 
		'</div>'

		$('.message-area').append(message);
		$('.message-area').animate({scrollTop:999999999},0);
		//$('.message-area').scrollTop(999999999);
		$(".add-message").trigger("reset");
		
		return false;
	});

	$("#messageTextarea").keypress(function(e) {
		if(e.which == 13) {
			var text = $(this).val();
			var avatar = '<i class="material-icons">person</i>';

			// date
			var d = new Date();
			var month = d.getMonth()+1;
			var day = d.getDate();
			var date = (day<10 ? '0' : '') + day + '.' +
			    (month<10 ? '0' : '') + month + '.' +
			    d.getFullYear();

			// Time
			var time = d.getHours() + ":" + d.getMinutes();
			
			var message = '<div class="message-item">' + 
			'<div class="avatar">' + avatar + '</div>' + 
			'<div class="date">' + time + '</div>' +
			'<div class="text">' + text + '</div>' + 
			'</div>'

			$('.message-area').append(message);
			$('.message-area').animate({scrollTop:999999999},0);
			//$('.message-area').scrollTop(999999999);
			$(".add-message").trigger("reset");
			
			return false;
		}
	});

	$("#messageTextarea").keypress(function(e) {
		if ((event.keyCode == 10 || event.keyCode == 13) && event.ctrlKey) {
			var txt = $(this);
			txt.val( txt.val() + '\n');
		}
	});

	// Park Coins Section 
	$('.park-coins-section .close-button, .close-park-button').click(function() {
		$('.park-section .call-section').css('display', 'block');
		$('.park-section').css('padding-bottom', '40px');
		$('.park-coins-section').css('display', 'none');
		$('.park-section .park-item').removeClass('active');
	});

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

	// Notification 
	$('.new-notification').click(function() {
		$(this).removeClass('new-notification');
	});

	// Phone mask
    //$("#inputAmount").mask("9.?99999999");

   	$("#inputAmount").on("change paste keyup", function(e) {
		var inputAmount = $(this).val();
		$('.park-coins-item .return').html(inputAmount);
	});

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

});

