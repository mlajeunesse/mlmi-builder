# Exemples d'utilisation des filtres

  /**
  *   Parsing global builder configuration.
  */
  add_filter('mlmi_builder_config', function ($builder_config) {
      return $builder_config;
  }, PHP_INT_MAX);

  /**
  *   Parsing list of hidden admin screen elements.
  */
  add_filter('mlmi_builder_hide_on_screen', function($hidden_elements){
      // unset($hidden_elements['the_content']);
      // $hidden_elements[] = 'featured_image';
      return $hidden_elements;
  }, PHP_INT_MAX);

  /**
  *   Editing layout types
  */
  add_filter('mlmi_builder_layout_types', function($layout_types){
      unset($layout_types['gallery_row']);
      $layout_types[] = array(
          "label" => __('Mon groupe perso', 'gtlpaysagiste'),
          "group" => "group_5b2d02c090bd8"
      );
          // pre($layout_types);
      return $layout_types;
  }, PHP_INT_MAX);

  /**
  *   Filtering column options.
  */
  add_filter('mlmi_builder_column_options', function($column_options){
      $column_options["rounded"] = __('Coins arrondis', 'gtlpaysagiste');
      $column_options["sidebar"] = __('Barre latérale', 'gtlpaysagiste');
      return $column_options;
  }, PHP_INT_MAX);

  /**
  *   Add fields to section presentation.
  */
  add_filter('mlmi_builder_section_add_fields', function($additional_fields){
      $additional_fields[] = array(
          'key' => 'field_add_example',
          'label' => __('Mon champ supplémentaire', 'gtlpaysagiste'),
          'name' => 'my_text_field',
          'type' => 'text'
      );
      return $additional_fields;
  }, PHP_INT_MAX);

  /**
  *   Add group of fields to section presentation.
  */
  add_filter('mlmi_builder_section_add_group', function($fields_group){
      $fields_group = "group_5b2d02c090bd8";
      return $fields_group;
  }, PHP_INT_MAX);

  /**
  *   Add fields to standard row presentation.
  */
  add_filter('mlmi_builder_standard_row_add_fields', function($additional_fields){
      $additional_fields[] = array(
          'key' => 'field_add_example',
          'label' => __('Mon champ supplémentaire', 'gtlpaysagiste'),
          'name' => 'my_text_field',
          'type' => 'text'
      );
      return $additional_fields;
  }, PHP_INT_MAX);

  /**
  *   Add group of fields to standard row presentation.
  */
  add_filter('mlmi_builder_standard_row_add_group', function($fields_group){
      $fields_group = "group_5b2d02c090bd8";
      return $fields_group;
  }, PHP_INT_MAX);

  /**
  *   Add fields to code row presentation.
  */
  add_filter('mlmi_builder_code_row_add_fields', function($additional_fields){
      $additional_fields[] = array(
          'key' => 'field_add_example',
          'label' => __('Mon champ supplémentaire', 'gtlpaysagiste'),
          'name' => 'my_text_field',
          'type' => 'text'
      );
      return $additional_fields;
  }, PHP_INT_MAX);

  /**
  *   Add group of fields to code row presentation.
  */
  add_filter('mlmi_builder_code_row_add_group', function($fields_group){
      $fields_group = "group_5b2d02c090bd8";
      return $fields_group;
  }, PHP_INT_MAX);

  /**
  *   Add fields to gallery row presentation.
  */
  add_filter('mlmi_builder_gallery_row_add_fields', function($additional_fields){
      $additional_fields[] = array(
          'key' => 'field_add_example',
          'label' => __('Mon champ supplémentaire', 'gtlpaysagiste'),
          'name' => 'my_text_field',
          'type' => 'text'
      );
      return $additional_fields;
  }, PHP_INT_MAX);

  /**
  *   Add group of fields to gallery row presentation.
  */
  add_filter('mlmi_builder_gallery_row_add_group', function($fields_group){
      $fields_group = "group_5b2d02c090bd8";
      return $fields_group;
  }, PHP_INT_MAX);

  /*
  *   Edit section classes
  */
  add_filter('mlmi_builder_section_classes', function($classes){
      if (get_sub_field('is_animated')){
          $classes[] = "is-animated";
      }
      return $classes;
  }, PHP_INT_MAX);

  /**
  *   Edit section attributes
  */
  add_filter('mlmi_builder_section_attributes', function($attributes){
      $attributes['style'] = "";
      if ($background_color = get_sub_field('background_color')){
          $attributes['style'] .= "background-color:".$background_color.";";
      }
      if (isset($attributes['style']) && $attributes['style'] == ""){
          unset($attributes['style']);
      }
      unset($attributes['id']);
      return $attributes;
  }, PHP_INT_MAX);

  /*
  *   Edit row classes
  */
  add_filter('mlmi_builder_row_classes', function($classes){
      if (get_sub_field('is_animated')){
          $classes[] = "is-animated";
      }
      return $classes;
  }, PHP_INT_MAX);

  /**
  *   Edit row attributes
  */
  add_filter('mlmi_builder_row_attributes', function($attributes){
      $attributes['style'] = "";
      if ($background_color = get_sub_field('background_color')){
          $attributes['style'] .= "background-color:".$background_color.";";
      }
      if (isset($attributes['style']) && $attributes['style'] == ""){
          unset($attributes['style']);
      }
      return $attributes;
  }, PHP_INT_MAX);

  /**
  *   Use container
  */
  add_filter('mlmi_builder_row_use_container', function($use_container){
      if (get_row_layout() == "code_row"){
          $use_container = false;
      }
      return $use_container;
  }, PHP_INT_MAX);

  /**
  *   Add content before section.
  */
  add_action('mlmi_builder_before_section', function(){
      if ($section_id = get_sub_field('section_id')){
          echo '<a name="'.$section_id.'"></a>';
      }
  }, PHP_INT_MAX);

  /**
  *   Exemple shortcode
  */
  add_shortcode('test_shortcode', function(){
      return '<h2 style="padding:3em;margin:0;background:pink;">Le shortcode a été exécuté!</h2>';
  }, PHP_INT_MAX);

  /**
  *   Customize code row template
  */
  add_filter('mlmi_builder_code_row_template', function($template){
      echo template("partials/grid-code-row");
      return false;
  }, PHP_INT_MAX);

  /**
  *   Customize gallery row template
  */
  add_filter('mlmi_builder_gallery_row_template', function($template){
      $template = '/views/partials/grid-gallery-row.php';
      return $template;
  }, PHP_INT_MAX);

  /**
  *   Customize default gallery template options
  */
  add_filter('mlmi_builder_gallery_attributes', function($attributes){
      $attributes["size"] = "medium";
      return $attributes;
  });

  /**
  *   Edit column classes.
  */
  add_filter('mlmi_builder_column_classes', function($classes){
      return $classes;
  });
