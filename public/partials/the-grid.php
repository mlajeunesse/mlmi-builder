<?php /* MLMI Builder */
global $post;

// column order manipulation
if (!function_exists('insert_column'))	// avoid redeclare
{
	function insert_column(&$columns, $column, $index = NULL){
		if ($index === NULL){
			for ($i=0; $i <= 2; $i++) {
				if (!isset($columns[$i])){
					$columns[$i] = $column;
					break;
				}
			}
		} else {
			if (isset($columns[$index])){
				array_splice($columns, $index, 0, array($column));
			} else {
				$columns[$index] = $column;
			}
		}
		return $columns;
	}
}

if (have_rows('sections', $post->ID)): while (have_rows('sections', $post->ID)) : the_row();
	$section_classes = array_filter(array_merge(array("mb-section"), array_map('trim', explode(" ", get_sub_field('section_class')))));
	$section_classes = implode(" ", $section_classes);
	if ($section_id = get_sub_field('section_id')){
		$section_id = ' id="'.$section_id.'"';
	} else {
		$section_id = "";
	}
?>

<div<?=$section_id?> class="<?=$section_classes?>">

<?php if (have_rows('rows')): while (have_rows('rows')) : the_row();
	$row_classes = array_filter(array_merge(array("row"), array_map('trim', explode(" ", get_sub_field('row_class')))));
	$row_id = get_sub_field('row_id');
	if ($padding_bottom = get_sub_field('padding_bottom')){
		if ($padding_bottom == "fitted"){
			$row_classes[] = "row--fitted";
		}
	}
	if (get_row_layout() == "text_row"){
		$columns_layout = get_sub_field('cols_config');
		$columns_sizes = explode("-", $columns_layout);
		$columns_count = count($columns_sizes);
	}
	$row_classes = implode(" ", $row_classes);
	?>
	<div<?php if ($row_id) echo ' id="'.$row_id.'"' ?> class="<?=$row_classes?>">

		<?php // Text row
		if (get_row_layout() == "text_row"):
		$columns = array();
		$columns_order = array();

		for ($i = 0; $i < $columns_count; $i++):
			// column classes
			$column_classes = array();
			$content_options = get_sub_field('col_'.($i+1).'_option');
			if (!is_array($content_options)) $content_options = array($content_options);
			$column_classes[] = "col";
			$column_classes[] = "col-12";
			$column_classes[] = "col-md-".($columns_sizes[$i]*2);
			$column_classes[] = "order-md-".($i+1);

			// content classes
			$content_classes = array("content");

			// content
			$is_empty = false;
			$content = get_sub_field('col_'.($i+1));
			if (!$content){
				$column_classes[] = "d-none";
				$column_classes[] = "d-md-block";
				$is_empty = true;
			}

			// order
			$order = NULL;
			if (in_array('order-first', $content_options)){
				$order = 0;
			} else if (in_array('order-second', $content_options)){
				$order = 1;
			} else if (in_array('order-third', $content_options)){
				$order = 2;
			}

			// classes
			$content_classes = implode(" ", $content_classes);
			$column_classes = implode(" ", $column_classes);
			$column = array(
				"content" => $content,
				"is_empty" => $is_empty,
				"content_classes" => $content_classes,
				"column_classes" => $column_classes,
				"index" => $i
			);
			insert_column($columns_order, $column, $order);
			ksort($columns_order);
			$columns[] = $column;
		endfor;

		// check column order for mobile
		foreach ($columns_order as $index => $column_order){
			$class = "";
			switch ($index) {
				case 0: $class = "order-1"; break;
				case 1: $class = "order-2"; break;
				case 2: $class = "order-3"; break;
			}
			$columns[$column_order['index']]["column_classes"] .= " ".$class;
		}

		// display each column
		foreach ($columns as $index => $column_single): ?>
		<div class="<?=$column_single['column_classes']?>">
			<?php if ($column_single['content']): ?>
			<div class="<?=$column_single['content_classes']?>">
				<?=$column_single['content']?>
			</div>
			<?php endif; ?>
		</div>
		<?php endforeach; ?>

		<?php // Code row
		elseif (get_row_layout() == "code_row"): ?>

		<div class="col">
			<?php echo do_shortcode(get_sub_field('shortcode')) ?>
		</div>

		<?php endif; ?>

	</div>
<?php endwhile; endif; ?>

</div>

<?php endwhile; endif; /* end MLMI Builder */ ?>
