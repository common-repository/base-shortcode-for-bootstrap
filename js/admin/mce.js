(function(){
    tinymce.create('tinymce.plugins.base_shortcode_for_bootstrap', {
        createControl : function(id, controlManager) {
            if (id == 'base_shortcode_for_bootstrap_button') {
                // creates the button
                var button = controlManager.createButton('base_shortcode_for_bootstrap_button', {
                    title : 'Base Shortcode For Bootstrap',
                    image : '../wp-content/plugins/base-shortcode-for-bootstrap/imgs/favicon.png',
                    onclick : function() {
                        var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                        W = W - 50;
                        H = H - 150;
                        tb_show( 'Base Shortcode For Bootstrap', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=tb-base-shortcode-for-bootstrap-region' );
                    }
                });
                return button;
            }
            return null;
        }
    });
	
    tinymce.PluginManager.add('base_shortcode_for_bootstrap', tinymce.plugins.base_shortcode_for_bootstrap);
    
    if(!String.prototype.trim) {
        String.prototype.trim = function () {
            return this.replace(/^\s+|\s+$/g,'');
        };
    }

    jQuery('#base-shortcode-for-bootstrap-submit').click(function() {
        $id = jQuery('#base-shortcodes-for-bootstrap-list-select').val();
        
        $fg = true;
        $idx = 0;
        jQuery('#' + $id + ' .root-datas [required="required"]').each(function() {
            jQuery(this).removeClass('error');
            if(jQuery(this).attr("readonly") != "readonly") {
                $tmp = jQuery(this).val().trim();
                var $tmp_str = jQuery(this).attr('class');
                var $tmp_fg = false;
                if($tmp_str.search("attr-info") != -1)
                    $tmp_fg = true;
                else if($tmp_str.search(" attr-info") != -1)
                    $tmp_fg = true;
                else if($tmp_str.search("attr-info ") != -1)
                    $tmp_fg = true;
                else if($tmp_str.search(" attr-info ") != -1)
                    $tmp_fg = true;
                
                if($tmp == '' && $tmp_fg) {
                    jQuery(this).addClass('error');
                    if($idx == 0)
                        jQuery(this).focus();
                    $fg = false;
                    ++$idx;
                }
                jQuery(this).val($tmp);
            }
        });
        jQuery('#'+$id + ' .child-datas [required="required"]').each(function() {
            jQuery(this).removeClass('error');
            if(jQuery(this).attr("readonly") != "readonly") {
                $tmp = jQuery(this).val().trim();
                var $tmp_str = jQuery(this).attr('class');
                var $tmp_fg = false;
                if($tmp_str.search("sub-attr-info") != -1)
                    $tmp_fg = true;
                else if($tmp_str.search(" sub-attr-info") != -1)
                    $tmp_fg = true;
                else if($tmp_str.search("sub-attr-info ") != -1)
                    $tmp_fg = true;
                else if($tmp_str.search(" sub-attr-info ") != -1)
                    $tmp_fg = true;
                
                if($tmp == '' && $tmp_fg) {
                    jQuery(this).addClass('error');
                    if($idx == 0)
                        jQuery(this).focus();
                    $fg = false;
                    ++$idx;
                }
                jQuery(this).val($tmp);
            }
        });
        $shortcode = '';
        if($fg) {
            $shortcode = '';
            $shortcode += '[bsfb_' + $id;
            $root_content = '';
            jQuery('#' + $id + ' .root-datas [class*="attr-info"]').each(function() {
                $tmp = jQuery(this).val().trim();
                var $tmp_str = jQuery(this).attr('class');
                if($tmp_str.search("content") == 0) {
                    $root_content = '<p>'+$tmp+'</p>';
                } else {
                    $shortcode += ' ';
                    $shortcode += jQuery(this).attr('name')+'="'+$tmp+'"';
                }
            });
            
            $sub_id = jQuery('#' + $id + ' input[name="sub_shortcode"]').val();
            $sub_shortcode = '';
            if($sub_id) {
                $sub_content = '';
                jQuery('#' + $id + ' .child-datas-grp').each(function() {
                    $tmp_test = jQuery('input[name="sub_shortcode"]', this).length;
                    if($tmp_test) {
                        $sub_id = jQuery('input[name="sub_shortcode"]', this).val();

                        $sub_shortcode += '<p>[bsfb_'+$sub_id;
                    
                        $tmp_sc = '';
                        jQuery('[class*="sub-attr-info"]', this).each(function() {
                            $tmp = jQuery(this).val().trim();
                            var $tmp_str = jQuery(this).attr('class');
                            if($tmp_str.search("content") == 0) {
                                $sub_content = '<p>'+$tmp+'</p>';
                            } else {
                                $tmp_sc += ' ';
                                $tmp_sc += jQuery(this).attr('name')+'="'+$tmp+'"';
                            }
                        });
                        if($tmp_sc != '') {
                            $sub_shortcode += ' ';
                            $sub_shortcode += $tmp_sc;
                        }
                        if($sub_content) {
                            $sub_shortcode += ']';
                            $sub_shortcode += $sub_content;
                            $sub_shortcode += '[/bsfb_'+$sub_id;
                            $sub_shortcode += ']</p>';
                        } else {
                            $sub_shortcode += '/]</p>';
                        }
                    }
                });
            }
            if($root_content == '' && $sub_shortcode == '') {
                $shortcode += '/]';
            } else {
                $shortcode += ']';
                if($sub_id) {
                    $shortcode += $sub_shortcode;
                } else {
                    $shortcode += $root_content;
                }
                $shortcode += '[/bsfb_'+$id;
                $shortcode += ']';
            }
            
            $wrap = jQuery('#'+$id + ' select[name="wrap"]').val();
            if($wrap) {
                if($id == 'button' || $id == 'image') {
                    if($wrap == 'yes') {
                    //$shortcode += '<p></p>';
                    }
                } else {
                //$shortcode += '<p></p>';
                }
            } else {
            //$shortcode += '<p></p>';
            }
            //window.send_to_editor($shortcode);
            tinyMCE.activeEditor.execCommand('mceInsertContent', 0, $shortcode);
            tb_remove();
        }
    });
    jQuery('#base-shortcode-for-bootstrap-cancel').click(function() {
        tb_remove();
    });
})()