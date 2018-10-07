/**
 * Created by phuongth on 1/20/2016.
 */
(function($){
    "use strict";
    var CourseShortcode = {
        init: function() {
            CourseShortcode.registerLinkTab();
            CourseShortcode.registerSelectTab();
            CourseShortcode.tooltip();
            CourseShortcode.magicLine();
        },
        registerLinkTab: function(){
            $('li','.course-categories-sc ul.icon').click(function(){
                CourseShortcode.changeTab($('a',this), true);
            });
            $('a','.course-categories-sc ul.icon li').click(function(){
                CourseShortcode.changeTab($(this), true);
            });
            $('a','.course-categories-sc ul.text li').click(function(){
                var tabId = $(this).attr('data-tab-id');
                var $li = $(this).parent();
                $('a','.course-categories-sc ul.text li').removeClass('active');
                $('li','.course-categories-sc ul.text').removeClass('active');
                $(this).addClass('active');
                $li.addClass('active');
                $('.course-tab.active','.course-categories-sc').fadeOut(function(){
                    $(this).removeClass('active');
                });
                $('.course-tab[data-tab-id="' + tabId + '"]','.course-categories-sc').fadeIn(function(){
                    $(this).addClass('active');
                });
                CourseShortcode.setSelectVal(tabId);
            });
        },
        registerSelectTab: function(){
            $('select','.course-categories-sc').change(function(){
                var tabId = $("option:selected", this ).val();
                var $elm = $('a[data-tab-id="'+ tabId +'"]','.course-categories-sc ul li');
                CourseShortcode.changeTab($elm, false);
            });
        },
        changeTab: function($elm, isSynSelect){
            var tabId = $($elm).attr('data-tab-id');
            var $li = $($elm).parent();
            $('.course-categories-sc ul.icon').css('padding-left','0');
            $('.course-categories-sc ul.icon').css('padding-right','0');
            if($li.is( ":first-child" ) || $li.is( ":last-child" )){
                $('.course-categories-sc ul.icon li').css('width','14.28%');//164px
                if($li.is( ":first-child" )){
                    $('.course-categories-sc ul.icon').css('padding-left','17px');
                    $li.css('width','14.2735%');
                }else{
                    $('.course-categories-sc ul.icon li').css('width','14.017%');
                    $li.css('width','14.5%');
                }
            }else{
                $('.course-categories-sc ul.icon li').css('width','14.2735%');//'167px'
            }

            $('a','.course-categories-sc ul li').removeClass('active');
            $('li','.course-categories-sc ul').removeClass('active');
            $($elm).addClass('active');
            $li.addClass('active');
            $('.course-tab.active','.course-categories-sc').fadeOut(function(){
                $(this).removeClass('active');
            });
            $('.course-tab[data-tab-id="' + tabId + '"]','.course-categories-sc').fadeIn(function(){
                $(this).addClass('active');
            });
            if(isSynSelect){
                CourseShortcode.setSelectVal(tabId);
            }
        },
        setSelectVal: function($val){
            $('select','.course-categories-sc').off();
            $('select','.course-categories-sc').val($val);
            CourseShortcode.registerSelectTab();
        },
        tooltip:function(){
            $('.hastip').tooltipsy({
                offset: [0, 10],
                show:function(e, $el){
                    $el.fadeIn();
                },
                hide:function(e, $el){
                    $el.fadeOut();
                },
                css: {
                    'font-size':'18px',
                    'color': '#fff',
                    'text-align':'center',
                    'text-transform': 'uppercase'
                }
            });
        },
        magicLine : function(){
            $('.magic-line-container').each(function() {
                var activeItem = $('li.active',this);
                var topMagicLine = $('.top.magic-line', $(activeItem).parent());
                var bottomMagicLine = $('.bottom.magic-line', $(activeItem).parent());
                topMagicLine.hide();
                bottomMagicLine.hide();
                setTimeout(function(){
                    CourseShortcode.magicLineSetPosition(activeItem);
                    topMagicLine.show();
                    bottomMagicLine.show();
                },100);


                $('li',this).hover(function(){
                    if(!$(this).hasClass('none-magic-line')){
                        CourseShortcode.magicLineSetPosition(this);
                    }
                },function(){
                    if(!$(this).hasClass('none-magic-line')){
                        CourseShortcode.magicLineReturnActive(this);
                    }
                });
            });
        },
        magicLineSetPosition : function(item) {
            if(item!=null && item!='undefined'){
                var left = 0;
                var $padding_left = $(item).css("padding-left");
                if(typeof $padding_left !='undefined'){
                    $padding_left = $padding_left.replace("px", "");

                    $padding_left  = parseInt($padding_left);
                }else{
                    $padding_left = 0;
                }
                if($(item).position()!=null)
                    left = $(item).position().left + $padding_left;

                var marginLeft = $(item).css('margin-left');
                var marginRight = $(item).css('margin-right');

                var topMagicLine = $('.top.magic-line', $(item).parent());
                var bottomMagicLine = $('.bottom.magic-line', $(item).parent());
                if(topMagicLine!=null && topMagicLine != 'undefined'){
                    $(topMagicLine).css('left',left);
                    $(topMagicLine).css('width',$(item).width());
                    $(topMagicLine).css('margin-left',marginLeft);
                    $(topMagicLine).css('margin-right',marginRight);
                }
                if(bottomMagicLine!=null && bottomMagicLine != 'undefined'){
                    $(bottomMagicLine).css('left',left);
                    $(bottomMagicLine).css('width',$(item).width());
                    $(bottomMagicLine).css('margin-left',marginLeft);
                    $(bottomMagicLine).css('margin-right',marginRight);
                }
            }
        },
        magicLineReturnActive : function(current_item) {
            if(!$(current_item).hasClass('active')){
                var activeItem = $('li.active',$(current_item).parent());
                CourseShortcode.magicLineSetPosition(activeItem);
            }
        },
    };
    $(document).ready(function(){
        CourseShortcode.init();
    });
    $(window).resize(function(){
        var $li = $('li.active','.course-categories-sc ul.text');
        if(typeof  $li !='undefined'){
            CourseShortcode.magicLineSetPosition($li);
        }
    });
})(jQuery);