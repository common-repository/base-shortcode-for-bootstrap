<?php
if (!class_exists("baseShortcodesFrontendPH")):

    class baseShortcodesFrontendPH {

        function __construct() {
            remove_filter('the_content', 'wpautop');
            add_filter('the_content', 'wpautop', 99);
            //add_filter('the_content', 'shortcode_unautop', 99);
            add_filter('the_content', array(&$this, 'remove_bad_tags'), 100);

            add_filter('the_excerpt', 'do_shortcode');
            add_filter('widget_text', 'do_shortcode');

            add_action('wp_footer', array(&$this, 'insert_footer'), 100);

            add_action('wp_enqueue_scripts', array(&$this, 'js_css'));
//Scaffolding
            add_shortcode('bsfb_columns', array(&$this, 'columns'));
            add_shortcode('bsfb_page_link', array(&$this, 'page_link'));
            add_shortcode('bsfb_index_custom_content', array(&$this, 'index_custom_content'));

            add_shortcode('bsfb_one_twelth', array(&$this, 'one_twelth'));
            add_shortcode('bsfb_one_sixth', array(&$this, 'one_sixth'));
            add_shortcode('bsfb_three_twelths', array(&$this, 'three_twelths'));
            add_shortcode('bsfb_one_third', array(&$this, 'one_third'));
            add_shortcode('bsfb_five_twelths', array(&$this, 'five_twelths'));
            add_shortcode('bsfb_one_half', array(&$this, 'one_half'));
            add_shortcode('bsfb_seven_twelths', array(&$this, 'seven_twelths'));
            add_shortcode('bsfb_two_thirds', array(&$this, 'two_thirds'));
            add_shortcode('bsfb_nine_twelths', array(&$this, 'nine_twelths'));
            add_shortcode('bsfb_five_sixths', array(&$this, 'five_sixths'));
            add_shortcode('bsfb_eleven_twelths', array(&$this, 'eleven_twelths'));
            add_shortcode('bsfb_full_width', array(&$this, 'full_width'));
            add_shortcode('bsfb_one_quarter', array(&$this, 'one_quarter'));
            add_shortcode('bsfb_three_quarters', array(&$this, 'three_quarters'));
//Base CSS
            add_shortcode('bsfb_button', array(&$this, 'button'));
            add_shortcode('bsfb_image', array(&$this, 'image'));
            add_shortcode('bsfb_icon', array(&$this, 'icon'));
//Components
            add_shortcode('bsfb_single_button_group', array(&$this, 'single_button_group'));
            add_shortcode('bsfb_single_button', array(&$this, 'single_button'));

            add_shortcode('bsfb_dropdown_button_group', array(&$this, 'dropdown_button_group'));
            add_shortcode('bsfb_dropdown_button', array(&$this, 'dropdown_button'));

            add_shortcode('bsfb_tab_group', array(&$this, 'tab_group'));
            add_shortcode('bsfb_tab', array(&$this, 'tab'));

            add_shortcode('bsfb_label_badge', array(&$this, 'label_badge'));

            add_shortcode('bsfb_tooltip', array(&$this, 'tooltip'));

            add_shortcode('bsfb_alert', array(&$this, 'alert'));

            add_shortcode('bsfb_collapse_group', array(&$this, 'collapse_group'));
            add_shortcode('bsfb_collapse', array(&$this, 'collapse'));

            add_shortcode('bsfb_progress_bar_group', array(&$this, 'progress_bar_group'));
            add_shortcode('bsfb_progress_bar', array(&$this, 'progress_bar'));

            add_shortcode('bsfb_media_object', array(&$this, 'media_object'));

            add_shortcode('bsfb_gallery_group', array(&$this, 'gallery_group'));
            add_shortcode('bsfb_gallery', array(&$this, 'gallery'));

            add_shortcode('bsfb_well', array(&$this, 'well'));
        }

        function js_css() {
            if (!is_admin()) {
                wp_enqueue_script('jquery-min-last', 'http://code.jquery.com/jquery.min.js');
                wp_enqueue_style('bootstrap', BASE_SHORTCODE_PLUGIN_URL . 'plugins/bootstrap/css/bootstrap.min.css');
                wp_enqueue_style('bootstrap-responsive', BASE_SHORTCODE_PLUGIN_URL . 'plugins/bootstrap/css/bootstrap-responsive.min.css');
                wp_enqueue_script('base-shortcode-front', BASE_SHORTCODE_PLUGIN_URL . 'js/front/front.js');
                wp_enqueue_style('base-shortcode-front', BASE_SHORTCODE_PLUGIN_URL . 'css/front/front.css');
                if (preg_match('/(?i)msie [1-8]/', $_SERVER['HTTP_USER_AGENT'])) {
                    wp_enqueue_style('base-shortcode-front-ie', BASE_SHORTCODE_PLUGIN_URL . 'css/front/front-ie.css');
                }
            }
        }

        function insert_footer() {
            ?>
            <script>if(jQuery('.in.bsfb-gallery.carousel').length > 0) {jQuery('.in.bsfb-gallery.carousel').carousel();}</script>
            <?php
        }

        function remove_bad_tags($content) {
            $bad_a = array(
                '</a><br />',
                '<button type="button" class="close" data-dismiss="alert">&times;</button><br />',
                '<p><a class="left carousel-control" href="#bsfb-gallery-'
            );
            $right_a = array(
                '</a>',
                '<button type="button" class="close" data-dismiss="alert">&times;</button>',
                '<a class="left carousel-control" href="#bsfb-gallery-'
            );
            $content = str_replace($bad_a, $right_a, $content);
            return $content;
        }

//Scaffolding
        function columns($attr, $content = null) {
            ob_start();
            ?>
            <div class="row-fluid"><?php echo do_shortcode($content); ?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function one_twelth($attr, $content = null) {
            ob_start();
            ?>
            <div class="span1"><?php echo do_shortcode($content); ?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function one_sixth($attr, $content = null) {
            ob_start();
            ?>
            <div class="span2"><?php echo do_shortcode($content); ?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function three_twelths($attr, $content = null) {
            ob_start();
            ?>
            <div class="span3"><?php echo do_shortcode($content); ?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function one_third($attr, $content = null) {
            ob_start();
            ?>
            <div class="span4"><?php echo do_shortcode($content); ?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function five_twelths($attr, $content = null) {
            ob_start();
            ?>
            <div class="span5"><?php echo do_shortcode($content); ?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function one_half($attr, $content = null) {
            ob_start();
            ?>
            <div class="span6"><?php echo do_shortcode($content); ?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function seven_twelths($attr, $content = null) {
            ob_start();
            ?>
            <div class="span7"><?php echo do_shortcode($content); ?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function two_thirds($attr, $content = null) {
            ob_start();
            ?>
            <div class="span8"><?php echo do_shortcode($content); ?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function nine_twelths($attr, $content = null) {
            ob_start();
            ?>
            <div class="span9"> <?php echo do_shortcode($content); ?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function five_sixths($attr, $content = null) {
            ob_start();
            ?>
            <div class="span10"><?php echo do_shortcode($content); ?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function eleven_twelths($attr, $content = null) {
            ob_start();
            ?>
            <div class="span11"><?php echo do_shortcode($content); ?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function full_width($attr, $content = null) {
            ob_start();
            ?>
            <div class="span12"><?php
            echo do_shortcode($content);
            ?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function one_quarter($attr, $content = null) {
            ob_start();
            ?>
            <div class="span3"><?php
            echo do_shortcode($content);
            ?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function three_quarters($attr, $content = null) {
            ob_start();
            ?>
            <div class="span9"><?php
            echo do_shortcode($content);
            ?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

//Base CSS
        var $botttons_idx = 0;

        function button($attr, $content) {
            $class = 'btn';
            if ($attr['size'])
                $class .= ' btn-' . $attr['size'];
            if ($attr['type'])
                $class .= ' btn-' . $attr['type'];
            if ($attr['block_btn_fg'] == 'yes')
                $class .= ' btn-block';
            if ($attr['position'] == 'right')
                $class .= ' pull-right';
            if ($attr['disabled_state'] == 'yes')
                $class .= ' disabled';

            $label = 'Button';
            if ($attr['label'])
                $label = $attr['label'];

            $href = '';
            if ($attr['link_url']) {
                $href = ' href="' . $attr['link_url'] . '" ';
                if ($attr['new_window'] == 'yes')
                    $href .= ' target="_black"';
            }

            $icon = '';
            if ($attr['icon'])
                $icon = '<i class="' . $attr['icon'] . '"></i> ';

            $loading_text = '';
            if ($attr['more'] == 'stateful') {
                $loading_text = ' data-loading-text="' . $attr['more'] . '" ';
                $class .= ' bsfb-button-stateful';
            }

            $single_toggle = '';
            if ($attr['more'] == 'single_toggle')
                $single_toggle = ' data-toggle="button" ';

            $rel = '';
            $data_content = '';
            $data_title = '';
            $more_position = '';
            $type = '';
            $data_toggle = '';
            $role = '';
            if (trim($attr['more']) == 'popover') {
                $href = ' href="#" ';
                $rel = ' rel="popover" ';

                $str_tmp = __(do_shortcode($content));
                $order = array('\r\n', '\n', '\r');
                $replace = '';
                $str_tmp = str_replace($order, $replace, trim($str_tmp));
                if (trim($str_tmp) != '')
                    $data_content = " data-content='" . trim($str_tmp) . "' ";

                if (trim($attr['more_title']))
                    $data_title = ' title="' . trim($attr['more_title']) . '" ';

                if (trim($attr['more_position']))
                    $more_position = ' data-placement="' . trim($attr['more_position']) . '" ';
            } elseif (trim($attr['more']) == 'modal') {
                $href = ' href="#bsfb-btn-modal-' . $this->botttons_idx . '" ';
                $data_toggle = ' data-toggle="modal" ';
                $role = ' role="button" ';
            } else {
                $type = ' type="button" ';
            }

            ob_start();

            if ($attr['position'] == 'center') {
                echo '<div class="clearfix"></div>';
                echo '<div class="bsfb-text-align">';
            }
            ?>
            <a <?php echo $type . $href . $loading_text . $single_toggle . $data_content . $data_title . $rel . $more_position . $data_toggle . $role ?> class="<?php echo $class ?>"><?php echo $icon; ?><?php _e($label) ?></a>
            <?php
            if (trim($attr['more']) == 'modal') {
                ?>
                <div id="bsfb-btn-modal-<?php echo $this->botttons_idx ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="bsfb-btn-modal-label-<?php $this->botttons_idx ?>" aria-hidden="true"><div class="modal-header"><a type="button" class="close" data-dismiss="modal" aria-hidden="true">×</a><h3 id="bsfb-btn-modal-label-<?php $this->botttons_idx ?>">Modal header</h3></div><div class="modal-body"><?php _e(do_shortcode($content)) ?></div><div class="modal-footer"><button class="btn" data-dismiss="modal" aria-hidden="true">Close</button></div></div>
                <?php
                ++$this->botttons_idx;
            }
            if ($attr['position'] == 'center') {
                echo '</div>';
                if ($attr['wrap'] != 'no')
                    echo '<div class="clearfix"></div>';
            }
            if ($attr['wrap'] == 'no')
                echo '<div class="clearfix"></div>';

            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function image($attr, $content) {
            ob_start();
            $class = '';
            $a_class = '';
            if ($attr['type'] == 'rounded') {
                $class .= 'img-rounded';
                $a_class = 'img-rounded';
            } elseif ($attr['type'] == 'circle') {
                $class .= 'img-circle';
                $a_class = 'img-circle';
            }
            if ($attr['border'] == 'yes') {
                $class .= ' img-polaroid';
            } else {
                $class .= ' noborder';
            }
            if ($attr['position'] == 'right') {
                $class .= ' pull-right';
                $a_class .= ' pull-right';
            } elseif ($attr['position'] == 'left') {
                $class .= ' pull-left';
                $a_class .= ' pull-left';
            }

            if ($attr['width_option'] == 'full') {
                $class .= ' full-width';
            }

            $style = '';
            if ($attr['width_option'] == 'custom') {
                if ($attr['width'] != '') {
                    $class .= ' width=' . $attr['width'];
                    $style .= ' width:' . $attr['width'] . 'px';
                }
                if ($attr['height'] != '') {
                    $class .= ' height=' . $attr['height'];
                    $style .= ' ; height:' . $attr['height'] . 'px';
                }
            }
            if ($attr['position'] == 'center') {
                echo '<div class="clearfix"></div>';
                echo '<div class="bsfb-text-align">';
            }
            if (trim($attr['link_url']) != '') {
                $target = '';
                if ($attr['new_window'] == 'yes')
                    $target .= ' target="_black"';

                echo '<a href="' . trim($attr['link_url']) . '" ' . $target . ' class="' . $a_class . ' in bsfb-images-a" alt="' . $attr['alt'] . '" title="' . $attr['alt'] . '" >';
            }
            ?><img src="<?php echo $attr['img_url'] ?>" alt="<?php echo $attr['alt'] ?>" title="<?php echo $attr['alt'] ?>" style="<?php echo $style ?>" class="<?php echo $class ?> in bsfb-images"><?php
            if (trim($attr['link_url']) != '') {
                echo '</a>';
            }
            if ($attr['position'] == 'center') {
                echo '</div>';
                if ($attr['wrap'] != 'no')
                    echo '<div class="clearfix"></div>';
            }

            if ($attr['wrap'] == 'no')
                echo '<div class="clearfix"></div>';

            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function icon($attr, $content) {
            ob_start();
            if ($attr['icon'] != '') {
                ?><i class="<?php echo $attr['icon'] ?>"></i><?php
            }
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        var $single_button_group_size = '';
        var $single_button_group_type = '';

        function single_button_group($attr, $content = null) {
            $this->single_button_group_size = trim($attr['size']);
            $this->single_button_group_type = trim($attr['type']);
            do_shortcode($content);
            $class = '';
            if (trim($attr['orient']) == 'vertically')
                $class = ' btn-group-vertical';
            if (trim($attr['position']) == 'left')
                $class .= ' pull-left';
            if (trim($attr['position']) == 'right')
                $class .= ' pull-right';
            ob_start();
            if ($attr['position'] == 'center') {
                echo '<div class="clearfix"></div>';
                echo '<div class="bsfb-text-align">';
            }
            ?>
            <div class="btn-group<?php echo $class; ?>"><?php echo $this->single_button_str; ?></div>
            <?php
            if (trim($attr['position']) == 'center') {
                echo '</div>';
                if (trim($attr['wrap']) != 'no')
                    echo '<div class="clearfix"></div>';
            }
            if ($attr['wrap'] == 'no')
                echo '<div class="clearfix"></div>';

            $this->single_button_str = '';

            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        var $single_button_str = '';

        function single_button($attr, $content = null) {
            $this->single_button_group_size;
            $class = '';
            if ($this->single_button_group_size != '')
                $class .= ' btn-' . $this->single_button_group_size;
            if ($this->single_button_group_type != '')
                $class .= ' btn-' . $this->single_button_group_type;

            $icon = '';
            if (trim($attr['icon']) != '')
                $icon .= '<i class="' . trim($attr['icon']) . '"></i>';

            $label = '';
            if (trim($attr['label']) != '')
                $label = trim($attr['label']);
            elseif (trim($attr['icon']) == '')
                $label = '&nbsp';

            $href = '';
            if (trim($attr['link_url']) != '') {
                $href = ' href="' . trim($attr['link_url']) . '"';
                if (trim($attr['new_window']) == 'yes')
                    $href .= ' target="_black"';
            }

            $space = '';
            if ($icon != '' && $label != '') {
                $space = '&nbsp';
            }

            $this->single_button_str .= '<a class="btn' . $class . '" ' . $href . '>' . $icon . $space . $label . '</a>';
        }

        function dropdown_button_group($attr, $content = null) {
            do_shortcode($content);
            ob_start();
            if (trim($attr['position']) == 'center') {
                echo '<div class="clearfix"></div>';
                echo '<div class="bsfb-text-align">';
            }
            $class = '';
            if (trim($attr['size']) != '') {
                $class .= ' btn-' . trim($attr['size']);
            }
            if (trim($attr['type']) != '') {
                $class .= ' btn-' . trim($attr['type']);
            }

            $position = '';
            if (trim($attr['position']) == 'right')
                $position .= ' pull-right';

            $submenu_direction = '';
            if (trim($attr['submenu_direction']) == 'up') {
                $submenu_direction .= ' dropup';
            }
            $icon = '';
            if (trim($attr['icon']) != '')
                $icon .= '<i class="' . trim($attr['icon']) . '"></i> ';

            if (trim($attr['kind']) == 'split') {
                $href = '';
                if (trim($attr['link_url']) != '') {
                    $href = ' href="' . trim($attr['link_url']) . '"';
                    if (trim($attr['new_window']) == 'yes')
                        $href .= ' target="_black"';
                }
                ?>
                <div class="btn-group <?php echo $submenu_direction . $position ?>"><a <?php echo $href; ?> class="btn <?php echo $class; ?>"><?php echo $icon; ?><?php _e(trim($attr['label'])); ?></a><a class="btn dropdown-toggle <?php echo $class; ?>" data-toggle="dropdown"><b class="caret"></b></a><ul class="dropdown-menu"><?php echo $this->dropdown_button_str ?></ul></div>
                <?php
            } else {
                ?>
                <div class="btn-group <?php echo $submenu_direction . $position ?>"><a class="btn dropdown-toggle <?php echo $class; ?>" data-toggle="dropdown"><?php echo $icon; ?><?php _e(trim($attr['label'])); ?> <b class="caret"></b></a><ul class="dropdown-menu"><?php echo $this->dropdown_button_str ?></ul></div>
                <?php
            }
            if ($attr['position'] == 'center') {
                echo '</div>';
                if ($attr['wrap'] != 'no')
                    echo '<div class="clearfix"></div>';
            }
            if ($attr['wrap'] == 'no')
                echo '<div class="clearfix"></div>';
            $this->dropdown_button_str = '';

            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        var $dropdown_button_str = '';

        function dropdown_button($attr, $content = null) {
            $href = '#';
            $target = '';
            if (trim($attr['link_url']) != '') {
                $href = trim($attr['link_url']);
                if (trim($attr['new_window']) == 'yes') {
                    $target .= ' target="_black"';
                }
            }
            $icon = '';
            if (trim($attr['divider']) == '1')
                $this->dropdown_button_str .= '<li class="divider"></li>';
            if (trim($attr['icon']) != '')
                $icon .= '<i class="' . trim($attr['icon']) . '"></i> ';
            $this->dropdown_button_str .= '<li><a href="' . $href . '"' . $target . '>' . $icon . trim($attr['label']) . '</a></li>';
        }

        var $tab_nav = '';
        var $tab_content = '';
        var $tab_root_id = 0;
        var $tab_sub_id = 0;
        var $subtab_fg = false;
        var $orient = '';

        function tab_group($attr, $content = null) {
            $this->orient = trim($attr['orient']);
            do_shortcode($content);
            if ($this->subtab_fg == true) {
                $this->tab_nav .= '</ul></li>';
                $this->subtab_fg = false;
            }

            $content_class = 'nav nav-tabs';
            $tab_root_class = 'bsfb-tab-group tabbable';
            if (trim($attr['orient']))
                $tab_root_class .= ' tabs-' . $attr['orient'];
            ?>
            <div class="<?php echo $tab_root_class ?>"><?php if ($attr['orient'] == 'below') { ?><div class="tab-content"><?php echo $this->tab_content; ?></div><ul class="<?php echo $content_class ?>"><?php echo $this->tab_nav; ?></ul><?php } else { ?><ul class="<?php echo $content_class ?>"><?php echo $this->tab_nav; ?></ul><div class="tab-content"><?php echo $this->tab_content; ?></div><?php } ?></div>
            <?php
            $this->tab_nav = '';
            $this->tab_content = '';
            $this->tab_sub_id = 0;
            ++$this->tab_root_id;
        }

        function tab($attr, $content = null) {
            $tab_class = '';
            $icon = '';
            if (trim($attr['icon']))
                $icon = '<i class="' . $attr['icon'] . '"></i> ';

            if (trim($attr['active']) == 1)
                $tab_class .= ' active';
            if (trim($attr['tree_view']) == 'have_child')
                if ($this->orient == 'below')
                    $tab_class .= ' dropup';
                else
                    $tab_class .= ' dropdown';

            if ((trim($attr['tree_view']) == '' || trim($attr['tree_view']) == 'have_child') && $this->subtab_fg == true) {
                $this->tab_nav .= '</ul></li>';
                $this->subtab_fg = false;
            }
            if (trim($attr['tree_view']) == 'have_child') {
                $this->tab_nav .= '<li class="' . $tab_class . '"><a href="#" class="dropdown-toggle" data-toggle="dropdown">' . $icon . $attr['label'] . ' <b class="caret"></b></a><ul class="dropdown-menu';
                if ($this->orient == 'below')
                    $this->tab_nav .= ' dropup-menu';
                $this->tab_nav .= '">';
                $this->subtab_fg = true;
            } else {
                $this->tab_nav .= '<li class="' . $tab_class . '"><a href="#bsfb-tab-' . $this->tab_root_id . '-' . $this->tab_sub_id . '" data-toggle="tab">' . $icon . $attr['label'] . '</a></li>';
            }

            $content_class = 'tab-pane';
            if (trim($attr['active']) == 1)
                $content_class .= ' active';
            $this->tab_content .= '<div class="' . $content_class . '" id="bsfb-tab-' . $this->tab_root_id . '-' . $this->tab_sub_id . '">' . do_shortcode($content) . '</div>';

            ++$this->tab_sub_id;
        }

        function label_badge($attr, $content = null) {
            $class = '';
            if (trim($attr['kind']) == 'badge') {
                $class .= 'badge';
            } else {
                $class .= 'label';
            }
            if (trim($attr['type']) != '') {
                $class .= ' ' . $class . '-' . trim($attr['type']);
            }
            ob_start();
            ?>
            <span class="<?php echo $class ?>"><?php _e(trim($attr['label'])) ?></span>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function tooltip($attr, $content = null) {
            ob_start();
            ?>
            <a href="#" data-toggle="tooltip" data-placement="<?php echo trim($attr['orient']) ?>" title="<?php echo trim($attr['content']) ?>" class="bsfb-tooltip"><?php echo trim($attr['label']) ?></a>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function alert($attr, $content = null) {
            ob_start();

            $class = '';

            if (trim($attr['type'])) {
                $class = 'alert-' . trim($attr['type']);
            }

            $title = '';
            if (trim($attr['title'])) {
                $title = '<h4 class="alert-heading">' . trim($attr['title']) . '</h4>';
            }
            ?>
            <div class="alert <?php echo $class ?> fade in"><button type="button" class="close" data-dismiss="alert">&times;</button><?php _e($title) ?><p><?php _e($content) ?></p></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        var $collapse_group_idx = 0;
        var $collapse_idx = 0;

        function collapse_group($attr, $content = null) {
            ob_start();
            ?>
            <div class="accordion" id="bsfb-accordion-<?php echo $this->collapse_group_idx ?>"><?php echo do_shortcode($content); ?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            ++$this->collapse_group_idx;
            $this->collapse_idx = 0;
            return $output_string;
        }

        function collapse($attr, $content = null) {
            ob_start();
            $active = '';
            if (trim($attr['active'])) {
                $active = 'in';
            }
            ?>
            <div class="accordion-group"><div class="accordion-heading"><a class="accordion-toggle" data-toggle="collapse" data-parent="#bsfb-accordion-<?php echo $this->collapse_group_idx ?>" href="#bsfb-collapse-<?php echo $this->collapse_idx ?>"><?php _e(trim($attr['title'])) ?></a></div><div id="bsfb-collapse-<?php echo $this->collapse_idx ?>" class="accordion-body collapse <?php echo $active ?>"><div class="accordion-inner"><?php _e($content) ?></div></div></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            ++$this->collapse_idx;
            return $output_string;
        }

        function progress_bar_group($attr, $content) {
            ob_start();

            $class = '';
            if (trim($attr['type']) == 'striped') {
                $class .= ' progress-striped';
            } elseif (trim($attr['type']) == 'animated') {
                $class .= ' progress-striped active';
            }
            ?>
            <div class="progress <?php echo $class ?>"><?php echo do_shortcode($content) ?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function progress_bar($attr, $content) {
            ob_start();
            $percent = $attr['percent'] . '%';

            $class = '';
            if (trim($attr['style'])) {
                $class .= ' bar-' . trim($attr['style']);
            }
            ?>
            <div class="bar <?php echo $class ?>" style="width: <?php echo $percent ?>;"></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function media_object($attr, $content) {
            ob_start();

            $link_url = '#';
            if (trim($attr['link_url']))
                $link_url = trim($attr['link_url']);

            $width = 'width: 64px;';
            if (trim($attr['img_width']))
                $width = 'width: ' . trim($attr['img_width']) . 'px;';

            $height = '';
            if (trim($attr['img_height']))
                $height = 'height: ' . trim($attr['img_height']) . 'px;';

            $class = 'pull-left';
            if (trim($attr['img_position']) == 'right')
                $class = 'pull-right';
            ?>
            <div class="media"><a class="<?php echo $class; ?>" href="<?php echo $link_url ?>"><img class="media-object" data-src="holder.js/64x64" src="<?php echo trim($attr['img_file_path']) ?>" style="<?php echo $width . $height ?>"></a><div class="media-body"><h4 class="media-heading"><?php _e(trim($attr['title'])); ?></h4><div class="media"><?php _e(trim($content)); ?></div></div></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        var $gallery_group_idex = 0;
        var $gallery_idex = 0;
        var $gallery_ol = '';

        function gallery_group($attr, $content) {
            ob_start();
            ?>
            <div id="bsfb-gallery-<?php echo $this->gallery_group_idex ?>" class="carousel slide in bsfb-gallery"><?php echo $this->gallery_ol ?><div class="carousel-inner"><?php echo do_shortcode($content); ?></div><a class="left carousel-control" href="#bsfb-gallery-<?php echo $this->gallery_group_idex ?>" data-slide="prev">&lsaquo;</a><a class="right carousel-control" href="#bsfb-gallery-<?php echo $this->gallery_group_idex ?>" data-slide="next">&rsaquo;</a></div>
            <?php
            ++$this->gallery_group_idex;
            $this->gallery_idex = 0;
            $this->gallery_ol = '';
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function gallery($attr, $content) {
            ob_start();
            $class = '';
            if (trim($attr['active']) == 1)
                $class = 'active';

            $tmp = str_replace('&nbsp;', '', $content);
            $this->gallery_ol .= '<ol class="carousel-indicators"><li data-target="#bsfb-gallery-' . $this->gallery_group_idex . '" data-slide-to="' . $this->gallery_idex . '" class="' . $class . '"></li></ol>';
            ?><div class="item <?php echo $class ?>"><img src="<?php echo trim($attr['img_file_path']) ?>" alt=""><?php
            if (trim($attr['title']) || trim($tmp)) {
                ?><div class="carousel-caption"><h4><?php _e(trim($attr['title'])) ?></h4><p><?php _e(trim($content)) ?></p></div><?php
            }
            ?></div>
            <?php
            ++$this->gallery_idex;
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function well($attr, $content) {
            ob_start();
            $class = 'well';
            if (trim($attr['style']))
                $class .= ' well-' . trim($attr['style']);
            ?>
            <div class="<?php echo $class ?>"><?php _e($content); ?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

    }

    new baseShortcodesFrontendPH();

endif;
?>
