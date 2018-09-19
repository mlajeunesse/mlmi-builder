<?php
/**
*   Main output and display function
*/
function the_grid()
{
  require_once plugin_dir_path( dirname( __FILE__ ) ) . '../public/partials/the-grid.php';
}

/*
* Get all text rows content as one text string.
*/
function mlmi_builder_get_grid_content($post_id)
{
  $grid_content = "";
  if (have_rows('sections')){
    while (have_rows('sections')){
      the_row();
      if (have_rows('rows')){
        while (have_rows('rows')){
          the_row();
          if (get_row_layout() == "text_row"){
            for ($i = 0; $i < get_sub_field('cols_num'); $i++){
              $grid_content .= get_sub_field('col_'.($i+1));
              $grid_content .= PHP_EOL.PHP_EOL;
            }
          }
        }
      }
    }
  }
  return $grid_content;
}

/**
*   Inline attributes for output in the grid.
*/
function mlmi_builder_attributes_inline($attributes = array(), $classes = array())
{
  $attributes_output = "";
  if ($attributes){
    foreach ($attributes as $key => $value) {
      if ($value){
        $attributes_output .= " ".$key.'="'.$value.'"';
      }
    }
  }
  if ($classes){
    $attributes_output .= ' class="'.trim(implode(" ", $classes)).'"';
  }
  return $attributes_output;
}
