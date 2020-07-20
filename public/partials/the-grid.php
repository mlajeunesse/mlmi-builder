<?php
/*
*	MLMI Builder
*	Grid template
*/

/* Global status variables for use in filters */
global $section_id, $section_classes, $section_attributes;
global $row_id, $row_classes;
global $is_first_section, $is_last_section;
global $is_first_row, $is_last_row;
global $section_index, $row_index, $column_index;
global $use_container;
global $builder_tabs;

/* Filtered settings */
$desktop_prefix = apply_filters('mlmi_builder_desktop_prefix', 'md');
$grid_system_base = apply_filters('mlmi_builder_grid_columns', 12);
$use_tabs_system = apply_filters('mlmi_builder_use_tabs_system', false);

/* Prepare sections loop */
$sections = get_field('sections', $post_id);
$sections_count = $sections ? count($sections) : 0;
$section_index = 0;

/* Loop for tabs */
if ($use_tabs_system && $sections) {
	/* Add action */
	add_action('mlmi_builder_tabs_open', 'mlmi_builder_tabs_open');
	add_action('mlmi_builder_tabs_close', 'mlmi_builder_tabs_close');
	
	/* Build tabs structure */
	$builder_tabs = [];
	$builder_tabs_ids = [];
	$in_tabset = false;
	$in_tab = false;
	
	foreach ($sections as $index => $section) {
		$end_tab = false;
		$end_tabset = false;
		$restart_tabset = false;
		$tab_data = [];
		if ($in_tabset === false) {
			if ($section['tab_cycle'] == 'tab_start' || $section['tab_cycle'] == 'tab_group') {
				$tab_id = mlmi_builder_unique_id($section['tab_label']);
				$tab_data['open_tab'] = $tab_id;
				$in_tabset = [];
				$in_tabset[] = ['index' => $index, 'label' => $section['tab_label'], 'id' => $tab_id];
				$in_tab = [];
				$in_tab[] = $index;
				if ($section['tab_cycle'] == 'tab_group') {
					$tab_data['tabset_format'] = $section['tabset_format'];
				}
			}
		} else if ($in_tabset !== false) {
			if ($section['tab_cycle'] == 'tab_none') {
				$in_tab[] = $index;
			} else if ($section['tab_cycle'] == 'tab_start') {
				$end_tab = true;
				$in_tab = [];
				$in_tab[] = $index;
				$tab_id = mlmi_builder_unique_id($section['tab_label']);
				$tab_data['open_tab'] = $tab_id;
				$in_tabset[] = ['index' => $index, 'label' => $section['tab_label'], 'id' => $tab_id];
			} else if ($section['tab_cycle'] == 'tab_end' || $section['tab_cycle'] == 'tab_group') {
				$end_tabset = true;
				$end_tab = true;
				if ($section['tab_cycle'] == 'tab_group') {
					$restart_tabset = true;
				}
			}
		}
		if ($end_tab) {
			$builder_tabs[$index - 1]['close_tab'] = 1;
		}
		if ($end_tabset) {
			$builder_tabs[$index - 1]['close_tabset'] = 1;
			$builder_tabs[$in_tabset[0]['index']]['display_tabs'] = $in_tabset;
			$in_tabset = false;
			$in_tab = false;
		}
		if ($restart_tabset) {
			$tab_id = mlmi_builder_unique_id($section['tab_label']);
			$tab_data['open_tab'] = $tab_id;
			$in_tabset = [];
			$in_tabset[] = ['index' => $index, 'label' => $section['tab_label'], 'id' => $tab_id];
			$in_tab = [];
			$in_tab[] = $index;
			if ($section['tab_cycle'] == 'tab_group') {
				$tab_data['tabset_format'] = $section['tabset_format'];
			}
		}
		$builder_tabs[$index] = $tab_data;
	}
	if ($in_tab) {
		$builder_tabs[count($sections) - 1]['close_tab'] = 1;
	}
	if ($in_tabset) {
		$builder_tabs[count($sections) - 1]['close_tabset'] = 1;
		$builder_tabs[$in_tabset[0]['index']]['display_tabs'] = $in_tabset;
	}
}

/* Loop sections */
if (have_rows('sections', $post_id)): while (have_rows('sections', $post_id)) : the_row();
	/* Section status */
	$section_index += 1;
	$is_first_section = $section_index === 1;
	$is_last_section = $section_index === $sections_count;
	$section_attributes = ["id" => $section_id];
	
	/* Section attributes */
	$section_classes = array_filter(array_merge(['page-section'], array_map('trim', explode(" ", get_sub_field('section_class')))));
	$pt = get_sub_field('padding_top');
	$pt_md = get_sub_field('padding_top_md');
	if ($pt) {
		$section_classes[] = 'pt-'.$pt;
	}
	if (($pt == 'auto' || $pt_md != 'auto') && $pt_md != $pt) {
		$section_classes[] = 'pt-md-'.$pt_md;
	}
	$pb = get_sub_field('padding_bottom');
	$pb_md = get_sub_field('padding_bottom_md');
	if ($pb) {
		$section_classes[] = 'pb-'.$pb;
	}
	if (($pb == 'auto' || $pb_md != 'auto') && $pb_md != $pb) {
		$section_classes[] = 'pb-md-'.$pb_md;
	}
	if ($justify_content = get_sub_field('justify_content')) {
		if ($justify_content != 'justify-content-center') {
			$section_classes[] = $justify_content;
		}
	}
	if ($background_color = get_sub_field('bg_color')) {
		if ($background_color != 'transparent') {
			$section_classes[] = 'bg-'.$background_color;
		}
	}
	
	/* Support for background image with mlmi-theme */
	if (function_exists('register_dynamic_style') && $bg_image_id = get_sub_field('bg_image')) {
		$bg_properties = get_sub_field('bg_properties');
		$selector = 'bg-image-'.$bg_image_id;
		$section_classes[] = $selector;
		the_background_image($selector, $bg_image_id, $bg_properties);
	}
	
	$section_classes = apply_filters('mlmi_builder_section_classes', $section_classes);
	$section_id = get_sub_field('section_id');
	$section_attributes = apply_filters('mlmi_builder_section_attributes', $section_attributes);
	$section_attributes_output = mlmi_builder_attributes_inline($section_attributes, $section_classes);
	$use_container = apply_filters('mlmi_builder_use_container', get_sub_field('use_container'));
	
	/* Tabs opening */
	if ($use_tabs_system) {
		do_action('mlmi_builder_tabs_open', $builder_tabs[$section_index - 1]);
	}
	
	/* Hook before section */
	do_action('mlmi_builder_before_section');
	
	/* Prepare rows loop */
	$rows = get_sub_field('rows');
	$rows_count = $rows ? count($rows) : 0;
	$row_index = 0;
	if (have_rows('rows')):
		
		/* Display section */
		echo '<div'.$section_attributes_output.'>';
		do_action('mlmi_builder_begin_section');
		
		/* Loop rows */
		while (have_rows('rows')): the_row();
			/* Row status */
			$row_index += 1;
			$is_first_row = $row_index === 1;
			$is_last_row = $row_index === $rows_count;
			$use_row = apply_filters('mlmi_builder_use_row', true);
			
			/* Row attributes */
			$row_id = get_sub_field('row_id');
			$row_classes = array_filter(array_merge(["row", str_replace('_', '-', get_row_layout())], array_map('trim', explode(" ", get_sub_field('row_class')))));
			$pt = get_sub_field('padding_top');
			$pt_md = get_sub_field('padding_top_md');
			if ($pt) {
				$row_classes[] = 'pt-'.$pt;
			}
			if (($pt == 'auto' || $pt_md != 'auto') && $pt_md != $pt) {
				$row_classes[] = 'pt-md-'.$pt_md;
			}
			$pb = get_sub_field('padding_bottom');
			$pb_md = get_sub_field('padding_bottom_md');
			if ($pb) {
				$row_classes[] = 'pb-'.$pb;
			}
			if (($pb == 'auto' || $pb_md != 'auto') && $pb_md != $pb) {
				$row_classes[] = 'pb-md-'.$pb_md;
			}
			if (get_sub_field('overflow_option') == 'overflow-content') {
				$row_classes[] = 'overflow-content';
			}
			$row_classes = apply_filters('mlmi_builder_row_classes', $row_classes);
			$row_attributes = apply_filters('mlmi_builder_row_attributes', ['id' => $row_id]);
			$row_attributes_output = mlmi_builder_attributes_inline($row_attributes, $row_classes);
			
			/* Using container element */
			if ($use_container && $is_first_row):
				$container_classes = apply_filters('mlmi_builder_container_classes', [$use_container]);
				$container_attributes_output = mlmi_builder_attributes_inline([], $container_classes);
				echo '<div'.$container_attributes_output.'>';
			endif;
			
			/* Hook before row */
			do_action('mlmi_builder_before_row');
			
			/* Using row element */
			if ($use_row):
				echo '<div'.$row_attributes_output.'>';
				do_action('mlmi_builder_begin_row');
			endif;
			
				/* Display standard row */
				if (get_row_layout() == "text_row"):
					
					/* Columns configuration */
					$columns_count = get_sub_field('cols_num');
					$columns = [];
					for ($i = 1; $i <= $columns_count; $i++) {
						$column = get_sub_field('col_'.$i.'_group');
						if (!is_array($column['column_options'])) {
							$column['column_options'] = [];
						}
						$columns[] = $column;
					}
					$columns = apply_filters('mlmi_builder_standard_columns', $columns, $columns_count);
					
					/* Custom output */
					if (isset($columns['output'])) {
						echo $columns['output'];
					} else {
						/* Standard reverse columns */
						if (get_sub_field('overflow_option') == 'mobile-reverse') {
							foreach ($columns as $index => &$column) {
								$column['column_order'] = 3 - $index;
							}
						}
						
						/* Order columns */
						foreach ($columns as $index => &$column) {
							$column['column_order_md'] = $index + 1;
							if (!isset($column['column_order'])) { $column['column_order'] = 2; }
							if (!isset($column['column_offset'])) { $column['column_offset'] = 0; }
							if (!isset($column['column_options'])) { $column['column_options'] = []; }
						}
						
						/* Reorder columns array */
						usort($columns, function($a, $b) {
							return $a['column_order'] > $b['column_order'];
						});
						
						/* Build columns */
						foreach ($columns as $index => &$column):
							/* Column index */
							$column_index = $column['column_order_md'];
							
							/* Column classes */
							$column_classes = [];
							$column_classes['column'] = 'col';
							$column_classes['base_column'] = 'col-'.$grid_system_base;
							$column_classes['md_column'] = 'col-'.$desktop_prefix.'-'.$column['column_width'];
							
							/* Offset classes */
							if ($column['column_offset'] > 0) {
								$column_classes[] = 'offset-'.$desktop_prefix.'-'.$column['column_offset'];
							}
							
							/* Order classes */
							$column_classes[] = 'order-md-'.$column['column_order_md'];
							
							/* Column options */
							$column_classes = array_merge($column_classes, $column['column_options']);
							
							/* Overriding */
							if (in_array('col-1', $column_classes) || in_array('col-2', $column_classes) || in_array('col-3', $column_classes) || in_array('col-4', $column_classes) || in_array('col-5', $column_classes) || in_array('col-6', $column_classes) || in_array('col-7', $column_classes) || in_array('col-8', $column_classes) || in_array('col-9', $column_classes) || in_array('col-10', $column_classes) || in_array('col-11', $column_classes)) {
								unset($column_classes['base_column']);
							}
							
							/* Content */
							$content = get_sub_field('col_'.$column['column_order_md']);
							if (!$content){
								$column_classes[] = 'd-none';
								$column_classes[] = 'd-md-block';
							}
							
							/* Content attributes */
							$content_classes = ['text-content'];
							$content_attributes = apply_filters('mlmi_builder_content_attributes', []);
							$content_classes = apply_filters('mlmi_builder_content_classes', $content_classes);
							$content_attributes_output = mlmi_builder_attributes_inline($content_attributes, $content_classes);
							
							/* Column attributes */
							$column_attributes = apply_filters('mlmi_builder_column_attributes', []);
							$column_classes = apply_filters('mlmi_builder_column_classes', $column_classes);
							$column_attributes_output = mlmi_builder_attributes_inline($column_attributes, $column_classes);
							
							/* Display column */
							echo '<div'.$column_attributes_output.'>';
							if ($content):
								echo '<div'.$content_attributes_output.'>';
								echo apply_filters('the_builder_content', $content);
								echo '</div>';
							endif;
							echo '</div>';
						endforeach;
					}
			
				/* Display shortcode row */
				elseif (get_row_layout() == "code_row"):
					
					$template_item = get_sub_field('template_item');
					if ($template_item && $template_item != 'shortcode' && function_exists('get_template_item')):
						
						echo get_template_item($template_item);
						
					else:
						
						$custom_code_row_layout = apply_filters('mlmi_builder_code_row_template', "plugin-template");
						if ($custom_code_row_layout == "plugin-template"):
							require plugin_dir_path(dirname(__FILE__)).'../public/partials/code-row.php';
						elseif ($custom_code_row_layout != false):
							require locate_template($custom_code_row_layout, false, false);
						endif;
						
					endif;
					
				/* Display gallery row */
				elseif (get_row_layout() == "gallery_row"):
						
					$gallery_images = get_sub_field('gallery');
					do_action('mlmi_builder_gallery_row_output', $gallery_images);
						
				/* Display custom row */
				else:
						
					do_action('mlmi_builder_'.get_row_layout().'_output');
						
				endif;
			
			/* Hook after row */
			do_action('mlmi_builder_after_row');
			
			/* Closing row element */
			if ($use_row):
				echo '</div>';
			endif;
			
			/* Closing container element */
			$close_container = apply_filters('mlmi_builder_close_container', $use_container);
			if ($use_container && $is_last_row && $close_container) {
				echo '</div>';
			}
		
		/* End loop rows */
		endwhile;
		
		/* Hook after section rows */
		do_action('mlmi_builder_end_section');
	
	/* Closing section */
	echo '</div>';
	
	/* Hook after section */
	do_action('mlmi_builder_after_section');
	
	/* Tabs closing */
	if ($use_tabs_system) {
		do_action('mlmi_builder_tabs_close', $builder_tabs[$section_index - 1]);
	}

/* End loop sections */
endif; endwhile; endif;
