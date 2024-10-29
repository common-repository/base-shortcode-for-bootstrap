// media upload
var $btn_str = '<input type="button" id="media_return_to_bsfb" name="media_return_to_bsfb" class="" value="Return" style="position: absolute; top: 32px; right: 30px;" onClick="return_gallery_bsfb()">';

function return_gallery_bsfb() {
    $idx = 0;
    jQuery("div[id='TB_title']").each(function() {
        if($idx == 0) {
            jQuery(this).show();
        } else {
            jQuery(this).remove();
        }
        ++$idx;
    });

    jQuery('#TB_ajaxContent').show();
    jQuery('#TB_iframeContent').remove();
}

var $base_shortcode_for_bootstrap_storeSendToEditor = '';
var $base_shortcode_for_bootstrap_newSendToEditor = '';

jQuery(document).ready(function () {
    var $base_shortcode_for_bootstrap_obj = '';
    var $base_shortcode_for_bootstrap_storeSendToEditor = '';
    var $base_shortcode_for_bootstrap_newSendToEditor = '';
    // media upload
    jQuery("#base-shortcode-for-bootstrap-region .file-upload-btn-bs").live('click', function(){
        jQuery("#TB_title").hide();
        jQuery('#TB_ajaxContent').hide();
        window.send_to_editor = $base_shortcode_for_bootstrap_newSendToEditor;

        tb_show('Add media', 'media-upload.php?type=image&TB_iframe=true');//&tab=library
        $idx = 0;
        jQuery("div[id='TB_title']").each(function () {
            if(jQuery(this).css("display") != "none") {
                if($idx == 0) {
                    jQuery(this).append($btn_str);
                } else {
                    jQuery(this).remove();
                }
                ++$idx;
            }
        });
        $base_shortcode_for_bootstrap_obj = this;
    });

    $base_shortcode_for_bootstrap_storeSendToEditor = window.send_to_editor;

    $base_shortcode_for_bootstrap_newSendToEditor = function(html) {
        $p_obj = jQuery($base_shortcode_for_bootstrap_obj).parent();
        imgurl = jQuery('img',html).attr('src');
        jQuery('input', $p_obj).val(imgurl);
        jQuery('input', $p_obj).css('border-color', '#dfdfdf');
        return_gallery_bsfb();
        window.send_to_editor = $base_shortcode_for_bootstrap_storeSendToEditor;
    }
    // add sub shortcode
    jQuery('.plus').live('click', function(){
        $id = jQuery('#base-shortcode-for-bootstrap-region select[name=base-shortcodes-for-bootstrap-list-select]').val();
        
        $body_st = jQuery('#'+$id+' .add-child-datas').html();
        jQuery('#'+$id+' .child-datas ul.child-items-sortable').append('<li class="ui-state-default"><div class="child-datas-grp">'+$body_st+'</div></li>');
        
        jQuery('#'+$id + ' .child-datas ul li .child-datas-grp').each(function() {
            jQuery('.del', jQuery(this)).remove();
        });
        jQuery('#'+$id+' .child-datas ul li .child-datas-grp').append('<div class="clearfix"></div><div class="del">Delete</div><div class="clearfix"></div>');

        $child_datas = 1;
        jQuery('#'+$id + ' .child-datas ul li .child-datas-grp').each(function() {
            if(jQuery('#'+$id + ' .child-datas ul li .child-datas-grp').length == $child_datas) {
                $sub_child_datas = 0;
                jQuery('.sub-attr-info', jQuery(this)).each(function() {
                    if($sub_child_datas == 0)
                        jQuery(this).focus();
                    ++$sub_child_datas;
                });
            }
            ++$child_datas;
        });

        $idx = 1;
        jQuery('#'+$id + ' .child-datas ul li .child-datas-grp').each(function() {
            jQuery('.cnum', jQuery(this)).each(function() {
                jQuery(this).html($idx);
            });
            ++$idx;
        });
    });

});
