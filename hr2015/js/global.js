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

});

jq(window).load(function(){
    preload([
        'http://maspormenos.com.pe/pichangatottus/wp-content/themes/tottus/images/forms/bg-peru.png',
        'http://maspormenos.com.pe/pichangatottus/wp-content/themes/tottus/images/forms/bg-germany.png',
    ]);

    function preload(arrayOfImages) {
    jq(arrayOfImages).each(function () {
        jq('<img />').attr('src',this).appendTo('body').css('display','none');
    });
}
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

