class WidgetHandlerClasstwo extends elementorModules.frontend.handlers.Base {
    getDefaultSettings() {
        return {
            selectors: {

            },
        };
    }

    getDefaultElements() {
        const selectors = this.getSettings( 'selectors' );
        return {

        };
    }

    bindEvents() {

    }

    onDelayTimeChange(  ) {

    }
}

jQuery( window ).on( 'elementor/frontend/init', () => {
    const addHandler = ( $element ) => {
        elementorFrontend.elementsHandler.addHandler( WidgetHandlerClasstwo, {
            $element,
        } );


        (function ($) {


            $( document ).ready(function() {


                if( 1 < 0 /* document.getElementById('loop_animation') && document.getElementById('loop_animation').value === 'off' */){
                    //nothing to do
                } else {
                    var gallery_item = $('.accordion_2 .card');

                    var accorGalleryTimeOut = parseInt( document.getElementById('accordion_two_gallery_time_out').value * 1000 );
                    var timeOutIndex = 0;

                    var timeout = accorGalleryTimeOut;
                    var timeout = accorGalleryTimeOut;
                    var action = function() {
                        if($('.accordion_2').is(':hover')){
                            $('.accordion_2 .card').hover(function (){
                                $(this).css("flex",""+gallery_item.length*2+"");
                                $(this).find('img').css({"filter": "unset"});
                                $(this).css({"filter": "unset"});
                                $('.accordion_2 .card').not(this).css("flex","1");
                                $('.accordion_2 .card').not(this).css("filter","grayscale(100%)");
                                $('.accordion_2 .card').not(this).find('img').css("filter","grayscale(100%)");
                            })
                            return;
                        }

                        // Do stuff here
                        if( timeOutIndex === gallery_item.length ){
                            // reset counter
                            timeOutIndex = 0;
                        } else {
                            // continue
                            var current_item = $('.accordion_2 .card').eq(timeOutIndex);
                            current_item.css("flex", ""+gallery_item.length*2+"" );
                            current_item.css({"filter": "unset"});
                            current_item.find('img').css({"filter": "unset"});
                            current_item.find('.card__head').css({"font-size": "1.5em"});
                            $('.accordion_2 .card').not(current_item).css("flex","1");
                            $('.accordion_2 .card').not(current_item).find('img').css("filter","grayscale(100%)");
                            $('.accordion_2 .card').not(current_item).css("filter","grayscale(100%)");
                            $('.accordion_2 .card').not(current_item).find('.card__head').css("font-size","initial");

                            timeOutIndex++;
                        }

                    };

                    setInterval(action, timeout);
                    action();
                }




            });



        })
        (jQuery);




    };

    elementorFrontend.hooks.addAction( 'frontend/element_ready/accordion-two-gallery.default', addHandler );





} );

