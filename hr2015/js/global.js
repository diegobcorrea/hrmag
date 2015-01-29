var hrWindow = jQuery(window),
    hrWindowHeight = hrWindow.height(),
    hrWindowWidth = hrWindow.width(),
    hrHTMLBody = jQuery('html, body');

jQuery(document).ready( function() {

    var test = jQuery('footer');

    var scroller={
        scrollTop:function(){
            var offset = jQuery(window).scrollTop(),
            $header = jQuery('#top-nav');

            if(offset>42){
                $header.addClass('scrolled');
            }
            else{
                $header.removeClass('scrolled');
            }
        },
        listener:function(){
            jQuery(window).on('scroll',scroller.scrollTop);
        },
        init:function(){
            scroller.listener();
        }
    };

    scroller.init();

    jQuery("img.js-fix").each(function(){
        //get height and width (unitless) and divide by 2
        var hWide = (jQuery(this).width())/2; //half the image's width

        // attach negative and pixel for CSS rule
        hWide = '-' + hWide + 'px';

        jQuery(this).css({
            "margin-left" : hWide,
        });
    });

    jQuery(".fixed-div img.variable").each(function(){
        //get height and width (unitless) and divide by 2
        var hWide = (jQuery(this).width())/2; //half the image's width
        var hTall = (jQuery(this).height())/2; //half the image's height, etc.

        // attach negative and pixel for CSS rule
        hWide = '-' + hWide + 'px';
        hTall = '-' + hTall + 'px';

        jQuery(this).css({
            "margin-left" : hWide,
            "margin-top" : hTall
        });
    });

});

hrWindow.load(function() {

    hrTopnav = jQuery('#top-nav'),
    hrSingle = jQuery('#single-main'),
    hrSingleContent = hrSingle.find('.single-content'),
    hrReadProgress= jQuery('#hr-read-progress'),
    hrNextPrevPosts = jQuery('#hr-next-previous-posts'),
    hrProgressBar = jQuery('#hr-progress-bar'),
    hrProgressBarWidth = jQuery('#hr-progress-bar .progress'),
    hrProgressBarPercent = jQuery('#hr-read-progress-percent');

    var hrWindowScrollTop = hrWindow.scrollTop();

    if ( hrSingleContent.length > 0 ) {
        var hrTopPostContent = ( hrSingleContent.offset().top ) / 1.2,
            hrBottomPostContent = hrSingleContent.outerHeight(),
            hrBottomPostContentAndTop = hrTopPostContent * 2 + hrBottomPostContent;
    }

    function hrNavBarAni(){

        hrWindowScrollTop = hrWindow.scrollTop();
        hrProgressScroll = ( hrWindowScrollTop - ( hrTopPostContent  ) ) / ( hrBottomPostContentAndTop - ( hrTopPostContent * 2 ) ) * 100;

        if ( ( hrProgressScroll < 101 ) && ( hrProgressScroll > 0 ) ) {

            var percentage = Math.floor( hrProgressScroll );

            var progressText = (percentage == 0 || percentage == 100) ? '' : percentage + '%';
            if (percentage == 0) {
                progressText == '';
            } else if (percentage == 100) {
                progressText = '';
            } else {
                progressText = percentage + '%';
            }
            hrProgressBarWidth.css({'width': percentage + '%'}).find('.value').text(progressText);
            hrProgressBarPercent.html( percentage + '%' );
            hrNextPrevPosts.hide();
            hrTopnav.hide();
            hrReadProgress.show();

        } else if ( hrProgressScroll > 101 ) {

            hrNextPrevPosts.show();
            hrTopnav.hide();
            hrReadProgress.hide();

        } else if ( hrProgressScroll <= 0 ) {

            hrReadProgress.hide();
            hrTopnav.show();

        }

    }

    hrNavBarAni();

    hrWindow.scroll( function() {

        hrNavBarAni();

    });

    var mobileButton = jQuery('#mobile-button'),
        mobileNav = jQuery('.main_menu'),
        content = jQuery('.content');

    var mobileMenu = {
        init: function() {
            mobileMenu.listener();
        },
        listener : function() {
            mobileButton.on('click', mobileMenu.toggleMenu);
            Hammer(document).on('swipeleft', mobileMenu.swipeLeft);
            Hammer(document).on('swiperight', mobileMenu.swipeRight);
        },
        toggleMenu : function() {
            mobileNav.toggleClass('show-menu');
            mobileNav.toggleClass('hide-menu');
            content.toggleClass('push-left');
            hrTopnav.toggleClass('push-left');
        },
        openMenu : function() {
            mobileNav.addClass('show-menu');
            mobileNav.removeClass('hide-menu');
            content.addClass('push-left');
            hrTopnav.toggleClass('push-left');
        },
        closeMenu : function() {
            mobileNav.removeClass('show-menu');
            mobileNav.addClass('hide-menu');
            content.removeClass('push-left');
            hrTopnav.toggleClass('push-left');
        },
        swipeLeft : function() {
            mobileMenu.openMenu();
        },
        swipeRight : function() {
            mobileMenu.closeMenu();
        }
    };
    mobileMenu.init();


});

function remove_accent(str){
    var charMap = {
        Á:'A',É:'E',Í:'I',Ó:'O',Ú:'U',Ñ:'N',
        á:'a',é:'e',í:'i',ó:'o',ú:'u',ñ:'n',
    };

    var str_array = str.split('');

    for( var i = 0, len = str_array.length; i < len; i++ ) {
        str_array[ i ] = charMap[ str_array[ i ] ] || str_array[ i ];
    };

    return str_array.join('');
}

