function blockPage(options) {
    return block('body', options);
}
function unblockPage() {
    return unblock('body');
}

function block (target, options) {
    var el = $(target);

    options = $.extend(true, {
        opacity: 0.03,
        overlayColor: '#000000',
        state: 'brand',
        type: 'loader',
        size: 'lg',
        centerX: true,
        centerY: true,
        message: '',
        shadow: true,
        width: 'auto'
    }, options);

    var skin;
    var state;
    var loading;

    if (options.type == 'spinner') {
        skin = options.skin ? 'm-spinner--skin-' + options.skin : '';
        state = options.state ? 'm-spinner--' + options.state : '';
        loading = '<div class="m-spinner ' + skin + ' ' + state + '"></div>';
    } else {
        skin = options.skin ? 'm-loader--skin-' + options.skin : '';
        state = options.state ? 'm-loader--' + options.state : '';
        size = options.size ? 'm-loader--' + options.size : '';
        loading = '<div class="m-loader ' + skin + ' ' + state + ' ' + size + '"></div>';
    }

    if (options.message && options.message.length > 0) {
        var classes = 'm-blockui ' + (options.shadow === false ? 'm-blockui-no-shadow' : '');

        html = '<div class="' + classes + '"><span>' + options.message + '</span><span>' + loading + '</span></div>';

        var el = document.createElement('div');
        $('body').prepend(el);
        el.className = classes;
        el.innerHTML = '<span>' + options.message + '</span><span>' + loading + '</span>';
        options.width = actualCss(el, 'width', '') + 10;
        el.remove();

        if (target == 'body') {
            html = '<div class="' + classes + '" style="margin-left:-'+ (options.width / 2) +'px;"><span>' + options.message + '</span><span>' + loading + '</span></div>';
        }
    } else {
        html = loading;
    }

    var params = {
        message: html,
        centerY: options.centerY,
        centerX: options.centerX,
        css: {
            top: '30%',
            left: '50%',
            border: '0',
            padding: '0',
            backgroundColor: 'none',
            width: options.width
        },
        overlayCSS: {
            backgroundColor: options.overlayColor,
            opacity: options.opacity,
            cursor: 'wait',
            zIndex: '10'
        },
        onUnblock: function() {
            if (el && el[0]) {
                css(el[0], 'position', '');
                css(el[0], 'zoom', '');
            }
        }
    };

    if (target == 'body') {
        params.css.top = '50%';
        $.blockUI(params);
    } else {
        var el = $(target);
        el.block(params);
    }
}

function unblock(target) {
    if (target && target != 'body') {
        $(target).unblock();
    } else {
        $.unblockUI();
    }
}

function actualCss(el, prop, cache) {
    if (el instanceof HTMLElement) {
        return;
    }

    if (!el.getAttribute('m-hidden-' + prop) || cache === false) {
        var value;

        // the element is hidden so:
        // making the el block so we can meassure its height but still be hidden
        el.style.cssText = 'position: absolute; visibility: hidden; display: block;';

        if (prop == 'width') {
            value = el.offsetWidth;
        } else if (prop == 'height') {
            value = el.offsetHeight;
        }

        el.style.cssText = '';

        // store it in cache
        el.setAttribute('m-hidden-' + prop, value);

        return parseFloat(value);
    } else {
        // store it in cache
        return parseFloat(el.getAttribute('m-hidden-' + prop));
    }
}

function css(el, styleProp, value) {
    el = get(el);

    if (!el) {
        return;
    }

    if (value !== undefined) {
        el.style[styleProp] = value;
    } else {
        var value, defaultView = (el.ownerDocument || document).defaultView;
        // W3C standard way:
        if (defaultView && defaultView.getComputedStyle) {
            // sanitize property name to css notation
            // (hyphen separated words eg. font-Size)
            styleProp = styleProp.replace(/([A-Z])/g, "-$1").toLowerCase();
            return defaultView.getComputedStyle(el, null).getPropertyValue(styleProp);
        } else if (el.currentStyle) { // IE
            // sanitize property name to camelCase
            styleProp = styleProp.replace(/\-(\w)/g, function(str, letter) {
                return letter.toUpperCase();
            });
            value = el.currentStyle[styleProp];
            // convert other units to pixels on IE
            if (/^\d+(em|pt|%|ex)?$/i.test(value)) {
                return (function(value) {
                    var oldLeft = el.style.left,
                        oldRsLeft = el.runtimeStyle.left;
                    el.runtimeStyle.left = el.currentStyle.left;
                    el.style.left = value || 0;
                    value = el.style.pixelLeft + "px";
                    el.style.left = oldLeft;
                    el.runtimeStyle.left = oldRsLeft;
                    return value;
                })(value);
            }
            return value;
        }
    }
}

function get(query) {
    var el;

    if (query === document) {
        return document;
    }

    if (!!(query && query.nodeType === 1)) {
        return query;
    }

    if (el = document.getElementById(query)) {
        return el;
    } else if (el = document.getElementsByTagName(query)) {
        return el[0];
    } else if (el = document.getElementsByClassName(query)) {
        return el[0];
    } else {
        return null;
    }
}

function showAlertMessage(type, message) {
    toastr.options = {
        "closeButton": true,
        "debug": true,
        "newestOnTop": true,
        "progressBar": false,
        "positionClass": "toast-bottom-left",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    if(type === 'success') {
        toastr.success(message);
    } else if(type === 'warning') {
        toastr.warning(message);
    } else if(type === 'error' || type === 'danger') {
        toastr.error(message);
    } else {
        toastr.info(message);
    }
}



$(document).on('keydown', 'input[type=number]', function() {
    if (parseInt($(this).val()) > parseInt($(this).attr('max'))) $(this).val($(this).attr('max'));
    if (parseInt($(this).val()) < parseInt($(this).attr('min'))) $(this).val($(this).attr('min'));
});

$(document).on('keyup', 'input[type=number]', function() {
    if (parseInt($(this).val()) > parseInt($(this).attr('max'))) $(this).val($(this).attr('max'));
    if (parseInt($(this).val()) < parseInt($(this).attr('min'))) $(this).val($(this).attr('min'));
});
