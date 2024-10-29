var base_shortcode_media_frame;
jQuery(document).ready(function () {
    jQuery('#base-shortcode-for-bootstrap-region .file-upload-btn-bs').live('click', function(){
        if ( base_shortcode_media_frame ) {
            base_shortcode_media_frame.open();
            return;
        } else {
            base_shortcode_media_frame = wp.media.frames.base_shortcode_media_frame = wp.media({
                className: 'media-frame basic_shortcode_media',
                frame: 'select',
                multiple: false,
                title: basic_shortcode_media.title,
                library: {
                    type: 'image'
                },
                button: {
                    text:  basic_shortcode_media.button
                },
                displaySettings: true,
                displayUserSettings: true
            });
            base_shortcode_media_frame.open();
        }
		
        $obj = this;

        base_shortcode_media_frame.on('select', function(){
            var media_attachment = base_shortcode_media_frame.state().get('selection').first().toJSON();
            jQuery('input', jQuery($obj).parent()).val(media_attachment.url);
            jQuery('input', jQuery($obj).parent()).css('border-color', '#dfdfdf');

            base_shortcode_media_frame = false;
        });
    });
    // add sub shortcode
    jQuery('.plus').live('click', function(){
        $id = jQuery('#base-shortcode-for-bootstrap-region select[name=base-shortcodes-for-bootstrap-list-select]').val();
        
        $body_st = jQuery('#'+$id+' .add-child-datas').html();
        jQuery('#'+$id+' .child-datas ul.child-items-sortable').append('<li class="ui-state-default"><div class="child-datas-grp">'+$body_st+'</div></li>');

        jQuery('#'+$id + ' .child-datas ul li .child-datas-grp').each(function() {
            jQuery('.del', jQuery(this)).remove();
            jQuery(this).append('<div class="clearfix"></div><div class="del">Delete</div><div class="clearfix"></div>');
        });

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
        jQuery('#' + $id + ' .child-datas ul li .child-datas-grp').each(function() {
            jQuery('.cnum', jQuery(this)).each(function() {
                jQuery(this).html($idx);
            });
            ++$idx;
        });

        jQuery('.file-upload-btn-bs').click(function(){
            if ( base_shortcode_media_frame ) {
                base_shortcode_media_frame.open();
                return;
            } else {
                base_shortcode_media_frame = wp.media.frames.base_shortcode_media_frame = wp.media({
                    className: 'media-frame basic_shortcode_media',
                    frame: 'select',
                    multiple: false,
                    title: basic_shortcode_media.title,
                    library: {
                        type: 'image'
                    },
                    button: {
                        text:  basic_shortcode_media.button
                    },
                    displaySettings: true,
                    displayUserSettings: true
                });
                base_shortcode_media_frame.open();
            }
		
            $obj = this;

            base_shortcode_media_frame.on('select', function(){
                var media_attachment = base_shortcode_media_frame.state().get('selection').first().toJSON();
                jQuery('input', jQuery($obj).parent()).val(media_attachment.url);
                jQuery('input', jQuery($obj).parent()).css('border-color', '#dfdfdf');

                base_shortcode_media_frame = false;
            });
        });
    });
});
