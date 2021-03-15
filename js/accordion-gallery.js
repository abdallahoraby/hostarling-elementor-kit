class WidgetHandlerClass extends elementorModules.frontend.handlers.Base {
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
        elementorFrontend.elementsHandler.addHandler( WidgetHandlerClass, {
            $element,
        } );


        (function ($) {


            $( document ).ready(function() {


                if( document.getElementById('loop_animation') && document.getElementById('loop_animation').value === 'off' ){
                    //nothing to do
                } else {
                    var gallery_item = $('#accordion_gallery .item');

                    var accorGalleryTimeOut = parseInt( document.getElementById('accordion_gallery_time_out').value * 1000 );
                    var timeOutIndex = 0;

                    var timeout = accorGalleryTimeOut;
                    var action = function() {
                        if($('#accordion_gallery').is(':hover')){
                            $('#accordion_gallery .item').hover(function (){
                                $(this).css("flex",""+gallery_item.length*2+"");
                                $('#accordion_gallery .item').not(this).css("flex","1")
                            })
                            return;
                        }

                        // Do stuff here
                        if( timeOutIndex === gallery_item.length ){
                            // reset counter
                            timeOutIndex = 0;
                        } else {
                            // continue
                            var current_item = $('#accordion_gallery .item').eq(timeOutIndex);
                            current_item.css("flex", ""+gallery_item.length*2+"" );
                            $('#accordion_gallery .item').not(current_item).css("flex","1");
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

    elementorFrontend.hooks.addAction( 'frontend/element_ready/accordion-gallery.default', addHandler );





} );



