# Exemples d'utilisation des filtres

```
/**
* Edit the global builder configuration.
* This allows for reviewing the full ACF configuration right before usage.
*/
add_filter('mlmi_builder_config', function ($builder_config) {
  return $builder_config;
}, PHP_INT_MAX);
```
```
/**
* Edit the list of hidden admin screen elements.
* In this example, the main content field is displayed and the thumbnail box is hidden.
*/
add_filter('mlmi_builder_hide_on_screen', function($hidden_elements){
  unset($hidden_elements['the_content']);
  $hidden_elements[] = 'featured_image';
  return $hidden_elements;
}, PHP_INT_MAX);

/* These are the defaults and possible options */
$hidden = array(
      // 'permalink'         => 'permalink',
      'the_content'       => 'the_content',
      'excerpt'           => 'excerpt',
      'custom_fields'     => 'custom_fields',
      'discussion'        => 'discussion',
      'comments'          => 'comments',
      // 'revisions'         => 'revisions',
      'slug'              => 'slug',
      // 'author'            => 'author',
      'format'            => 'format',
      // 'page_attributes'   => 'page_attributes',
      // 'featured_image'    => 'featured_image',
      // 'categories'        => 'categories',
      'tags'              => 'tags',
      'send-trackbacks'   => 'send-trackbacks',
  );
```
```
/**
* Edit layout types.
* This example removes the "gallery_row" type and creates a new one.
*/
add_filter('mlmi_builder_layout_types', function($layout_types){
  unset($layout_types['gallery_row']);
  $layout_types['my_type_name'] = array(
    "label" => __('My Content Type', 'gtlpaysagiste'),
    "group" => "group_5b2d02c090bd8"
  );
  return $layout_types;
}, PHP_INT_MAX);
```
```
/**
* Edit column options.
* There is no default class. You must add them all manually on a per-project basis.
*/
add_filter('mlmi_builder_column_options', function($column_options){
  $column_options["rounded"] = __('Coins arrondis', 'gtlpaysagiste');
  $column_options["sidebar"] = __('Barre latérale', 'gtlpaysagiste');
  return $column_options;
}, PHP_INT_MAX);
```
```
/**
* Add custom fields to section.
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
```
```
/**
* Add fields group to section presentation.
*/
add_filter('mlmi_builder_section_add_group', function($fields_group){
  $fields_group = "group_5b2d02c090bd8";
  return $fields_group;
}, PHP_INT_MAX);
```
```
/**
* Add fields to standard row presentation.
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
```
```
/**
* Add fields group to standard row presentation.
*/
add_filter('mlmi_builder_standard_row_add_group', function($fields_group){
  $fields_group = "group_5b2d02c090bd8";
  return $fields_group;
}, PHP_INT_MAX);
```
```
/*
* Edit section classes
* This example adds a class based on a custom field value.
*/
add_filter('mlmi_builder_section_classes', function($classes){
  if (get_sub_field('is_animated')){
    $classes[] = "is-animated";
  }
  return $classes;
}, PHP_INT_MAX);
```
```
/**
* Edit section attributes
* This allows customization of all HTML attributes of the section element, except the classes.
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
```
```
/*
* Edit row classes
* This example adds a class based on a custom field value.
*/
add_filter('mlmi_builder_row_classes', function($classes){
  if (get_sub_field('is_animated')){
    $classes[] = "is-animated";
  }
  return $classes;
}, PHP_INT_MAX);
```
```
/**
* Edit row attributes
* This allows customization of all HTML attributes of the row element, except the classes.
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
```
```
/**
* Use container or not?
* In this example, it is determined that the "code_row" layout won't use the container div.
*/
add_filter('mlmi_builder_use_container', function($use_container){
  if (get_row_layout() == "code_row"){
    $use_container = false;
  }
  return $use_container;
}, PHP_INT_MAX);
```
```
/**
* Use row or not?
* In this example, it is determined that the "gallery_row" layout won't use the default bootstrap row.
*/
add_filter('mlmi_builder_use_row', function($use_row){
  if (get_row_layout() == "gallery_row"){
    $use_row = false;
  }
  return $use_row;
}, PHP_INT_MAX);
```
```
/**
* Add HTML content before section.
* In this example, an anchor using the section ID is created.
*/
add_action('mlmi_builder_before_section', function(){
  if ($section_id = get_sub_field('section_id')){
    echo '<a name="'.$section_id.'"></a>';
  }
}, PHP_INT_MAX);
```
```
/**
* Customize gallery row template.
* This example specifies a PHP template to use instead of the default for a "gallery_row".
*/
add_filter('mlmi_builder_gallery_row_template', function($template){
  $template = '/views/partials/grid-gallery-row.php';
  return $template;
}, PHP_INT_MAX);
```
```
/**
* Customize code row template.
* This example outputs the result of a Blade template for a "code_row".
* The function returns FALSE to avoid using the default plugin template.
*/
add_filter('mlmi_builder_code_row_template', function($template){
  echo template("partials/grid-code-row");
  return false;
}, PHP_INT_MAX);
```
```
/**
* Custom content type template action.
* Output the template directly for the custom content type.
* In this example, a "color_row" type has been created and a Blade template is used.
*/
add_action('mlmi_builder_color_row_template', function(){
    echo template("partials/grid-color-row");
});
```
