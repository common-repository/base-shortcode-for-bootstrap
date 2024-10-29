//columns
var $columns_num = 0;
var $after_fix = '';
function select_column_number_bsfb($this, $after_fix_txt) {
    $after_fix = $after_fix_txt;
    $columns_num = jQuery($this).val();
    $input_str = '<div class="clear"></div><input type="button" value="%%number%%" style="width: %%width%%px; text-align: left; padding-left: 5px" onClick="insert_columns_bsfb(this)" class="btn_column-%%number_cls%%">';
    $attach_str = '';
    $t = 0;
    $width = '90';

    for (var $i = 0; $i < jQuery($this).val(); $i++) {
        ++$t;
        $tmp = '';
        $tmp = $input_str.replace('%%number%%',  get_name_columns_bsfb($t+'/'+jQuery($this).val()));
        $tmp = $tmp.replace('%%number_cls%%', $t);
        $tmp_v = parseInt($width)+parseInt($t)*20;
        $tmp = $tmp.replace('%%width%%', $tmp_v);
        $attach_str += $tmp;
    }

    jQuery(jQuery($this).next()).html($attach_str);
    jQuery(jQuery($this).next().next()).html('');
}
function insert_columns_bsfb(obj) {
    $str = jQuery(obj).attr('class');    
    $ary = $str.split("-");

    $columns_num -= $ary[1];
    $test_tmp = $ary[1];

    $str = obj.value;
    $ary = $str.split('/');
    $span_num = 12 * $ary[0]/$ary[1];
    
    //$tmp_str = get_name_columns_bsfb($ary[0]/$ary[1]);
    
    $attach_str = '<div class="child-datas-grp"><input type="hidden" name="sub_shortcode" value="'+obj.value+'"><textarea name="content" rows="4" cols="40" class="content sub-attr-info" style="float: left" >Column '+obj.value+'</textarea><div class="del" onClick="del_columns_bsfb(this, '+$test_tmp+')"></div><div class="h-10"></div></div>';
    jQuery(jQuery(obj).parent().next()).append($attach_str);
    reindexing_columns_bsfb(jQuery(obj).parent());
}

function del_columns_bsfb(obj, num) {
    $column_v_obj = jQuery(obj).parent().parent().prev();
    jQuery(obj).parent().remove();
    $columns_num += num;
    reindexing_columns_bsfb($column_v_obj);
}

function reindexing_columns_bsfb($column_v_obj) {
    $add_items_obj = jQuery($column_v_obj).next();

    $tmp_len = jQuery('textarea[name=content]', $add_items_obj).length;
    jQuery('input[class^=btn_column]', $column_v_obj).each(function () {
        if($columns_num > 0) {
            $str = jQuery(this).attr('class');
            $ary_tmp = $str.split(" ");

            if($ary_tmp.length == 1) {
                $ary = $str.split('-');
                $tmp_num = $ary[1];
            } else {
                $str = $ary_tmp[0];
                $ary = $str.split('-');
                $tmp_num = $ary[1];
            }
                
            if($tmp_num > $columns_num) {
                jQuery(this).attr('disabled', 'disabled');
                jQuery(this).addClass('col_disabled');
            } else {
                jQuery(this).removeAttr('disabled');
                jQuery(this).removeClass('col_disabled');
            }
        } else {
            jQuery(this).attr('disabled', 'disabled');
            jQuery(this).addClass('col_disabled');
        }
    });
}

function get_name_columns_bsfb($str) {
    $ret_str = '';
    switch($str) {
        case '1/12':
            $ret_str = 'one_twelth'+$after_fix;
            break;
        case '2/12':
            $ret_str = 'one_sixth'+$after_fix;
            break;
        case '3/12':
            $ret_str = 'three_twelths'+$after_fix;
            break;
        case '4/12':
            $ret_str = 'one_third'+$after_fix;
            break;
        case '5/12':
            $ret_str = 'five_twelths'+$after_fix;
            break;
        case '6/12':
            $ret_str = 'one_half'+$after_fix;
            break;
        case '7/12':
            $ret_str = 'seven_twelths'+$after_fix;
            break;
        case '8/12':
            $ret_str = 'two_thirds'+$after_fix;
            break;
        case '9/12':
            $ret_str = 'nine_twelths'+$after_fix;
            break;
        case '10/12':
            $ret_str = 'five_sixths'+$after_fix;
            break;
        case '11/12':
            $ret_str = 'eleven_twelths'+$after_fix;
            break;
        case '12/12':
            $ret_str = 'full_width'+$after_fix;
            break;
        case '1/2':
            $ret_str = 'one_half'+$after_fix;
            break;
        case '2/2':
            $ret_str = 'full_width'+$after_fix;
            break;
        case '1/3':
            $ret_str = 'one_third'+$after_fix;
            break;
        case '2/3':
            $ret_str = 'two_thirds'+$after_fix;
            break;
        case '3/3':
            $ret_str = 'full_width'+$after_fix;
            break;
        case '1/4':
            $ret_str = 'one_quarter'+$after_fix;
            break;
        case '2/4':
            $ret_str = 'one_half'+$after_fix;
            break;
        case '3/4':
            $ret_str = 'three_quarters'+$after_fix;
            break;
        case '4/4':
            $ret_str = 'full_width'+$after_fix;
            break;
        case '1/6':
            $ret_str = 'one_sixth'+$after_fix;
            break;
        case '2/6':
            $ret_str = 'one_third'+$after_fix;
            break;
        case '3/6':
            $ret_str = 'one_half'+$after_fix;
            break;
        case '4/6':
            $ret_str = 'two_thirds'+$after_fix;
            break;
        case '5/6':
            $ret_str = 'five_sixths'+$after_fix;
            break;
        case '6/6':
            $ret_str = 'full_width'+$after_fix;
            break;
    }
    return $ret_str;
}

function tab_active_check_bsfb() {
    jQuery('#base-shortcode-for-bootstrap-region #tab_group .child-datas ul.child-items-sortable li').each(function() {
        $obj = jQuery('input[name=active]', jQuery(this)).parent();
        jQuery('input[name=active]', jQuery($obj)).each(function () {
            if(jQuery(this).attr('type') == 'hidden') {
                jQuery(this).remove();
            }
        });
        if(jQuery('select[name=tree_view]', jQuery(this)).val() == 'have_child') {
            jQuery($obj).append('<input type="hidden" name="active" class="sub-attr-info" value="" />');
        }
    });

    jQuery('#base-shortcode-for-bootstrap-region #tab_group .child-datas ul.child-items-sortable li').each(function() {
        if(jQuery('select[name=tree_view]', jQuery(this)).val() == 'child' && jQuery('input[name=active]', jQuery(this)).val() == '1') {
            $obj = jQuery(this);
            $obj = jQuery($obj).prev();
            $fg = false;
            do {
                if(jQuery($obj).attr('class') == 'ui-state-default') {
                    if(jQuery('.ctrl select[name=tree_view]', jQuery($obj)).val() == 'have_child') {
                        jQuery('.ctrl input[name=active].sub-attr-info', jQuery($obj)).val('1');
                        $fg = true;
                    }
                    if(jQuery('.ctrl select[name=tree_view]', jQuery($obj)).val() == '') {
                        $fg = true;
                    }
                    $obj = jQuery($obj).prev();
                } else {
                    $fg = true;
                }
            } while($fg == false);
        }
    });
}

jQuery(document).ready(function() {
    //columns
    jQuery('#columns select[name=column]').change(function() {
        select_column_number_bsfb(this, '');
    });
    
    //buttons
    jQuery('#base-shortcode-for-bootstrap-region #button select[name=position]').live('change', function() {
        $obj = jQuery('#base-shortcode-for-bootstrap-region #button select[name=wrap]');
        disabled_select_obj_bsfb($obj,'','');
        if(jQuery(this).val() == 'center') {
            disabled_select_obj_bsfb($obj,'disabled', 'yes');
        }
    });
    jQuery('#base-shortcode-for-bootstrap-region #button select[name=block_btn_fg]').live('change', function() {
        $obj = jQuery('#base-shortcode-for-bootstrap-region #button select[name=wrap]');
        disabled_select_obj_bsfb($obj,'','');
        if(jQuery(this).val() == 'yes') {
            disabled_select_obj_bsfb($obj,'disabled', 'yes');
        }
        $obj = jQuery('select[name=position]', jQuery(this).parent().parent().parent());
        hide_show_obj_bsfb($obj, 'show');
        if(jQuery(this).val() == 'yes') {
            hide_show_obj_bsfb($obj, 'hide');
        }
    });
    jQuery('#base-shortcode-for-bootstrap-region #button select[name=more]').live('change', function() {
        $obj = jQuery('#base-shortcode-for-bootstrap-region #button input[name=loading_text]');
        hide_show_obj_bsfb($obj, 'hide');
        if(jQuery(this).val() == 'stateful') {
            hide_show_obj_bsfb($obj, 'show');
        }
        
        $obj = jQuery('#base-shortcode-for-bootstrap-region #button input[name=link]');
        hide_show_obj_bsfb($obj, 'show');
        if(jQuery(this).val() == 'stateful' || jQuery(this).val() == 'single_toggle' || jQuery(this).val() == 'popover' || jQuery(this).val() == 'modal') {
            hide_show_obj_bsfb($obj, 'hide');
        }
        
        $obj = jQuery('#base-shortcode-for-bootstrap-region #button select[name=new_window]');
        hide_show_obj_bsfb($obj, 'show');
        if(jQuery(this).val() == 'stateful' || jQuery(this).val() == 'single_toggle' || jQuery(this).val() == 'popover' || jQuery(this).val() == 'modal') {
            hide_show_obj_bsfb($obj, 'hide');
        }
        
        $obj = jQuery('#base-shortcode-for-bootstrap-region #button input[name=more_title]');
        hide_show_obj_bsfb($obj, 'hide');
        if(jQuery(this).val() == 'popover' || jQuery(this).val() == 'modal') {
            hide_show_obj_bsfb($obj, 'show');
            $tmp_str = jQuery('.label', $obj.parent()).html();
            if($tmp_str.search('class="mandatory-star"') != -1) {
                jQuery('.label', $obj.parent()).html('Title for '+jQuery(this).val()+' <span class="mandatory-star">*</span>');
            }
        }
        
        $obj = jQuery('#base-shortcode-for-bootstrap-region #button textarea[name=more_content]');
        hide_show_obj_bsfb($obj, 'hide');
        if(jQuery(this).val() == 'popover' || jQuery(this).val() == 'modal') {
            hide_show_obj_bsfb($obj, 'show');
            $tmp_str = jQuery('.label', $obj.parent()).html();
            if($tmp_str.search('class="mandatory-star"') != -1)
                jQuery('.label', $obj.parent()).html('Content for '+jQuery(this).val()+' <span class="mandatory-star">*</span>');
        }
        
        $obj = jQuery('#base-shortcode-for-bootstrap-region #button select[name=more_position]');
        hide_show_obj_bsfb($obj, 'hide');
        if(jQuery(this).val() == 'popover') {
            hide_show_obj_bsfb($obj, 'show');
            $tmp_str = jQuery('.label', $obj.parent()).html();
            if($tmp_str.search('class="mandatory-star"') != -1)
                jQuery('.label', $obj.parent()).html('Position for '+jQuery(this).val()+' <span class="mandatory-star">*</span>');
        }
    });
    //image
    jQuery('#base-shortcode-for-bootstrap-region #image select[name=position]').live('change', function() {
        $obj = jQuery('#base-shortcode-for-bootstrap-region #image select[name=wrap]');
        disabled_select_obj_bsfb($obj,'','');
        if(jQuery(this).val() == 'center') {
            disabled_select_obj_bsfb($obj,'disabled', 'yes');
        }
    });
    jQuery('#base-shortcode-for-bootstrap-region #image select[name=width_option]').live('change', function() {
        $obj = jQuery('#base-shortcode-for-bootstrap-region #image input[name=width]');
        hide_show_obj_bsfb($obj, 'hide');
        if(jQuery(this).val() == 'custom')
            hide_show_obj_bsfb($obj, 'show');
        
        $obj = jQuery('#base-shortcode-for-bootstrap-region #image input[name=height]');
        hide_show_obj_bsfb($obj, 'hide');
        if(jQuery(this).val() == 'custom')
            hide_show_obj_bsfb($obj, 'show');
    });
    //Single button group
    jQuery('#base-shortcode-for-bootstrap-region #single_button_group select[name=position]').live('change', function() {
        $obj = jQuery('#base-shortcode-for-bootstrap-region #single_button_group select[name=wrap]');
        disabled_select_obj_bsfb($obj,'','');
        if(jQuery(this).val() == 'center') {
            disabled_select_obj_bsfb($obj,'disabled', 'yes');
        }
    });
    //gropdown button group
    jQuery('#base-shortcode-for-bootstrap-region #dropdown_button_group select[name=position]').live('change', function() {
        $obj = jQuery('#base-shortcode-for-bootstrap-region #dropdown_button_group select[name=wrap]');
        disabled_select_obj_bsfb($obj,'','');
        if(jQuery(this).val() == 'center') {
            disabled_select_obj_bsfb($obj,'disabled', 'yes');
        }
    });
    jQuery('#base-shortcode-for-bootstrap-region #dropdown_button_group select[name=kind]').live('change', function() {
        $obj = jQuery('input[name=link_url]', jQuery(this).parent().parent());
        hide_show_obj_bsfb($obj, 'hide');
        if(jQuery(this).val() == 'split')
            hide_show_obj_bsfb($obj, 'show');
        
        $obj = jQuery('select[name=new_window]', jQuery(this).parent().parent());
        hide_show_obj_bsfb($obj, 'hide');
        if(jQuery(this).val() == 'split')
            hide_show_obj_bsfb($obj, 'show');
    });
    
    // tab group
    jQuery('#base-shortcode-for-bootstrap-region #tab_group .child-datas-grp .ctrl select[name=tree_view]').live('change', function() {
        $obj = jQuery('.ctrl textarea[name=content]', jQuery(this).parent().parent().parent());
        hide_show_sub_obj_bsfb($obj, 'show');
        if(jQuery(this).val() == 'have_child') {
            hide_show_sub_obj_bsfb($obj, 'hide');
        }
        
        $obj = jQuery('.ctrl input[name=active]', jQuery(this).parent().parent().parent());
        hide_show_sub_obj_bsfb($obj, 'show');
        if(jQuery(this).val() == 'have_child') {
            hide_show_sub_obj_bsfb($obj, 'hide');
        }
        tab_active_check_bsfb();
    });
    
    jQuery('#base-shortcode-for-bootstrap-region #tab_group .child-datas-grp .ctrl input:radio').live('change', function() {
        tab_active_check_bsfb();
    });
    
    jQuery('#base-shortcode-for-bootstrap-region #tab_group .child-items-sortable').on( "sortbeforestop", function( event, ui ) {
        tab_active_check_bsfb();
    });
    jQuery('#base-shortcode-for-bootstrap-region #tab_group .del').live('click', function() {
        tab_active_check_bsfb();
    });
});