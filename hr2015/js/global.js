// AJAX Functions
var jq = jQuery;
var images = "http://maspormenos.com.pe/pichangatottus/wp-content/themes/tottus/images/";

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
            Hammer(document).on('swipeleft', mobileMenu.swipeLeft);
            Hammer(document).on('swiperight', mobileMenu.swipeRight);
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

