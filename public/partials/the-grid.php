<?php /* MLMI Builder */
global $post;

if (have_rows('sections', $post->ID)): while (have_rows('sections', $post->ID)) : the_row();
	$section_classes = array_filter(array_merge(array("mb-section"), array_map('trim', explode(" ", get_sub_field('section_class')))));
    $section_classes[] = get_sub_field('padding_top');
    $section_classes[] = get_sub_field('padding_bottom');
    $section_classes = apply_filters('mlmi_builder_section_classes', $section_classes);
	$section_attributes = apply_filters('mlmi_builder_section_attributes', array( "id" => get_sub_field('section_id') ));
    $section_attributes_output = mlmi_builder_attributes_inline($section_attributes, $section_classes);
?>

<div<?=$section_attributes_output?>>

<?php do_action('mlmi_builder_before_section'); ?>

<?php if (have_rows('rows')): while (have_rows('rows')) : the_row();
	$row_classes = array_filter(array_merge(array("row", get_row_layout()), array_map('trim', explode(" ", get_sub_field('row_class')))));
    $row_classes[] = get_sub_field('padding_top');
    $row_classes[] = get_sub_field('padding_bottom');
    $row_classes = apply_filters('mlmi_builder_row_classes', $row_classes);
	if (get_row_layout() == "text_row"){
		$columns_layout = get_sub_field('cols_config');
		$columns_sizes = explode("-", $columns_layout);
		$columns_count = count($columns_sizes);
	}
    $row_attributes = apply_filters('mlmi_builder_row_attributes', array( "id" => get_sub_field('row_id') ));
    $row_attributes_output = mlmi_builder_attributes_inline($row_attributes, $row_classes);
    $use_container = apply_filters('mlmi_builder_row_use_container', true);
	?>
    <?php if ($use_container): ?><div class="container">
    <?php endif; ?>
    	<div<?=$row_attributes_output?>>

            <?php do_action('mlmi_builder_before_row'); ?>

    		<?php
            /**
            *   Standard Row
            */
    		if (get_row_layout() == "text_row"):

        		$columns = array();

        		for ($i = 0; $i < $columns_count; $i++):

        			// column classes
        			$column_classes = array();
        			$column_classes[] = "col";
        			$column_classes[] = "col-12";
        			$column_classes[] = "col-md-".($columns_sizes[$i]*2);
        			$column_classes[] = "order-md-".($i+1);
                    switch (get_sub_field('col_'.($i+1).'_order')) {
                        case 'first': $column_classes[] = "order-1"; break;
                        case 'last': $column_classes[] = "order-3"; break;
                        default: $column_classes[] = "order-2"; break;
                    }

        			// column options
        			$column_options = get_sub_field('col_'.($i+1).'_option');
        			if (!is_array($column_options)) $column_options = array($column_options);
                    $column_classes = array_merge($column_classes, $column_options);

                    // content classes
                    $content_classes = array("text-content");

        			// content
        			$content = get_sub_field('col_'.($i+1));
        			if (!$content){
        				$column_classes[] = "d-none";
        				$column_classes[] = "d-md-block";
        			}

        			// classes
                    $column_attributes = apply_filters('mlmi_builder_column_attributes', array());
                    $column_classes = apply_filters('mlmi_builder_column_classes', $column_classes);
                    $column_attributes_output = mlmi_builder_attributes_inline($column_attributes, $column_classes);
                    $content_attributes = apply_filters('mlmi_builder_content_attributes', array());
                    $content_classes = apply_filters('mlmi_builder_content_classes', $content_classes);
                    $content_attributes_output = mlmi_builder_attributes_inline($content_attributes, $content_classes);
                    ?>
                    <div<?=$column_attributes_output?>>
            			<?php if ($content): ?>
            			<div<?$content_attributes_output?>>
            				<?=$content?>
            			</div>
            			<?php endif; ?>
            		</div>
        		<?php endfor;

            // Code row
    		elseif (get_row_layout() == "code_row"):

                $custom_code_row_layout = apply_filters('mlmi_builder_code_row_template', "plugin-template");
                if ($custom_code_row_layout == "plugin-template"):
                    require plugin_dir_path( dirname( __FILE__ ) ) . '../public/partials/code-row.php';
                elseif ($custom_code_row_layout != false):
                    require locate_template($custom_code_row_layout, false, false);
                endif;

            // Gallery row
        	elseif (get_row_layout() == "gallery_row"):

                // gallery images
                $gallery_images = get_sub_field('gallery');
                $gallery_ids = array();
                foreach ($gallery_images as $image){
                    $gallery_ids[] = $image['ID'];
                }
                $gallery_ids = implode(',', $gallery_ids);
                $gallery_attributes = apply_filters('mlmi_builder_gallery_attributes', array(
                    "link" => "file",
                    "size" => "medium"
                ));

                // layout
                $custom_gallery_row_layout = apply_filters('mlmi_builder_gallery_row_template', 'plugin-template');
                if ($custom_gallery_row_layout == "plugin-template"):
                    require plugin_dir_path( dirname( __FILE__ ) ) . '../public/partials/gallery-row.php';
                elseif ($custom_gallery_row_layout != false):
                    require locate_template($custom_gallery_row_layout, false, false);
                endif;

            endif; ?>

            <?php do_action('mlmi_builder_after_row'); ?>

    	</div>
    <?php if ($use_container): ?></div><?php endif; ?>
<?php endwhile; endif; ?>

<?php do_action('mlmi_builder_after_section'); ?>

</div>

<?php endwhile; endif; /* end MLMI Builder */ ?>
