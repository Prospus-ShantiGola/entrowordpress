/*
  Description: Plugin for create slider with specific number and image slider in modal box
               1. set image number to bootstrap slider 
               2. show bootstrap slider in modal box
*/

// Create closure.
(function( $ ) {
          
        var defaults = {
            showItems: 3,
            indicator: true
        };
        
        var settings = {};
        /*
          Description: show slider in modal box
          @param: {object} with number of image to slide, indicator to show.
        */
        $.fn.modalSlider = function(options) {
            settings = $.extend( {}, defaults, options );
            return this.each(function() {
                 numberOfImgSlider(this);
                 clickHandlers(this);
                 if(settings.indicator === true) {
                    activeSlectedImgOnLightBox();
                 }
            });
        }

        function numberOfImgSlider(container) {
          var number = settings.showItems;
          $(container).find('.item').each(function() {
            var itemToClone = $(this);

            for (var i=1;i<number;i++) {
              itemToClone = itemToClone.next();

              // wrap around if at end of item collection
              if (!itemToClone.length) {
                itemToClone = $(this).siblings(':first');
              }

              // grab item, clone, add marker class, add to collection
              itemToClone.children(':first-child').clone()
                .addClass("cloneditem-"+(i))
                .appendTo($(this));
            }
          });
        }
        function changeTitle() {
            $("#modal-carousel").on("slid.bs.carousel", function () {
              console.log($(this));
                  $(".modal-title")
                  .html( $(this)
                  .find(".active img")
                  .attr("title") );
             });
        }

        function activeSlectedImgOnLightBox() {
          $('#modal-gallery').on('shown.bs.modal', function() {
          // carousel indicator
               var carouselIndicator = $('.carousel-indicators li');
               var indexOfClickedImg = $("#modal-gallery").data('selectedImg');
                   carouselIndicator.filter('[data-slide-to='+ indexOfClickedImg +']').addClass('active')
                   .siblings()
                   .removeClass('active');
          });  
        }
        function showImgSliderInLightBox(e) {
            var currentImg = e.target,
                $modalGallery = $("#modal-gallery"),
                $modalCarousel = $('#modal-carousel'),
                $carouselIndicator = $modalCarousel.find('.carousel-indicators')
                content = $modalGallery.find(".carousel-inner"),
                title = $modalGallery.find(".modal-title"),
               id = currentImg.id,
                listOfImages = createImgSourceArray(currentImg);

                content.empty(); 
                title.empty();

                var htmlStrc = createSliderHTML(listOfImages)
                if(settings.indicator === true) {
                  var indiactorHTML = carsouselIndicator(listOfImages)
                  $carouselIndicator.html(indiactorHTML);    
                }
                content.append(htmlStrc);
            var repo = $("#modal-carousel .item");
            //var active = $modalCarousel.find('.carousel-inner .item').eq(currentIndex);
            var active = repo.filter('#' + id);
                $(currentImg).addClass('active');
                active.addClass("active")
                  .siblings()
                  .removeClass('active')
              
              title.html(active.find("img").attr("title"));
              // show the modal
              var selectedImg = id.split('-')[1]; //currentIndex+1;

              $modalGallery.data('selectedImg', selectedImg);
              $modalGallery.modal("show");

              //setTimeout(function() {
                $modalCarousel.carousel();  
              //}, 21000);
              // pause carousel
              $('.carousel:not(".overlayImg")').carousel('pause');
              
        }
        function createImgSourceArray(currentImg) {
          var arrayListOfImg = [];
              $(currentImg).parents('.carousel-inner').find('.item div:not("[class*=cloneditem]")').find('img').each(function() {
                  arrayListOfImg.push( $(this).attr('src') )
              })
            return arrayListOfImg;
        }
        function createSliderHTML(listOfImages) {
              var htmlStr = '';
              for(var i = 0; listOfImages[i]; i++) {
                var imgId = (i+1);
                htmlStr += '<div class="item" id="image-'+imgId+'" >' +
                              '<div class="col-xs-12"><a href="#"><img src="'+listOfImages[i]+'" class="img-responsive" title="Image '+imgId+'" width="260" height="145"></a></div>' +
                            '</div>'
              }
              return htmlStr;
        }
        function carsouselIndicator(arrayImgList) {
              var arrayImgList = arrayImgList.length;
              var indicatorStr = '';
              for(var i = 0; i < arrayImgList; i++) {
                var slideNumber = i+1;
                indicatorStr += '<li data-target="#modal-carousel" data-slide-to="'+slideNumber+'"></li>';
              }
              return indicatorStr;
        }
        function clickHandlers(currentSlider) {
            $(currentSlider).find(".carousel-inner .img-responsive").off('click').on('click', function(e) {
              e.preventDefault();
              //var currentIndex = $(currentSlider).find(".carousel-inner .img-responsive").index(this);
                showImgSliderInLightBox(e)
            });
            // remove pause carousel
            $('#modal-gallery').on('hide.bs.modal', function() {
              $('.carousel:not(".overlayImg")').carousel();
            })
        }

      
})( jQuery );


