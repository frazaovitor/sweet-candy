(function ($) {

    var defaults = {
        /* Variables */
        appendTo: 'body',
        title: '',
        content: '',
        event: 'click',
        html: false,

        /* Callbacks */
        confirm: null,
        cancel: null,
        beforeShow: null
    };

    var modal = {
        /* Window selectors */
        container: '.rsc-confirm',
        title: '.rsc-confirm-title',
        content: '.rsc-confirm-content',
        overlay: '.rsc-confirm-overlay',
        controls: {
            container: '.rsc-confirm-controls',
            confirm: '.rsc-confirm-confirm',
            cancel: '.rsc-confirm-cancel'
        }
    };

    var markup = [
        '<section class="%modal.container%">',
        '<div class="%modal.title%">Title</div>',
        '<div class="%modal.content%">Content</div>',
        '<div class="%modal.controls.container%">',
        '<button class="%modal.controls.confirm% button button-primary">OK</button>',
        '<button class="%modal.controls.cancel% button">Cancel</button>',
        '</div>',
        '</section>',
        '<div class="%modal.overlay%"></div>'
    ];

    $.fn.rscConfirm = function (parameters) {

        var options = $.extend({}, defaults, parameters),
            element = this;

        this.on(options.event, function (e) {

            e.preventDefault();

            $(options.appendTo).append(markup.join('').replace(/(%.+?%)/g, function (match) {
                return eval(match.replace(/%/g, '')).slice(1);
            }));

            if (options.html === true) {
                $(modal.title).html(options.title);
                $(modal.content).html(options.content);
            } else {
                $(modal.title).text(options.title);
                $(modal.content).text(options.content);
            }

            $(modal.overlay).slideDown(function () {
                if (options.beforeShow !== null) {
                    options.beforeShow();
                }

                $(modal.container).fadeIn('fast', function () {

                    /* handle result */
                    $('button', modal.controls.container).on('click', function (e) {

                        /* do event function */
                        var callback = options[e.target.className.split(' ').shift().split('-').pop()];
                        if (callback && typeof callback == 'function') {
                            callback(e, element);
                        }

                        /* hide container */
                        $(modal.container).fadeOut('fast', function () {
                            $(this).remove();
                        });

                        /* hide overlay */
                        $(modal.overlay).slideUp(function () {
                            $(this).remove()
                        });
                    });
                });
            });
        });
    };
})(jQuery);