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
    require_once plugin_dir_path(dirname(__FILE__)).'../public/partials/the-grid-v0.10.php';
  } else {
    require_once plugin_dir_path(dirname(__FILE__)).'../public/partials/the-grid.php';
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