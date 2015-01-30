var jq = jQuery;

var hrWindow = jQuery(window),
    hrWindowHeight = hrWindow.height(),
    hrWindowWidth = hrWindow.width(),
    hrHTMLBody = jQuery('html, body');

jq(document).ready( function() {

    var scroller={
        scrollTop:function(){
            var offset = jq(window).scrollTop(),
            $header = jq('#top-nav');

            if(offset>42){
                $header.addClass('scrolled');
            }
            else{
                $header.removeClass('scrolled');
            }
        },
        listener:function(){
            jq(window).on('scroll',scroller.scrollTop);
        },
        init:function(){
            scroller.listener();
        }
    };

    var hammernew = Hammer( jq('body') );

    scroller.init();

    var $mobileButton = jq('#mobile-button'),
        $mobileNav = jq('.main_menu'),
        $content = jq('.content'),
        $topnav = jq('#top-nav');

    

    var mobileMenu = {
        init: function() {
            mobileMenu.listener();
        },
        listener : function() {
            $mobileButton.on('click', mobileMenu.toggleMenu);
        },
        toggleMenu : function() {
            $mobileNav.toggleClass('show-menu');
            $mobileNav.toggleClass('hide-menu');
            $content.toggleClass('push-left');
            $topnav.toggleClass('push-left');
        },
        openMenu : function() {
            $mobileNav.addClass('show-menu');
            $mobileNav.removeClass('hide-menu');
            $content.addClass('push-left');
            $topnav.toggleClass('push-left');
        },
        closeMenu : function() {
            $mobileNav.removeClass('show-menu');
            $mobileNav.addClass('hide-menu');
            $content.removeClass('push-left');
            $topnav.toggleClass('push-left');
        },
        panleft : function() {
            mobileMenu.openMenu();
        },
        panright : function() {
            mobileMenu.closeMenu();
        }
    };
    mobileMenu.init();


    jq("img.js-fix").each(function(){
        //get height and width (unitless) and divide by 2
        var hWide = (jq(this).width())/2; //half the image's width

        // attach negative and pixel for CSS rule
        hWide = '-' + hWide + 'px';

        jq(this).css({
            "margin-left" : hWide,
        });
    });

    jq(".fixed-div img.variable").each(function(){
        //get height and width (unitless) and divide by 2
        var hWide = (jq(this).width())/2; //half the image's width
        var hTall = (jq(this).height())/2; //half the image's height, etc.

        // attach negative and pixel for CSS rule
        hWide = '-' + hWide + 'px';
        hTall = '-' + hTall + 'px';

        jq(this).css({
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
    hrNextPrevPosts = jq('#hr-next-previous-posts'),
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

