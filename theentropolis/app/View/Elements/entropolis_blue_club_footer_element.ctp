<!-- <div class="footerAlt">
        <div class="footerAltInner">
            <div class="H1-white">
                SIGN UP today!
            </div>
            <div align="center" style="margin:2em 0 4em;">
                <a href="<?=$this->webroot?>pdf/TRPCTY_CK.pdf" class="buttonBlue dinBut open-registration-js" target="_blank">
                    DOWNLOAD FLYER
                </a>
            </div>
             <a href="<?php echo Router::url(array('controller' => 'pages', 'action' => 'privacy')) ?>" class="afoot">Privacy and Security</a> | <a href="<?php echo Router::url(array('controller' => 'pages', 'action' => 'termUse')) ?>" class="afoot">Terms of Use</a> | <a href="<?php echo Router::url(array('controller' => 'EmergencyServices', 'action' => 'index')) ?>" class="afoot disabled">Emergency Services</a> <br />
    Copyright <?= date("Y") ?> TrepiCity Pty Ltd. All Rights Reserved | Powered by Club Kidpreneur Ltd and Entropolis Pty Ltd
            
        </div>
    </div>
 -->
 <div class="footer">
        
            <div class="H1-white">
                SIGN UP today!
            </div>
            <div align="center" style="margin:2em 0 4em;">
                <a href="<?=$this->webroot?>pdf/TRPCTY_CK.pdf" class="buttonBlue dinBut open-registration-js" target="_blank">
                    DOWNLOAD FLYER
                </a>
            </div>
             <a href="<?php echo Router::url(array('controller' => 'pages', 'action' => 'privacy')) ?>" class="afoot">Privacy and Security</a> | <a href="<?php echo Router::url(array('controller' => 'pages', 'action' => 'termUse')) ?>" class="afoot">Terms of Use</a> | <a href="<?php echo Router::url(array('controller' => 'EmergencyServices', 'action' => 'index')) ?>" class="afoot disabled">Emergency Services</a> <br />
  
    (c) <?= date("Y") ?> Entropolis Pty. Ltd. All Rights Reserved | Powered Club Kidpreneur Ltd. and Kidpreneur World Pty. Ltd.
            
    
    </div>



<?php echo $this->element('modal_element_layout'); ?>

<script>
    $('.carousel-showthreemoveone').carousel({interval: false});
    (function () {
        $('.carousel-showthreemoveone .item').each(function () {
            var itemToClone = $(this);

            for (var i = 1; i < 3; i++) {
                itemToClone = itemToClone.next();

                // wrap around if at end of item collection
                if (!itemToClone.length) {
                    itemToClone = $(this).siblings(':first');
                }

                // grab item, clone, add marker class, add to collection
                itemToClone.children(':first-child').clone()
                        .addClass("cloneditem-" + (i))
                        .appendTo($(this));
            }
        });
    }());

    function pops(popName) {
        if (document.getElementById("" + popName + "").style.display == 'block') {
            document.getElementById("" + popName + "").style.display = 'none';
        } else {
            document.getElementById("supportpeeppop").style.display = 'none';
            document.getElementById("trepicityhq").style.display = 'none';
            document.getElementById("superherotown").style.display = 'none';
            document.getElementById("theacademy").style.display = 'none';
            document.getElementById("clubkid").style.display = 'none';
            document.getElementById("trepicentre").style.display = 'none';
            document.getElementById("" + popName + "").style.display = 'block';
        }
    }
    function menushow() {
        if (document.getElementById("navmenu").style.display == 'block') {
            $("#navmenu").hide("slow");
        } else {
            $("#navmenu").show("slow");
        }
    }

</script>
<script type="text/javascript">
    var fadeImageStartAfter = 3000; //The default bg image will fade out and replaced by next bg image after 5 seconds.
    var fadeImageLoopAfter = 3000; //The rest of the bg images will fade out and be replaced by the next after 5 seconds each.
    var fadeImageIndex = 1; //Index of current bg image - DO NOT CHANGE, unless you want to start at a different bg image.
    var fadeImageTotal = 4; //Total number of bg images - ONLY CHANGE if bg images count changes.
    var fadeImageSpeedOut = 800; //3 Seconds.
    var fadeImageSpeedIn = 800; //3 Seconds.

    (function ($) {
        var imgList = [];
        $.extend({
            preload: function (imgArr, option) {
                var setting = $.extend({
                    init: function (loaded, total) { },
                    loaded: function (img, loaded, total) { },
                    loaded_all: function (loaded, total) { }
                }, option);
                var total = imgArr.length;
                var loaded = 0;

                setting.init(0, total);
                for (var i in imgArr) {
                    imgList.push($("<img />")
                            .attr("src", imgArr[i])
                            .load(function () {
                                loaded++;
                                setting.loaded(this, loaded, total);
                                if (loaded == total) {
                                    setting.loaded_all(loaded, total);
                                }
                            })
                            );
                }

            }
        });
    })(jQuery);

    $(function () {
        $.preload([
            "img/trepi-images/banner-image1.png",
            "img/trepi-images/banner-image2.png",
            "img/trepi-images/banner-image3.png",
            "img/trepi-images/banner-image4.png"
        ], {
            init: function (loaded, total) {
                //$("#indicator").html("Loaded: " + loaded + "/" + total);
            },
            loaded: function (img, loaded, total) {
                //$("#indicator").html("Loaded: " + loaded + "/" + total);

            },
            loaded_all: function (loaded, total) {
                //$("#indicator").html("Loaded: " + loaded + "/" + total + ". Done!");
                setTimeout(ChangeBG, fadeImageStartAfter);
            }
        });
    });

    function ChangeBG() {
        fadeImageIndex++;
        if (fadeImageIndex > fadeImageTotal) {
            fadeImageIndex = 1;
        }


        $('#bg').fadeOut(fadeImageSpeedOut, function () {

            var classToRemove = fadeImageIndex - 1;
            if (fadeImageIndex == 1) {
                classToRemove = 4;
            }

            $(this).removeClass("bgFade" + classToRemove);
            $('#bgPic').attr("src", "img/trepi-images/banner-image" + fadeImageIndex + ".png");

            $(this).toggleClass("bgFade" + fadeImageIndex).fadeIn(fadeImageSpeedIn, function () {
                $(this).css({opacity: 1.0})

                setTimeout(ChangeBG, fadeImageLoopAfter);
            })
        });
    }
//# sourceURL=entropolis_blue_footer_element.js
</script>
