(function($) {
    'use strict';
    
    // Preload images - v2.7.1
    $.fn.preload = function() {
        this.each(function(){
            $('<img/>')[0].src = this;
        });
    }

    var bbsmController = new ScrollMagic.Controller();
    var bbsmController_h = new ScrollMagic.Controller( {vertical: false} );
        
    $('document').ready(function() {
        
        $('body').before('<span id="bbsm-trigger-top-document" class="bb-scrollmagic-trigger"></span>');
        
        $.each(BB_SCENES, function(key, value) {
            var counter = 1;
            
            var settings = value.settings;
            var init = value['init'];
            var tween = value['tween'];
            var misc = value['misc'];
            var bezier = value['bezier'];
            
            var controller;
            if(typeof settings.general.vertical != undefined && settings.general.vertical == 'off') {
                if(typeof misc.container != 'undefined' && misc.container != '' && $(misc.container).length > 0) {
                    controller = new ScrollMagic.Controller( { container: misc.container , vertical: false} );
                } else {
                    controller = bbsmController_h;
                }
            } else {
                if(typeof misc.container != 'undefined' && misc.container != '' && $(misc.container).length > 0) {
                    controller = new ScrollMagic.Controller( {container: misc.container} );
                } else {
                    controller = bbsmController;
                }
            }
            
            if (typeof misc.selector !== 'undefined' && misc.selector != '' && $(misc.selector).length > 0) {
                $(misc.selector).each(function() {
                    var $self = $(this);
                    var trigger = '';
                    if(typeof settings.general.triggerElement != undefined) {
                        trigger = settings.general.triggerElement;
                    } 
                    if(trigger == 'top-document') {
                        trigger = 'bbsm-trigger-top-document';
                    } else {
                        trigger = 'bbsm-trigger-selector-'+key+'-'+(counter++);
                        $self.before('<span id="'+trigger+'" class="bb-scrollmagic-trigger"></span>');
                    }
                    
                    bbsm_scrollmagic($self, settings, init, tween, misc, bezier, trigger, controller);
                });
            }
            
            $('.' + key).each(function() {
                
                var $self = $(this);
                var trigger = '';
                if(typeof settings.general.triggerElement != undefined) {
                    trigger = settings.general.triggerElement;
                }
                if(trigger == 'top-document') {
                    trigger = 'bbsm-trigger-top-document';
                } else {
                    trigger = 'bbsm-trigger-'+key+'-'+(counter++);
                    $self.before('<span id="'+trigger+'" class="bb-scrollmagic-trigger"></span>');
                }
                
                bbsm_scrollmagic($self, settings, init, tween, misc, bezier, trigger, controller);
            });
        });
        

        $('[data-scrollmagic="true"]').each(function() {
            var $self = $(this);
            var settings = ($self.data('bbsm-settings'));
            var init = ($self.data('bbsm-init'));
            var tween = ($self.data('bbsm-tween'));
            var misc = ($self.data('bbsm-misc'));
            var bezier = ($self.data('bbsm-bezier'));
            var trigger = ($self.data('bbsm-trigger'));

            bbsm_scrollmagic($self, settings, init, tween, misc, bezier, trigger);
        });

    });

    function bbsm_scrollmagic($self, settings, init, tween, misc, bezier, trigger, controller){
        TweenMax.to($self, 0, init, 0);
        
        var reverse = true;
        if (typeof settings.general.reverse !== 'undefined') {
            reverse = eval(settings.general.reverse);
        }

        var scene = new ScrollMagic.Scene({
            triggerElement: '#' + trigger,
            duration: settings.general.duration,
            offset: settings.general.offset,
            triggerHook: settings.general.triggerHook,
            reverse: reverse,
            tweenChanges: true
        }).setTween($self, settings.ease.duration, tween);

        if (typeof bezier != undefined && bezier.length > 0) {
            scene.setTween($self, settings.ease.duration, {
                css: {
                    bezier: {
                        curviness: 1.25,
                        autoRotate: true,
                        values: bezier
                    }
                },
                ease: eval(settings.ease.ease)
            });
        }

        if (typeof settings.general.pin !== 'undefined' && settings.general.pin == 'on') {
            var pushFollowers = true;
            if (typeof settings.general.pushFollowers !== 'undefined') {
                pushFollowers = eval(settings.general.pushFollowers);
            }
            scene.setPin($self[0], {pushFollowers: pushFollowers});
        }

        if (typeof settings.class.classToggleEnable !== 'undefined' && settings.class.classToggleEnable == 'on') {
            $self.addClass('animated');
            scene.setClassToggle($self[0], settings.class.classCSS);
        }
        scene.addTo(controller);

        
        $(window).load(function() {
            if ($self.find('path').length > 0 && typeof misc !== 'undefined' && typeof misc.drawSVG !== 'undefined' && misc.drawSVG == 'on') {
                var lineLength = $self.find('path')[0].getTotalLength();
                $self.find('path').css("stroke-dasharray", lineLength);
                $self.find('path').css("stroke-dashoffset", lineLength);

                var tween_svg = new TimelineMax().add(TweenMax.to($self.find('path'), settings.ease.duration, {
                    strokeDashoffset: 0,
                    ease: Linear.easeNone
                }));
                var scene_svg = new ScrollMagic.Scene({
                    triggerElement: '#' + trigger,
                    triggerHook: settings.general.triggerHook,
                    duration: settings.general.duration,
                    offset: settings.general.offset,
                    reverse: reverse,
                    tweenChanges: true
                }).setTween(tween_svg);
                scene_svg.addTo(controller);
            }
        });

        if ($self.find('.bbsm-imagesequence').length > 0) {

            var images = $self.find('.bbsm-imagesequence').data('bbsm-imagesequence');
            $(images).preload();

            var obj = {
                curImg: 0
            };
            // create tween
            var tween_imagesequence = TweenMax.to(obj, 0.5, {
                curImg: images.length - 1, // animate propery curImg to number of images
                roundProps: "curImg", // only integers so it can be used as an array index
                repeat: 0, // repeat 0 times
                immediateRender: true, // load first image automatically
                ease: Linear.easeNone, // show every image the same ammount of time
                onUpdate: function() {
                    $self.find('.bbsm-imagesequence img').attr("src", images[obj.curImg]); // set the image source
                }
            });
            var scene_imagesequence = new ScrollMagic.Scene({
                triggerElement: '#' + trigger,
                triggerHook: settings.general.triggerHook,
                duration: settings.general.duration,
                offset: settings.general.offset,
                reverse: reverse,
                tweenChanges: true
            }).setTween(tween_imagesequence);
            scene_imagesequence.addTo(controller);

        }

    }
    
})(jQuery);