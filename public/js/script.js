// Biến khởi tạo
var view_collection = true;
var viewout = true;
var viewoutSlider = true;
var checkslideFirst = true;
var timeOut_modalCart;
var check_show_modal = true;
var timeOut_tabIndex;
var check_show_tabIndex = true;
var cur_scrollTop = 0;
var timeOutEffect;
if ( typeof(formatMoney) == 'undefined' ){
	formatMoney = '';
}
var check_header_fixTop = false;

var Nobita = {
	parseQueryString: function(){
		var str = window.location.search.toLowerCase();
		var objURL = {};
		str.replace(
			new RegExp("([^?=&]+)(=([^&]*))?", "g"),
			function($0, $1, $2, $3) {
				objURL[$1] = $3;
			});
		return objURL;
	},
	fixHeightProduct: function (data_parent, data_target, data_image) {
		var box_height = 0;
		var box_image = 0;
		var boxtarget = data_parent + ' ' + data_target;
		var boximg = data_parent + ' ' + data_target + ' ' + data_image;
		jQuery(boximg).css('height', 'auto');
		jQuery($(boxtarget)).css('height', 'auto');
		jQuery($(boxtarget)).removeClass('fixheight');
		jQuery($(boxtarget)).each(function() {
			if (jQuery(this).find($(data_image)).height() > box_image) {
				box_image = jQuery(this).find($(data_image)).height();
			}
		});
		if (box_image > 0) {
			jQuery(boximg).height(box_image);
		}
		jQuery($(boxtarget)).each(function() {
			if (jQuery(this).height() > box_height) {
				box_height = jQuery(this).height();
			}
		});
		jQuery($(boxtarget)).addClass('fixheight');
		if (box_height > 0) {
			jQuery($(boxtarget)).height(box_height);
		}
		try {
			fixheightcallback();
		} catch (ex) {}
	},
	setCookiePopup: function (cvalue, exdays, nameCookie) {
		var d = new Date();
		d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
		//$.cookie(nameCookie, cvalue, { expires: d, path: '/' });
	},
	getCookiePopup: function (nameCookie) {
		//return $.cookie(nameCookie);
	},
	changeTemplate: function(element){
		// Change grid list in collection
		if ( $(element).hasClass('active') ) {

		} else {
			$('#event-grid > div:not(.clear-ajax)').hide();
			$('.box-product-lists > .loadmore, .box-product-lists > .pagination-default').hide();
			$('.icon-loading').show();
			$('.btn-change-list').removeClass('active');
			$(element).addClass('active');
			if( $(element).attr('data-template') == 'template-list' ) {
				$('#event-grid').addClass('template-list');
			} else {
				$('#event-grid').removeClass('template-list');
			}
		}
		jQuery('#event-grid').imagesLoaded(function() {
			$('.icon-loading').hide();
			$('#event-grid > div:not(.clear-ajax)').show();
			$('.box-product-lists > .loadmore, .box-product-lists > .pagination-default').show();
			jQuery(window).resize();
		});
	},
	filterItemInList: function(object){
		// Keyup find item in list filter collection
		q = object.val().toLowerCase();
		object.parent().next().find('li').show();
		if (q.length > 0) {
			object.parent().next().find('li').each(function() {
				if ($(this).find('label').attr("data-filter").indexOf(q) == -1)
					$(this).hide();
			})
		}
	},
	filterItemInList_2: function(object){
		// Keyup find item in list filter collection
		q = object.val().toLowerCase();
		q = slug_words(q).trimRight();
		object.parent().next().find('li').show();
		if (q.length > 0) {
			object.parent().next().find('li').each(function() {
				if (slug_words($(this).find('span').html()).indexOf(q) == -1)
					$(this).hide();
			})
		}
	},
	checkItemOwlShow: function(object,tab,a,b,c,d){
		debugger
		// Check owl item next/prev show or hide
		if ( tab == 'tab' ) {
			item = object.find('.active').find('.owl-carousel');
		} else {
			item = object.find('.owl-carousel');
		}	
		if ( item.find('.owl-item.active').length < a && $(window).width() >= 1200 ) {
			item.find('.owl-controls').hide();
		}
		if ( item.find('.owl-item.active').length < b && $(window).width() >= 992 && $(window).width() < 1199 ) {
			item.find('.owl-controls').hide();
		}
		if ( item.find('.owl-item.active').length < c && $(window).width() >= 768 && $(window).width() < 991 ) {
			item.find('.owl-controls').hide();
		}
		if ( item.find('.owl-item.active').length < d && $(window).width() < 768 ) {
			item.find('.owl-controls').hide();
		}
	},
	destroyResize: function(url){
		// Destroy resize image
		if ( url != undefined ) {
			if ( url.indexOf('_pico') != -1 || url.indexOf('_icon') != -1 || url.indexOf('_thumb') != -1
					|| url.indexOf('_small') != -1 || url.indexOf('_compact') != -1 || url.indexOf('_medium') != -1
					|| url.indexOf('_large') != -1 || url.indexOf('_grande') != -1 || url.indexOf('_1024x1024') != -1
					|| url.indexOf('_2048x2048') != -1 || url.indexOf('_master') != -1 ) {		
				link_image = (url.split('_')[url.split('_').length - 1]).split('.')[0];
				switch (link_image) {
					case 'pico': 
						link_image = url.split('_pico').join('').replace('http:','').replace('https:','');;
						break;
					case 'icon': 
						link_image = url.split('_icon').join('').replace('http:','').replace('https:','');;
						break;
					case 'thumb': 
						link_image = url.split('_thumb').join('').replace('http:','').replace('https:','');;
						break;
					case 'small':
						link_image = url.split('_small').join('').replace('http:','').replace('https:','');; 
						break;
					case 'compact': 
						link_image = url.split('_compact').join('').replace('http:','').replace('https:','');;
						break;
					case 'medium': 
						link_image = url.split('_medium').join('').replace('http:','').replace('https:','');;
						break;
					case 'large': 
						link_image = url.split('_large').join('').replace('http:','').replace('https:','');;
						break;
					case 'grande': 
						link_image = url.split('_grande').join('').replace('http:','').replace('https:','');;
						break;
					case '1024x1024': 
						link_image = url.split('_1024x1024').join('').replace('http:','').replace('https:','');;
						break;
					case '2048x2048': 
						link_image = url.split('_2048x2048').join('').replace('http:','').replace('https:','');;
						break;
					case 'master':
						link_image = url.split('_master').join('').replace('http:','').replace('https:','');;
						break;
				}
				return link_image;
			}
			return url;
		}
	},
	// getCartModal: function(){
	// 	// Modal Cart
	// 	var cart = null;
	// 	jQuery('#cartform').hide();
	// 	jQuery('#myCart #exampleModalLabel').text("Giỏ hàng");
	// 	jQuery.getJSON('/cart.js', function(cart, textStatus) {
	// 		if(cart) {
	// 			jQuery('#cartform').show();
	// 			jQuery('.line-item:not(.original)').remove();
	// 			jQuery.each(cart.items,function(i,item){
	// 				var total_line = 0;
	// 				var total_line = item.quantity * item.price;
	// 				tr = jQuery('.original').clone().removeClass('original').appendTo('table#cart-table tbody');
	// 				if(item.image != null)
	// 					tr.find('.item-image').html("<img src=" + Haravan.resizeImage(item.image,'small') + ">");
	// 				else
	// 					tr.find('.item-image').html("<img src='//hstatic.net/0/0/global/noDefaultImage6_large.gif'>");
	// 				vt = item.variant_options;
	// 				if(vt.indexOf('Default Title') != -1)
	// 					vt = '';
	// 				tr.find('.item-title').children('a').html(item.product_title + '<br><span>' + vt + '</span>').attr('href', item.url);
	// 				tr.find('.item-quantity').html("<input id='quantity1' name='updates[]' min='1' type='number' value=" + item.quantity + " class='' />");
	// 				if ( typeof(formatMoney) != 'undefined' ){
	// 					tr.find('.item-price').html(Haravan.formatMoney(total_line, formatMoney));
	// 				}else {
	// 					tr.find('.item-price').html(Haravan.formatMoney(total_line, ''));
	// 				}
	// 				tr.find('.item-delete').html("<a href='javascript:void(0);' onclick='deleteCart(" + item.variant_id + ")' ><svg class='svg-next-icon svg-next-icon-size-16' style='fill:#333'><use xlink:href='#icon-delete'></use></svg></a>");
	// 			});
	// 			jQuery('.item-total').html(Haravan.formatMoney(cart.total_price, formatMoney));
	// 			jQuery('.modal-title').children('b').html(cart.item_count);
	// 			jQuery('#cart-count').html(cart.item_count);
	// 			if(cart.item_count == 0){				
	// 				jQuery('#exampleModalLabel').html('Giỏ hàng của bạn đang trống. Mời bạn tiếp tục mua hàng.');
	// 				jQuery('#cart-view').html('<tr><td>Hiện chưa có sản phẩm</td></tr>');
	// 				jQuery('#cartform').hide();
	// 			}
	// 			else{			
	// 				jQuery('#exampleModalLabel').html('Bạn có ' + cart.item_count + ' sản phẩm trong giỏ hàng.');
	// 				jQuery('#cartform').removeClass('hidden');
	// 				jQuery('#cart-view').html('');
	// 			}
	// 			// Get product for cart view

	// 			jQuery.each(cart.items,function(i,item){
	// 				Nobita.clone_item(item);
	// 			});
	// 			jQuery('#total-view-cart').html(Haravan.formatMoney(cart.total_price, formatMoney));
	// 		}
	// 		else{
	// 			jQuery('#exampleModalLabel').html('Giỏ hàng của bạn đang trống. Mời bạn tiếp tục mua hàng.');
	// 			jQuery('#cart-view').html('<tr><td>Hiện chưa có sản phẩm</td></tr>');
	// 			jQuery('#cartform').hide();
	// 		}
	// 	});
	// },
	// clone_item: function(product){
	// 	var item_product = jQuery('#clone-item-cart').find('.item_2');
	// 	item_product.find('img').attr('src',Haravan.resizeImage(product.image,'small')).attr('alt', product.url);
	// 	item_product.find('a').attr('href', product.url).attr('title', product.url);
	// 	item_product.find('.pro-title-view').html(product.title);
	// 	item_product.find('.pro-quantity-view').html('Số lượng: ' + product.quantity);
	// 	item_product.find('.pro-price-view').html('Giá: ' + Haravan.formatMoney(product.price,formatMoney));
	// 	item_product.clone().removeClass('hidden').prependTo('#cart-view');
	// },
	// delete_item_in_Cart: function(variant_id){
	// 	var params = {
	// 		type: 'POST',
	// 		url: '/cart/change.js',
	// 		data: 'quantity=0&id=' + variant_id,
	// 		dataType: 'json',
	// 		success: function(cart) {
	// 			Nobita.getCartModal();
	// 		},
	// 		error: function(XMLHttpRequest, textStatus) {
	// 			Haravan.onError(XMLHttpRequest, textStatus);
	// 		}
	// 	};
	// 	jQuery.ajax(params);
	// },
	// buy_now: function(id){
	// 	// Add a product in checkout
	// 	var quantity = 1;
	// 	var params = {
	// 		type: 'POST',
	// 		url: '/cart/add.js',
	// 		data: 'quantity=' + quantity + '&id=' + id,
	// 		dataType: 'json',
	// 		success: function(line_item) {
	// 			window.location = '/checkout';
	// 		},
	// 		error: function(XMLHttpRequest, textStatus) {
	// 			Haravan.onError(XMLHttpRequest, textStatus);
	// 		}
	// 	};
	// 	jQuery.ajax(params);
	// },
	// add_item: function(id){
	// 	// Add a product in cart
	// 	var quantity = 1;
	// 	var params = {
	// 		type: 'POST',
	// 		url: '/cart/add.js',
	// 		data: 'quantity=' + quantity + '&id=' + id,
	// 		dataType: 'json',
	// 		success: function(line_item) {
	// 			window.location = '/cart';
	// 		},
	// 		error: function(XMLHttpRequest, textStatus) {
	// 			Haravan.onError(XMLHttpRequest, textStatus);
	// 		}
	// 	};
	// 	jQuery.ajax(params);
	// },
	// add_item_show_modalCart: function(id){
	// 	// Add a product and show modal cart
	// 	if( check_show_modal ) {		
	// 		check_show_modal = false;
	// 		timeOut_modalCart = setTimeout(function(){ 
	// 			check_show_modal = true;
	// 		}, 3000);
	// 		if ( $('.addtocart-modal').hasClass('clicked_buy') ) {
	// 			var quantity = $('#quantity').val();
	// 		} else {
	// 			var quantity = 1;
	// 		}
	// 		var params = {
	// 			type: 'POST',
	// 			url: '/cart/add.js',
	// 			async: true,
	// 			data: 'quantity=' + quantity + '&id=' + id,
	// 			dataType: 'json',
	// 			success: function(line_item) {
	// 				if ( jQuery(window).width() >= 1200 ) {
	// 					Nobita.getCartModal();					
	// 					jQuery('#myCart').modal('show');				
	// 					jQuery('.modal-backdrop').css({'height':jQuery(document).height(),'z-index':'99'});
	// 				} else {
	// 					window.location = '/cart';
	// 				}
	// 				$('.addtocart-modal').removeClass('clicked_buy');
	// 			},
	// 			error: function(XMLHttpRequest, textStatus) {
	// 				Haravan.onError(XMLHttpRequest, textStatus);
	// 			}
	// 		};
	// 		jQuery.ajax(params);
	// 	}
	// },
	plusQuantity: function(){
		// Plus number quantiy product detail 
		if ( jQuery('input[name="quantity"]').val() != undefined ) {
			var currentVal = parseInt(jQuery('input[name="quantity"]').val());
			if (!isNaN(currentVal)) {
				jQuery('input[name="quantity"]').val(currentVal + 1);
			} else {
				jQuery('input[name="quantity"]').val(1);
			}
		}else {
			console.log('error: Not see elemnt ' + jQuery('input[name="quantity"]').val());
		}
	},
	minusQuantity: function(){
		// Minus number quantiy product detail 
		if ( jQuery('input[name="quantity"]').val() != undefined ) {
			var currentVal = parseInt(jQuery('input[name="quantity"]').val());
			if (!isNaN(currentVal) && currentVal > 1) {
				jQuery('input[name="quantity"]').val(currentVal - 1);
			}
		}else {
			console.log('error: Not see elemnt ' + jQuery('input[name="quantity"]').val());
		}
	},
	slug: function(str){
		// Change handleize
		str = str.toLowerCase();
		str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
		str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
		str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
		str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
		str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
		str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
		str = str.replace(/đ/g, "d");
		str = str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'| |\"|\&|\#|\[|\]|~|$|_/g, "-");
		str = str.replace(/-+-/g, "-"); //thay thế 2- thành 1- 
		str = str.replace(/^\-+|\-+$/g, "");
		return str;
	},
	slug_words: function(str) {
		str = str.toLowerCase();
		str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
		str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
		str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
		str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
		str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
		str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
		str = str.replace(/đ/g, "d");
		str = str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'| |\"|\&|\#|\[|\]|~|$|_/g, " ");
		str = str.replace(/-+-/g, ""); //thay thế 2- thành 1- 
		str = str.replace(/^\-+|\-+$/g, "");
		return str;
	}
}

jQuery(document).ready(function(){
	// Image Product Loaded fix height
	jQuery('.box-product-lists .image-resize').imagesLoaded(function() {
		Nobita.fixHeightProduct('.box-product-lists','.product-resize','.image-resize');
		jQuery(window).resize(function() {
			Nobita.fixHeightProduct('.box-product-lists','.product-resize','.image-resize');
		});
	});
	// Slider index
	if($('#slider-menu').length > 0 ) {
		$('#slider-menu .owl-carousel').owlCarousel({
			items: 1,
			dots: true,
			autoplay:true,
			autoplayTimeout:5000,
			autoplayHoverPause:true
		});
	}
	// Group About us owl-carousel index
	if ($('#aboutus-slide').length > 0 ) {
		$('#aboutus-slide.owl-carousel').owlCarousel({
			items: 1,
			nav: true,
			dots: false,
			autoplay:true,
			autoplayTimeout:5000,
			autoplayHoverPause:true
		});
		$('#aboutus-slide.owl-carousel').find('.owl-next').html("<svg class='svg-next-icon svg-next-icon-size-16' style='fill:#fff'><use xlink:href='#icon-right-owlCarousel'></use></svg>");
		$('#aboutus-slide.owl-carousel').find('.owl-prev').html("<svg class='svg-next-icon svg-next-icon-size-16' style='fill:#fff'><use xlink:href='#icon-left-owlCarousel'></use></svg>");
	}
	// Group Teacher owl-carousel index
	if ($('#slider-teacher').length > 0 ) {
		$('#slider-teacher .owl-carousel').owlCarousel({
			nav: true,
			dots: false,
			margin: 15,
			responsive:{
				0:{
					items:1
				},
				768:{
					items:2
				},
				1024:{
					items:3
				},
				1200:{
					items:3
				}
			}
		});
		$('#slider-teacher .owl-carousel').find('.owl-next').html("<svg class='svg-next-icon svg-next-icon-size-16' style='fill:#fff'><use xlink:href='#icon-right-owlCarousel'></use></svg>");
		$('#slider-teacher .owl-carousel').find('.owl-prev').html("<svg class='svg-next-icon svg-next-icon-size-16' style='fill:#fff'><use xlink:href='#icon-left-owlCarousel'></use></svg>");
	}
	// Group blog owl-carousel index
	if ($('#blog-index').length > 0 ) {
		$('#blog-index.owl-carousel').owlCarousel({
			margin: 15,
			dots: false,
			responsive:{
				0:{
					items:1
				},
				768:{
					items:2
				},
				1024:{
					items:4
				}
			}
		});
	}
	// Group Brand owl-carousel index
	if ($('.brand-carousel').length > 0 ) {
		$('.brand-carousel .owl-carousel').owlCarousel({
			items: 10,
			margin: 15,
			dots: false,
			responsive:{
				0:{
					items:3
				},
				768:{
					items:6
				},
				1024:{
					items:8
				}
			}
		});
	}
	// Menu sidebarleft index
	if ($('#menusidebarleft').length > 0 ) {
		$('#menusidebarleft li a').click(function(e){
			if ( $(this).parent('li').attr('aria-expanded') == 'false' ) {
				e.preventDefault();
				if ( $(this).parent('.submenu-parent').length > 0 ) {
					$(this).parent('.submenu-parent').parent('ul').find('li.submenu-parent,li.submenu-children').attr('aria-expanded','false').children('ul').slideUp();

				} else {
					if ( $(this).parent('.submenu-children').length > 0 ) {
						$(this).parent('.submenu-children').parent('ul').children('li.submenu-parent,li.submenu-children').attr('aria-expanded','false').children('ul').slideUp();
					}
				}
				$(this).parent('li').attr('aria-expanded','true');
				$(this).nextAll(".dropdown-menu").slideDown();
				$(this).next('ul').slideDown();			
			} else {
				$(this).nextAll(".dropdown-menu").slideUp();
				$(this).parent('li').attr('aria-expanded','false');
			}
		});
	}
	// Product related
	if ($('#product-related').length > 0 ) {
		$('#product-related .owl-carousel').owlCarousel ({
			margin: 15,
			nav: false,
			dots: false,
			responsive:{
				0:{
					items:2
				},
				768:{
					items:3
				},
				1024:{
					items:4
				}
			}
		});
		$('#product-related .owl-carousel').find('.owl-next').html("<svg class='svg-next-icon svg-next-icon-size-16' style='fill:#333'><use xlink:href='#icon-right-owlCarousel'></use></svg>");
		$('#product-related .owl-carousel').find('.owl-prev').html("<svg class='svg-next-icon svg-next-icon-size-16' style='fill:#333'><use xlink:href='#icon-left-owlCarousel'></use></svg>");
	}

	$(document).on("click",".dropdown-filter", function(){
		if ( $(this).parent().attr('aria-expanded') == 'false' ) {
			$(this).parent().attr('aria-expanded','true');
		} else {
			$(this).parent().attr('aria-expanded','false');
		}
	});
	$(document).on("click", "#trigger-mobile", function(){
		if ($('body').hasClass('responsive') == false) {
			$('body').addClass('responsive helper-overflow-hidden');
			$('html').addClass('helper-overflow-hidden');
			$(window).scrollTop(0);
			$('body').removeClass('hideresponsive');
			$("#box-wrapper").bind('click', function () {
				$("body").removeClass("responsive helper-overflow-hidden");
				$('html').removeClass('helper-overflow-hidden');
				$('body').addClass('hideresponsive');
				$("#box-wrapper").unbind('click');
			});
		}
		else {
			$("body").removeClass("responsive helper-overflow-hidden");
			$('html').removeClass('helper-overflow-hidden');
			$('body').addClass('hideresponsive');
		}
	});

	$(document).on("click", "#menu-mobile li a", function(){
		if ($(this).parent('li').hasClass('active')){
			$('#menu-mobile .menu-mobile ul').slideUp('fast');
			$(this).parent('li').removeClass('active');
		} else {
			$('#menu-mobile li.active').removeClass('active');
			$('#menu-mobile .menu-mobile ul').slideUp('fast');
			$(this).parent('li').addClass('active').find('ul').slideDown('fast');
		}
	});
	// Update product in modalCart
	// jQuery(document).on("click","#update-cart-modal",function(event){
	// 	event.preventDefault();
	// 	if (jQuery('#cartform').serialize().length <= 5) return;
	// 	jQuery(this).html('Đang cập nhật');
	// 	var params = {
	// 		type: 'POST',
	// 		url: '/cart/update.js',
	// 		data: jQuery('#cartform').serialize(),
	// 		dataType: 'json',
	// 		success: function(cart) {
	// 			if ((typeof callback) === 'function') {
	// 				callback(cart);
	// 			} else {
	// 				Nobita.getCartModal();
	// 			}
	// 			jQuery('#update-cart-modal').html('Cập nhật');
	// 		},
	// 		error: function(XMLHttpRequest, textStatus) {
	// 			Haravan.onError(XMLHttpRequest, textStatus);
	// 		}
	// 	};
	// 	jQuery.ajax(params);
	// });

	jQuery(document).on('click','.headtab-filter a',function(){
		$('.headtab-filter').removeClass('active');
		$(this).parent().addClass('active');
	});

	jQuery(document).on('click','.btn-select li',function(){
		$(this).parents('.bootstrap-select').addClass('active');
		$(this).parents('.bootstrap-select').find('.dropdown-toggle > .filter-option').html($(this).find('span').html());
		if ( $(this).parents('#filter-acreage-index').length > 0 || $(this).parents('#filter-price-index').length > 0 ){
			$(this).parents('.bootstrap-select').find('.dropdown-toggle > .filter-option').attr('data-filter',$(this).find('span').attr('data-filter'));
		}	else {
			$(this).parents('.bootstrap-select').find('.dropdown-toggle > .filter-option').attr('data-filter',$(this).find('span').html());
			$(this).parents('.bootstrap-select').find('.bs-searchbox input').val('');
		}
		$('.btn-select li').show();
		if( $(this).parent('.data-bind-city').length > 0 && $(this).attr('data-city') != '' && $(this).attr('data-city').indexOf('tatca') == -1 ) {
			$('.data-bind-district').html('');
			$('#filter-district > .dropdown-menu').removeClass('hidden');
			$.each(district[$(this).attr('data-city')],function(i,v){
				$('.data-bind-district').append("<li><a><span class='text'>" + v + "</span></a></li>");
			});
		}
	});

	jQuery('.product-comments .tab-content > div').eq(0).addClass('active');

	$('#navbar li').hover(function(){
		$(this).toggleClass('open');
	});

	// Scroll Top
	jQuery(document).on("click", ".back-to-top", function(){
		jQuery(this).removeClass('display');
		jQuery('html, body').animate({
			scrollTop: 0			
		}, 600);
	});

	// Add attribute data-spy=scroll in element <a> when you click, it'll scroll to href="#abc"
	jQuery(document).on("click", "a[data-spy=scroll]", function(e) {
		e.preventDefault();
		jQuery('body').animate({scrollTop: (jQuery(jQuery(this).attr('href')).offset().top - 70) + 'px'}, 500);
	});

	// Add a product when you change variant in cart ( product detail )
	// jQuery(document).on("click", "#buy-now", function(e) {
	// 	e.preventDefault() ;
	// 	var params = {
	// 		type: 'POST',
	// 		url: '/cart/add.js',
	// 		data: jQuery('#add-item-form').serialize(),
	// 		dataType: 'json',
	// 		success: function(line_item) {
	// 			window.location = '/checkout';
	// 		},
	// 		error: function(XMLHttpRequest, textStatus) {
	// 			Haravan.onError(XMLHttpRequest, textStatus);
	// 		}
	// 	};
	// 	jQuery.ajax(params);
	// });

	// Active image thumb and change image featured ( product detail )
	jQuery(document).on("click", ".product-thumb img", function() {
		jQuery('.product-thumb').removeClass('active');
		jQuery(this).parents('.product-thumb').addClass('active');
		jQuery(".product-image-feature").attr("src",jQuery(this).parent().attr("data-image"));
	});

	// Active image thumb and change image featured ( Quickview )
	jQuery(document).on("click", ".slide-quickview a", function(){
		$('.slide-quickview a.active').removeClass('active');
		$(this).addClass('active');
		image_url = $(this).attr('data-image');
		$('.quickview-image').find('img').attr('src', image_url);
	});

	// Click change slide next image featured ( product detail )
	jQuery(document).on("click", ".slide-next", function() {
		if(jQuery(".product-thumb.active").prev().length > 0){
			jQuery(".product-thumb.active").prev().find('img').click();
		}
		else{
			jQuery(".product-thumb:last img").click();
		}
	});

	// Click change slide prev image featured ( product detail )
	jQuery(document).on("click", ".slide-prev", function() {
		if(jQuery(".product-thumb.active").next().length > 0){
			jQuery(".product-thumb.active").next().find('img').click();
		}
		else{
			jQuery(".product-thumb:first img").click();
		}
	});

	// Search filter index sidebar
	$(document).on("click","#search-index", function(){
		data_type = $('#filter-type .headtab-filter.active').attr('data-type');
		search_filter = '/search?q=filter=(';
		url = '' + data_type;
		data_city = $('#filter-city > button').find('span').attr('data-filter');
		if ( data_city.indexOf('Tất cả') == -1 ) {
			data_city = '(vendor:product**' + data_city + ')';
			url = url + '&&' + data_city;
		}
		data_district = $('#filter-district > button').find('span').attr('data-filter');
		if ( data_district.indexOf('Tất cả') == -1 ) {
			data_district = '(tag:product**' + data_district + ')';
			url = url + '&&' + data_district;
		}
		data_acreage = $('#filter-acreage-index > button').find('span').attr('data-filter');
		if ( data_acreage.indexOf('Tất cả') == -1 ) {
			url = url + '&&' + data_acreage;
		}
		data_price = $('#filter-price-index > button').find('span').attr('data-filter');
		if ( data_price.indexOf('Tất cả') == -1 ) {
			url = url + '&&' + data_price;
		}
		window.location = search_filter + encodeURIComponent(url) + ")";
	});

	// Cart header hover
	jQuery('.cart-link').hover(function() {
		jQuery('.cart-view').slideDown(200);
	}, function() {
		setTimeout(function() {
			if (viewout) jQuery('.cart-view').slideUp(200);
		}, 500)
	});
	jQuery('.cart-view').hover(function() {
		viewout = false;
	}, function() {
		viewout = true;
		jQuery('.cart-view').slideUp(100);
	});

	// Ajax get product in collection for page home
	if ( $('#tab-product-template').length > 0 ) {
		$('#tab-product-template').tabdrop({text: '<i class="fa fa-bars"></i>'});
	}

	// Scroll show icon section index
	jQuery(window).on("scroll", function() {	
		/* Process scroll header top  */		
		if ($(window).width() >= 768) {
			if( jQuery(window).scrollTop() > 0 ) {			
				jQuery('nav.navbar-main.navbar').addClass('affix-mobile');
			}	else {
				jQuery('nav.navbar-main.navbar').removeClass('affix-mobile');
			}
		}
		/* Scroll to top */
		if ( jQuery('.back-to-top').length > 0 && jQuery(window).scrollTop() > 500 ) {
			jQuery('.back-to-top').addClass('display');
		} else {
			jQuery('.back-to-top').removeClass('display');
		}
	});

});