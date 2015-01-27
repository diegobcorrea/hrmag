// AJAX Functions
var jq = jQuery;
var images = "http://maspormenos.com.pe/pichangatottus/wp-content/themes/tottus/images/";

jq(document).ready( function() {

    if (jq.cookie('20080521') != '1') {
        jq('.step-by-step').show();
        
        jq('.close-steps').click( function(){
            jq.cookie('20080521', '1', { expires: 20 }); 
            jq('.step-by-step').fadeOut(1000);
        });

        jq(document).keyup(function(e) {
            if (e.keyCode == 27) { 
                jq.cookie('20080521', '1', { expires: 20 }); 
                jq('.step-by-step').fadeOut(1000);
            }// esc
        });
    };

    //jq.removeCookie('20080521');

	jq('ul#menu-top-menu > li:not(:last)').after('<li class="divider">|</li>');
	jq('ul#menu-menu-principal li:not(:last)').after('<li class="divider">|</li>');

    jq('#people-mainSlider .wrapper').carouFredSel({
        items               : 1,
        infinite            : false,
        circular            : false,
        auto                : false,
        scroll : {
            items           : 1,
            easing          : "linear",
        },
        prev  : { 
            button  : "#mainSlider_prev",
            key   : "left"
        },
        next  : { 
            button  : "#mainSlider_next",
            key   : "right"
        }                   
    });

    jq('#scrollList').mCustomScrollbar({
        scrollButtons:{
            enable:true
        }
    });

    var sideNavbar      = jq('.sideNavbar'),
        formVideo       = jq('#participaForm .video'),
        formVideoField  = jq('#participaForm .video .field'),
        publish         = jq('.publish img'),
        formInfo        = jq('#participaForm .info'),
        viewProfile     = jq('a.viewProfile'),
        goStadium       = jq('a.goStadium'),
        linkStadium     = jq('a.goStadium').attr("href");;

    sideNavbar.addClass('close');
    formVideo.css({'display':'none'});
    formVideoField.css({'display':'none'});
    viewProfile.removeAttr('href').addClass('off');

    if( jq('body').hasClass('single') ){
        goStadium.addClass('on');    
    }else{

        goStadium.addClass('off').removeAttr('href');
    };
    
    jq('.btnShare.shareFB').click(function(e){
        e.preventDefault();

        elem = jq(this);
        postToFeed(elem.data('title'), elem.data('desc'), elem.data('url'), elem.data('image'));

        return false;
    });

    jq(".btnShare.shareTW").click(function(e){
        e.preventDefault();

        var loc = jq(this).data('url');
        var title  = escape( remove_accent(jq(this).data('title')).toUpperCase() );
        window.open('http://twitter.com/share?url=' + loc + '&text=' + title + '&', 'twitterwindow', 'height=450, width=550, top='+(jq(window).height()/2 - 225) +', left='+jq(window).width()/2 +', toolbar=0, location=0, menubar=0, directories=0, scrollbars=0');
    });

    jq('.sideNavbar .tab').click(function(){
        if( jq(sideNavbar).hasClass('open') ){
            jq(sideNavbar).animate({'marginLeft':'-191px'}).removeClass('open').addClass('close');
        }else{
            jq(sideNavbar).animate({'marginLeft':'0px'}).removeClass('close').addClass('open');    
        };
    });

    jq('.type').click(function(){
        jq(this).addClass('active').siblings().removeClass('active');
    });

    jq('.nextStep img').click(function(){
        var value = jq('input:radio[name=team]:checked').val();

        if (jq("#participaForm").valid()) {
            formInfo.hide();
            formVideo.show().css({'background-image':'url('+images+'/forms/bg-'+value+'.png)'});
        } else {
            jq('.overlay-error').show();
            setTimeout(function() {
                jq('.overlay-error').fadeOut(1000);
            }, 3000);
        }
    });

    jq("#participaForm").validate({
        rules: {
            name: "required",
            lastname: "required",
            email: {
                required: true,
                email: true,
            },
            city: "required",
            phone: {
                required: true,
                number: true
            },
            dni: {
                required: true,
                minlength: 7,
                remote: 'http://maspormenos.com.pe/pichangatottus/validardni',
            },
            team: "required"
        },
        messages: {
            name: "Por favor ingresa tu nombre.",
            dni: {
                required: "Por favor ingresa tu número de DNI.",
                remote: 'DNI en uso.'
            },
        },

    });

    jq('.chooseVideoType .type').click(function(){
        var type    = jq(this).data('type');

        formVideoField.fadeIn(1000);
        jq('.input-video').val('');
        publish.css({'cursor':'default'}).removeClass('active');
        viewProfile.removeClass('on').addClass('off');
        goStadium.removeClass('on').addClass('off');
        jq('.input-video').attr('id', type);
    });

    jq('.input-video').on('input',function(e){
        var type    = jq(this).attr('id');

        publish.css({'cursor':'pointer'}).addClass('active');
        jq('.previewVideo .image img').remove();

        if(type == 'youtube'){
            jq.jYoutube(jq(this).val());
        }
        if(type == 'vimeo'){
            jq.jVimeo(jq(this).val());
        }
        if(type == 'instagram'){
            jq.jInstagram(jq(this).val());
        }
    });

    publish.click(function(){
        if( publish.hasClass('active') ){
            if (jq("#participaForm").valid()) {
                var name        = jq('input#name').val(),
                    lastname    = jq('input#lastname').val(),
                    email       = jq('input#email').val(),
                    city        = jq('input#city').val(),
                    phone       = jq('input#phone').val(),
                    dni         = jq('input#dni').val(),
                    team        = jq('input[name=team]:checked').val(),
                    videoID     = jq('input#videoID').val(),
                    videoType   = jq('input#videoType').val();
                    videoImage  = jq('input#videoImage').val();

                jq.ajax({
                    type: 'POST',         
                    url: apfajax.ajaxurl,
                    data: {
                        action: 'apf_addpost',
                        name: name,
                        lastname: lastname,
                        email : email,
                        city : city,
                        phone : phone,
                        dni : dni,
                        team : team,
                        videoID : videoID,
                        videoType : videoType,
                        videoImage : videoImage
                    },
                    success: function(data, textStatus, XMLHttpRequest) {
                        jq('.overlay-success').show();
                        setTimeout(function() {
                            jq('.overlay-success').fadeOut(1000);
                        }, 3000);
                        viewProfile.removeClass('off').addClass('on').attr('href',data);
                        goStadium.removeClass('off').addClass('on').attr('href',linkStadium);
                        formVideoField.slideUp(1000);
                        jq('.chooseVideoType .type').removeClass('active');
                    },
                    error: function(MLHttpRequest, textStatus, errorThrown) {
                        alert(errorThrown);
                    }
             
                });
            } else {
                jq('.overlay-error').show();
                setTimeout(function() {
                    jq('.overlay-error').fadeOut(1000);
                }, 3000);
            }
        }
    });

	jq(window).stellar({
        horizontalScrolling: false,
        verticalOffset: 0
    });

    var links = jq('.navigation').find('li');
    navLinks = jq('.navigation_estadio').find('li');
    slide = jq('.slide');
    button = jq('.button');
    mywindow = jq(window);
    htmlbody = jq('html,body');


    slide.waypoint(function (event, direction) {

        dataslide = jq(this).attr('data-section');

        if (direction === 'down') {
            jq('.navigation li[data-section="' + dataslide + '"]').addClass('active').prev().removeClass('active');
        }
        else {
            jq('.navigation li[data-section="' + dataslide + '"]').addClass('active').next().removeClass('active');
        }

    });
 
    mywindow.scroll(function () {
        if (mywindow.scrollTop() == 0) {
            jq('.navigation li[data-section="1"]').addClass('active');
            jq('.navigation li[data-section="2"]').removeClass('active');
        }
    });

    function goToByScroll(dataslide) {
        htmlbody.animate({
            scrollTop: jq('.slide[data-section="' + dataslide + '"]').offset().top
        }, 1200, 'easeInOutQuint');
    }

    var GET = jq(document).getUrlParam('section');
    if(GET){
        goToByScroll(GET);
    }

    links.click(function (e) {
        e.preventDefault();

        dataslide = jq(this).attr('data-section');

        if( dataslide == '4' ){
            window.location.href = "http://maspormenos.com.pe/pichangatottus/estadio/";
        }else{
            goToByScroll(dataslide);
        }
    });

    navLinks.click(function (e) {
        e.preventDefault();

        dataslide = jq(this).attr('data-section');
        window.location.href = "http://maspormenos.com.pe/pichangatottus/?section="+dataslide;
    });

    button.click(function (e) {
        e.preventDefault();
        dataslide = jq(this).attr('data-section');
        goToByScroll(dataslide);
    });

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

