<?php
if (!class_exists("baseShortcodeBackendPH")):

    class baseShortcodeBackendPH {

        function __construct() {
            add_action('admin_init', array($this, 'action_admin_init'));
        }

        function action_admin_init() {
            if (current_user_can('edit_posts') && current_user_can('edit_pages')) {
                add_filter('mce_buttons', array(&$this, 'filter_mce_button'));
                add_filter('mce_external_plugins', array(&$this, 'filter_mce_plugin'));
                add_filter('admin_footer', array(&$this, 'render'));

                wp_enqueue_style('base-shortcode-admin', BASE_SHORTCODE_PLUGIN_URL . 'css/admin/admin.css');
                wp_enqueue_script('base-shortcode-general', BASE_SHORTCODE_PLUGIN_URL . 'js/admin/general.js');
                wp_enqueue_script('base-shortcode-special', BASE_SHORTCODE_PLUGIN_URL . 'js/admin/special.js');
                wp_enqueue_style('farbtastic');
                wp_enqueue_script('farbtastic');

                $wp_version = get_bloginfo('version');
                if ($wp_version < 3.5) {
                    wp_enqueue_script('basic-shortcode-sls-admin-media-less-3.5', BASE_SHORTCODE_PLUGIN_URL . 'js/admin/admin-media-less-3.5.js');
                } else {
                    wp_register_script('basic_shortcode_media', BASE_SHORTCODE_PLUGIN_URL . 'js/admin/admin-media-3.5.js', array('jquery'), '1.0.0', true);
                    wp_localize_script('basic_shortcode_media', 'basic_shortcode_media', array(
                        'title' => __('Upload or Choose Your Custom Image File', 'base_shortcode'),
                        'button' => __('Insert Image into Input Field', 'base_shortcode'))
                    );
                    wp_enqueue_script('basic_shortcode_media');
                }
            }
        }

        function filter_mce_button($buttons) {
            array_push($buttons, '|', 'base_shortcode_for_bootstrap_button');
            return $buttons;
        }

        function filter_mce_plugin($plugins) {
            $plugins['base_shortcode_for_bootstrap'] = BASE_SHORTCODE_PLUGIN_URL . 'js/admin/mce.js';
            return $plugins;
        }

        function render() {
            ?>
            <style>
                #TB_ajaxContent {
                    padding: 0px;
                }
            </style>
            <div id="tb-base-shortcode-for-bootstrap-region" style="display: none">
                <div id="base-shortcode-for-bootstrap-region">
                    <div class="nav-sls">
                        <button type="button" id="base-shortcode-for-bootstrap-cancel" class="btn pull-left"><?php _e('Cancel', 'base_shortcode'); ?></button>
                        <?php
                        $xmlfilename = apply_filters('templ_theme_options_xmlpath_filter', BASE_SHORTCODE_PLUGIN_PATH . 'xml/shortcodes.xml');
                        if (file_exists($xmlfilename))
                            $rawdata = implode('', file($xmlfilename));
                        if ($rawdata) {
                            $shortcodes_obj = new SimpleXMLElement($rawdata);
                            ?>
                            <select name="base-shortcodes-for-bootstrap-list-select" id="base-shortcodes-for-bootstrap-list-select" style="float: left; margin: 2px 0px 0px 178px; width: 150px">
                                <option value="0"><?php _e('Select Shortcode', 'base_shortcode'); ?></option>

                                <?php
                                $cnt = count($shortcodes_obj->groups);

                                if ($cnt)
                                    $this->get_shortcode_selectbox_ingroup($shortcodes_obj->groups);
                                else
                                    $this->get_shortcode_selectbox($shortcodes_obj->shortcode);
                                ?>
                            </select>
                            <?php
                        } else {
                            ?>
                            <div class="no-xml-file"><?php _e('XML file could not be find', 'base_shortcode'); ?></div>
                            <?php
                        }
                        ?>
                        <button type="button" id="base-shortcode-for-bootstrap-submit" class="btn btn-info pull-right hide">Save changes</button>
                        <div class="clearfix"></div>
                    </div>
                    <?php
                    if ($rawdata) {
                        $shortcodes_obj = new SimpleXMLElement($rawdata);
                        ?>
                        <div class="clearfix"></div>
                        <div id="base-shortcode-for-bootstrap-generator">
                            <?php
                            $cnt = count($shortcodes_obj->groups);

                            if ($cnt) {
                                foreach ($shortcodes_obj->groups as $shortcodes) {
                                    $this->get_shortcode_items($shortcodes->shortcode);
                                }
                            } else {
                                $this->get_shortcode_items($shortcodes_obj->shortcode);
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                    <div id="color-picker-int" style="display: none"></div>
                </div>
            </div>
            <?php
        }

        function get_shortcode_selectbox_ingroup($objs) {
            foreach ($objs as $obj) {
                ?>
                <optgroup label="<?php echo trim($obj->groups_label); ?>"><?php trim($this->get_shortcode_selectbox($obj->shortcode)); ?></optgroup>
                <?php
            }
        }

        function get_shortcode_selectbox($objs) {
            foreach ($objs as $obj) {
                ?>
                <option value="<?php echo trim($obj->shortcode_id); ?>"><?php echo trim($obj->shortcode_label); ?></option>
                <?php
            }
        }

        function get_shortcode_items($objs) {
            foreach ($objs as $obj) {
                ?>
                <div id="<?php echo trim($obj->shortcode_id); ?>" class="shortcode-items hide">
                    <div class="pull-left"><h3><?php echo trim($obj->shortcode_label); ?></h3></div>
                    <?php if (trim($obj->shortcode_dev_desc) != '') { ?>
                        <div class="pull-right"><a href="#" class="for-develper-btn"><?php _e('For developer', 'base_shortcode'); ?></a></div>
                    <?php } ?>
                    <div class="clearfix"></div>
                    <?php if (trim($obj->shortcode_dev_desc) != '') { ?>
                        <div class="dev-desc hide"><button type="button" class="close">×</button><?php echo trim($obj->shortcode_dev_desc); ?></div>
                    <?php } ?>
                    <?php echo (trim($obj->shortcode_descript)) ? '<p>' . trim($obj->shortcode_descript) . '</p>' : '' ?>
                    <hr>
                    <div class="root-datas">
                        <?php
                        $this->get_shortcode_p_controls($obj->pitem_grp->pitem);
                        ?>
                    </div>
                    <div class="clearfix"></div>
                    <?php
                    if (count($obj->citem_grp->citem) > 0) {
                        ?>
                        <div class="child-datas">
                            <div class="cdesc"><?php echo $obj->citem_grp->cshortcode_descript ?></div>
                            <ul class="child-items-sortable">
                                <?php
                                for ($i = 0; $i < $obj->citem_grp->cshortcode_default_num; $i++) {
                                    ?>
                                    <li class="ui-state-default">
                                        <div class="child-datas-grp">
                                            <input type="hidden" name="sub_shortcode" value="<?php echo $obj->citem_grp->cshortcode_id ?>">
                                            <?php
                                            $this->get_shortcode_c_controls($obj->citem_grp->citem, $i + 1);
                                            ?>
                                        </div>
                                        <div class="clearfix"></div>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="plus">More insert</div>
                        <div class="add-child-datas hide" value="<?php echo $obj->citem_grp->cshortcode_default_num ?>">
                            <input type="hidden" name="sub_shortcode" value="<?php echo $obj->citem_grp->cshortcode_id ?>">
                            <?php
                            $this->get_shortcode_c_controls($obj->citem_grp->citem);
                            ?>
                        </div>
                        <?php
                    }
                    if (trim($obj->shortcode_priview_option) == 1) {
                        ?>
                        <div class="clearfix"></div>
                        <a href="#" class="preview-btn">Preview</a>
                        <div class="preview-region"></div>
                        <?php
                    }
                    ?>
                </div>
                <?php
            }
        }

        function get_shortcode_p_controls($objs) {
            if (count($objs) == 1)
                $span6 = '';
            else
                $span6 = 'span6 ';

            $idx = 0;
            foreach ($objs as $obj) {
                $class = 'label';
                $desc_class = 'desc';
                $unit_class = 'unit';
                $item_hide_fg = trim($obj->item_hide_fg);
                ?>
                <div class="<?php echo $span6 ?>ctrl pull-left <?php echo ($item_hide_fg == 1) ? ' hide' : '' ?>">
                    <div class="<?php echo $class; ?>">
                        <?php echo trim($obj->item_title); ?>
                        <?php echo (trim($obj->item_mandatory)) ? '<span class="mandatory-star">*</span>' : '' ?>
                    </div>
                    <?php $this->check_controls($obj, 1); ?>
                    <?php echo (trim($obj->item_unit)) ? '<span class="' . $unit_class . '">' . trim($obj->item_unit) . '</span>' : '' ?>
                    <?php echo (trim($obj->item_desc)) ? '<p class="' . $desc_class . '">' . trim($obj->item_desc) . '</p>' : '' ?>
                    <div class="clearfix"></div>
                    <?php
                    $str_tmp = (string) $obj->item_other->asXML();
                    if ($str_tmp) {
                        $str_tmp = str_replace('<item_other>', '', $str_tmp);
                        $str_tmp = str_replace('</item_other>', '', $str_tmp);
                        $str_tmp = str_replace('tmp', '', $str_tmp);
                        echo $str_tmp;
                    }
                    ?>
                </div>
                <?php
                if ($idx % 2) {
                    ?>
                    <div class="clearfix"></div>
                    <?php
                }
                ++$idx;
            }
        }

        function get_shortcode_c_controls($objs, $num = 0) {
            $idx = 0;
            foreach ($objs as $obj) {
                $class = 'label';
                $desc_class = 'desc';
                $unit_class = 'unit';
                $item_hide_fg = trim($obj->item_hide_fg);
                ?>
                <div class="span6 ctrl pull-left <?php echo ($item_hide_fg == 1) ? ' hide' : '' ?>">
                    <div class="<?php echo $class; ?>">
                        <?php
                        $item_title = trim($obj->item_title);
                        echo str_replace('%number%', '<span class="cnum">' . $num . '</span>', $item_title);
                        ?>
                        <?php echo (trim($obj->item_mandatory)) ? '<span class="mandatory-star">*</span>' : '' ?>
                    </div>
                    <?php $this->check_controls($obj, 0); ?>
                    <?php echo (trim($obj->item_unit)) ? '<span class="' . $unit_class . '">' . trim($obj->item_unit) . '</span>' : '' ?>
                    <div class="clearfix"></div>
                    <?php echo (trim($obj->item_desc)) ? '<p class="' . $desc_class . '">' . trim($obj->item_desc) . '</p>' : '' ?>
                </div>
                <?php
                if ($idx % 2) {
                    ?>
                    <div class="clearfix"></div>
                    <?php
                }
                ++$idx;
            }
        }

        function check_controls($obj, $root_fg) {
            switch (trim($obj->item_type)) {
                case 'select':
                    $this->select_ctrl($obj, $root_fg);
                    break;
                case 'input':
                    $this->input_ctrl($obj, $root_fg);
                    break;
                case 'check';
                    $this->check_ctrl($obj, $root_fg);
                    break;
                case 'radio';
                    $this->radio_ctrl($obj, $root_fg);
                    break;
                case 'color':
                    $this->color_ctrl($obj, $root_fg);
                    break;
                case 'file_upload':
                    $this->file_upload_ctrl($obj, $root_fg);
                    break;
                case 'textarea';
                    $this->textarea_ctrl($obj, $root_fg);
                    break;
                case 'pages_select';
                    $this->pages_select_ctrl($obj, $root_fg);
                    break;
                case 'categories_select';
                    $this->categories_select_ctrl($obj, $root_fg);
                    break;
                case 'custom_taxonomies_select';
                    $this->custom_taxonomies_select_ctrl($obj, $root_fg);
                    break;
                case 'select_icon';
                    $this->select_icon_ctrl($obj, $root_fg);
                    break;
            }
            ?>

            <?php
        }

        function get_class($obj, $root_fg) {
            $class = '';
            if (trim($obj->item_hide_fg) != 1) {
                if (trim($root_fg))
                    $class = 'attr-info';
                else
                    $class = 'sub-attr-info';
            }

            if (trim($obj->item_for_sc_fg) == 1)
                $class = '';

            if (trim($obj->item_unit))
                $class .= ' you-unit';
            return $class;
        }

        function input_ctrl($obj, $root_fg) {
            $name = trim($obj->item_name);
            $value = trim($obj->item_default_val);
            $mandatory = '';
            if (trim($obj->item_mandatory) == 1)
                $mandatory = 'required="required"';
            $class = $this->get_class($obj, $root_fg);
            ?>
            <input type="text" name="<?php echo $name ?>" value="<?php echo $value ?>" <?php echo $mandatory ?> class="<?php echo $class ?>">
            <?php
        }

        function check_ctrl($obj, $root_fg) {
            $name = trim($obj->item_name);
            $value = trim($obj->item_default_val);
            $checked = '';
            if ($value != '' && $value != '0') {
                $checked = ' checked="checked" ';
                $value = '1';
            } else {
                $value = '';
            }
            $mandatory = '';
            if (trim($obj->item_mandatory) == 1)
                $mandatory = 'required="required"';
            $class = $this->get_class($obj, $root_fg);
            ?>
            <input type="checkbox" name="<?php echo $name ?>" value="<?php echo $value ?>" <?php echo $mandatory . $checked ?> class="checkbox <?php echo $class ?>">
            <?php
        }

        function radio_ctrl($obj, $root_fg) {
            $name = trim($obj->item_name);
            $class = $this->get_class($obj, $root_fg);
            ?>
            <input type="radio" name="<?php echo $name ?>" value="" class="radiobox <?php echo $class ?>">
            <?php
        }

        function select_ctrl($obj, $root_fg) {
            $title_a = explode(",", trim($obj->item_option_titles));
            $val_a = explode(",", trim($obj->item_option_values));
            ?>
            <select name="<?php echo trim($obj->item_name); ?>" class="<?php echo $this->get_class($obj, $root_fg) ?>" <?php echo (trim($obj->item_mandatory) == 1) ? 'required="required"' : '' ?>>
                <?php
                $idx = 0;
                foreach ($title_a as $title) {
                    $selected = '';
                    if (trim($obj->item_default_val) == trim($val_a[$idx]))
                        $selected = 'selected';
                    ?>
                    <option value="<?php echo trim($val_a[$idx]) ?>" <?php echo $selected ?>><?php echo trim($title) ?></option>
                    <?php
                    ++$idx;
                }
                ?>
            </select>
            <?php
        }

        function color_ctrl($obj, $root_fg) {
            ?>
            <input type="text" name="<?php echo trim($obj->item_name); ?>" value="<?php echo trim($obj->item_default_val) ?>" <?php echo (trim($obj->item_mandatory) == 1) ? 'required="required"' : '' ?> class="color-picker <?php echo $this->get_class($obj, $root_fg) ?>">
            <?php
        }

        function file_upload_ctrl($obj, $root_fg) {
            ?>
            <input type="text" name="<?php echo trim($obj->item_name); ?>" value="<?php echo trim($obj->item_default_val) ?>" <?php echo (trim($obj->item_mandatory) == 1) ? 'required="required"' : '' ?> class="<?php echo $this->get_class($obj, $root_fg) ?>">
            <div class="clearfix"></div>
            <div class="btn file-upload-btn-bs">Upload Image</div>
            <?php
        }

        function textarea_ctrl($obj, $root_fg) {
            ?>
            <textarea name="<?php echo trim($obj->item_name); ?>" <?php echo (trim($obj->item_mandatory) == 1) ? 'required="required"' : '' ?> class="content <?php echo $this->get_class($obj, $root_fg) ?>" rows="4" cols="22"><?php echo trim($obj->item_default_val) ?></textarea>
            <?php
        }

        function select_icon_ctrl($obj, $root_fg) {
            //$str_tmp = (string) $obj->item_option_titles->asXML();
            //$order = array('\r\n', '\n', '\r', '<item_option_titles>', '</item_option_titles>', 'tmp');
            //$replace = '';
            //$str_tmp = str_replace($order, $replace, $str_tmp);

            $title_a = explode(",", trim($obj->item_option_titles));
            $val_a = explode(",", trim($obj->item_option_values));
            $default = __('Select', 'base_shortcode');
            if (trim($obj->item_default_val) != '') {
                $default = trim($obj->item_default_val);
            }
            ?>
            <div class="select-icon">
                <i class="<?php echo $default ?>"></i> <?php _e($default); ?>
                <div class="select-icon-img"></div>
            </div>
            <input type="text" name="select_icon_input" class="select-icon-input" value="">
            <div class="icons-group hide" style="height: <?php echo count($title_a) * 20; ?>px">
                <ul>
                    <?php
                    $idx = 0;
                    foreach ($title_a as $title) {
                        if (trim($title)) {
                            ?>
                            <li><i class="<?php echo $val_a[$idx] ?>"></i> <? _e(trim($title)) ?></li>
                            <?php
                        } else {
                            ?>
                            <li><?php _e('Select', 'base_shortcode'); ?></li>
                            <?php
                        }
                        ++$idx;
                    }
                    ?>
                </ul>
            </div>
            <input type="hidden" name="<?php echo trim($obj->item_name); ?>" value="<?php echo trim($obj->item_default_val) ?>" class="<?php echo $this->get_class($obj, $root_fg) ?>"/>
            <?php
        }

        function pages_select_ctrl($obj, $root_fg) {
            $defaults = array(
                'depth' => 0, 'child_of' => 0,
                'selected' => 0, 'echo' => 1,
                'name' => 'page_id', 'id' => '',
                'show_option_none' => '', 'show_option_no_change' => '',
                'option_none_value' => ''
            );

            $r = wp_parse_args($args, $defaults);
            extract($r, EXTR_SKIP);

            $pages = get_pages($r);
            $output = '';
            // Back-compat with old system where both id and name were based on $name argument
            if (empty($id))
                $id = $name;

            if (!empty($pages)) {
                if (trim($obj->item_mandatory) == 1)
                    $item_mandatory = 'required="required"';
                if (trim($root_fg))
                    $output = "<select name='" . trim($obj->item_name) . "' " . $item_mandatory . " class='" . $this->get_class($obj, $root_fg) . "'>\n";
                else
                    $output = "<select name='" . trim($obj->item_name) . "' " . $item_mandatory . " class='" . $this->get_class($obj, $root_fg) . "'>\n";

                if (trim($obj->item_no_value))
                    $output .= "\t<option value=\"\">" . $obj->item_no_value . "</option>";
                if ($show_option_none)
                    $output .= "\t<option value=\"" . esc_attr($option_none_value) . "\">$show_option_none</option>\n";
                $output .= walk_page_dropdown_tree($pages, $depth, $r);
                $output .= "</select>\n";
            }

            $output = apply_filters('wp_dropdown_pages', $output);

            echo $output;
        }

        function categories_select_ctrl($obj, $root_fg) {
            $defaults = array(
                'show_option_all' => '', 'show_option_none' => '',
                'orderby' => 'id', 'order' => 'ASC',
                'show_count' => 0,
                'hide_empty' => 1, 'child_of' => 0,
                'exclude' => '', 'echo' => 1,
                'selected' => 0, 'hierarchical' => 0,
                'name' => 'cat', 'id' => '',
                'class' => 'postform', 'depth' => 0,
                'tab_index' => 0, 'taxonomy' => 'category',
                'hide_if_empty' => false
            );

            $defaults['selected'] = ( is_category() ) ? get_query_var('cat') : 0;

            $args = array('hierarchical' => 1, 'hide_empty' => 0);
            // Back compat.
            if (isset($args['type']) && 'link' == $args['type']) {
                _deprecated_argument(__FUNCTION__, '3.0', '');
                $args['taxonomy'] = 'link_category';
            }

            $r = wp_parse_args($args, $defaults);

            if (!isset($r['pad_counts']) && $r['show_count'] && $r['hierarchical']) {
                $r['pad_counts'] = true;
            }

            extract($r);

            $tab_index_attribute = '';
            if ((int) $tab_index > 0)
                $tab_index_attribute = " tabindex=\"$tab_index\"";

            $categories = get_terms($taxonomy, $r);
            $name = esc_attr($name);
            $class = esc_attr($class);
            $id = $id ? esc_attr($id) : $name;

            if (!$r['hide_if_empty'] || !empty($categories)) {
                if (trim($obj->item_mandatory) == 1)
                    $item_mandatory = 'required="required"';
                if (trim($root_fg))
                    $output = "<select name='" . trim($obj->item_name) . "' " . $item_mandatory . " class='" . $this->get_class($obj, $root_fg) . "' $tab_index_attribute>\n";
                else
                    $output = "<select name='" . trim($obj->item_name) . "' " . $item_mandatory . " class='" . $this->get_class($obj, $root_fg) . "' $tab_index_attribute>\n";

                //$output = "<select name='$name' id='$id' $item_mandatory class='$class' $tab_index_attribute>\n";
            } else {
                $output = '';
            }

            /*
              if (empty($categories) && !$r['hide_if_empty'] && !empty($show_option_none)) {
              $show_option_none = apply_filters('list_cats', $show_option_none);
              $output .= "\t<option value='' selected='selected'>$show_option_none</option>\n";
              }
             * 
             */
            if (trim($obj->item_no_value))
                $output .= "\t<option value=\"\">" . trim($obj->item_no_value) . "</option>";


            if (!empty($categories)) {
                if ($show_option_all) {
                    $show_option_all = apply_filters('list_cats', $show_option_all);
                    $selected = ( '0' === strval($r['selected']) ) ? " selected='selected'" : '';
                    $output .= "\t<option value='0'$selected>$show_option_all</option>\n";
                }

                if ($show_option_none) {
                    $show_option_none = apply_filters('list_cats', $show_option_none);
                    $selected = ( '-1' === strval($r['selected']) ) ? " selected='selected'" : '';
                    $output .= "\t<option value='-1'$selected>$show_option_none</option>\n";
                }

                if ($hierarchical)
                    $depth = $r['depth'];  // Walk the full depth.
                else
                    $depth = -1; // Flat.

                $output .= walk_category_dropdown_tree($categories, $depth, $r);
            }

            if (!$r['hide_if_empty'] || !empty($categories))
                $output .= "</select>\n";

            $output = apply_filters('wp_dropdown_cats', $output);

            echo $output;
        }

        function custom_taxonomies_select_ctrl($obj, $root_fg) {
            $defaults = array(
                'show_option_all' => '', 'show_option_none' => '',
                'orderby' => 'id', 'order' => 'ASC',
                'show_count' => 0,
                'hide_empty' => 1, 'child_of' => 0,
                'exclude' => '', 'echo' => 1,
                'selected' => 0, 'hierarchical' => 0,
                'name' => 'cat', 'id' => '',
                'class' => 'postform', 'depth' => 0,
                'tab_index' => 0, 'taxonomy' => 'category',
                'hide_if_empty' => false
            );

            $defaults['selected'] = ( is_category() ) ? get_query_var('cat') : 0;

            $args = array('hierarchical' => 1,
                'hide_empty' => 0,
                'type' => trim($obj->item_post_type),
                'taxonomy' => trim($obj->item_taxonomy)
            );
            // Back compat.
            if (isset($args['type']) && 'link' == $args['type']) {
                _deprecated_argument(__FUNCTION__, '3.0', '');
                $args['taxonomy'] = 'link_category';
            }

            $r = wp_parse_args($args, $defaults);

            if (!isset($r['pad_counts']) && $r['show_count'] && $r['hierarchical']) {
                $r['pad_counts'] = true;
            }

            extract($r);

            $tab_index_attribute = '';
            if ((int) $tab_index > 0)
                $tab_index_attribute = " tabindex=\"$tab_index\"";

            $categories = get_terms($taxonomy, $r);
            $name = esc_attr($name);
            $class = esc_attr($class);
            $id = $id ? esc_attr($id) : $name;

            if (!$r['hide_if_empty'] || !empty($categories)) {
                if (trim($obj->item_mandatory) == 1)
                    $item_mandatory = 'required="required"';
                if (trim($root_fg))
                    $output = "<select name='" . trim($obj->item_name) . "' " . $item_mandatory . " class='attr-info' $tab_index_attribute>\n";
                else
                    $output = "<select name='" . trim($obj->item_name) . "' " . $item_mandatory . " class='sub-attr-info' $tab_index_attribute>\n";

                //$output = "<select name='$name' id='$id' $item_mandatory class='$class' $tab_index_attribute>\n";
            } else {
                $output = '';
            }

            /*
              if (empty($categories) && !$r['hide_if_empty'] && !empty($show_option_none)) {
              $show_option_none = apply_filters('list_cats', $show_option_none);
              $output .= "\t<option value='' selected='selected'>$show_option_none</option>\n";
              }
             * 
             */


            if (!empty($categories)) {
                if (trim($obj->item_no_value))
                    $output .= "\t<option value=\"\">" . $obj->item_no_value . "</option>";
                /*
                  if ($show_option_all) {
                  $show_option_all = apply_filters('list_cats', $show_option_all);
                  $selected = ( '0' === strval($r['selected']) ) ? " selected='selected'" : '';
                  $output .= "\t<option value='0'$selected>$show_option_all</option>\n";
                  }

                  if ($show_option_none) {
                  $show_option_none = apply_filters('list_cats', $show_option_none);
                  $selected = ( '-1' === strval($r['selected']) ) ? " selected='selected'" : '';
                  $output .= "\t<option value='-1'$selected>$show_option_none</option>\n";
                  }
                 * 
                 */

                if ($hierarchical)
                    $depth = $r['depth'];  // Walk the full depth.
                else
                    $depth = -1; // Flat.

                $output .= walk_category_dropdown_tree($categories, $depth, $r);
            }

            if (!$r['hide_if_empty'] || !empty($categories))
                $output .= "</select>\n";

            $output = apply_filters('wp_dropdown_cats', $output);

            echo $output;
        }

    }

    new baseShortcodeBackendPH();

endif;
?>