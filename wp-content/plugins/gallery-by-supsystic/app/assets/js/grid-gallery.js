(function ($) {
    $.fn.refresh = function () {
        return $(this.selector);
    };
}(jQuery));

(function (app, $) {

    function Loader() {
        this.$overlay = $('.gg-modal-loading-overlay');
        this.$content = $('.gg-modal-loading-object');
        this.$loadingText = this.$content.find('span#loading-text');

        this.defaultText = this.$loadingText.text();
    }

    Loader.prototype.clearText = function () {
        this.$loadingText.text(this.defaultText);
    };

    Loader.prototype.show = function (text) {
        this.$overlay.slideDown($.proxy(function () {
            if (typeof text !== 'undefined') {
                this.$loadingText.text(text);
            }

            this.$content.show();
        }, this));
    };

    Loader.prototype.hide = function () {
        // Chrome bug ?
        setTimeout($.proxy(function () {
            this.$content.hide($.proxy(function () {
                this.$overlay.slideUp();
                this.clearText();
            }, this));
        }, this), 1500)
    };

    $(document).ready(function () {
        app.Loader = new Loader;
    });

}(window.SupsysticGallery = window.SupsysticGallery || {}, jQuery));

(function (app, $) {

    function Forms() {
    }

    Forms.prototype.preventSubmit = function (submitEvent) {
        submitEvent.preventDefault();
        return false;
    };

    $(document).ready(function () {
        app.Forms = new Forms;

        $('[data-prevent-submit]').submit(app.Forms.preventSubmit);
    });

}(window.SupsysticGallery = window.SupsysticGallery || {}, jQuery));

(function ($) {

    $(document).ready(function () {
        var ggActiveTab = (jQuery('nav.supsystic-navigation li.active a').length ? jQuery('nav.supsystic-navigation li.active a').attr('href').split('/') : null);

        if(ggActiveTab) {
            ggActiveTab = ggActiveTab[ggActiveTab.length - 1];

            if(typeof(ggActiveTab) != 'undefined') {
                var subMenus = jQuery('#toplevel_page_supsystic-gallery').find('.wp-submenu li');
                subMenus.removeClass('current').each(function(){
                    if(jQuery(this).find('a[href="'+ ggActiveTab + '"]').size()) {
                        jQuery(this).addClass('current');
                    }
                });
            }
        }

        //SupsysticGallery.Loader.show();

		var $toolTipParams = {
			'contentAsHTML': true,
			'interactive': true,
			'speed': 250,
			'delay': 0,
			'animation': 'swing',
			'position': 'right',
			'maxWidth': 450,
		};
		if(window && window.sggParams && window.sggParams.isRtl == '1') {
			$toolTipParams['position'] = 'left';
		}
        /* Tooltipster */
        $('.supsystic-tooltip').tooltipster($toolTipParams);

        /* Lazy loading */
        $('.supsystic-lazy').ggLazyLoad({
            effect: 'fadeIn',
            load: function () {
                setContainerHeight();
            }
        });

        ggInitCustomCheckRadio();
        changeUiButtonToWp();
        closeOnOutside();

        /*setTimeout(function(){	// setTimeout to make sure that all required show/hide were triggered
            ggResetCopyTextCodeFields();
        }, 10);*/
        ggCodeSelection();
        setTimeout(function() {setContainerHeight();}, 200);
    });

    $(window).on('resize', function () {
        setContainerHeight();
        //ggResetCopyTextCodeFields();
    });

    function ggInitCustomCheckRadio(selector) {
        if(!selector)
            selector = document;
        jQuery(selector).find('input').iCheck('destroy').iCheck({
            checkboxClass: 'icheckbox_minimal'
            ,	radioClass: 'iradio_minimal'
        }).on('ifClicked', function(e){
            jQuery(this).trigger('click')
                .trigger('change');
            ggCheckUpdateArea('.supsystic-container');
        });
    }
    function ggCheckUpdate(checkbox) {
        jQuery(checkbox).iCheck('update');
    }
    function ggCheckUpdateArea(selector) {
        jQuery(selector).find('input[type=radio], input[type=checkbox]').iCheck('update');
    };

    function setContainerHeight() {
        var container = $('.supsystic-container'),
            content = $('.supsystic-content'),
            navigation = $('.supsystic-navigation ul');

        container.css({'height': 'auto'});
        navigation.css({'height': 'auto'});
        content.css({'height': 'auto'});

        if (content.outerHeight() > navigation.outerHeight() || container.outerHeight > navigation.outerHeight()) {
            navigation.css({'height': container.css('heigth') + 'px'});
        } else {
            container.css({'height': navigation.outerHeight() + 'px'});
            content.css({'height': navigation.outerHeight() + 'px'});
        }
    }

    function changeUiButtonToWp() {
        $(document).on('dialogopen', function (event, ui) {
            var $button = $('.ui-button');

            $button.each(function () {
                if (!$(this).hasClass('ui-dialog-titlebar-close')) {
                    $(this).removeAttr('class').addClass('button button-primary');
                }
            });
        });
    }

    function closeOnOutside() {
        $(document).on('click', function () {
            var $overlay = $('.ui-widget-overlay');
            var $container = $('body').find('.ui-dialog-content');

            $overlay.on('click', function () {
                $container.dialog('close');
            });
        });
    }

    /**
     * Make shortcodes display normal width
     */
    function ggResetCopyTextCodeFields(selector) {
        var area = selector ? jQuery(selector) : jQuery(document);
        if(area.find('.ggCopyTextCode').size()) {
            var cloneWidthElement =  jQuery('<span class="sup-shortcode" />').appendTo('.supsystic-plugin');
            area.find('.ggCopyTextCode').attr('readonly', 'readonly').click(function(){
                this.setSelectionRange(0, this.value.length);
            }).focus(function(){
                this.setSelectionRange(0, this.value.length);
            });
            area.find('input.ggCopyTextCode').each(function(){
                cloneWidthElement.html( str_replace(jQuery(this).val(), '<', 'P') );
                jQuery(this).width( cloneWidthElement.width() );
            });
            cloneWidthElement.remove();
        }
    }
    function str_replace(haystack, needle, replacement) {
        var temp = haystack.split(needle);
        return temp.join(replacement);
    }

    function ggCodeSelection() {
        jQuery('.ggCopyTextCode').click(function() {
            $(this).trigger('select');
        });
    }

})(jQuery);