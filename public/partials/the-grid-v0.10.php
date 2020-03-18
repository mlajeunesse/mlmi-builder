<?php
/*
*	MLMI Builder
*	Grid template (Legacy v0.12)
*/
global $section_classes, $section_id, $container_classes, $row_classes;
global $is_first_row, $is_last_row, $is_first_section, $is_last_section, $column_index;
$sections = get_field('sections');
$sections_count = $sections ? count($sections) : 0;
$sections_index = 0;
if (have_rows('sections')): while (have_rows('sections')) : the_row();
$sections_index += 1;
$is_first_section = $sections_index === 1;
$is_last_section = $sections_index === $sections_count;
$section_classes = array_filter(array_merge(['mb-section'], array_map('trim', explode(" ", get_sub_field('section_class')))));
$section_classes[] = get_sub_field('padding_top');
$section_classes[] = get_sub_field('padding_bottom');
$section_classes = apply_filters('mlmi_builder_section_classes', $section_classes);
$section_id = get_sub_field('section_id');
$section_attributes = apply_filters('mlmi_builder_section_attributes', ["id" => $section_id]);
$section_attributes_output = mlmi_builder_attributes_inline($section_attributes, $section_classes);
$desktop_prefix = apply_filters('mlmi_builder_desktop_class', 'md');
do_action('mlmi_builder_before_section');
$rows = get_sub_field('rows');
$rows_count = $rows ? count($rows) : 0;
$rows_index = 0;
if (have_rows('rows')): ?>

<div<?=$section_attributes_output?>>

<?php do_action('mlmi_builder_begin_section'); ?>

<?php while (have_rows('rows')): the_row();
$rows_index += 1;
$is_first_row = $rows_index === 1;
$is_last_row = $rows_index === $rows_count;
$row_classes = array_filter(array_merge(["row", get_row_layout()], array_map('trim', explode(" ", get_sub_field('row_class')))));
$row_classes[] = get_sub_field('padding_top');
$row_classes[] = get_sub_field('padding_bottom');
$row_classes = apply_filters('mlmi_builder_row_classes', $row_classes);
if (get_row_layout() == "text_row"){
	$columns_layout = get_sub_field('cols_config');
	$columns_sizes = explode("-", $columns_layout);
	$columns_count = count($columns_sizes);
}
$row_attributes = apply_filters('mlmi_builder_row_attributes', ['id' => get_sub_field('row_id')]);
$use_row = apply_filters('mlmi_builder_use_row', true);
$row_attributes_output = mlmi_builder_attributes_inline($row_attributes, $row_classes);
$use_container = apply_filters('mlmi_builder_use_container', true);
$wrap_container = apply_filters('mlmi_builder_wrap_container', false);
$container_class = ($use_container === true) ? 'container' : $use_container;
$container_classes = apply_filters('mlmi_builder_container_classes', [$container_class]);
$container_attributes_output = mlmi_builder_attributes_inline([], $container_classes);
?>
<?php if ($use_container && (!$wrap_container || ($wrap_container && $is_first_row))): ?><div<?=$container_attributes_output?>>
	<?php do_action('mlmi_builder_before_container'); endif; if ($use_row): ?>
		<div<?=$row_attributes_output?>><?php endif; ?>
		<?php do_action('mlmi_builder_before_row'); ?>
		<?php
		/*
		*   Standard Row
		*/
		if (get_row_layout() == "text_row"):
			
			// order columns
			$last_order = [];
			$middle_order = [];
			$first_order = [];
			
			for ($i = 0; $i < $columns_count; $i++):
				switch (get_sub_field('col_'.($i+1).'_order')) {
					case 'first':
					$first_order[] = $i;
					break;
					case 'last':
					$last_order[] = $i;
					break;
					default:
					$middle_order[] = $i;
					break;
				}
			endfor;
			
			// get last column
			$last_mobile_column = NULL;
			if (count($last_order)){
				$last_mobile_column = $last_order[count($last_order) - 1];
			} else if (count($middle_order)){
				$last_mobile_column = $middle_order[count($middle_order) - 1];
			} else if (count($first_order)){
				$last_mobile_column = $first_order[count($first_order) - 1];
			}
			
			// display columns
			for ($i = 0; $i < $columns_count; $i++):
				$column_index = $i;
				
				// column classes
				$column_classes = [];
				$column_classes[] = "col";
				$column_classes[] = "col-12";
				if ($columns_sizes[$i] == 2 || $columns_sizes[$i] == 3 || $columns_sizes[$i] == 4) {
					$column_classes[] = "col-$desktop_prefix-".($columns_sizes[$i]*2);
				} else if ($columns_sizes[$i] == 5 || $columns_sizes[$i] == 7) {
					$column_classes[] = "col-$desktop_prefix-".($columns_sizes[$i]);
				}
				$column_classes[] = "order-$desktop_prefix-".($i+1);
				switch (get_sub_field('col_'.($i+1).'_order')) {
					case 'first':
					$column_classes[] = "order-1";
					break;
					case 'last':
					$column_classes[] = "order-3";
					break;
					default:
					$column_classes[] = "order-2";
					break;
				}
				if ($last_mobile_column == $i){
					$column_classes[] = "sm-last";
				}
				
				// column options
				$column_options = get_sub_field('col_'.($i+1).'_option');
				if (!is_array($column_options)) $column_options = [$column_options];
				$column_classes = array_merge($column_classes, $column_options);
				
				// content classes
				$content_classes = ['text-content'];
				
				// content
				$content = get_sub_field('col_'.($i+1));
				if (!$content){
					$column_classes[] = "d-none";
					$column_classes[] = "d-$desktop_prefix-block";
				}
				
				// classes
				$column_attributes = apply_filters('mlmi_builder_column_attributes', []);
				$column_classes = apply_filters('mlmi_builder_column_classes', $column_classes);
				$column_attributes_output = mlmi_builder_attributes_inline($column_attributes, $column_classes);
				$content_attributes = apply_filters('mlmi_builder_content_attributes', []);
				$content_classes = apply_filters('mlmi_builder_content_classes', $content_classes);
				$content_attributes_output = mlmi_builder_attributes_inline($content_attributes, $content_classes);
				?>
				<div<?=$column_attributes_output?>>
				<?php if ($content): ?>
					<div<?=$content_attributes_output?>>
					<?=apply_filters('the_content', $content)?>
				</div>
			<?php endif; ?>
		</div>
	<?php endfor;
	
	// Code row
	elseif (get_row_layout() == "code_row"):
		
		$custom_code_row_layout = apply_filters('mlmi_builder_code_row_template', "plugin-template");
		if ($custom_code_row_layout == "plugin-template"):
			require plugin_dir_path(dirname(__FILE__)).'../public/partials/code-row.php';
			elseif ($custom_code_row_layout != false):
				require locate_template($custom_code_row_layout, false, false);
			endif;
			
			// Gallery row
			elseif (get_row_layout() == "gallery_row"):
				
				$gallery_images = get_sub_field('gallery');
				do_action('mlmi_builder_gallery_row_output', $gallery_images);
				
			else:
				
				// layout
				do_action('mlmi_builder_'.get_row_layout().'_output');
				
			endif; ?>
			
			<?php do_action('mlmi_builder_after_row'); ?>
			
			<?php if ($use_row): ?></div><?php endif; ?>
			
			<?php if ($use_container && (!$wrap_container || ($wrap_container && $is_last_row))): do_action('mlmi_builder_after_container'); ?></div><?php endif; ?>
		<?php endwhile; ?>
		
		<?php do_action('mlmi_builder_after_section'); ?>
		
	</div>
	
	<?php do_action('mlmi_builder_after_section'); ?>
	
<?php endif; endwhile; endif; ?>
