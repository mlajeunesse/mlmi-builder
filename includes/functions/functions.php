<?php
/*
*	Admin notice if ACF Pro is missing.
*/
function mlmi_builder_notice_acf_pro_missing() {
  echo '<div class="error"><p>'.__('Advanced Custom Fields PRO is required to use MLMI Builder.', 'mlmi-builder').'</p></div>';
}

/*
* Admin notice if legacy grid is required.
*/
function mlmi_builder_notice_use_legacy_grid() {
  echo '<div class="error"><p>'.__('This website uses the legacy version of MLMI Builder. Please define `MLMI_BUILDER_USE_LEGACY_GRID` to TRUE in `application.php`.', 'mlmi-builder').'</p></div>';
}

/*
* Main output and display function
*/
function the_grid($post_id = NULL) {
  ob_start();
  $use_legacy_grid = defined('MLMI_BUILDER_USE_LEGACY_GRID') && MLMI_BUILDER_USE_LEGACY_GRID == true;
  if ($use_legacy_grid) {
    $legacy_version = "0.10";
    if (defined('MLMI_BUILDER_LEGACY_GRID_VERSION')) {
      $legacy_version = MLMI_BUILDER_LEGACY_GRID_VERSION;
    }
    require plugin_dir_path(dirname(__FILE__)).'../public/partials/the-grid-v'.$legacy_version.'.php';
  } else if (!is_plugin_active('mlmi-core/mlmi-core.php')) {
    require plugin_dir_path(dirname(__FILE__)).'../public/partials/the-grid-v0.13.php';
  } else {
    require plugin_dir_path(dirname(__FILE__)).'../public/partials/the-grid.php';
  }
  $grid_output = ob_get_clean();
  echo apply_filters('mlmi_builder_output', $grid_output);
}

/*
* Main output background image
*/
function the_background_image($selector, $bg_image, $bg_properties = []) {
  /* Default properties */
  $bg_default_properties = [
    'height_basis' => 'ratio',
    'horizontal_align' => 'center',
    'vertical_align' => 'center',
    'height_value' => 'auto',
    'height_unit' => '',
    'size' => 'cover',
  ];
  $bg_properties = array_merge($bg_default_properties, $bg_properties);

  /* Background properties */
  $bg_properties = apply_filters('mlmi_builder_background_properties', $bg_properties);
  if (is_numeric($bg_image)) {
    $bg_image = get_attachment($bg_image);
  }
  $bg_mobile = false;
  if ($bg_mobile_id = get_field('mobile_image', $bg_image['ID'])) {
    $bg_mobile = get_attachment($bg_mobile_id);
  }
  $bg_sources = apply_filters('mlmi_builder_background_image_sources', ['large'], $bg_properties);

  /* Get background properties */
  $use_ratio = in_array($bg_properties['height_basis'], ['ratio', 'min', 'max']);
  $use_exact = $bg_properties['height_basis'] == 'exact';
  $use_max = $bg_properties['height_basis'] == 'max';
  $use_min = $bg_properties['height_basis'] == 'min';
  $bg_align_horizontal = $bg_properties['horizontal_align'];
  $bg_align_vertical = $bg_properties['vertical_align'];
  $bg_size = $bg_properties['size'];
  $height_values = explode('.', $bg_properties['height_value']);

  /* Register background styles */
  $min_width = 0;
  $previous_image = '';
  $previous_image_retina = '';
  $previous_ratio = 0;
  $previous_height = 0;

  /* Action */
  do_action('mlmi_builder_before_background_image', $bg_properties, $selector, $bg_image);

  foreach ($bg_sources as $bg_source) {
    do_action('mlmi_builder_before_background_image_source', $bg_properties, $selector, $bg_image, $bg_source);
    $image = $min_width < 768 && $bg_mobile ? $bg_mobile : $bg_image;
    $height_value = ($min_width >= 768 && count($height_values) == 2) ? $height_values[1] : $height_values[0];
    $height_unit = $bg_properties['height_unit'];
    $general_styles = [];
    if ($use_exact || $use_min || $use_max) {
      if ($bg_align_horizontal != 'center' || $bg_align_vertical != 'center') {
        $general_styles['background-position'] = $bg_align_vertical.' '.$bg_align_horizontal;
      }
      if ($bg_size == 'natural') {
        $general_styles['background-size'] = 'auto auto';
      } else if ($bg_size == 'auto-height') {
        $general_styles['background-size'] = '100% auto';
      } else if ($bg_size == 'auto-width') {
        $general_styles['background-size'] = 'auto 100%';
      } else if ($bg_size == 'cover') {
        $general_styles['background-size'] = 'cover';
      }
    } else {
      if ($bg_size == 'cover') {
        $general_styles['background-size'] = 'cover';
      }
    }
    $general_styles = apply_filters('mlmi_builder_section_background_general_styles', $general_styles, $bg_properties);
    $selector = apply_filters('mlmi_builder_section_background_image_selector', $selector, $bg_properties);
    if ($general_styles) {
      register_style('.'.$selector, $general_styles);
    }
    if ($previous_image != $image['sizes'][$bg_source]) {
      $styles = [
        'background-image' => "url('".$image['sizes'][$bg_source]."')",
      ];
      if ($use_ratio) {
        $image_ratio = round($image['sizes'][$bg_source.'-height'] / $image['sizes'][$bg_source.'-width'], 2);
        if ($image_ratio != $previous_ratio) {
          $styles[$use_max && $min_width >= 768 ? 'height' : 'min-height'] = ($image_ratio * 100).'vw';
        }
        if ($use_max) {
          $styles['max-height'] = $height_value.$height_unit;
        } else if ($use_min) {
          $styles['min-height'] = $height_value.$height_unit;
        }
      } else if ($use_exact && $previous_height != $height_value) {
        $previous_height = $height_value;
        if ($height_unit == 'px') {
          global $theme_variables;
          $base_size = 16;
          if (isset($theme_variables['Base font sizes']['$font-size-base'])) {
            $base_size = $theme_variables['Base font sizes']['$font-size-base'];
          }
          $height_value /= $base_size;
          $height_unit = 'rem';
        }
        $styles['height'] = $height_value.$height_unit;
      }
      $styles = apply_filters('mlmi_builder_section_background_source_styles', $styles, $bg_properties);
      register_style('.'.$selector, $styles, ($min_width > 0) ? '(min-width: '.$min_width.'px) and (max-resolution: 191dpi)' : false);
      $previous_image = $image['sizes'][$bg_source];
      if ($use_ratio) {
        $previous_ratio = $image_ratio;
      }
    }
    if (isset($image['sizes'][$bg_source.'_2x']) && $previous_image_retina != $image['sizes'][$bg_source.'_2x']) {
      $retina_styles = [
        'background-image' => "url('".$image['sizes'][$bg_source.'_2x']."')",
      ];
      $retina_styles = apply_filters('mlmi_builder_section_background_retina_styles', $retina_styles, $bg_properties);
      register_style('.'.$selector, $retina_styles, ($min_width > 0) ? '(min-width: '.$min_width.'px) and (min-resolution: 192dpi)' : '(min-resolution: 192dpi)');
      $previous_image_retina = $image['sizes'][$bg_source.'_2x'];
    }
    $min_width = $image['sizes'][$bg_source.'-width'] + 1;
    do_action('mlmi_builder_after_background_image_source', $bg_properties, $selector, $bg_image, $bg_source);
  }
  do_action('mlmi_builder_after_background_image', $bg_properties, $selector, $bg_image);
}

/*
* Get all text rows content as one text string.
*/
if (!function_exists('mlmi_builder_get_text_content')) {
  function mlmi_builder_get_text_content($post_id) {
    $text_content = '';
    if (have_rows('sections')):
      while (have_rows('sections')): the_row();
        if (have_rows('rows')):
          while (have_rows('rows')): the_row();
            if (get_row_layout() == 'text_row') {
              for ($i = 0; $i < get_sub_field('cols_num'); $i++) {
                $column_content = html_entity_decode(trim(strip_tags(get_sub_field('col_'.($i+1)), '<em><sup>')));
                if ($column_content) {
                  $text_content .= $column_content;
                  $text_content .= PHP_EOL;
                }
              }
            } else {
              $row_content = apply_filters('mlmi_builder_text_content', '');
              $row_content = html_entity_decode(trim(strip_tags($row_content, '<em><sup>')));
              if ($row_content) {
                $text_content .= $row_content;
                $text_content .= PHP_EOL;
              }
            }
          endwhile;
        endif;
      endwhile;
    endif;
    return $text_content;
  }
}

/*
* Get row classes according to row options
*/
function mlmi_builder_get_row_classes($row_classes = []) {
  $use_row_options = apply_filters('mlmi_builder_use_row_options', false);
  $row_classes = array_filter(array_merge($row_classes, array_map('trim', explode(' ', get_sub_field('row_class')))));
  $pt = get_sub_field('padding_top');
  $pt_md = get_sub_field('padding_top_md');
  $row_classes[] = 'pt-'.$pt;
  if (($pt == 'auto' || $pt_md != 'auto') && $pt_md != $pt) {
    $row_classes[] = 'pt-md-'.$pt_md;
  }
  $pb = get_sub_field('padding_bottom');
  $pb_md = get_sub_field('padding_bottom_md');
  $row_classes[] = 'pb-'.$pb;
  if (($pb == 'auto' || $pb_md != 'auto') && $pb_md != $pb) {
    $row_classes[] = 'pb-md-'.$pb_md;
  }
  if ($row_options = get_sub_field('row_options')) {
    $row_classes = array_merge($row_classes, $row_options);
  }
  $row_classes = apply_filters('mlmi_builder_row_classes', $row_classes);
  return $row_classes;
}

/*
* Inline attributes for output in the grid.
*/
function mlmi_builder_attributes_inline($attributes = [], $classes = []) {
  $attributes_output = '';
  $props = [];
  if ($attributes) {
    foreach ($attributes as $key => $value) {
      if ($value === true) {
        $props[] = $key;
      } else if ($value) {
        $attributes_output .= ' '.$key.'="'.$value.'"';
      }
    }
  }
  if ($classes) {
    $attributes_output .= ' class="'.trim(implode(" ", $classes)).'"';
  }
  foreach ($props as $prop) {
    $attributes_output .= ' '.$prop;
  }
  return $attributes_output;
}

/*
* Get cloned group field structure
*/
function mlmi_builder_cloned_group($group_key) {
  return [
    'key' => 'mlmi_builder_cloned_'.$group_key,
    'name' => 'mlmi_builder_cloned_'.$group_key,
    'type' => 'clone',
    'clone' => [
      0 => $group_key,
    ],
    'display' => 'seamless',
    'layout' => 'block',
  ];
}

/*
* Get unique sanitized
*/
$mlmi_builder_unique_ids = [];
function mlmi_builder_unique_id($string) {
  global $mlmi_builder_unique_ids;
  $unique_id = sanitize_title($string);
  if (in_array($unique_id, $mlmi_builder_unique_ids) && function_exists('string_random')) {
    $id_exists = $unique_id;
    while ($id_exists) {
      $unique_id = $unique_id.'-'.string_random(4);
      if (!in_array($unique_id, $mlmi_builder_unique_ids)) {
        $id_exists = false;
      }
    }
  }
  $mlmi_builder_unique_ids[] = $unique_id;
  return $unique_id;
}

/*
* Tabs opening actions
*/
function mlmi_builder_tabs_open($tabs = []) {
  $use_legacy_grid = defined('MLMI_BUILDER_USE_LEGACY_GRID') && MLMI_BUILDER_USE_LEGACY_GRID == true;
  $use_tabs_options = apply_filters('mlmi_builder_use_tabs_options', false);
  $is_first_tab = false;
  if (isset($tabs['display_tabs']) && $tabs['display_tabs']) {
    $is_first_tab = true;
    $tabset_classes = ['tabs'];
    $tabset_attributes = [];
    if (isset($tabs['tabset_format']) && $tabs['tabset_format'] != '' && $tabs['tabset_format'] != 'default') {
      $tabset_classes[] = 'tabs--'.$tabs['tabset_format'];
    }
    if ($tabset_manual_class = get_sub_field('tabset_class')) {
      $tabset_manual_class = explode(' ', $tabset_manual_class);
      $tabset_classes = array_merge($tabset_classes, $tabset_manual_class);
    }
    if ($use_legacy_grid) {
      $tabset_classes[] = get_sub_field('tabset_padding_top');
    	$tabset_classes[] = get_sub_field('tabset_padding_bottom');
    } else {
      $pt = get_sub_field('tabset_padding_top');
    	$pt_md = get_sub_field('tabset_padding_top_md');
    	$tabset_classes[] = 'pt-'.$pt;
      if ($use_tabs_options) {
        if ($tabs_options = get_sub_field('tabset_options')) {
          $tabset_classes = array_merge($tabset_classes, $tabs_options);
        }
			}
    	if (($pt == 'auto' || $pt_md != 'auto') && $pt_md != $pt) {
    		$tabset_classes[] = 'pt-md-'.$pt_md;
    	}
    	$pb = get_sub_field('tabset_padding_bottom');
    	$pb_md = get_sub_field('tabset_padding_bottom_md');
    	$tabset_classes[] = 'pb-'.$pb;
    	if (($pb == 'auto' || $pb_md != 'auto') && $pb_md != $pb) {
    		$tabset_classes[] = 'pb-md-'.$pb_md;
    	}
    }
    if ($tabset_id = get_sub_field('tabset_id')) {
      $tabset_attributes['id'] = $tabset_id;
    }
    if ($tabset_id = get_sub_field('tabset_id')) {
      $tabset_attributes['id'] = $tabset_id;
    }
    $tabset_classes = apply_filters('mlmi_builder_tabset_classes', $tabset_classes, $tabs);
    $tabset_attributes = apply_filters('mlmi_builder_tabset_attributes', $tabset_attributes, $tabs);
    echo '<div'.mlmi_builder_attributes_inline($tabset_attributes, $tabset_classes).'">';
    echo '<div class="tabs__wrapper">';
    echo '<div class="tabs__list" role="tablist">';
    foreach ($tabs['display_tabs'] as $index => $tab) {
      $tab_classes = apply_filters('mlmi_builder_tab_classes', ['tabs__item'], $tab);
      $tab_attributes = apply_filters('mlmi_builder_tab_attributes', [
        'role' => 'tab',
        'tabindex' => '-1',
        'aria-selected' => $index == 0 ? 'true' : 'false',
        'aria-controls' => 'panel-'.$tab['id'],
        'id' => 'tab-'.$tab['id'],
      ], $tab);
      echo '<button '.mlmi_builder_attributes_inline($tab_attributes, $tab_classes).'>';
      echo apply_filters('mlmi_builder_tab_label', $tab['label'], $tab);
      echo '</button>';
    }
    echo '</div>';
    $tabset_panels_list_classes = apply_filters('mlmi_builder_tabset_panels_classes', ['tabs__panels-list'], $tabs);
    $tabset_panels_list_attributes = apply_filters('mlmi_builder_tabset_panels_classes', ['tabs__panels-list'], $tabs);
    echo '<div '.mlmi_builder_attributes_inline($tabset_panels_list_attributes, $tabset_panels_list_classes).'>';
  }
  if (isset($tabs['open_tab']) && $tabs['open_tab']) {
    $tab_panel_classes = apply_filters('mlmi_builder_tabpanel_classes', ['tabs__panel'], $tabs);
    $tab_panel_attributes = apply_filters('mlmi_builder_tabpanel_attributes', [
      'role' => 'tabpanel',
      'tabindex' => '0',
      'id' => 'panel-'.$tabs['open_tab'],
      'aria-labelledby' => 'tab-'.$tabs['open_tab'],
      'hidden' => !$is_first_tab ? true : false,
    ], $tabs);
    echo '<div '.mlmi_builder_attributes_inline($tab_panel_attributes, $tab_panel_classes).'>';
  }
}

/*
* Tabs closing actions
*/
function mlmi_builder_tabs_close($tabs = []) {
  if (isset($tabs['close_tab']) && $tabs['close_tab']) {
    echo '</div>';
  }
  if (isset($tabs['close_tabset']) && $tabs['close_tabset']) {
    echo '</div>';
    echo '</div>';
    echo '</div>';
  }
}

/*
* Register dynamic styles (legacy function)
*/
if (!function_exists('register_dynamic_style')) {
  function register_dynamic_style($selector, $styles, $media = 0) {
    if (function_exists('register_style')) {
      register_style($selector, $styles, $media);
    }
  }
}

/*
* TinyMCE plugins
*/
add_action('admin_init', function() {
  /* Tables */
  $use_tinymce_table = apply_filters('mlmi_builder_use_tinymce_table', false);

  if ($use_tinymce_table) {
    add_filter('mce_external_plugins', function ($plugins) {
      $plugins['table'] = plugin_dir_url(dirname(__FILE__)).'../admin/js/tinymce-table.min.js';
      return $plugins;
    });

    add_filter('mlmi_core_editor_buttons', function ($buttons) {
      array_splice($buttons, count($buttons) - 2, 0, 'table');
      return $buttons;
    });
  }
  /* Blockquotes */
  $use_tinymce_blockquote = apply_filters('mlmi_builder_use_tinymce_blockquote', false);

  if ($use_tinymce_blockquote) {
    add_action( 'admin_enqueue_scripts', function() {
  		wp_localize_script( 'editor', 'mlmi_blockquote',
      [
  			'add_blockquote'  => __( 'Ajouter une citation', 'mlmi-builder' ),
  			'blockquote'  => __( 'Citation', 'mlmi-builder' ),
  			'quote'  => __( 'Citation', 'mlmi-builder' ),
  			'author'  => __( 'Auteur', 'mlmi-builder' ),
  			'source'  => __( 'Nom de la source', 'mlmi-builder' ),
  			'source_link'  => __( 'Lien de la source', 'mlmi-builder' ),
  			'class' => __( 'Style', 'mlmi-builder' ),
        'remove_formating' => __( 'Supprimer la mise en forme', 'mlmi-builder' ),
  			'class_options' => apply_filters( 'mlmi_builder_blockquote_classes', false )
  		]);
  	});

    add_filter('mce_external_plugins', function ($plugins) {
      $plugins['mlmi_blockquote'] = plugin_dir_url(dirname(__FILE__)).'../admin/js/tinymce-blockquote.js';
      return $plugins;
    });

    add_filter('mlmi_core_editor_buttons', function ($buttons) {
      // Removes the default blockquote button
  		if ( false !== ( $key = array_search( 'blockquote', $buttons ) ) ) {
  			unset( $buttons[$key] );
  		}
      array_splice($buttons, count($buttons) - 2, 0, 'mlmi_blockquote');
      return $buttons;
    });
  }
});

/*
* Import rows
*/
add_action('acf/save_post', function($post_id) {
  $old_sections = get_fields($post_id);
  $new_sections = $old_sections;
  $has_imported_rows = false;
  if (isset($old_sections['sections'])) {
    foreach ($old_sections['sections'] as $section_index => $section) {
      foreach ($section['rows'] as $row_index => $row) {
        if ($row_index == 0) {
          $new_sections['sections'][$section_index]['rows'] = [];
        }
        if ($row['acf_fc_layout'] == 'code_row' && $row['template_item'] == 'import-row') {
          $import_action = json_decode($row['action_code']);
          if (isset($import_action->action) && $import_action->action == 'import-row') {
            $has_imported_rows = true;
            if (isset($import_action->site) && $import_action->site) {
              set_site_id($import_action->site);
            }
            $copied_page = get_fields($import_action->page);
            if (isset($import_action->site) && $import_action->site) {
              reset_site();
            }
            $copied_section = intval($import_action->section) - 1;
            $copied_rows = explode(',', $import_action->row);
            foreach ($copied_rows as $copied_row_index) {
              $copied_row = intval(trim($copied_row_index)) - 1;
              $copied_data = $copied_page['sections'][$copied_section]['rows'][$copied_row];
              $copied_data['advanced_options']['advanced_options'][] = 'skip_row';
              $new_sections['sections'][$section_index]['rows'][] = $copied_data;
            }
          }
        } else {
          $new_sections['sections'][$section_index]['rows'][] = $row;
        }
      }
    }
    if ($has_imported_rows) {
  	  delete_field('sections', $post_id);
      foreach ($new_sections['sections'] as $new_section) {
  			add_row('sections', $new_section, $post_id);
      }
    }
  }
});
