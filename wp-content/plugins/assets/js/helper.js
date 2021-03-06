var builder_helper = this.ec_builder_helper || (this.ec_builder_helper = {});
var ec_utils_helper = builder_helper.Utils || (builder_helper.Utils = {});
var ec_functions_helper = builder_helper.Functions || (builder_helper.Functions = {});
var ec_settings_helper = builder_helper.Settings || (builder_helper.Settings = {});
var ec_templates_helper = builder_helper.Templates || (builder_helper.Templates = {});

var make_image_proper_size=function () {
  var __email_width=jQuery('#settings-email-width').val();

  jQuery('.image-a').each(function () {
    jQuery(this).find('.img').css('max-width',__email_width+'px');
  });
}

var jsonParse = function (jsonStr) {
    var __json = jsonStr;
    try {
        __json = JSON.parse(jsonStr);
    } catch (e) {

    }
    return __json;
}

var ec_woo_debug = false;
/*
 * For sending AJAX request
 */

var shortcode_list = {};

var generate_shortcode_for_all_text = function () {
    jQuery('.ec-preview-content-sortable-column[data-settings-type="text"]').each(function () {
        var __self = jQuery(this);
        var __body = __self.find('.ec-preview-content-sortable-column-body');
        var __generate = do_shortcode(__body.html());
        __body.html(__generate);
    });
}

var generate_shortcode = function (key, value) {
    var __span_tag_list = [
        '[ec_woo_site_name]',
        '[ec_woo_order_date]',
        '[ec_woo_order_time]',
        '[ec_woo_order_datetime]',
        '[ec_woo_order_link]',
        '[ec_woo_user_name]',
        '[ec_woo_billing_first_name]',
        '[ec_woo_billing_last_name]',
        '[ec_woo_user_id]',
        '[ec_woo_user_email]',
        '[ec_woo_shipping_first_name]',
        '[ec_woo_shipping_last_name]',
        '[ec_woo_billing_phone]',
        '[ec_woo_order_id]',
        '[ec_woo_billing_email]',
        '[ec_woo_order_delivery_date]'
    ];
    ;
    var __result = '';
    // if (__span_tag_list.indexOf(key) > -1) {
    //   __result = '<span data-shortcode="' + key + '">' + value + '</span>';
    // } else {
    //   __result = '<div data-shortcode="' + key + '">' + value + '</div>';
    // }
    __result = '<span data-shortcode="' + key + '">' + value + '</span>';
    return __result;
}
var check_has_shortcode = function (_shortcode) {
    // if ((/ec_woo_related_items/).test(_shortcode))
    //     return true;

    // if ((/type='([^"]*)'/).test(_shortcode))
    //     return true;
}
var do_shortcode = function (value) {
    value = value.split('<p').join('<div');
    value = value.split('</p>').join('</div>');

    var result = value.match(/\[([\w-]+)([^]*?)(\/?)\]/g);
    for (var index in result) {
      (function () {
        var _shortcode = result[index];
        var _has_type = !!check_has_shortcode(_shortcode);
        if (_has_type===true) {
            // var data = {
            //     action: 'generate_shortcode',
            //     shortcode: _shortcode.split("'").join('"')
            // };
            // ajax_request(data, function (response) {
            //     shortcode_list[_shortcode] = response.data;
            //     var __generated_shortcode = generate_shortcode(_shortcode, shortcode_list[key]);
            //     value = _join(value.split(key), __generated_shortcode);
            //     // for (var key in shortcode_list) {
            //     //     if (value.indexOf(key) > -1) {
            //     //         var __generated_shortcode = generate_shortcode(key, shortcode_list[key]);
            //     //         value = _join(value.split(key), __generated_shortcode);
            //     //     }
            //     // }
            // });
          }
        })(index);
    }
    for (var key in shortcode_list) {
        if (value.indexOf(key) > -1) {
            var __generated_shortcode = generate_shortcode(key, shortcode_list[key]);
            value = _join(value.split(key), __generated_shortcode);
        }
    }
    return value;
}
var _join = function (arr, value) {
    var result = '';
    for (var i = 0; i < arr.length; i++) {
        //console.log(arr[i]);
        if (arr[i].length > 0) {
            result += arr[i];
        }
        if (i != (arr.length - 1)) {
            result += value;
        }
    }
    return result;
}

/*
 * For sending AJAX request
 */
var ajax_request = function (data, success_callback, fail_callback) {

    var _ajax_url = woo_ec_vars.ajax_url;

    data.development = ec_woo_debug == true ? 1 : 0;

    var jqxhr = jQuery.post(_ajax_url, data);

    jqxhr.done(function (response) {
        if (ec_woo_debug) {
            console.log('jqxhr.done', response);
        }

        response = jsonParse(response);

        if (response.code == 200) {
            if (success_callback !== undefined) {
                success_callback(response);
            }
        } else {
            if (fail_callback !== undefined) {
                fail_callback(response);
            }

            iziToast.error({
                title: 'Error',
                message: response.message,
                position: 'bottomRight'
            });
        }
    });

    jqxhr.fail(function (response) {
        if (ec_woo_debug) {
            console.log('jqxhr.fail', response);
        }
        iziToast.error({
            title: 'Request failed',
            message: "Please check <b>logs</b> in the plugin's folder",
            position: 'bottomRight'
        });
        if (fail_callback !== undefined) {
            fail_callback(response);
        }
    });

}

var enable_save_template = function () {
    jQuery('.ec-preview-header-control-item.ec-control-save').removeClass('ec-control-save-disabled');
}



var scrollTop = function () {
    setTimeout(function () {
        window.scrollTo(0, 0);
    }, 200);
}
