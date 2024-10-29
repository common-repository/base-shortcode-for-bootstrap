function hide_show_obj_bsfb($obj, $fg) {
    if($fg == 'hide') {
        $obj.removeClass('attr-info');
        $obj.parent().addClass('hide');
    } else {
        $obj.addClass('attr-info');
        $obj.parent().removeClass('hide');
    }
}
function hide_show_sub_obj_bsfb($obj, $fg) {
    if($fg == 'hide') {
        $obj.removeClass('sub-attr-info');
        $obj.parent().addClass('hide');
    } else {
        $obj.addClass('sub-attr-info');
        $obj.parent().removeClass('hide');
    }
}
function disabled_select_obj_bsfb($obj, $fg, $val_str) {
    if($fg == 'disabled') {
        var $splits = $val_str.split(',');
        $fg = 0;
        jQuery('option', $obj).each(function() {
            for (var i = 0; i < $splits.length; i++) {
                if(jQuery.trim($splits[i]) == jQuery(this).attr('value')) {
                    jQuery(this).attr('disabled', 'disabled');
                }
            }
        });
        $selected_fg = 0;
        jQuery('option', $obj).each(function() {
            if(jQuery(this).attr('disabled') != 'disabled') {
                if($selected_fg == 0) {
                    jQuery(this).attr('selected', 'selected');
                    ++$selected_fg;
                }
            }
        });
    } else {
        jQuery('option', $obj).each(function(){
            jQuery(this).removeAttr('disabled');
        });
    }
}

jQuery(document).ready(function() {
    //select shortcode
    jQuery('select[name=base-shortcodes-for-bootstrap-list-select]', jQuery('#base-shortcode-for-bootstrap-region')).live('change', function() {
        jQuery('div.shortcode-items', jQuery('#base-shortcode-for-bootstrap-generator')).addClass('hide');
        jQuery('div#'+jQuery(this).val(), jQuery('#base-shortcode-for-bootstrap-generator')).removeClass('hide');
        if(jQuery(this).val() != 0)
            jQuery('button#base-shortcode-for-bootstrap-submit', jQuery('#base-shortcode-for-bootstrap-region .nav-sls')).removeClass('hide');
        else 
            jQuery('button#base-shortcode-for-bootstrap-submit', jQuery('#base-shortcode-for-bootstrap-region .nav-sls')).addClass('hide');
    });
    
    jQuery('.for-develper-btn', jQuery('#base-shortcode-for-bootstrap-generator')).live('click', function() {
        jQuery(this).parent().next().next().removeClass('hide');
    });
    jQuery('.dev-desc button.close', jQuery('#base-shortcode-for-bootstrap-generator')).live('click', function() {
        jQuery(this).parent().addClass('hide');
    });
    jQuery('.preview-btn', jQuery('#base-shortcode-for-bootstrap-generator')).live('click', function() {
        });

    // color picker
    try {
        var $bs_farbtastic_obj = jQuery.farbtastic('#base-shortcode-for-bootstrap-region #color-picker-int');

        jQuery('#base-shortcode-for-bootstrap-region .color-picker').each(function () {
            $bs_farbtastic_obj.linkTo(this);
        });

        jQuery('#base-shortcode-for-bootstrap-region .color-picker').live('click', function(){
            jQuery('#base-shortcode-for-bootstrap-region #color-picker-int').css("display", "inline");
            $bs_farbtastic_obj.linkTo(this);
            jQuery('#base-shortcode-for-bootstrap-region #color-picker-int').insertAfter(this);
        });
    } catch (e1) {
    }
    try {
        jQuery( ".child-items-sortable" ).sortable({
            placeholder: "ui-state-highlight-bsfb",
            stop: function(evt, ui) {
                $id = jQuery('#base-shortcode-for-bootstrap-region select[name=base-shortcodes-for-bootstrap-list-select]').val();
                $idx = 1;
                jQuery('#'+$id + ' .child-datas-grp').each(function() {
                    jQuery('.cnum', jQuery(this)).each(function() {
                        jQuery(this).html($idx);
                    });
                    ++$idx;
                });
            }
        });
    } catch (e1) {
    }

    jQuery('#base-shortcode-for-bootstrap-region .del').live('click', function(){
        jQuery(this).parent().parent().remove();
        $idx = 1;
        jQuery('#'+$id + ' .child-datas-grp').each(function() {
            jQuery('.cnum', jQuery(this)).each(function() {
                jQuery(this).html($idx);
            });
            ++$idx;
        });
        
        $id = jQuery('#base-shortcode-for-bootstrap-region select[name=base-shortcodes-for-bootstrap-list-select]').val();
        $num = jQuery('#'+$id+' .add-child-datas').attr('value');
        $child_len = jQuery('#'+$id+' .child-datas .child-datas-grp').length;
        if($num == $child_len) {
            jQuery('#'+$id + ' .child-datas ul li .child-datas-grp').each(function() {
                jQuery('.del', jQuery(this)).remove();
            });
        }
    });
    
    //icons
    $select_icon_input_fg = false;
    jQuery('#base-shortcode-for-bootstrap-region .ctrl .select-icon-input').live('mousedown', function(){
        if(jQuery(this).next().attr('class') == 'icons-group hide') {
            jQuery('#base-shortcode-for-bootstrap-region .ctrl .icons-group').each(function() {
                jQuery(this).addClass('hide');
            });
            jQuery(this).prev().addClass('selected-icon-border');
            jQuery(this).next().removeClass('hide');
        } else {
            jQuery('#base-shortcode-for-bootstrap-region .ctrl .icons-group').each(function() {
                jQuery(this).addClass('hide');
            });
            jQuery(this).prev().removeClass('selected-icon-border');
            jQuery(this).next().addClass('hide');
        }
        $select_icon_input_fg = true;
    });
    jQuery('#base-shortcode-for-bootstrap-region .ctrl .select-icon-input').live('focusout', function(){
        if($select_icon_input_fg) {
            jQuery(this).prev().removeClass('selected-icon-border');
            jQuery(this).next().addClass('hide');
        }
    });
    jQuery('#base-shortcode-for-bootstrap-region .ctrl .select-icon-input').live('mouseover', function(){
        jQuery('div', jQuery(this).prev()).removeClass('select-icon-img');
        jQuery('div', jQuery(this).prev()).addClass('select-click-focus-img');
    });
    jQuery('#base-shortcode-for-bootstrap-region .ctrl .select-icon-input').live('mouseout', function(){
        jQuery('div', jQuery(this).prev()).removeClass('select-click-focus-img');
        jQuery('div', jQuery(this).prev()).addClass('select-icon-img');
    });
    jQuery(document).on('mousedown', "#base-shortcode-for-bootstrap-region .ctrl .icons-group ul li", function(){
        $class = jQuery('i', jQuery(this)).attr('class');
        $tmp = '';
        if($class) {
            $tmp = '<i class="'+$class+'"></i> '+$class+'<div class="select-icon-img"></div>';
        } else {
            $tmp = 'Select <div class="select-icon-img"></div>';
        }
        jQuery('.select-icon', jQuery(this).parent().parent().parent()).html($tmp);
        jQuery(this).parent().parent().next().val($class);
        jQuery(this).parent().parent().addClass('hide');
        jQuery(this).parent().parent().prev().prev().removeClass('selected-icon-border');
        $select_icon_input_fg = true;
    });
    jQuery(document).on('mousedown', "#base-shortcode-for-bootstrap-region .ctrl .icons-group", function(){
        $select_icon_input_fg = false;
    });
    jQuery('#base-shortcode-for-bootstrap-region .ctrl input:checkbox').live('change', function() {
        if(jQuery(this).attr('value') == '1')
            jQuery(this).attr('value', '');
        else 
            jQuery(this).attr('value', '1');
    });
    jQuery('#base-shortcode-for-bootstrap-region .child-datas-grp .ctrl input:radio').live('change', function() {
        jQuery("#base-shortcode-for-bootstrap-region .child-datas-grp .ctrl input[type='radio']").val('');
        jQuery("#base-shortcode-for-bootstrap-region .child-datas-grp .ctrl input[type='radio']:checked").val('1');
    });
});
