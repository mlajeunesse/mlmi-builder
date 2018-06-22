<?php
/**
*   Main output and display function
*/
function the_grid()
{
    require_once plugin_dir_path( dirname( __FILE__ ) ) . '../public/partials/the-grid.php';
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
