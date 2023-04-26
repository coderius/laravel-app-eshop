$(function() {
    console.log( "ready!" );


var sliderMain = function(params) {
	var itemsLenght = params.itemsLenght || 5;
    var $wrap = $('#SSliderWrap');
    var $itemsImg = $('#SSliderItems');
    var $mainImg = $('#SSliderMainImg');
    var $imgForExtraNum = $('#SSliderImgForExtraNum');
    var $extraNumTag = $('#SSliderExtraNum');
    var $imgExtra = $('#SSliderImgExtra');
    var $images = $wrap.find('[data-sslider-img]');
    var itemsCount = $images.length;
    var extraNum = itemsCount - (itemsLenght+1);
    console.log(itemsCount );

    //Create style images on the page
    $itemsImg.find('[data-sslider-img]').each(function(i, el){
        // console.log(i);
        if(i === itemsLenght-1){
            $imgForExtraNum.attr('src', $(this).attr('src'));
            $extraNumTag.text('+'+ extraNum);
            $imgExtra.removeAttr("style");
        }

        if(i >= itemsLenght-1){
            $(this).parent().css({"display": "none"})
        }

    });

    //Create slider gallery
    $images.each(function(ind, el){
        var img;
        var ind = $(this).attr('data-sslider-img-index');
        var attr = $(this).attr('src');
        img = $('<img src="" class="fade" style="display:none;">');
        img.attr('src', attr);
        img.attr('data-index', ind);
        img.prependTo('.sslider-screen__items');
    });

    //Slider Carousel hendler
    var $body = $('body');//slider-show
    var $sliderShadow = $('.slider-shadow');//active
    var $ssliderScreen = $('.sslider-screen');//active

    //Open slider by click in image in the page
    $images.on('click', function(e){
        //Activate classes for showing slider
        $body.addClass("slider-show");
        $sliderShadow.addClass("active");
        $ssliderScreen.addClass("active");
        var activeImgInd = $(this).attr('data-sslider-img-index');
        // console.log(activeImgInd);
        //Change styles for active image
        $('.sslider-screen__items').find('[data-index]')
            .each(function(ind, el){
                if($(this).attr('data-index') == activeImgInd){
                    $(this).attr('class', '');
                    $(this).attr('style', '');
                    $(this).attr('class', 'sslider-visible-img');//add class to visible image
                }
            });
    });//end $images.on('click'

    //Hendler for last item wich number
    $('.slider-item-last').on('click', function(e){
        // console.log(this);
        //Activate classes for showing slider
        $body.addClass("slider-show");
        $sliderShadow.addClass("active");
        $ssliderScreen.addClass("active");
        var activeImgInd = itemsLenght+1;//Т.к. первая большая картинка не учитівалась при просчете числа картинок в колонке рядом с большой
        //Activate classes for showing slider
        
        console.log(activeImgInd);
        //Change styles for active image
        $('.sslider-screen__items').find('[data-index]')
            .each(function(ind, el){
                if($(this).attr('data-index') == activeImgInd){
                    $(this).attr('class', '');
                    $(this).attr('style', '');
                    $(this).attr('class', 'sslider-visible-img');//add class to visible image
                }
            });
    });

    var $ssliderScreenLc = $('.sslider-screen-lc');
    var $ssliderScreenRc = $('.sslider-screen-rc');
    
    //Hendler control buttons by click
    //Left
    $ssliderScreenLc.on('click', function(e){
        // console.log(this);
        var $visibleImg = $('.sslider-screen__items').find('.sslider-visible-img');
        var $visibleImgInd = parseInt($visibleImg.attr('data-index'));
        var nextIndex = $visibleImgInd - 1;
        if(nextIndex < 1){
            nextIndex = itemsCount;
        }
        console.log(nextIndex);

        //Hide current image
        $visibleImg.attr('class','fade');
        $visibleImg.attr('style','display:none;');

        //Show next image
        var $nextImage = $('.sslider-screen__items').find('[data-index="'+nextIndex+'"]')
        $nextImage.attr('class', '');
        $nextImage.attr('style', '');
        $nextImage.attr('class', 'sslider-visible-img');//add class to visible image   
    });//end $ssliderScreenLc.on('click'

    //Right
    $ssliderScreenRc.on('click', function(e){
        var $visibleImg = $('.sslider-screen__items').find('.sslider-visible-img');
        var $visibleImgInd = parseInt($visibleImg.attr('data-index'));
        var nextIndex = $visibleImgInd + 1;
        if(nextIndex > itemsCount){
            nextIndex = 1;
        }
        // console.log(nextIndex > itemsCount,$visibleImgInd,nextIndex,itemsCount);

        //Hide current image
        $visibleImg.attr('class','fade');
        $visibleImg.attr('style','display:none;');

        //Show next image
        var $nextImage = $('.sslider-screen__items').find('[data-index="'+nextIndex+'"]')
        $nextImage.attr('class', '');
        $nextImage.attr('style', '');
        $nextImage.attr('class', 'sslider-visible-img');//add class to visible image   
    });//end $ssliderScreenRc.on('click'

    //Mobile swipe by jquery mobile
    $( ".sslider-screen" ).on( "swipeleft", function( e ) {
        var $visibleImg = $('.sslider-screen__items').find('.sslider-visible-img');
        var $visibleImgInd = parseInt($visibleImg.attr('data-index'));
        var nextIndex = $visibleImgInd + 1;
        if(nextIndex > itemsCount){
            nextIndex = 1;
        }
        // console.log(nextIndex > itemsCount,$visibleImgInd,nextIndex,itemsCount);

        //Hide current image
        $visibleImg.attr('class','fade');
        $visibleImg.attr('style','display:none;');

        //Show next image
        var $nextImage = $('.sslider-screen__items').find('[data-index="'+nextIndex+'"]')
        $nextImage.attr('class', '');
        $nextImage.attr('style', '');
        $nextImage.attr('class', 'sslider-visible-img');//add class to visible image   
        console.log(e);
    } );

    $( ".sslider-screen" ).on( "swiperight", function( e ) {
        var $visibleImg = $('.sslider-screen__items').find('.sslider-visible-img');
        var $visibleImgInd = parseInt($visibleImg.attr('data-index'));
        var nextIndex = $visibleImgInd - 1;
        if(nextIndex < 1){
            nextIndex = itemsCount;
        }
        console.log(nextIndex);

        //Hide current image
        $visibleImg.attr('class','fade');
        $visibleImg.attr('style','display:none;');

        //Show next image
        var $nextImage = $('.sslider-screen__items').find('[data-index="'+nextIndex+'"]')
        $nextImage.attr('class', '');
        $nextImage.attr('style', '');
        $nextImage.attr('class', 'sslider-visible-img');//add class to visible image  
        console.log(e);
    } );

    // $("#listitem").swiperight(function() {
    //     $.mobile.changePage("#page1");
    // });


    //Close button
    var $ssliderScreenClose = $('.sslider-screen-close');
    $ssliderScreenClose.on('click', function(e){
        $body.removeClass("slider-show");
        $sliderShadow.removeClass("active");
        $ssliderScreen.removeClass("active");
        var $visibleImg = $('.sslider-screen__items').find('.sslider-visible-img');
        $visibleImg.attr('style', 'display:none;');
        $visibleImg.attr('class', 'fade');
    });

    
};

sliderMain({
    itemsLenght: 5
});


//Обработка формі заказа товара
$('#bayer-form').on('submit', function(e){
    e.preventDefault();
    console.log('submit');
});


//Add to favorite for user
$('.js-hendler').on('click', function(e){
    var uId = getCookie('uId');
    console.log(uId);
    if(uId == ''){
        var genStr = passGen(32);
        setCookie('uId', genStr, 365);
    }
    console.log(getCookie('uId'));

    var prodId = $(this).attr('data-product-id');
    setCookie('uId-prodId-'+prodId, prodId, 365);

    //Set unset cookie and style by toggle
});

});//end ready

function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    let expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
  }

function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for(let i = 0; i <ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }

  function passGen(len) {
    chrs = 'abdehkmnpswxzABDEFGHKMNPQRSTWXZ123456789';
    var str = '';
    for (var i = 0; i < len; i++) {
        var pos = Math.floor(Math.random() * chrs.length);
        str += chrs.substring(pos,pos+1);
    }
    return str;
}