var G5Plus_Product_Categories_Home = G5Plus_Product_Categories_Home || {};
(function ($) {
	"use strict";
	G5Plus_Product_Categories_Home = {
		init : function() {
			G5Plus_Product_Categories_Home.setHeight();
			G5Plus_Product_Categories_Home.showMoreClick();
		},
		setHeight : function() {
			$('.sc-product-categories-home-wrap').each(function(){
				var wrapCurrent = $(this);
				var heightFull = $('.product-categories-home',wrapCurrent).outerHeight() + parseInt($(wrapCurrent).css('padding-top').replace('px',''),10) + parseInt($(wrapCurrent).css('padding-bottom').replace('px',''),10);
				var heightConfig = parseInt($(wrapCurrent).data('height'),10);
				var responsivePoint = 767;
				if ($(wrapCurrent).hasClass('style-02')) {
					responsivePoint = 991;
				}
				if (!isNaN(heightConfig)) {
					if (window.matchMedia('(max-width: '+ responsivePoint +'px)').matches && (heightConfig > heightFull)) {
						$(wrapCurrent).css('height','');
					} else {
						$(wrapCurrent).css('height',heightConfig + 'px');
					}

				}
			});
		},
		showMoreClick : function() {
			var wrap = $('.sc-product-categories-home-wrap');
			$(wrap).on('click','.show-more',function() {
				var wrapCurrent = $(this).parent();
				var heightFull = $('.product-categories-home',wrapCurrent).outerHeight() + parseInt($(wrapCurrent).css('padding-top').replace('px',''),10) + parseInt($(wrapCurrent).css('padding-bottom').replace('px',''),10);
				var heightConfig = parseInt($(wrapCurrent).data('height'),10);
				var heightCurrent = $(wrapCurrent).css('height');
				if (heightCurrent.indexOf('px') >= 0) {
					heightCurrent = parseInt(heightCurrent.replace('px',''),10) ;
				}

				if (isNaN(heightConfig) || (heightConfig >= heightFull)) {
					return;
				}

				if (heightConfig == heightCurrent) {
					$(wrapCurrent).css('height',heightFull + 'px');
					$(this).addClass('up');
				} else {
					$(wrapCurrent).css('height',heightConfig + 'px');
					$(this).removeClass('up');
				}
			});
		},
		isDesktop: function () {
			return window.matchMedia('(max-width: 767px)').matches;
		},
		windowResized : function() {
			G5Plus_Product_Categories_Home.setHeight();
		}
	};

	$(document).ready(G5Plus_Product_Categories_Home.init);
	$(window).resize(G5Plus_Product_Categories_Home.windowResized);
})(jQuery);
