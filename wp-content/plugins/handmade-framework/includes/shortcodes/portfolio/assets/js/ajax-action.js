/**
 * Created by phuongth on 3/20/15.
 */
"use strict";
var PortfolioAjaxAction = {
    htmlTag:{
        load_more :'.load-more',
        portfolio_container: '#portfolio-'
    },
    vars:{
        ajax_url: '',
        tab_category_action: 'filter'
    },

    processFilter:function(elm, isLoadmore){
        var $this = jQuery(elm);
        var l = Ladda.create(elm);
        l.start();
        var $filterType = $this.attr('data-load-type');
        var $overlay_style = $this.attr('data-overlay-style');
        var $section_id = $this.attr('data-section-id');
        var $data_source = $this.attr('data-source');
        var $data_portfolioIds = $this.attr('data-portfolio-ids');
        var $data_show_paging = $this.attr('data-show-paging');
        var $current_page =  $this.attr('data-current-page');
        var $category  = $this.attr('data-category');
        var $offset = 0;
        var $post_per_page = $this.attr('data-post-per-page');
        var $column = $this.attr('data-column');
        var $padding = '';
        var $order =  $this.attr('data-order');
        var $layout_type = $this.attr('data-layout-type');

        if($filterType=='ajax'){
            jQuery('a.active', jQuery(elm).parent().parent()).removeClass('active');
            jQuery('li.active', jQuery(elm).parent().parent()).removeClass('active');
            jQuery($this).parent().addClass('active');
            jQuery($this).addClass('active');
        }else{
            $category = jQuery('a.active', jQuery(elm).parent().parent()).attr('data-category');
        }

        jQuery.ajax({
            url: PortfolioAjaxAction.vars.ajax_url,
            data: ({action : 'g5plusframework_portfolio_load_by_category', postsPerPage: $post_per_page, current_page: $current_page,
                layoutType: $layout_type,category : $category,
                columns: $column, colPadding: $padding, offset: 0, order: $order,
                data_source  : $data_source, portfolioIds: $data_portfolioIds, data_show_paging: $data_show_paging,
                overlay_style: $overlay_style, data_section_id: $section_id
            }),
            success: function(data) {
                l.stop();
                if($filterType=='ajax')
                    PortfolioAjaxAction.registerFilterByCategory($section_id);

                if($data_show_paging=='1'){
                    jQuery('#load-more-' + $section_id).empty();
                    if(jQuery('.paging',data).length>0){
                        var $loadButton = jQuery('.portfolio .paging a',data);
                        $loadButton.attr('data-section-id',$section_id);
                        jQuery('#load-more-' + $section_id).append($loadButton);
                        PortfolioAjaxAction.registerLoadmore();
                    }
                }
                var $container = jQuery('#portfolio-container-' + $section_id);

                var $item = jQuery('.portfolio-item',data);


                if(isLoadmore == null || !isLoadmore){
                    $container.isotope();
                    jQuery('.portfolio-item',$container).each(function(){
                        $container.isotope( 'remove', jQuery(this) );
                    })
                    $container.fadeOut();
                    $item.css('transition','all 0.3s');
                    $item.css('-webkit-transition','all 0.3s');
                    $item.css('-moz-transition','all 0.3s');
                    $item.css('-ms-transition','all 0.3s');
                    $item.css('-o-transition','all 0.3s');
                    $item.css('opacity',0);
                }else{
                    $item.fadeOut();
                }
                if(isLoadmore !=null && isLoadmore && $filterType=='ajax'){
                    $container.append( $item );

                }else{

                    $container.append( $item ).isotope( 'appended', $item);
                    var $containerIsotope = jQuery('div[data-section-id="' + $section_id + '"]');
                    $containerIsotope.imagesLoaded( function() {
                        jQuery('.portfolio-item > div').hoverdir('destroy');
                        jQuery('.portfolio-item > div').hoverdir('rebuild');
                        $container.isotope({ filter: '*' });
                    });

                }

                PortfolioAjaxAction.registerPrettyPhoto();

                var owl = jQuery($container).data('owlCarousel');
                if(owl!=null && $item.length > 0 ){
                    owl.destroy();
                    jQuery($container).owlCarousel({
                        items : $column,
                        pagination: false,
                        navigation: true,
                        navigationText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>']
                    });
                }
                jQuery('.portfolio-item > div.entry-thumbnail').hoverdir();
                if($filterType=='ajax'){
                    $container.fadeIn(10,function(){
                        $item.css('opacity',1);
                    });
                }else{
                    $item.fadeIn();
                }



                PortfolioAjaxAction.registerLoadmore($section_id);

            },
            error:function(){
                if($filterType=='ajax')
                    PortfolioAjaxAction.registerFilterByCategory($section_id);
            }
        });
    },

    registerLoadmore:function(sectionId){
        jQuery('a','#load-more-' + sectionId).off();
        jQuery('a','#load-more-' + sectionId).click(function(){
            PortfolioAjaxAction.processFilter(this, true);
            jQuery('li.active','.portfolio-tabs').removeClass('active');
            jQuery('a.active','.portfolio-tabs').removeClass('active');
            jQuery('li:first-child','.portfolio-tabs').addClass('active');
            jQuery('li:first-child a','.portfolio-tabs').addClass('active');
        });
    },

    registerPrettyPhoto:function(){
        jQuery("a[data-rel^='prettyPhoto']").prettyPhoto(
            {
                hook: 'data-rel',
                theme: 'light_rounded',
                slideshow: 5000,
                deeplinking: false,
                social_tools: false
            });
    },

    registerFilterByCategory:function(sectionId){
        var $container = jQuery('#portfolio-' + sectionId);
        jQuery('.portfolio-tabs li',$container).each(function(){
            jQuery('a',jQuery(this)).off();
            jQuery('a',jQuery(this)).click(function(){
                PortfolioAjaxAction.processFilter(this, false);
            });
        });
    },

    wrapperContentResize:function(){
        jQuery('#wrapper-content').bind('resize', function(){
            var $container = jQuery('.portfolio-wrapper');
            var owl = jQuery('.portfolio-wrapper').data('owlCarousel');
            if(owl==null ){
                 $container.isotope({
                 itemSelector: '.portfolio-item'
                 }).isotope('layout');

            }
        });
    },

    init:function(ajax_url, tab_category_action, dataSectionId){
        PortfolioAjaxAction.vars.ajax_url = ajax_url;
        PortfolioAjaxAction.vars.tab_category_action = tab_category_action;
        PortfolioAjaxAction.registerLoadmore(dataSectionId);
        PortfolioAjaxAction.registerPrettyPhoto();
        if(tab_category_action=='ajax'){
            PortfolioAjaxAction.registerFilterByCategory(dataSectionId);
        }
        PortfolioAjaxAction.wrapperContentResize();
    }
}