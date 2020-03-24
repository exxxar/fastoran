var basket = [];
var summDelivery = 0;
var bonus=0;
var delivery_price_global = 0;
$(document).ready(function() {
    $(".to-top").click(function(e) {
      	$("html, body").animate({
          	scrollTop: 0
      	}, "800");
      return false;
      });
 	$(window).scroll(function() {
      	if ($(this).scrollTop() > 700) {
          	$(".to-top, .to-basket").fadeIn();
      	} else {
          	$(".to-top, .to-basket").fadeOut();
     	 }
     });

    show_prof($.cookie('id'));
    
	/*show form register*/
	$(".modal-phone").mask("(099) 999-99-99");
	$("#prof_phone").mask("(099) 999-99-99");
	$("#partner_user_phone").mask("(099) 999-99-99");
	$('.show-form').on('click', function(){
		$('.register-preview').css({'display':'none'});
			if(window.innerWidth <767){
				$('.register-enter').css({'display':'none'});
			}
			$('.l-register-form').css({'display':'block'});
	});
	/*------*/
	/*show modal-profile*/
	$('.show-profile').on('click',function(){
		$('.register-wrap').addClass('hidden');
		$('.profile-wrap').removeClass('hidden');

	});
	/*END show modal-profile*/
	/*edit modal-profile*/
	$('.edit-profile').on('click', function(){
		$('.default-data').addClass('hidden');
		$('.new-data').removeClass('hidden');
	});
    
 
    
	/*END edit modal-profile*/
	/*open register*/
	if(window.innerWidth >767){
		var registerHeight = $('.register').outerHeight();
		$('.register').css({'display':'block', 'margin-top':-registerHeight});
		$('.register').removeClass('my-hidden');
		
	}
	else {
		$('.register').css({'display':'block', 'margin-top':'0'});
		$('.register').addClass('my-hidden');
	
	}
	var resize = false;	
	$('.reg').on('click', function(){
		resize = true;
		if(window.innerWidth >767){
			if($.cookie("user") != null){
				if($('.log-out-wrap').hasClass('hidden')) {
					$('.log-out-wrap').removeClass('hidden');
				}
				else {
					$('.log-out-wrap').addClass('hidden');
				}
				return false;
			}
			$('.register').animate({'margin-top': 0},500);
		}
		else {
			$('.register').removeClass('my-hidden');
			$('.register').css({'margin-top':0});
			$('.register-overplay').removeClass('hidden');
			// $('.register-close').removeClass('hidden');
			$('.basket').addClass('hidden');
		}
	});
	$('.basket, .to-basket').on('click', function(){
		if($.cookie("user") == null) {
			noty('войдите или зарегистрируйтесь');
			return false;
		}
		if($.cookie("basket") == null){
			noty('корзина пуста');
			return false;
		}
		else {
			if(window.innerWidth <767){
				$('.reg').addClass('hidden');
			}
		}
	});
	$('.modal-dialog .close').on('click', function(){
		if(window.innerWidth <767){
			$('.reg').removeClass('hidden');
		}
	});
	$('.register-close').on('click', function(e){
		e.preventDefault();
		resize = false;
		if(window.innerWidth >767){
			var registerHeight = $('.register').outerHeight();
			$('.register').animate({'margin-top': -registerHeight},500);
		
		}
		else {
			$('.register').addClass('my-hidden');
			$('.register').css({'opacity':'1'});
			$('.register-overplay').addClass('hidden');
			// $(this).addClass('hidden');
			$('.basket').removeClass('hidden');
		}
	});

	$(window).resize(function(){
		
		// alert('resize');
		if(window.innerWidth >767 ){
			if (resize == true ) {
				return;
			}
			var registerHeight = $('.register').outerHeight();
			$('.register').css({'display':'block', 'margin-top':-registerHeight});
			$('.register').removeClass('my-hidden');
			$('.register-preview').css({'display':'block'});
			$('.register-enter').css({'display':'block'});
			$('.l-register-form.sm').css({'display':'none'});
			$('.basket').removeClass('hidden');
			$('.register-overplay').addClass('hidden');
		}
		else {
			if (resize == true ) {
				return;
			}
			$('.l-register-form.sm').css({'display':'none'});
			$('.l-register-form.xs').css({'display':'none'});
			$('.register-enter').css({'display':'block'});
			$('.register').css({'display':'none','margin-top':'0'});
			$('.register').addClass('my-hidden');
			$('.basket').removeClass('hidden');
			$('.register-overplay').addClass('hidden');
			setTimeout(function(){
				$('.register').css({'display':'block'});
			},1000);
		}
	});
	
	/*----END----*/
	/*----show/hide fitres----*/
	$('.btn-filtres').on('click', function(){
		$('.l-rest-list__filtres').removeClass('fixed-xs-hidden');
	});
	$('.close-filter').on('click', function(){
		$('.l-rest-list__filtres').addClass('fixed-xs-hidden');
	});
	/*----END----*/
 	$(".main").owlCarousel({
		items : 1,
		navigation : true,
		pagination: false,
		responsive: true,
		nav:true,
		loop : true,
		// autoplay: true,
 	// 	autoplayTimeout: 3000,
 		mouseDrag: false,
 		navText: [
		  "<i class='my-arrow-left'></i>",
		  "<i class='my-arrow-right'></i>"
      	]
		
	});
	$(".discount").owlCarousel({
		items : 4,
		navigation : true,
		pagination: false,
		responsive: true,
		nav:true,
		loop : true,
		autoplay: true,
 		autoplayTimeout: 3000,
		navText: [
		  "<i class='my-arrow-left'></i>",
		  "<i class='my-arrow-right'></i>"
      	],
      	responsive: {
	      0: {
	        items: 2
	      },
	      480: {
	        items: 2
	      },
	      768: {
	        items: 3
	      },
	      992: {
	      	items: 4
	      }
	    }
	});

	/*modal action*/
	$('#basket .formalization').on('click',function(){
		$('#basket').modal('hide');
		setTimeout(function(){
			$.ajax({
			      type: "POST",
			      async: false,
			      url: "http://"+window.location.hostname+"/user_api.php",
			      data: "api_method=get_profile_user&id="+$.cookie('id'),
			      dataType: "json",
			      success: function(data) {
			   
			       $("#basket_name_desktop").val(data.name);
			       // $('#basket_region [value="'+data.user_region+'"]').attr('selected', 'true');
			       // $('.dropdown div ul li:nth-child('+data.user_region+')').click().click();
			       $("#basket_adress").val(data.user_city);
			       $("#basket_street").val(data.user_street);
			       $("#basket_house").val(data.user_home);
			       $("#basket_flat").val(data.user_flat);
			       $('#basket_house').blur();
			     
			       //$("#basket_region").attr();
			       // $("#prof_mail_val").text(data.email);
			       // $("#prof_birthday_val").text(data.birthday);
			       // $("#bonus_val").text(data.bonus+' баллов');
			       console.log(data);
			      }
			  }); 
			$('#order').modal('show');

		},300);
	});

	$('.edit-basket').on('click',function(){
		$('#order').modal('hide');
		setTimeout(function(){
			$('#basket').modal('show');
		},300);
	});
	$('#thx .btn-warning').on('click',function(){
		$('#thx').modal('hide');
		if(window.innerWidth <767){
			$('.reg').removeClass('hidden');
		}
	});
	/*END modal action*/

	/*делаем аккордион на мобиле или при ресайзе*/
	if(window.innerWidth >767){
		$('.l-menu-list-item__title').removeClass('collapsed').attr({"role":"", "data-toggle":"","style":""});
		$('.l-menu-list-item__body').removeClass('collapse').attr({"aria-expanded":"","style":""});

	}
	else {
		$('.l-menu-list-item__title').addClass('collapsed').attr({"role":"button", "data-toggle":"collapse","style":""});
		$('.l-menu-list-item__body').addClass('collapse').attr({"aria-expanded":"true","style":""});
	}
	$(window).resize(function(){
		if(window.innerWidth >767){
			$('.l-menu-list-item__title').removeClass('collapsed').attr({"role":"", "data-toggle":"","style":""});;
			$('.l-menu-list-item__body').removeClass('collapse').attr({"aria-expanded":"","style":""});
		}
		else {
			$('.l-menu-list-item__title').addClass('collapsed').attr({"role":"button", "data-toggle":"collapse","style":""});
			$('.l-menu-list-item__body').addClass('collapse').attr({"aria-expanded":"true","style":""});
		}
	});
	/*------------END---------------*/
	/*menu accordeon*/
	$('.l-menu-list-item__title').on('click', function(){
		var that = $(this);
		setTimeout(function(){
			$('.l-menu-list-item__title').each(function(){
				if($(this).siblings('.l-menu-list-item__body').hasClass('in')) {
					$(this).siblings('.l-menu-list-item__body').removeClass('in');
					$(this).addClass('collapsed');
				}
			});
		},200);
		setTimeout(function(){
			var scroll = $(that).offset().top;
			$("body , html").animate({"scrollTop": scroll}, 300);
		},300);
	});
	/*END menu accordeon*/
	/*open and init modal-menu-item*/
	$('.item-zoom').on('click',function(){
		$('#modal-menu-item .modal-header h3').text($(this).parents('.menu-item').find('.menu-item__description--name').text());
		$('#modal-menu-item .modal-body__media img').attr('src', $(this).parents('.menu-item').find('.menu-item__media img').attr('src'));
		$('#modal-menu-item .modal-body__description p').text($(this).parents('.menu-item').find('.menu-item__description--text').text());
		$('#modal-menu-item .modal-footer .price span').text($(this).parents('.menu-item').find('.price-info h4').text());
		$('#modal-menu-item .modal-footer .weight span').text($(this).parents('.menu-item').find('.menu-item__description .weight').text());
		
	});
	/*END open and init modal-menu-item*/
	/*Basket*/
	if(document.getElementById('rest_id')) {
		var menuArr = get_menu_arr($('#rest_id').attr('value'));
		var minSumOrder = getMinSum($('#rest_id').attr('value'));
	}
	
	//подставляем имя пользователя если авторизован
	if($.cookie("user") != null) {
		$('.header .reg > div p').text($.cookie('user'));
		$('#basket_name_desktop').val($.cookie("user"));
		if(window.innerWidth >767){
			//$('.log-out-wrap').removeClass('hidden');
		}
		else {
			$('.profile-wrap').removeClass('hidden');
			$('.register-wrap').addClass('hidden');
		}
	}
	if($.cookie("phone") != null) {
		$('.has-phone').removeClass('hidden').text($.cookie('phone'));
		$('.edit-phone').removeClass('hidden');
		$('#basket_phone_desktop').addClass('hidden');
		if(window.innerWidth >767){
			$('#basket_phone_desktop').val($.cookie("phone"));
		}
		else {
			$('#basket_phone_desktop').val($.cookie("phone"));
		}
	}
	$('.edit-phone').on('click', function(event){
		event.preventDefault();
		$(this).addClass('hidden');
		$('.has-phone').addClass('hidden');
		$('#basket_phone_desktop').removeClass('hidden');
	});
	
	var totalPriceOrder = 0;
	// var totalBonusOrder = 0;
	var totalPriceRest = 0;
	//количество бонусов у пользователя, создано для теста
	/*------*/
	//количество ресторанов из которых были заказы
	var cntRest = [];
	/*получаем значение из куки*/
	if($.cookie("cntRest") != null) {
		cntRest = JSON.parse($.cookie("cntRest"));
		// если пользователь перешел на страницу другого ресторана ресторана
		if(document.getElementById('rest_id')){
			if(cntRest[0].id != $('#rest_id').val()){
				console.log('another restoran');
				getBonus($.cookie('id'));
				console.log('bonus after getBonus=' + bonus)
				cntRest = [];
				basket = [];
				$.cookie('basket', null, {path:'/'});
				$.cookie('bonus', bonus);
				$.cookie('cntRest', null, {path:'/'});
			}
		}
	}
	if($.cookie("bonus") != null){
		bonus = parseInt($.cookie("bonus"));
		console.log('bonus is cookie=' + bonus);
	}
	if($.cookie("basket") != null) {
		basket = JSON.parse($.cookie("basket"));
		$('.basket .clean').addClass('hidden');
		$('.basket .full').removeClass('hidden');
		$('.basket .cnt p').text(basket.length);
		totalPriceOrder = 0;
		for(var i=0; i<basket.length; i++) {
			totalPriceOrder += parseInt(basket[i].totalPrice);
		}
		$('.basket .summ').text(totalPriceOrder+' руб');
		/*распарсиваем корзину*/
		var checkedBonus; //выбраное бонусное блюдо
		for(var i = 0; i< basket.length; i++) {
			if(basket[i].bonus == 0){
				$('.basket-list').append("<li data-basket-item='"+basket[i].id+"' data-rest='"+basket[i].rest+"' ><div><p>"+basket[i].name+"</p><button class='btn-delete'></button></div><div class='hidden-xs'><p>"+basket[i].price+" руб</p></div><div><button class='modal-minus'></button><input type='text' readonly='true' value='"+basket[i].count+"'><button class='modal-plus'></button></div><div><p class='price-one-position hidden-sm hidden-md hidden-lg'>"+basket[i].totalPrice+" руб</p><p class='total-price-position'>"+basket[i].totalPrice+" руб</p></div></li>");
				$('#'+basket[i].id).find('.add-btn').addClass('hidden');
				$('#'+basket[i].id).find('.cnt-container').removeClass('hidden');
				$('#'+basket[i].id).find('input').attr('value',basket[i].count);
			}
			else {
				$('.basket-list').append("<li data-basket-item='"+basket[i].id+"' data-rest='"+basket[i].rest+"' class='bonus-position'><div><p>"+basket[i].name+"</p><button class='btn-delete'></button></div><div class='hidden-xs'><p></p></div><div></div><div><p class='price-one-position hidden-sm hidden-md hidden-lg'></p><p class='total-price-position'>0 руб</p></div></li>");
				/*блокируем бонусные блюда если оно есть в корзине*/
				$('.menu-item.bonus .add-btn').each(function(){
					$(this).text('Недоступно').attr('disabled','disabled');
					if($(this).attr('data-target') == basket[i].id) {
						checkedBonus = basket[i].id;
					}
				});
				/*------------*/
			}
			if(basket[i].rest == $('#rest_id').attr('value')) {
				totalPriceRest += parseInt(basket[i].totalPrice);
			}
			console.log('bonus='+bonus);
		}
		if(document.getElementById('rest_id')) {
			for(var i = 0; i< menuArr.length; i++) {
				if(menuArr[i].bonus !=0 && menuArr[i].price > bonus) {
					$('#'+menuArr[i].id).find('.add-btn').text('Недоступно').attr('disabled','disabled');
				}
			}
			$('#'+checkedBonus).find('.add-btn').text('В корзине');
		}
		/*----------*/

	}
	/*-----------------*/
	/*блокируем при зарузке бонусные блюда*/
	if(minSumOrder > totalPriceRest) {
		$('.menu-item.bonus').each(function(){
			$(this).find('.add-btn').attr('disabled','disabled').text('Недоступно');
		});
	}
	/*------*/
	var sumDelivery = parseInt($('.price-delivery').text());
	/*show cnt-container and add first item in basket*/
	$('.add-btn').on('click', function(){
		if($(this).hasClass('add-btn-2')) {
			return false;
		}
		var idMenu = $(this).attr('data-target');
		for(var i =0; i<basket.length; i++) {
			/*Если не набрана минимальная сумма заказа*/
			if($(this).parents('.menu-item').hasClass('bonus') && minSumOrder > totalPriceRest) {
				return false;
			}
			/*---------------*/
			/*Если 1 бонусное блюдо уже добавлено*/
			if($(this).parents('.menu-item').hasClass('bonus') && basket[i].bonus != 0 && basket[i].rest == $('#rest_id').attr('value')) {
				return false;
			}
			/*---------------*/
		}
		var basketItem ={
			name : '',
			count : 0,
			price : 0,
			totalPrice : 0,
			bonus: 0,
			id: 0,
			rest: 0
		};
		var rest = {
			id: 0,
			minSum: 0,
			restAddr: $('#rest_addr').val()
		};
		//проверяем если ресторан уже добавлен
		var hasRest = false;
		for(var i = 0; i < cntRest.length; i++) {
			if(cntRest[i].id == $('#rest_id').attr('value')) {
				hasRest = true;//есть такой ресторан
			}
		}
		//если нет
		if(hasRest == false){
			rest.id = $('#rest_id').attr('value');
			rest.minSum = minSumOrder;
			cntRest.push(rest);
		}
		for(var i =0; i < menuArr.length; i++) {
			if(idMenu == menuArr[i].id) {
				if(menuArr[i].bonus == 0) {
					$(this).addClass('hidden');
					$(this).siblings('.cnt-container').removeClass('hidden');
					$(this).siblings('.cnt-container').find('input').attr('value','1');
				}
				else {
					$('.menu-item.bonus .add-btn').each(function(){
						$(this).text('Недоступно').attr('disabled','disabled');
					});
					$(this).text('В корзине');
				}
				basketItem.name = menuArr[i].name;
				basketItem.count = 1;
				basketItem.rest = menuArr[i].rest;
				if(menuArr[i].bonus == 1) {
					basketItem.price = 0;
					basketItem.bonus = menuArr[i].price;
					bonus = bonus -parseInt(basketItem.bonus);
				}
				else {
					basketItem.price = menuArr[i].price;
					basketItem.bonus = 0;
				}
				basketItem.totalPrice = basketItem.price;
				basketItem.id = menuArr[i].id;
				console.log(basket);
				basket.push(basketItem);
				if(basketItem.bonus == 0){
					$('.basket-list').append("<li data-basket-item='"+basketItem.id+"' data-rest='"+basketItem.rest+"'><div><p>"+basketItem.name+"</p><button class='btn-delete'></button></div><div class='hidden-xs'><p>"+basketItem.price+" руб</p></div><div><button class='modal-minus'></button><input type='text' readonly='true' value='1'><button class='modal-plus'></button></div><div><p class='price-one-position hidden-sm hidden-md hidden-lg'>"+basketItem.totalPrice+" руб</p><p class='total-price-position'>"+basketItem.totalPrice+" руб</p></div></li>");
				}
				else {
					$('.basket-list').append("<li data-basket-item='"+basketItem.id+"' data-rest='"+basketItem.rest+"' class='bonus-position'><div><p>"+basketItem.name+"</p><button class='btn-delete'></button></div><div class='hidden-xs'><p></p></div><div></div><div><p class='price-one-position hidden-sm hidden-md hidden-lg'></p><p class='total-price-position'>0 руб</p></div></li>");
				}
				totalPriceOrder = 0;
				totalPriceRest =0;
				for(var i = 0; i < basket.length; i++) {
					totalPriceOrder = totalPriceOrder + parseInt(basket[i].totalPrice);
					if(basket[i].rest == $('#rest_id').attr('value')) {
						totalPriceRest = totalPriceRest + parseInt(basket[i].totalPrice);
					}
				}
				$('.basket .clean').addClass('hidden');
				$('.basket .full').removeClass('hidden');
				$('.basket .cnt p').text(basket.length);
				$('.basket .summ').text(totalPriceOrder+' руб');
				/*Если пользователь набрал нужную сумму и может добавить бонус*/
				/*проверяем есть ли в корзине бонусное блюдо этого ресторана*/
				var hasBonus = false;
				for(var i =0; i< basket.length; i++) {
					if(basket[i].rest == $('#rest_id').attr('value') && basket[i].bonus !=0) {
						hasBonus = true;
					}
				}
				/*----*/
				if(minSumOrder <= totalPriceRest && hasBonus == false) {
					$('.menu-item.bonus').each(function(){
						var id = $(this).attr('id');
						for(var i = 0; i < menuArr.length; i++) {
							if(menuArr[i].id == id && menuArr[i].price < bonus) {
								$(this).find('.add-btn').removeAttr('disabled');
								$(this).find('.add-btn').text('Добавить');
							}
						}
					});
					//если в корзине есть бонусное блюдо
					for(var i=0; i<basket.length; i++) {
						if(basket[i].bonus != 0 && hasBonus == true) {
							$('.menu-item.bonus').each(function(){
								$(this).find('.add-btn').attr('disabled','disabled');
								$(this).find('.add-btn').text('Недоступно');
							});
							$('#'+basket[i].id).find('.add-btn').text('В корзине');
						}
					}
					/*-----*/
				}
				/*-----------*/
				break;
			}
		}
		/*-----------*/
		totalPriceOrder =0;
		for(var i =0; i< basket.length; i++) {
			totalPriceOrder += parseInt(basket[i].totalPrice); 
		}
		$('.total-price-order').text(totalPriceOrder);
		console.log(basket);
		console.log(bonus);
		pushInCookie(basket, cntRest);
	});
	/*----END----*/
	$('.price-delivery').text(sumDelivery);
	$('.total-price-order').text(totalPriceOrder);
	$('.btn-plus , .btn-minus').on('click', function(){
		/*if plus in item*/
		if ($(this).hasClass('btn-plus')) {
			var id = $(this).attr('data-target');
			totalPriceOrder =0;
			totalPriceRest = 0;
			for(var i = 0; i < basket.length; i++) {
				if(id == basket[i].id){
					basket[i].count++;
					basket[i].totalPrice = basket[i].price * basket[i].count;
					$(this).siblings('input').attr('value',basket[i].count);
					$('[data-basket-item='+basket[i].id+']').find('input').attr('value',basket[i].count);
					$('[data-basket-item='+basket[i].id+']').find('.total-price-position').text(basket[i].totalPrice +' руб');
					break;
				}
			}
			/*Если пользователь набрал нужную сумму и может добавить бонус*/
			for(var i = 0; i < basket.length; i++) {
				totalPriceOrder+= parseInt(basket[i].totalPrice);
				if(basket[i].rest == $('#rest_id').attr('value')) {
					totalPriceRest += parseInt(basket[i].totalPrice);
				}
			}
			var hasBonus = false;
			for(var i =0; i< basket.length; i++) {
				if(basket[i].rest == $('#rest_id').attr('value') && basket[i].bonus !=0) {
					hasBonus = true;
				}
			}
			if(minSumOrder <= totalPriceRest && hasBonus == false) {
				$('.menu-item.bonus').each(function(){
					var id = $(this).attr('id');
					for(var i = 0; i < menuArr.length; i++) {
						if(menuArr[i].id == id && menuArr[i].price < bonus) {
							$(this).find('.add-btn').removeAttr('disabled');
							$(this).find('.add-btn').text('Добавить');
						}
					}
				});
				/*если в корзине есть бонусное блюдо*/
				/*-----*/
				for(var i=0; i<basket.length; i++) {
					if(basket[i].bonus != 0 && hasBonus == true) {
						$('.menu-item.bonus').each(function(){
							$(this).find('.add-btn').attr('disabled','disabled');
							$(this).find('.add-btn').text('Недоступно');
						});
						$('#'+basket[i].id).find('.add-btn').text('В корзине');
					}
				}
			}
			/*-----------*/
			pushInCookie(basket, cntRest);
			$('.basket .cnt p').text(basket.length);
			$('.basket .summ').text(totalPriceOrder+' руб');
			$('.total-price-order').text(totalPriceOrder);
		}
		/*END if plus in item*/
		/*if minus in item*/
		else {
			var id = $(this).attr('data-target');
			totalPriceOrder =0;
			totalPriceRest = 0;
			minSumOrder=0;
			var rest;
			for(var i = 0; i < basket.length; i++) {
				if(id == basket[i].id){
					//получаем id ресторана
					rest = basket[i].rest;
					for(var j = 0; j<cntRest.length; j++) {
						if(cntRest[j].id == rest) {
							minSumOrder = cntRest[j].minSum;
						}
					}
					basket[i].count--;
					if(basket[i].count == 0) {
						$('[data-basket-item='+basket[i].id+']').remove();
						basket.splice(i,1);
						$(this).parents('.cnt-container').addClass('hidden');
						$(this).parents('.cnt-container').find('input').attr('value','1');
						$(this).parents('.menu-item').find('.add-btn').removeClass('hidden');
						break;	
					}
					basket[i].totalPrice = basket[i].price * basket[i].count;
					$(this).siblings('input').attr('value',basket[i].count);
					$('[data-basket-item='+basket[i].id+']').find('input').attr('value',basket[i].count);
					$('[data-basket-item='+basket[i].id+']').find('.total-price-position').text(basket[i].totalPrice +' руб');
					break;
				}
			}
			for(var i = 0; i < basket.length; i++) {
				totalPriceOrder+= parseInt(basket[i].totalPrice);
				if(basket[i].rest == $('#rest_id').attr('value')) {
					totalPriceRest += parseInt(basket[i].totalPrice);
				}
			}
			/*Если пользователь потерял нужную сумму и не может добавить бонус*/
			if(minSumOrder > totalPriceRest) {
				$('.bonus-position').each(function(){
					if(rest == $(this).attr('data-rest')){
						var id = $(this).attr('data-basket-item');
						$(this).remove();
						for(var i = 0; i < basket.length; i++) {
							if(basket[i].id == id) {
								bonus +=parseInt(basket[i].bonus);
								basket.splice(i, 1);
							}
						}
					}
				});
				$('.menu-item.bonus').each(function(){
					$(this).find('.add-btn').attr('disabled','disabled');
					$(this).find('.add-btn').text('Недоступно');
					
				});
			}
			/*-----------*/
			/*если пользователь удалил все блюда этого ресторана*/
			var hasRest = false; //предположим что блюд данного ресторана нет
			for(var i = 0; i < basket.length; i++) {
				//находим в корзине блюдо по которому кликнули
				if(rest == basket[i].rest ) {
					hasRest = true;//если есть
				}
			}
			if(hasRest == false){
				for(var i= 0; i<cntRest.length; i++) {
					if(cntRest[i].id == $('#rest_id').attr('value')) {
						cntRest.splice(i,1);
					}
				}
			}
			/*---------------------*/
			$('.total-price-order').text(totalPriceOrder);
			$('.basket .cnt p').text(basket.length);
			$('.basket .summ').text(totalPriceOrder+' руб');
			pushInCookie(basket, cntRest);			
			if(basket.length == 0) {
				$('.basket .clean').removeClass('hidden');
				$('.basket .full').addClass('hidden');
				$.cookie('basket', null, {path:'/'});
				$.cookie('bonus', null, {path:'/'});
				$.cookie('cntRest', null, {path:'/'});
			}
		}
		/*END if minus in item*/
	});
	/*edit in modal*/
		$('body').on('click', '.modal-plus, .modal-minus', function(){
			var id = $(this).parents('li').attr('data-basket-item');
			if($(this).hasClass('modal-plus')){
				totalPriceOrder =0;
				totalPriceRest = 0;
				for(var i = 0; i < basket.length; i++) {
					if(id == basket[i].id){
						basket[i].count++;
						basket[i].totalPrice = basket[i].price * basket[i].count;
						$(this).siblings('input').attr('value',basket[i].count);
						$('[data-basket-item='+basket[i].id+']').find('input').attr('value',basket[i].count);
						$('[data-basket-item='+basket[i].id+']').find('.total-price-position').text(basket[i].totalPrice +' руб');
						$('[data-input='+basket[i].id+']').attr('value',basket[i].count);
						break;
					}
				}
				/*Если пользователь набрал нужную сумму и может добавить бонус*/
				for(var i = 0; i < basket.length; i++) {
					totalPriceOrder+= parseInt(basket[i].totalPrice);
					if(basket[i].rest == $('#rest_id').attr('value')) {
						totalPriceRest += parseInt(basket[i].totalPrice);
					}
				}
				var hasBonus = false;
				for(var i =0; i< basket.length; i++) {
					if(basket[i].rest == $('#rest_id').attr('value') && basket[i].bonus !=0) {
						hasBonus = true;
					}
				}
				if(minSumOrder <= totalPriceRest && hasBonus == false) {
					$('.menu-item.bonus').each(function(){
						var id = $(this).attr('id');
						for(var i = 0; i < menuArr.length; i++) {
							if(menuArr[i].id == id && menuArr[i].bonus < bonus) {
								$(this).find('.add-btn').removeAttr('disabled');
								$(this).find('.add-btn').text('Добавить');
							}
						}
					});
					/*если в корзине есть бонусное блюдо*/
					for(var i=0; i<basket.length; i++) {
						if(basket[i].bonus != 0 && hasBonus == true) {
							$('.menu-item.bonus').each(function(){
								$(this).find('.add-btn').attr('disabled','disabled');
								$(this).find('.add-btn').text('Недоступно');
							});
							$('#'+basket[i].id).find('.add-btn').text('В корзине');
						}
					}
					/*-----*/
				}
				/*-----------*/
				$('.basket .cnt p').text(basket.length);
				$('.basket .summ').text(totalPriceOrder+' руб');
				$('.total-price-order').text(totalPriceOrder);
				pushInCookie(basket, cntRest);
			}
			else {
				totalPriceOrder =0;
				totalPriceRest =0;
				minSumOrder=0;
				var rest;
				for(var i = 0; i < basket.length; i++) {
					if(id == basket[i].id){
						//получаем id ресторана
						rest = basket[i].rest;
						for(var j = 0; j<cntRest.length; j++) {
							if(cntRest[j].id == rest) {
								minSumOrder = cntRest[j].minSum;
							}
						}
						basket[i].count--;
						if(basket[i].count == 0) {
							$('#'+basket[i].id).find('.cnt-container').addClass('hidden');
							$('#'+basket[i].id).find('input').attr('value','1');
							$('#'+basket[i].id).find('.add-btn').removeClass('hidden');
							$('[data-basket-item='+basket[i].id+']').remove();
							basket.splice(i,1);
							break;	
						}
						basket[i].totalPrice = basket[i].price * basket[i].count;
						$('#'+id).siblings('input').attr('value',basket[i].count);
						$('[data-basket-item='+basket[i].id+']').find('input').attr('value',basket[i].count);
						$('[data-basket-item='+basket[i].id+']').find('.total-price-position').text(basket[i].totalPrice +' руб');
						$('[data-input='+basket[i].id+']').attr('value',basket[i].count);
						break;
					}
				}
				for(var i = 0; i < basket.length; i++) {
					totalPriceOrder+= parseInt(basket[i].totalPrice);
					if(basket[i].rest == rest) {
						totalPriceRest += parseInt(basket[i].totalPrice);
					}
				}
				/*Если пользователь потерял нужную сумму и не может добавить бонус*/
				if(minSumOrder > totalPriceRest) {
					$('.bonus-position').each(function(){
						if(rest == $(this).attr('data-rest')){
							var id = $(this).attr('data-basket-item');
							$(this).remove();
							for(var i = 0; i < basket.length; i++) {
								if(basket[i].id == id) {
									bonus +=parseInt(basket[i].bonus);
									basket.splice(i, 1);
								}
							}
						}
					});
				}
				$('.menu-item.bonus').each(function(){
					$(this).find('.add-btn').attr('disabled','disabled');
					$(this).find('.add-btn').text('Недоступно');
				});
				/*-----------*/
				/*если пользователь удалил все блюда этого ресторана*/
				var hasRest = false; //предположим что блюд данного ресторана нет
				for(var i = 0; i < basket.length; i++) {
					//находим в корзине блюдо по которому кликнули
					if(rest == basket[i].rest ) {
						hasRest = true;//если есть
					}
				}
				if(hasRest == false){
					for(var i= 0; i<cntRest.length; i++) {
						if(cntRest[i].id == $('#rest_id').attr('value')) {
							cntRest.splice(i,1);
						}
					}
				}
				/*---------------------*/
				$('.total-price-order').text(totalPriceOrder);
				$('.basket .cnt p').text(basket.length);
				$('.basket .summ').text(totalPriceOrder+' руб');
				if(basket.length == 0) {
					$('.basket .clean').removeClass('hidden');
					$('.basket .full').addClass('hidden');
				}
				pushInCookie(basket, cntRest);
			}
		});
		/*delete from modal*/
		$('body').on('click','.btn-delete',function(){
			var id = $(this).parents('li').attr('data-basket-item');
			var totalPriceOrder =0;
			var totalPriceRest =0;
			minSumOrder=0;
			var rest = $(this).parents('li').attr('data-rest');
			//удаляем блюдо из корзины
			for(var i = 0; i < basket.length; i++) {
				if(basket[i].id == id) {
					$(this).parents('li').remove();
					//елси это было бонусное блюдо возвращаем бонусы
					if(basket[i].bonus != 0) {
						bonus += parseInt(basket[i].bonus);
						//открываем доступные бонусные блюда если мы на стр ресторана
						if(document.getElementById('rest_id')) {
							$('.menu-item.bonus').each(function(){
								var id = $(this).attr('id');
								for(var i = 0; i < menuArr.length; i++) {
									if(menuArr[i].id == id && menuArr[i].price < bonus) {
										$(this).find('.add-btn').removeAttr('disabled');
										$(this).find('.add-btn').text('Добавить');
									}
								}
							});
						}
					}
					$('#'+basket[i].id).find('.cnt-container').addClass('hidden');
					$('#'+basket[i].id).find('input').attr('value','1');
					$('#'+basket[i].id).find('.add-btn').removeClass('hidden');
					basket.splice(i,1);
				}
			}
			//определяем сумму заказа для ресторана из которого удалили блюдо
			for(var i = 0; i < basket.length; i++) {
				if(basket[i].rest == rest) {
					totalPriceRest += parseInt(basket[i].totalPrice); 
				}
				totalPriceOrder = totalPriceOrder + parseInt(basket[i].totalPrice);
			}
			//определяем мин сумму заказа
			for(var i = 0; i < cntRest.length; i++) {
				if(cntRest[i].id == rest) {
					minSumOrder = cntRest[i].minSum;
				}
			}
			//если сумма стала меньше минимальной удаляем бонусное блюдо этого ресторана
			if(minSumOrder > totalPriceRest) {
				for(var i = 0; i < basket.length; i++) {
					if(basket[i].bonus != 0) {
						bonus += parseInt(basket[i].bonus);
						$('[data-basket-item='+basket[i].id+']').remove();
						basket.splice(i,1); 
					}
				}
				$('.menu-item.bonus').each(function(){
					$(this).find('.add-btn').attr('disabled','disabled');
					$(this).find('.add-btn').text('Недоступно');
				});
			}
			$('.total-price-order').text(totalPriceOrder);
			$('.basket .cnt p').text(basket.length);
			$('.basket .summ').text(totalPriceOrder+' руб');
			pushInCookie(basket, cntRest);
			if(basket.length == 0) {
				$('.basket .clean').removeClass('hidden');
				$('.basket .full').addClass('hidden');
				$.cookie('bonus', null, {path:'/'});
				$.cookie('basket', null, {path:'/'});
				$.cookie('cntRest', null, {path:'/'});
			}
			
		});
		/*END delete from modal*/
		/*clear-basket from modal*/
		$('.clear-basket').on('click',function(event){
			event.preventDefault();
			$('.basket-list').empty();
			for(var i=0; i < basket.length; i++) {
				$('#'+basket[i].id).find('.cnt-container').addClass('hidden');
				$('#'+basket[i].id).find('input').attr('value','1');
				$('#'+basket[i].id).find('.add-btn').removeClass('hidden');
			}
			for(var i = 0; i < basket.length; i++) {
				if(basket[i].bonus != 0) {
					bonus += parseInt(basket[i].bonus); 
				}
			}
			totalPriceOrder =0;
			basket =[];
			cntRest =[];
			$('.menu-item.bonus').each(function(){
				$(this).find('.add-btn').attr('disabled','disabled');
				$(this).find('.add-btn').text('Недоступно');
			});
			$('.total-price-order').text(totalPriceOrder);
			$('.basket .cnt p').text(basket.length);
			$('.basket .summ').text(totalPriceOrder+' руб');
			$('.basket .clean').removeClass('hidden');
			$('.basket .full').addClass('hidden');
			$('.menu-item.bonus').each(function(){
				$(this).find('.add-btn').attr('disabled','disabled');
				$(this).find('.add-btn').text('Недоступно');
			});
			// pushInCookie(basket, bonus);
			$.cookie('basket', null, {path:'/'});
			$.cookie('bonus', null, {path:'/'});
			$.cookie('cntRest', null, {path:'/'});
			$.cookie('price_delivery', null, {path:'/'});
		});
		/*END clear-basket from modal*/
		/*END edit in modal*/
	/*END Basket*/

	/*like */
	var restId;
	$('body').on('click','.like-container', function(event){
		event.preventDefault();
		event.stopPropagation();
		// restId = $(this).attr('data-target');
		// add_rest_like(restId);
	});
	//END like 
	/*disslike */
	$('body').on('click','.disslike-container', function(event){
		event.preventDefault();
		event.stopPropagation();
		// restId = $(this).attr('data-target');
		// add_rest_antilike(restId);
	});
	/*END disslike */

	/*FILTRES MENU*/
	// var menuFilterList = $('.menu-filter');
	// menuFilterList.each(function(){
	// 	var id = $(this).attr('id');
	// 	if(!$(this).hasClass('checked')){
	// 		$('[data-menu-item = '+id+']').addClass('menu-item-hidden');
	// 	}
	// });
	var menuFilterList = $('.menu-filter');
	$('.menu-filter').on('change', function(){
		var id = $(this).attr('id');

		menuFilterList.each(function(){
			if($(this).attr('id') != id) {
				$(this).removeAttr('checked');
			}
		});
		var scroll = $('[data-menu-item = '+id+']').offset().top;
		$("body , html").animate({"scrollTop": scroll}, 1000);
		// if(!$(this).hasClass('checked')){
		// 	$(this).addClass('checked');
		// 	$('[data-menu-item = '+id+']').removeClass('menu-item-hidden');
		// 	//add_category($(this).attr('id'));
		// }
		// else {
		// 	$('[data-menu-item = '+id+']').addClass('menu-item-hidden');
		// 	$(this).removeClass('checked');
		// }
	});
	/*END FILTRES MENU*/
	/*FILTRES REST-LIST*/
	var isChecked = false;
	var checkedList=[];
	var kitchen = [];
	var criterion = [];
	var region = [];
	var restArr = [];
	$('.rest-filter').on('change', function() {

		var id = $(this).attr('id');
		if(!$(this).hasClass('checked')){
			$(this).addClass('checked');
			isChecked = true;
			if($(this).parent().parent().hasClass('kitchen')){
				kitchen.push(id);
			}
			if($(this).parent().parent().hasClass('criterion')){
				criterion.push(id);
			}
			if($(this).parent().parent().hasClass('region')){
				region.push(id);
			}
			strKitchen = kitchen.join(',');
			strCriterion = criterion.join(',');
			strRegion = region.join(',');
			checkedList = strKitchen +","+ strCriterion +","+ strRegion;
            
    
   
   if(checkedList[checkedList.length-1]==',')
    {
        checkedList = checkedList.slice(0, -1);
    }
   if(checkedList[checkedList.length-1]==',')
    {
        checkedList = checkedList.slice(0, -1);
    }
            
            
		}
		else {
			$(this).removeClass('checked');
			//isChecked = false;
				if($(this).parent().parent().hasClass('kitchen')){
					for(var i = 0; i < kitchen.length; i++) {
						if(kitchen[i] == id) {
							kitchen.splice(i,1);
						}
					}
				}
				if($(this).parent().parent().hasClass('criterion')){
					for(var i = 0; i < criterion.length; i++) {
						if(criterion[i] == id) {
							criterion.splice(i,1);
						}
					}
				}
				if($(this).parent().parent().hasClass('region')){
					for(var i = 0; i < region.length; i++) {
						if(region[i] == id) {
							region.splice(i,1);
						}
					}
				}
			
			checkedList = kitchen.join(',')+','+criterion.join(',')+','+region.join(',');
			$('.rest-filter').each(function(){
				if($(this).hasClass('checked')) {
					isChecked = true;
				}
			});

		}
		console.log('cange filter');
		restArr = getRestorans(checkedList,restArr);	
	});
	/*END FILTRES REST-LIST*/
	/*Listen Paggination*/
	var numPageClick = 0;
	$('body').on('click', '.paggination li a',function(event){
		if(isChecked == true) {
			event.preventDefault();
			$('.paggination li').each(function(){
				$(this).removeClass('active');
			});
			$(this).parent().addClass('active');
			numPageClick = (parseInt($(this).text()));
			getRestoransPag(numPageClick, restArr);
			var scroll = $('#item-list').offset();
			$('html,body').animate({scrollTop:scroll.top},400);
		}
	});
	/*--------------------*/
	/*получение районов в модалку*/
	$('.streets').keyup(function(){
		var str = $(this).val();
		var region = $('.user-region').val();
		getStreets(str,region);
	})
	/*----------------------*/
	/*нажатие на улицу*/
	$('body').on('click','.streets-list div p', function(){
		var text = $(this).text();
		$('.streets').val(text);
		$('.streets-list').css({'display':'none'});
        $('#basket_house').css('display', 'block');
        $('#basket_flat').css('display', 'block');
	});
	/*--------------*/
	/*получение стоимотсти доставки*/
	// $('.user-region').on('change', function(){
	// 	var region = $(this).val();
	// 	getPriceDelivery(region, cntRest, basket);
	// });

	//delivery lenght
//	$('#basket_house').on('change', function(){
	//	$('#getDirections').click();
//		//console.log('src= '+src+';'+'dst= '+dst);
//	});

	/*------------------*/
    $('.send_basket').on('click', function(){
        send_basket(cntRest);
    });
    $('.btn-register').on('click',function(){
    	register(bonus);
    });
    //вход
    $('.btn-enter').on('click',function(){
    	enter('', $("#enter_pass").val(), $("#enter_mail").val());
    });
    //modal-review
    //открытие окна
    $('.add-comment').on('click', function(){
     
    	if($.cookie("user")==null){
           noty("Для того что бы оставить отзыв, зарегистрируйтесь на сайте или войдите!");
    	}
    	else {	
	        $(".user_review").text($.cookie('user'));
	        $('#modal-review').modal('show');
    	}
    });
    //выбор статуса коментария
    $('.comment-status label').on('click', function(){
	  	 $('.comment-status input').each(function(){
		  	$(this).removeAttr('checked');
		  	$(this).val(0);
	  	 });
	  	$(this).siblings('input').attr('checked','checked');
	  	$(this).siblings('input').val(1);
	});
	//отправка коментария
	$('.send-review').on('click', function(){
		sendReview($.cookie('id'));
	});
	//закрытие окна
	$('.close-review').on('click', function(){
		$('#modal-review').modal('hide');
	});
	//datapiker
	if(document.getElementById('prof_birthday')) {
		
		$('#prof_birthday').datetimepicker({
	  //value:'',
	    lang:'en',
	    format: 'd.m.Y',
	    //formatTime: 'H:i',
	    formatDate: 'd.m.Y',
	    startDate:  false, // new Date(), '1986/12/08', '-1970/01/05','-1970/01/05',
	    step:60,
	    monthChangeSpinner:true,
	    closeOnDateSelect:false,
	    closeOnWithoutClick:true,
	    closeOnInputClick: true,
	    timepicker:false,
	    datepicker:true,
	    defaultTime:false,// use formatTime format (ex. '10:00' for formatTime: 'H:i')
	    defaultDate:false, // use formatDate format (ex new Date() or '1986/12/08' or '-1970/01/05' or '-1970/01/05')
	    minDate:false,
	    maxDate:false,
	    minTime:false,
	    maxTime:false,
	    allowTimes:[],
	    opened:false,
	    initTime:true,
	    inline:false,
	    onSelectDate:function() {},
	    onSelectTime:function() {},
	    onChangeMonth:function() {},
	    onChangeDateTime:function() {},
	    onShow:function() {},
	    onClose:function() {},
	    onGenerate:function() {},
	    withoutCopyright:true,
	    inverseButton:false,
	    hours12:false,
	    next: 'xdsoft_next',
	    prev : 'xdsoft_prev',
	    dayOfWeekStart:0,
	    timeHeightInTimePicker:25,
	    //timepicker<a href="http://www.jqueryscript.net/tags.php?/Scroll/">Scroll</a>bar:true,
	    todayButton:true, // 2.1.0
	    defaultSelect:true, // 2.1.0
	    scrollMonth:true,
	    scrollTime:true,
	    scrollInput:true,
	    lazyInit:false,
	    mask:false,
	    validateOnBlur:true,
	    allowBlank:true,
	    yearStart:1950,
	    yearEnd:2050,
	    style:'',
	    id:'',
	    fixed: false,
	    roundTime:'round', // ceil, floor
	    className:'',
	    weekends  :   [],
	    yearOffset:0,
	    beforeShowDay: null
  		});
	  	
	}
	/*изменение данных в профиле*/
	$('.edit-user-data').on('click', function(event){
		event.preventDefault();
		$('.data-user').addClass('hidden');
		$('.data-user-change').removeClass('hidden');
		$('.save-change-user').removeClass('hidden');

        get_user_data();
        
	});
    
	$('.save-change-address, .save-change-user').on('click', function(event){
		event.preventDefault();
        $.ajax({
	      type: "POST",
	      async: false,
	      url: "http://"+window.location.hostname+"/user_api.php",
	      data: $("#user_form").serialize()+"&api_method=save_profile_user&id="+$.cookie('id'),
	      dataType: "html",
	      success: function(data) 
	      {
	        show_prof($.cookie('id'));
	     	    $('.data-user').removeClass('hidden');
			    $('.data-user-change').addClass('hidden');
			    $('.save-change-user').addClass('hidden');

                $('.edit-address').addClass('hidden');
                $('.data-address').removeClass('hidden');
                $('.save-change-address').addClass('hidden');
	      }
	  }); 
	});

	$('.edit-user-address').on('click', function(event){
		event.preventDefault();
		$('.data-address').addClass('hidden');
		$('.edit-address').removeClass('hidden');
		$('.save-change-address').removeClass('hidden');
        
        get_user_data();
	});
	$('.profile-order-history').on('click', function(){
		get_order_history($.cookie('id'));
	})
	//переход в профайл
	$('.profile').on('click', function(event){
		event.stopPropagation();
	});
	//exit
	$('.log-out').on('click', function(event){
		event.preventDefault();
		event.stopPropagation();
		$('.log-out-wrap').addClass('hidden');
		$.cookie('basket', null, {path:'/'});
		$.cookie('bonus', null, {path:'/'});
		$.cookie('cntRest', null, {path:'/'});
		$.cookie('user', null, {path:'/'});
		$.cookie('phone', null, {path:'/'});
		$.cookie('id', null, {path:'/'});
		basket = [];
		$('.header .reg > div p').text('Личный кабинет');
		$('.basket .cnt p').text(basket.length);
		$('.basket .summ').text(totalPriceOrder+' руб');
		$('.basket .clean').removeClass('hidden');
		$('.basket .full').addClass('hidden');
		//если был заказ закрываем блоки
		$('.menu-item').each(function(){
			$(this).find('.cnt-container').addClass('hidden');
			$(this).find('input').attr('value','1');
			$(this).find('.add-btn').removeClass('hidden');
		});
		$('.menu-item.bonus').each(function(){
			$(this).find('.add-btn').attr('disabled','disabled');
			$(this).find('.add-btn').text('Недоступно');
		});

        location.href="/";
	});
	//exit mobile 
	$('.mobile-log-out').on('click', function(event){
		event.preventDefault();
		event.stopPropagation();
		$('.log-out-wrap').addClass('hidden');
		$.cookie('basket', null, {path:'/'});
		$.cookie('bonus', null, {path:'/'});
		$.cookie('cntRest', null, {path:'/'});
		$.cookie('user', null, {path:'/'});
		$.cookie('phone', null, {path:'/'});
		$.cookie('id', null, {path:'/'});
		basket = [];
		$('.profile-wrap').addClass('hidden');
		$('.register-wrap').removeClass('hidden');
		//если был заказ закрываем блоки
		$('.menu-item').each(function(){
			$(this).find('.cnt-container').addClass('hidden');
			$(this).find('input').attr('value','1');
			$(this).find('.add-btn').removeClass('hidden');
		});
		$('.menu-item.bonus').each(function(){
			$(this).find('.add-btn').attr('disabled','disabled');
			$(this).find('.add-btn').text('Недоступно');
		});
	});
	//редактирование профайла в мобиле
	$('.edit-profile').on('click', function(){
		$('.new-data-save').removeClass('hidden');
		get_user_data($.cookie('id'));
	});
	//сохранение профайла
	$('.new-data-save').on('click', function(){
		 $.ajax({
	      type: "POST",
	      async: false,
	      url: "http://"+window.location.hostname+"/user_api.php",
	      data: $(".form-user-data").serialize()+"&api_method=save_profile_user&id="+$.cookie('id'),
	      dataType: "html",
	      success: function(data) 
	      {
	        show_prof($.cookie('id'));
	        $('.default-data').removeClass('hidden');
			$('.new-data').addClass('hidden');
			$('.new-data-save').addClass('hidden');
	      }
	  }); 
	});
	$('.send-partner').on('click', function(){
		sendPartner();
	})
	$('p.reviews a').on('click',function(event){
		event.preventDefault();
		var scroll = $('div.reviews').offset().top;
		$("body , html").animate({"scrollTop": scroll}, 1000);
	});
});

/*END READY*/

// function add_rest_like(restId) {
  
//     $.ajax({
//       type: "POST",
//       async: false,
//       url: "http://"+window.location.hostname+"/user_api.php",
//       data: "api_method=add_rest_like&var="+restId,
//       dataType: "html",
//       success: function(data) {
       
//         if(data=='false')
//         {
//             alert('Ваш голос уже был учтен для этого заведения!');
//         } else
//         {
//             alert('Спасибо за Ваш голос!!!');
//         }
//         update_likes(restId);

//       }
//   }); 
// }
// function add_rest_antilike(restId) { 
//     $.ajax({
//       type: "POST",
//       async: false,
//       url: "http://"+window.location.hostname+"/user_api.php",
//       data: "api_method=add_rest_antilike&var="+restId,
//       dataType: "html",
//       success: function(data) {

//         if(data=='false')
//         {
//             alert('Ваш голос уже был учтен для этого заведения!');
//         } else
//         {
//             alert('Спасибо за Ваш голос!!!');
//         }
//         update_likes(restId);

//       }
//   }); 
// }
function update_likes(restId) {
 $.ajax({
      type: "POST",
      async: false,
      url: "http://"+window.location.hostname+"/user_api.php",
      data: "api_method=update_likes&var="+restId,
      dataType: "html",
      success: function(data) {
       arr=data.split('|',2);
       
       $("#"+restId+" .like-container h4").text(arr[0]); 
        $("#"+restId+" .disslike-container h4").text(arr[1]);    
   

      }
  }); 
}  
function getRestorans(checkedList,restArr) {
    var rem = '';
	console.log(checkedList);
	$.ajax({
		type: "POST",
		async: false,
		url: "http://"+window.location.hostname+"/user_api.php",
		data: "api_method=get_restorans&checked_list="+checkedList,
		dataType: "json",
		success: function(data) {
			console.log(data);
			var cntRestOnPage = 0;
			if(data !='') {
				$('#item-list').empty();
				$.each(data, function(key, value) {
					if(cntRestOnPage == 15) {
						return false;
					}
                    
                    if(data[key].remark!='')
                    {
                        rem="<div class='delivery-info'><p>"+data[key].remark+"</p></div>";
                    }
                    
					$('#item-list').append("<li><a href='/"+data[key].url+"' class='l-rest-list__container--item' id="+data[key].id+"><div class='top-shadow'></div><div class='l-rest-list__container--item__media'><img src='"+data[key].rest_img+"' alt=''></div><div class='l-rest-list__container--item__content'><div class='l-rest-list__container--item__content__header'><h4 class='text-uppercase'>"+data[key].name+"</h4><ul id='kitchen-list-"+data[key].id+"'></ul></div><div class='l-rest-list__container--item__content__body'><div><h4>"+data[key].min_sum+" руб</h4><p>мин сумма <br/>заказа</p></div><div><h4>"+data[key].price_delivery+" руб</h4><p>стоимость <br/>доставки</p></div><div class='hidden-xs'><h4>"+data[key].time_delivery+" мин</h4><p>время <br/> доставки</p></div><div><div><div class='like-container' data-target='"+data[key].id+"'><div><img src='/img/svg/like.svg' alt=''></div><div><h4>"+data[key].like+"</h4></div></div><div class='disslike-container' data-target='"+data[key].id+"'><div><img src='/img/svg/disslike.svg' alt=''></div><div><h4>"+data[key].anti+"</h4></div></div></div><p class='reviews'>"+data[key].cnt+" отзывов</p></div></div>"+rem+"</div><div class='bottom-shadow'></div></a></li>");
				    rem='';
                	var kitchen = data[key].kitchen.split(','); 
					for(var i=0; i<kitchen.length; i++) {
						$('#kitchen-list-'+data[key].id).append("<li> "+kitchen[i]+"</li>");
					}
					cntRestOnPage++;
				});
				if(data.length <=15) {
					var cntPage = Math.ceil(data.length/5)
					$('.paggination').empty();
				}
				else {
					var cntPage = Math.ceil(data.length/15)
					$('.paggination').empty();
					for(var i=0; i<cntPage; i++){
						if(i == 0) {
							var numPage =0;
							numPage = numPage + 1 + i;
							$('.paggination').append("<li class='active'><a href='#'>"+numPage+"</a><li>");
						}
						else {
							var numPage =0;
							numPage = numPage + 1 + i;
							$('.paggination').append("<li><a href='#'>"+numPage+"</a><li>");
						}

					}
				}
				//формируем массив ресторанов
				restArr = [];
				for(var i = 0; i<data.length; i++) {
					restArr[i] = data[i];
				}
			}
			else {
				$('#item-list').empty();
				$('.paggination').empty();
			}

		}
	});
	return restArr;
}
function getRestoransPag(numPage, restArr) {
	var restArrPositionEnd = 0;
	var restArrPositionStart = 0;
    var rem = '';
	if(numPage == 1) {
		restArrPositionEnd = 14;
		restArrPositionStart = 0;
	}
	else {
		restArrPositionEnd = (numPage * 15)-1;
		restArrPositionStart = restArrPositionEnd -14;
	}
	$('#item-list').empty();
	for(var i=restArrPositionStart; i<=restArrPositionEnd; i++){
		if(i > restArr.length-1) {
			break;
		}
        
          if(restArr[i].remark!='')
                    {
                        rem="<div class='delivery-info'><p>"+restArr[i].remark+"</p></div>";
                    }
        
		$('#item-list').append("<li><a href='#' class='l-rest-list__container--item' id="+restArr[i].id+"><div class='top-shadow'></div><div class='l-rest-list__container--item__media'><img src='"+restArr[i].rest_img+"' alt=''></div><div class='l-rest-list__container--item__content'><div class='l-rest-list__container--item__content__header'><h4 class='text-uppercase'>"+restArr[i].name+"</h4><ul id='kitchen-list-"+restArr[i].id+"'></ul></div><div class='l-rest-list__container--item__content__body'><div><h4>"+restArr[i].min_sum+" руб</h4><p>мин сумма <br/>заказа</p></div><div><h4>"+restArr[i].price_delivery+" руб</h4><p>стоимость <br/>доставки</p></div><div class='hidden-xs'><h4>"+restArr[i].time_delivery+" мин</h4><p>время <br/> доставки</p></div><div><div><div class='like-container' data-target='"+restArr[i].id+"'><div><img src='img/svg/like.svg' alt=''></div><div><h4>"+restArr[i].rest_like+"</h4></div></div><div class='disslike-container' data-target='"+restArr[i].id+"'><div><img src='img/svg/disslike.svg' alt=''></div><div><h4>"+restArr[i].rest_antilike+"</h4></div></div></div><p class='reviews'>"+restArr[i].comments+" отзывов</p></div></div>"+rem+"</div><div class='bottom-shadow'></div></a></li>");
		 rem='';
        	var kitchen = restArr[i].kitchen.split(','); 
			for(var j=0; j<kitchen.length; j++) {
				$('#kitchen-list-'+restArr[i].id).append("<li> "+kitchen[j]+"</li>");
			}
	}
}
function get_menu_arr(id){
	var menuArr=[]; 
	$.ajax({
      type: "POST",
      async: false,
      url: "http://"+window.location.hostname+"/user_api.php",
      data: 'api_method=get_menu_arr&id='+id,
      dataType: "json",
      success: function(data) {
        	$.each(data, function(key, value) {
        		var menuArrItem = {};
        		menuArrItem.id = data[key].id;
        		menuArrItem.name = data[key].name;
        		menuArrItem.price = data[key].price;
        		menuArrItem.bonus = data[key].bonus;
        		menuArrItem.rest = data[key].rest;
        		menuArr.push(menuArrItem);
        	});
        }
  });
	return menuArr;
}
function getMinSum(id){
	var minSum; 
	$.ajax({
      type: "POST",
      async: false,
      url: "http://"+window.location.hostname+"/user_api.php",
      data: 'api_method=get_min_sum&id='+id,
      dataType: "html",
      success: function(data) {
      	minSum = data;  	
      }
  });
	return minSum;
}
function pushInCookie (basket, cntRest){
	$.cookie('basket', JSON.stringify(basket));
	$.cookie('bonus', bonus);
	$.cookie('cntRest', JSON.stringify(cntRest));
}
function getStreets(str,region){
	if(region == '') {
		console.log('не выбран район')
		return false;
	}
	if (str.length > 2) {
		$.ajax({
	      type: "POST",
	      async: false,
	      url: "http://"+window.location.hostname+"/user_api.php",
	      data: 'api_method=get_streets&str='+str+'&region='+region,
	      dataType: "json",
	      success: function(data) {
	      	if(data != null){
		      	$('.streets-list div').empty();
		      	$.each(data, function(key, value) {
		      		$('.streets-list').css({'display':'block'});
		      		$('.streets-list div').append("<p>"+data[key].name+"</p>");
		      	});
		    }
	      }
	  });
	}
	if(str.length < 2) {
		$('.streets-list').css({'display':'none'});
	}
}
function getPriceDelivery(region, cntRest, basket){
	if(cntRest.length !=0){
		cntRest = JSON.stringify(cntRest);
		$.ajax({
		      type: "POST",
		      async: false,
		      url: "http://"+window.location.hostname+"/user_api.php",
		      data: 'api_method=get_price_delivery&region='+region+'&cnt_rest='+cntRest,
		      dataType: "html",
		      success: function(data) {
		     	$('#order .price-delivery').text(data);
		     	var totalOrder = 0;
		     	for(var i = 0; i <basket.length; i++ ) {
		     		totalOrder += parseInt(basket[i].totalPrice);
		     	}
		     	totalOrder += parseInt(data);
		     	$('#order .total-summ').text(totalOrder);
		      }
		  });
	}
}
function send_basket (cntRest){
	if(window.innerWidth >767){
		if($('#basket_name_desktop').val() == ''){
			$("#basket_name_desktop").css("border", "1px solid red");
			return;
		} else {
			$("#basket_name_desktop").css("border", "1px solid transparent");
		}
	}
	else {
		if($('#basket_name_mobile').val() == ''){
			$("#basket_name_mobile").css("border", "1px solid red");
			return;
		} else {
			$("#basket_name_mobile").css("border", "1px solid #ccc");
		}
	}
	if($('#basket_adress').val() == ''){
			$("#basket_adress").css("border", "1px solid red");
			return;
	} else {
		$("#basket_adress").css("border", "1px solid #ccc");
	}
	if($('#basket_region').val() == 0){
			$(".modal-body .dropdown").css("border", "1px solid red");
			return;
	} else {
		$(".modal-body .dropdown").css("border", "1px solid #ccc");
	}
	if($('#basket_street').val() == ''){
			$("#basket_street").css("border", "1px solid red");
            noty('Необходимо выбрать улицу и ввести номер дома');
			return;
	} else {
		$("#basket_street").css("border", "1px solid #ccc");
	}
	if($('#basket_house').val() == ''){
			$("#basket_house").css("border", "1px solid red");
            noty('Необходимо выбрать улицу и ввести номер дома');
			return;
	} else {
		$("#basket_house").css("border", "1px solid #ccc");
	}
    if($('#basket_phone_desktop').val()=='') {
        noty("Укажите телефон");
        return;
    }
	// if($('#basket_flat').val() == ''){
	// 		$("#basket_flat").css("border", "1px solid red");
	// 		return;
	// } else {
	// 	$("#basket_flat").css("border", "1px solid #ccc");
	// }
	// if($('#basket_pers_desktop').val() == ''){
	// 		$("#basket_pers_desktop").css("border", "1px solid red");
	// 		return;
	// } else {
	// 	$("#basket_pers_desktop").css("border", "1px solid #ccc");
	// }
	// if(window.innerWidth >767){
	// 	if($('#basket_pers_desktop').val() == ''){
	// 			$("#basket_pers_desktop").css("border", "1px solid red");
	// 			return;
	// 	} else {
	// 		$("#basket_pers_desktop").css("border", "1px solid #ccc");
	// 	}
	// 	if($('#basket_sdacha_desktop').val() == ''){
	// 			$("#basket_sdacha_desktop").css("border", "1px solid red");
	// 			return;
	// 	} else {
	// 		$("#basket_sdacha_desktop").css("border", "1px solid #ccc");
	// 	}
	// }
	// else {
	// 	if($('#basket_pers_mobile').val() == ''){
	// 			$("#basket_pers_mobile").css("border", "1px solid red");
	// 			return;
	// 	} else {
	// 		$("#basket_pers_mobile").css("border", "1px solid #ccc");
	// 	}
	// 	if($('#basket_sdacha_mobile').val() == ''){
	// 			$("#basket_sdacha_mobile").css("border", "1px solid red");
	// 			return;
	// 	} else {
	// 		$("#basket_sdacha_mobile").css("border", "1px solid #ccc");
	// 	}
	// }
	var totalPrice=0;
	console.log('delivery_price_global='+delivery_price_global);
	for(var i =0; i< basket.length; i++) {
		totalPrice += parseInt(basket[i].totalPrice); 
	}
	console.log(basket);
	basket = JSON.stringify(basket);
	$.ajax({
      	type: "POST",
      	async: false,
      	url: "http://"+window.location.hostname+"/user_api.php",
      	data: $("#zakaz_form").serialize()+"&api_method=add_basket&basket="+basket+"&cnt_rest="+cntRest+"&id="+$.cookie('id')+"&delivery_price="+delivery_price_global+"&basket_mail="+$.cookie('mail')+"&distance="+$('.distance').val(),
      	dataType: "html",
      	success: function(data) {
      		$('.thx-summ').text(totalPrice + ' руб');
      		$('.thx-delivery').text(delivery_price_global + ' руб');
      		$('#order').modal('hide');
      		$('.basket-list').empty();
      		$.cookie('basket', null, {path:'/'});
			$.cookie('cntRest', null, {path:'/'});
			basket = [];
			$('.cnt-bonus').text(Math.round(totalPrice/10));
			$('.basket .clean').removeClass('hidden');
			$('.basket .full').addClass('hidden');
			$('.menu-item').each(function(){
				$(this).find('.cnt-container').addClass('hidden');
				$(this).find('input').attr('value','1');
				$(this).find('.add-btn').removeClass('hidden');
			});
			$('.menu-item.bonus').each(function(){
				$(this).find('.add-btn').attr('disabled','disabled');
				$(this).find('.add-btn').text('Недоступно');
			});
			$('#basket_pers_desktop').val('');
			$('#basket_sdacha_desktop').val('');
			$('#basket_remark_desktop').val('');
			bonus = bonus+Math.round(totalPrice/10);
			$.cookie('bonus', bonus);
			console.log(bonus);
				setTimeout(function(){
				$('#thx').modal('show');
			},300);
            
            console.log(data);
      	}
  });
}
function register(){
	if($('#user_name').val() == ''){
		$("#user_name").css("border", "1px solid red");
		return;
	} else {
		$("#user_name").css("border", "1px solid transparent");
	}
	if($('#user_mail').val() != ''){
		var r = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
		if (!r.test($("#user_mail").val())) {
		   	$("#user_mail").css("border", "1px solid red");
        	return;
		}

	} 
	if($('#user_pass').val() == ''){
		$("#user_pass").css("border", "1px solid red");
		return;
	} else {
		$("#user_pass").css("border", "1px solid transparent");
	}
	if($('#user_pass').val() != $('#user_pass2').val()) {
		$("#user_pass2").css("border", "1px solid red");
		return;
	}else {
		$("#user_pass2").css("border", "1px solid transparent");
	}
	$.ajax({
      type: "POST",
      url: "http://"+window.location.hostname+"/user_api.php",
      data: $("#register-form").serialize() + "&api_method=reg_user",
      dataType: "html",
      success: function(data) {
        if (data=='err') {noty('Такой e-mail уже зарегистрирован на сайте'); return;}
   		  data = JSON.parse(data);
          $('.header .reg > div p').text(data['name'] +' '+data['famil']);
          $.cookie('user', data['name'] +' '+data['famil']);
          $.cookie('bonus', data['bonus']);
          $.cookie('id', data['id']);
          show_prof($.cookie('id'));
          bonus = parseInt(data['bonus']);
          $(".register-form").trigger('reset');
          var registerHeight = $('.register').outerHeight();
		  //$('.log-out-wrap').removeClass('hidden');
		  $('#basket_name_desktop').val(data['name']);
		  if(window.innerWidth >767){
				$('.register').animate({'margin-top': -registerHeight},500);
			}
			else {
				$('.register').addClass('my-hidden');
				$('.basket').removeClass('hidden');
				//показываем профайл скрываем форму
				$('.profile-wrap').removeClass('hidden');
				$('.register-wrap').addClass('hidden');
				$('.register-overplay').addClass('hidden');
			}
      }
  });
}
function enter(name, pass, email){
	if($('#enter_mail').val() != ''){
		var r = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
		if (!r.test($("#enter_mail").val())) {
		   	$("#enter_mail").css("border", "1px solid red");
        	return;
		}

	}
	if($('#enter_pass').val() == ''){
		$("#enter_pass").css("border", "1px solid red");
		return;
	} else {
		$("#enter_pass").css("border", "1px solid transparent");
	}
	$.ajax({
      type: "POST",
      async: false,
      url: "http://"+window.location.hostname+"/user_api.php",
      data: "enter_name="+name+"&enter_pass="+pass+"&enter_mail="+email+"&api_method=enter_user",
      dataType: "html",
      success: function(data) {
   		  data = JSON.parse(data);
          console.log(data);
   		  if(data['cnt'] !=0) {
	        $('.header .reg > div p').text(data['name']);
	        $.cookie('user', data['name']);
	        $.cookie('bonus', data['bonus']);
	        bonus = parseInt(data['bonus']);
	        $.cookie('phone', data['phone']);
            $.cookie('social', data['social']);
	        $.cookie('id', data['id']);
	        $.cookie('mail', data['mail']);
            show_prof($.cookie('id'));
	        $("#enter-form").trigger('reset');
	        var registerHeight = $('.register').outerHeight();
			//$('.log-out-wrap').removeClass('hidden');
			$('#basket_name_desktop').val(data['name']);
			console.log(data.bonus);
			console.log(data.mail);
			if(data['phone'] != '') {
			  	$('.has-phone').removeClass('hidden').text(data['phone']);
			  	$('.edit-phone').removeClass('hidden');
			  	$('#basket_phone_desktop').attr('value');
			  	$('#basket_phone_desktop').addClass('hidden');
			}
			if(window.innerWidth >767){
				$('.register').animate({'margin-top': -registerHeight},500);
			}
			else {
				$('#basket_name_mobile').val(data['name']);
				$('.register').addClass('my-hidden');
				$('.basket').removeClass('hidden');
				//показываем профайл скрываем форму
				$('.profile-wrap').removeClass('hidden');
				$('.register-wrap').addClass('hidden');
				$('.register-overplay').addClass('hidden');
			}
			if(window.innerWidth >767){
				$('#basket_phone_desktop').val(data['phone']);
			}
			else {
				$('#basket_phone_desktop').val(data['phone']);
			}
	      }
	      else {
	      	alert('нет такого пользователя');
	      }
      }
  }); 
}
function sendReview(id) {
	if($('#review_body').val() == '') {
		$("#review_body").css("border", "1px solid red");
		return;
	}
	else {
		$("#review_body").css("border", "1px solid #ccc")
	}
	var checkbox = false;
	$('.comment-status-like input').each(function(){
		if($(this).val()==1) {
			checkbox = true;
		}
	});
	if(checkbox == false) {
		$('.comment-status-wrap p').css({'color':'red'});
		return;
	}
	else {
		$('.comment-status-wrap p').css({'color':'#333'});
	}
	console.log($(".review-form").serialize());
	$.ajax({
      type: "POST",
      async: false,
      url: "http://"+window.location.hostname+"/user_api.php",
      data: $(".review-form").serialize() + "&api_method=add_comment"+"&id="+id+"&rest_id="+$('#rest_id').val(),
      dataType: "html",
      success: function(data) {
      	console.log(data);
   		 $(".review-form").trigger('reset');
   		 $('#modal-review').modal('hide');
      }
  }); 
}
function preview(token){
    $.getJSON("//ulogin.ru/token.php?host=" +
        encodeURIComponent(location.toString()) + "&token=" + token + "&callback=?",
    function(data){
        data=$.parseJSON(data.toString());
        if(!data.error){
            
            $('#enter_pass').val(data.identity);
            $('#enter_mail').val(data.email);
            
            enter(data.first_name+" "+data.last_name, data.identity, data.email);
            show_prof($.cookie('id'));
            
        }
    });
}

function show_prof(id){
	
    $.ajax({
      type: "POST",
      async: false,
      url: "http://"+window.location.hostname+"/user_api.php",
      data: "api_method=get_profile_user&id="+id,
      dataType: "json",
      success: function(data) {
     
     if($.cookie('social')==1)
     {
        $(".password").addClass('hidden');
     }
     
       $("#prof_name_val").text(data.name);
       $("#prof_phone_val").text(data.phone);
       $("#prof_adr_val").text(data.adr);
       
       $("#prof_street_val").text(data.user_street);
       $("#prof_home_val").text(data.user_home);
       $("#prof_flat_val").text(data.user_flat);
       
       $("#prof_mail_val").text(data.email);
       $("#prof_birthday_val").text(data.birthday);
       $("#bonus_val").text(data.bonus+' баллов');
       console.log(data.name);
      }
  }); 
}

function get_user_data(){
    $.ajax({
      type: "POST",
      async: false,
      url: "http://"+window.location.hostname+"/user_api.php",
      data: "api_method=get_profile_user&id=" + $.cookie('id'),  // вставить айди юзера
      dataType: "json",
      success: function(data) {

       $("#prof_name").val(data.name);
       $("#prof_phone").val(data.phone);
       $("#prof_adr").val(data.adr);
       $("#prof_mail").val(data.email);
       $("#prof_birthday").val(data.birthday);
       $("#prof_birthday_mobile").val(data.birthday);
       $("#prof_street").val(data.user_street);
       $("#prof_home").val(data.user_home);
       $("#prof_flat").val(data.user_flat);
      }
  }); 
}
function get_order_history(id) {
	$.ajax({
	    type: "POST",
	    async: false,
	    url: "http://"+window.location.hostname+"/user_api.php",
	    data: 'api_method=get_order_history&id='+id,
	    dataType: "json",
	    success: function(data) {
	    	// console.log('data='+data);
	      	if(data != null){
	      		console.log(data);
		      	$('.history-order-wrap').empty();
		      	$.each(data, function(key, value) {
		      		$('.history-order-wrap').append("<div class='history-item-order'><ul class='order-data'><li class='order-id' id='itm-"+data[key].id+"'><div><p>ЗАКАЗ <span>"+data[key].id+"</span> | <span>"+data[key].rest_name+"</span></p></div><div><p><span>"+data[key].dat+"</span>, <span>"+data[key].tim+"</span></p></div></li><li class='system'><div><p>Сумма заказа</p></div><div><p>"+data[key].summ+" руб</p></div></li><li class='system'><div><p>Стоимость доставки</p></div><div><p>"+data[key].delivery_price+" руб</p></div></li><li class='system'><div><p>ИТОГО</p></div><div><p>"+(parseInt(data[key].summ) + parseInt(data[key].delivery_price))+" руб</p></div></li></ul></div>");
		      		for(var i =0; i < data[key].items.length; i++ ){
		      			$('#itm-'+data[key].id).after("<li class='order-item'><div><p>"+data[key].items[i].product_name+"</p></div><div><p>"+(parseInt(data[key].items[i].price)/parseInt(data[key].items[i].count))+" руб</p></div><div><p>"+data[key].items[i].count+" шт</p></div><div><p>"+data[key].items[i].price+" руб</p></div></li>");
		      			
		      		}
		      	});
		  	}
	    }
	});
}
function getGradation(id, distance) {
	console.log('getGradation');
	var totalPriceRest=0;
	for(var i = 0; i< basket.length; i++) {
		if(basket[i].rest == id) {
			totalPriceRest+= parseInt(basket[i].totalPrice);
		}
	}
    //alert("api_method=get_gradation&id=" + id +'&distance='+distance+'&total_price_rest='+totalPriceRest);
	//console.log(totalPriceRest);
	$.ajax({
      type: "POST",
      async: false,
      url: "http://"+window.location.hostname+"/user_api.php",
      data: "api_method=get_gradation&id=" + id +'&distance='+distance+'&total_price_rest='+totalPriceRest, 
      dataType: "html",
      success: function(data) {
     	console.log('data=' +data);
     	if(data != ''){
     	  
            if(data == 'not_route')
            {
	    	$('.total-summ').text(0);
	    	$('.delivery-ok').addClass('hidden');
		    $('.delivery-err').removeClass('hidden');
	    	$('.send_basket').attr('disabled','disabled');
	    	alert('В Ваш район доставка с этого ресторана не возможна!');
            return;
          }
     		data = parseInt(data);
     		 if(data % 5 != 0) {
		    	data = data - (data % 5) + 5;
		    }
		    $('.delivery-ok').removeClass('hidden');
		    $('.delivery-err').addClass('hidden');
     		$('.price-delivery').text(data);
     		$('.total-summ').text(totalPriceRest + parseInt(data));
     		$('.send_basket').removeAttr('disabled');

	 
     
        }
	    else {
	    	$('.total-summ').text(0);
	    	$('.delivery-ok').addClass('hidden');
		    $('.delivery-err').removeClass('hidden');
	    	$('.send_basket').attr('disabled','disabled');
	    	alert('Cлишком маленький заказ');
	    }
	    delivery_price_global = data;

      }
  });
}
function getBonus(id) {
	$.ajax({
      type: "POST",
      async: false,
      url: "http://"+window.location.hostname+"/user_api.php",
      data: 'api_method=get_user_bonus&id='+id,
      dataType: "html",
      success: function(data) {
      	bonus = parseInt(data);
      	console.log('getBonus='+data);
        }
  });
}
function sendPartner() {
	if($('#partner_company_name').val() == ''){
		$("#partner_company_name").css("border", "1px solid red");
		return;
	} else {
		$("#partner_company_name").css("border", "1px solid #cececf");
	}

	if($('#partner_user_name').val() == ''){
		$("#partner_user_name").css("border", "1px solid red");
		return;
	} else {
		$("#partner_user_name").css("border", "1px solid #cececf");
	}

	if($('#partner_user_phone').val() == ''){
		$("#partner_user_phone").css("border", "1px solid red");
		return;
	} else {
		$("#partner_user_phone").css("border", "1px solid #cececf");
	}

	if($('#partner_user_mail').val() != ''){
		var r = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
		if (!r.test($("#partner_user_mail").val())) {
		   	$("#partner_user_mail").css("border", "1px solid red");
        	return;
		} else {
			$("#partner_user_mail").css("border", "1px solid #cececf");
		}
	} 
	$.ajax({
      type: "POST",
      url: "http://"+window.location.hostname+"/user_api.php",
      data: $("#form_partner").serialize() + "&api_method=send_mail",
      dataType: "html",
      success: function(data) {
   		 if(data =='ok') {
   		 	$("#form_partner").trigger('reset');
   		 }
      }
  });

}

function noty(text) {
  $('body').append('<div class="noty" style=\"z-index:1100; opacity:0; width: 320px; padding: 15px; text-align: center; border-radius: 10px; position: fixed; top: 25%; left:50%; margin-left: -160px; background-color: #ffab00; box-shadow: 0px 0px 6px 1px rgba(0,0,0,.5);\"><p style=\"margin:0; font-size:16px;\">'+text+'</p></div>');
  $('.noty').animate({'opacity':'1'}, 500);

  setTimeout(function(){
    $('.noty').fadeOut(500);
    $('.noty').animate({'opacity':'0'}, 500);
  },2500);
}