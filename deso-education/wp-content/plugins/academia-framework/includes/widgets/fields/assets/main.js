"use strict";
var widget_acf = {
    acf_init: function () {
        jQuery('h3.title', '.widget_acf_accordion').off();
        jQuery('h3.title', '.widget_acf_accordion').click(function () {
            var $parent = jQuery(this).parent();
            var $fieldset = jQuery('.fieldset', $parent);
            var $collapse = $fieldset.attr('data-collapse');
            if ((typeof $collapse) == 'undefined' || $collapse == '1') {
                $fieldset.slideDown();
                $fieldset.attr('data-collapse', '0');
                jQuery('span', jQuery(this)).removeClass('collapse-in');
                jQuery('span', jQuery(this)).addClass('collapse-out');
            } else {
                $fieldset.slideUp();
                $fieldset.attr('data-collapse', '1');
                jQuery('span', jQuery(this)).removeClass('collapse-out');
                jQuery('span', jQuery(this)).addClass('collapse-in');
            }
        });

        jQuery('input[data-title="1"]', '.widget_acf_accordion').keyup(function () {
            var $title = jQuery(this).val();
            var $parent = jQuery(this).attr('data-section-id');
            if ($title == '')
                $title = 'New Section';

            jQuery('span:last-child', '#' + $parent + ' h3.title').text($title);

        });

        jQuery('input[data-title="1"]', '.widget_acf_accordion').off();
        jQuery('input[data-title="1"]', '.widget_acf_accordion').keyup(function () {
            var $title = jQuery(this).val();
            var $parent = jQuery(this).attr('data-section-id');
            if ($title == '')
                $title = 'New Section';

            jQuery('span:last-child', '#' + $parent + ' h3.title').text($title);

        });

        jQuery('.button.add', '.widget_acf_wrap').off();
        jQuery('.button.add', '.widget_acf_wrap').click(function () {
            widget_acf.addSection(jQuery(this));
        });

        jQuery('.button.deletion', '.widget_acf_wrap').off();
        jQuery('.button.deletion', '.widget_acf_wrap').click(function () {
            widget_acf.delSection(jQuery(this));
        });

        var $wrap = jQuery('.widget_acf_wrap');
        widget_acf.initSelect2($wrap);

        widget_acf.uploadImage();
        widget_acf.initCheckbox($wrap);
        widget_acf.registerRequireElement($wrap);

        jQuery('input, select', $wrap).each(function () {
            widget_acf.initRequireElement(jQuery(this));
        })

        if (jQuery.isFunction(jQuery.fn.sortable)){
            jQuery('.accordion-wrap').sortable({
                update: function(){
                    widget_acf.reIndexSection(jQuery('.widget_acf_wrap'));
                }
            });
        }
    },

    addSection: function ($elm) {
        var $data_section_wrap = jQuery($elm).parent().parent();
        var $section = jQuery('.widget_acf_accordion', $data_section_wrap).last().clone(true);
        jQuery('input', jQuery($section)).each(function () {
            jQuery(this).val('');
        });
        jQuery('.media img', $section).remove();
        jQuery('.media .remove-media', $section).remove();

        jQuery('h3.title span', $section).last().html('New Section');
        jQuery('.fieldset', $section).attr('data-collapse', 0);
        jQuery('.fieldset', $section).show();
        jQuery('input', $section).first().focus();
        jQuery('.widget_acf_accordion', $data_section_wrap).last().after($section);

        widget_acf.reIndexSection($elm);

        var $wrap = jQuery('.widget_acf_accordion', $data_section_wrap).last();
        jQuery('div.select-wrap', $wrap).each(function () {
            var $label = jQuery('label', jQuery(this)).clone(false);
            var $select = jQuery('select', jQuery(this)).clone(false);
            var $input = jQuery('input[type="hidden"]', jQuery(this)).clone(false);
            $select.removeClass('select2-offscreen');
            jQuery(this).empty();
            if (typeof $label != 'undefined') {
                jQuery(this).append($label);
            }
            if (typeof $input != 'undefined') {
                jQuery(this).append($input);
            }
            if (typeof $select != 'undefined') {
                jQuery(this).append($select);
            }

        });
        widget_acf.initSelect2($wrap);
        widget_acf.initCheckbox($wrap);
        widget_acf.registerRequireElement($wrap);
    },

    delSection: function ($elm) {
        var $wrap = jQuery($elm).parent().parent().parent().parent();
        var $items = jQuery('.widget_acf_accordion', jQuery($wrap)).length;
        var $data_section_id = jQuery($elm).parent().parent().parent();
        if ($items > 1) {
            jQuery($data_section_id).remove();
            widget_acf.reIndexSection($elm);
        } else {
            jQuery('input', jQuery($wrap)).each(function () {
                jQuery(this).val('');
            });
            jQuery('h3.title span', jQuery($wrap)).last().html('New Section');
        }
    },

    uploadImage: function () {
        jQuery('.widget-acf-upload-button').each(function () {
            jQuery(this).off();
            jQuery(this).click(function (event) {
                event.preventDefault();

                // check for media manager instance
                if (wp.media.frames.gk_frame) {
                    wp.media.frames.gk_frame.open();
                    wp.media.frames.gk_frame.clicked_button = jQuery(this);
                    return;
                }
                // configuration of the media manager new instance
                wp.media.frames.gk_frame = wp.media({
                    title: 'Select image',
                    multiple: false,
                    library: {
                        type: 'image'
                    },
                    button: {
                        text: 'Use selected image'
                    }
                });

                wp.media.frames.gk_frame.clicked_button = jQuery(this);
                // Function used for the image selection and media manager closing
                var gk_media_set_image = function () {
                    var selection = wp.media.frames.gk_frame.state().get('selection');

                    // no selection
                    if (!selection) {
                        return;
                    }

                    // iterate through selected elements
                    selection.each(function (attachment) {
                        var url = attachment.attributes.url;
                        var parent = jQuery(wp.media.frames.gk_frame.clicked_button).parent();
                        var img = jQuery('img', parent);
                        var buttonRemove = jQuery('a.remove-media', parent);

                        var inputId = jQuery('input[data-type="id"]', parent);
                        var inputUrl = jQuery('input[data-type="url"]', parent);
                        var width = wp.media.frames.gk_frame.clicked_button.attr('data-width');
                        var height = wp.media.frames.gk_frame.clicked_button.attr('data-height');
                        if (typeof width == 'undefined') {
                            width = 46;
                        }
                        if (typeof height == 'undefined') {
                            height = 28;
                        }
                        if (img.length <= 0) {
                            img = '<img src="" width="' + width + '" height="' + height + '">';
                            img = jQuery(img);
                        }
                        img.attr('src', url);
                        inputUrl.val(url);
                        inputId.val(attachment.attributes.id);
                        parent.prepend(img);


                        if (buttonRemove.length <= 0) {
                            buttonRemove = jQuery('<a href="javascript:void(0);" class="button remove-media">Remove</a>');
                            buttonRemove.insertAfter(wp.media.frames.gk_frame.clicked_button);
                        }
                        widget_acf.removeImage(parent);
                    });
                };

                // closing event for media manger
                //wp.media.frames.gk_frame.on('close', gk_media_set_image);
                // image selection event
                wp.media.frames.gk_frame.on('select', gk_media_set_image);
                // showing media manager
                wp.media.frames.gk_frame.open();


            });

            widget_acf.removeImage(jQuery(this).parent());
        });
    },

    removeImage: function (parent) {
        jQuery('.remove-media', parent).off();
        jQuery('.remove-media', parent).click(function () {
            var inputId = jQuery('input[data-type="id"]', parent);
            var inputUrl = jQuery('input[data-type="url"]', parent);
            var img = jQuery('img', parent);
            img.remove();
            inputUrl.val('');
            inputId.val('');
            jQuery(this).remove();
        });
    },

    initSelect2: function ($wrap) {
        if (jQuery.isFunction(jQuery.fn.select2)) {
            jQuery('select.select2', $wrap).each(function () {
                var id = '#s2id_' + jQuery(this).attr('id');
                var divSelect2 = jQuery(id, jQuery(this).parent());
                if (typeof (divSelect2) != 'undefined') {
                    divSelect2.remove();
                }
                jQuery(this).select2({
                    allowClear: true
                });

                var $multiple = jQuery(this).attr('data-multiple');
                if (typeof($multiple) != 'undefined' && $multiple == '1') {

                    var $input = jQuery('input', jQuery(this).parent()).first();
                    var $values = jQuery($input).val();

                    var choices = [];
                    if (typeof ($values) != 'undefined' && $values != '') {
                        $values = $values.split(",");
                        for (var i = 0; i < $values.length; i++) {
                            var option = jQuery("option[value=" + $values[i] + "]", jQuery(this));
                            choices[i] = {id: $values[i], text: option[0].label, element: option};
                        }
                        jQuery(this).select2("data", choices);
                    }

                    jQuery(this).on("select2-selecting",function (e) {
                        var ids = jQuery(this).val();
                        if (typeof (ids) == 'undefined' || ids == null)
                            ids = '';
                        if (ids != "") {
                            ids += ",";
                        }
                        ids += e.val;
                        jQuery($input).val(ids);
                    }).on("select2-removed", function (e) {
                        var ids = jQuery($input).val();
                        var arr_ids = ids.split(",");
                        var newIds = "";
                        for (var i = 0; i < arr_ids.length; i++) {
                            if (arr_ids[i] != e.val) {
                                if (newIds != "") {
                                    newIds += ",";
                                }
                                newIds += arr_ids[i];
                            }
                        }
                        jQuery($input).val(newIds);
                    });
                }
                ;

                var data_select_icon = jQuery(this).attr('data-select-icon');
                if (typeof data_select_icon != 'undefined' && data_select_icon == '1') {
                    jQuery(this).select2({
                        formatResult: widget_acf.formatIconState,
                        formatSelection: widget_acf.formatIconState
                    });
                }
            });
        }
    },

    initCheckbox: function ($wrap) {
        jQuery('.checkbox', $wrap).each(function () {
            var $checkbox = jQuery(this);
            $checkbox.off();
            $checkbox.change(function () {
                if ($checkbox.is(':checked')) {
                    $checkbox.val('1');
                } else {
                    $checkbox.val('0');
                }
            })
        });
    },

    reIndexSection: function ($elm_raise_event) {
        var $wrap = '.widget_acf_wrap';
        var $section = '.widget_acf_accordion';
        var $prefix_id = 'widget_acf_accordion_';
        jQuery($section, $wrap).each(function ($index) {
            $index--;
            jQuery(this).attr('id', $prefix_id + $index);
            jQuery('input', jQuery(this)).each(function () {
                if (typeof jQuery(this).attr('name') != 'undefined') {
                    jQuery(this).attr(
                        "name", jQuery(this).attr("name").replace(/\[(\d+)\](?!.*\[\d+\])/, '[' + $index + ']')
                    );
                }
                jQuery(this).attr(
                    "id", jQuery(this).attr("id").replace(/[0-9]$/, $index)
                );
                jQuery(this).attr(
                    "data-section-id", ($prefix_id + $index)
                );
            });

            jQuery('div[data-require-element-id]', jQuery(this)).each(function () {
                jQuery(this).attr(
                    "data-require-element-id", jQuery(this).attr("data-require-element-id").replace(/[0-9]$/, $index)
                );
            });


            jQuery('select', jQuery(this)).each(function () {
                if (typeof jQuery(this).attr('name') != 'undefined') {
                    jQuery(this).attr(
                        "name", jQuery(this).attr("name").replace(/\[(\d+)\](?!.*\[\d+\])/, '[' + $index + ']')
                    );
                }
                jQuery(this).attr(
                    "id", jQuery(this).attr("id").replace(/[0-9]$/, $index)
                );
            });
            jQuery('a.button.deletion').each(function () {
                jQuery(this).attr(
                    "data-section-id", ($prefix_id + $index)
                );
            });
        });
    },

    registerRequireElement: function ($wrap) {
        jQuery('input, select', $wrap).change(function () {
            widget_acf.initRequireElement(jQuery(this));
        })
    },

    initRequireElement: function ($wrap) {
        var id = $wrap.attr('id');
        var value = $wrap.val();

        jQuery('div[data-require-element-id="' + id + '"]').each(function () {
            var compare = jQuery(this).attr('data-require-compare');
            var values = jQuery(this).attr('data-require-values');
            if (typeof values != 'undefined' && values != '') {
                values = values.split(',');
            }
            var isShow = false;
            if (compare == '!=')
                isShow = true;

            jQuery.each(values, function ($i, $v) {
                if ($v == value) {
                    isShow = compare == '=';
                    return;
                }
            });
            if (isShow) {
                jQuery(this).show();
            } else {
                jQuery(this).hide();
            }

        });
    },

    formatIconState: function (state) {
        if (!state.id) {
            return state.text;
        }
        var $state = jQuery(
            '<span><i class="' + state.element[0].value.toLowerCase() + '"/> ' + state.text + '</span>'
        );
        return $state;
    }

}

