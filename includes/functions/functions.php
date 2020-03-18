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
    require_once plugin_dir_path(dirname(__FILE__)).'includes/types/the-grid-v'.$legacy_version.'.php';
  } else {
    require_once plugin_dir_path(dirname(__FILE__)).'includes/types/the-grid.php';
  }
  $grid_output = ob_get_clean();
  echo apply_filters('mlmi_builder_output', $grid_output);
}

/*
* Get all text rows content as one text string.
*/
if (!function_exists('mlmi_builder_get_grid_content')) {
  function mlmi_builder_get_grid_content($post_id) {
    $grid_content = "";
    if (have_rows('sections')): while (have_rows('sections')): the_row();
    if (have_rows('rows')): while (have_rows('rows')): the_row();
    if (get_row_layout() == "text_row") {
      for ($i = 0; $i < get_sub_field('cols_num'); $i++) {
        $column_content = trim(strip_tags(get_sub_field('col_'.($i+1)), '<em><sup>'));
        if ($column_content) {
          $grid_content .= $column_content;
          $grid_content .= PHP_EOL.PHP_EOL;
        }
      }
    } else {
      $custom_grid_content = apply_filters('mlmi_builder_get_grid_content', '');
      if ($custom_grid_content) {
        $grid_content .= $custom_grid_content;
        $grid_content .= PHP_EOL.PHP_EOL;
      }
    }
  endwhile; endif;
endwhile; endif;
return $grid_content;
}
}

/*
* Inline attributes for output in the grid.
*/
function mlmi_builder_attributes_inline($attributes = [], $classes = []) {
  $attributes_output = "";
  if ($attributes) {
    foreach ($attributes as $key => $value) {
      if ($value) {
        $attributes_output .= " ".$key.'="'.$value.'"';
      }
    }
  }
  if ($classes) {
    $attributes_output .= ' class="'.trim(implode(" ", $classes)).'"';
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
    $tabset_classes[] = get_sub_field('tabset_padding_top');
  	$tabset_classes[] = get_sub_field('tabset_padding_bottom');
    if ($tabset_id = get_sub_field('tabset_id')) {
      $tabset_attributes['id'] = $tabset_id;
    }
    if ($tabset_id = get_sub_field('tabset_id')) {
      $tabset_attributes['id'] = $tabset_id;
    }
    echo '<div'.mlmi_builder_attributes_inline($tabset_attributes, $tabset_classes).'">';
    echo '<div class="tabs__wrapper">';
    echo '<div class="tabs__list" role="tablist">';
    foreach ($tabs['display_tabs'] as $index => $tab) {
      echo '<button class="tabs__item" role="tab" tabindex="-1" aria-selected="'.($index == 0 ? 'true' : 'false').'" aria-controls="tab-'.$tab['id'].'" id="'.$tab['id'].'">'.$tab['label'].'</button>';
    }
    echo '</div>';
    echo '<div class="tabs__panels-list">';
  }
  if (isset($tabs['open_tab']) && $tabs['open_tab']) {
    echo '<div role="tabpanel" tabindex="0" class="tabs__panel" id="tab-'.$tabs['open_tab'].'" aria-labelledby="'.$tabs['open_tab'].'"'.($is_first_tab ? '' : ' hidden').'>';
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