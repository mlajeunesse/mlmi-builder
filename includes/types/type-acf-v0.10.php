<?php
/*
* MLMI Builder (Legacy v0.10)
* Advanced Custom Fields — Basic fields
*/

/*
*   Dynamically create ACF layout using basic settings
*/
function mlmi_builder_create_acf_layout($key, $settings) {
  // Default settings
  $settings = array_merge([
    'name' => 'row',
    'label' => __('Rangée', 'mlmi-builder'),
    'display' => 'block',
    'group' => 'mlmi_builder_layout_text_row'
  ], $settings);
  
  // Generated layout
  return [
    'key' => 'mlmi_builder_layout_'.$key,
    'name' => $key,
    'label' => $settings['label'],
    'display' => $settings['display'],
    'sub_fields' => [
      [
        'key' => 'mlmi_builder_cloned_group_'.$key,
        'label' => __('Clone', 'mlmi-builder'),
        'name' => 'replaced',
        'type' => 'clone',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '',
          'class' => '',
          'id' => '',
        ],
        'clone' => [
          0 => $settings['group'],
        ],
        'display' => 'seamless',
        'layout' => 'block',
        'prefix_label' => 0,
        'prefix_name' => 0,
      ],
    ],
    'min' => '',
    'max' => '',
  ];
}

if (function_exists('acf_add_local_field_group')):
  add_action('after_setup_theme', function() {
    /*
    * Hide on screen (defaults)
    */
    $hidden = [
      'the_content' => 'the_content',
      'excerpt' => 'excerpt',
      'custom_fields' => 'custom_fields',
      'discussion' => 'discussion',
      'comments' => 'comments',
      'slug' => 'slug',
      'format' => 'format',
      'tags' => 'tags',
      'send-trackbacks' => 'send-trackbacks',
    ];
    $hide_on_screen = apply_filters('mlmi_builder_hide_on_screen', $hidden);
    
    /*
    * Content Type: Standard Row
    */
    $content_type_text_row_column_options = apply_filters('mlmi_builder_column_options', []);
    $padding_bottom_options = [
      'pb-5' => '5',
      'pb-4' => 'Par défaut (4)',
      'pb-3' => '3',
      'pb-0' => 'Aucun (0)',
    ];
    $padding_bottom_options = apply_filters('mlmi_builder_padding_bottom_options', $padding_bottom_options);
    $padding_bottom_default = apply_filters('mlmi_builder_padding_bottom_default', "pb-4");
    $padding_top_options = [
      'pt-5' => '5',
      'pt-4' => 'Par défaut (4)',
      'pt-3' => '3',
      'pt-0' => 'Aucun (0)',
    ];
    $padding_top_options = apply_filters('mlmi_builder_padding_top_options', $padding_top_options);
    $padding_top_default = apply_filters('mlmi_builder_padding_top_default', "pt-4");
    
    /*
    * Column choices
    */
    $column_choices_1_column = apply_filters('mlmi_builder_column_choices_1_column', [
      '6' => __('Pleine largeur', 'mlmi-builder'),
    ]);
    $column_choices_2_columns = apply_filters('mlmi_builder_column_choices_2_columns', [
      '3-3' => __('Moitié-moitié', 'mlmi-builder'),
      '2-4' => __('1 / 2', 'mlmi-builder'),
      '4-2' => __('2 / 1', 'mlmi-builder'),
    ]);
    $column_choices_3_columns = apply_filters('mlmi_builder_column_choices_3_columns', [
      '2-2-2' => __('Trois colonnes', 'mlmi-builder'),
    ]);
    
    /*
    *   Standard row fields
    */
    $standard_row_fields = [
      [
        'key' => 'text_row_tab_content',
        'label' => '<span class="dashicons dashicons-edit"></span>',
        'name' => '',
        'type' => 'tab',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '',
          'class' => '',
          'id' => '',
        ],
        'placement' => 'left',
        'endpoint' => 0,
      ],
      [
        'key' => 'text_row_field_col_1',
        'label' => '',
        'name' => 'col_1',
        'type' => 'wysiwyg',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '33.333',
          'class' => 'mlmi-builder-column no-label',
          'id' => '',
        ],
        'default_value' => '',
        'tabs' => 'all',
        'toolbar' => 'full',
        'media_upload' => 1,
        'delay' => 0,
      ],
      [
        'key' => 'text_row_field_col_2',
        'label' => '',
        'name' => 'col_2',
        'type' => 'wysiwyg',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => [
          [
            [
              'field' => 'text_row_field_cols_num',
              'operator' => '==',
              'value' => '2',
            ],
          ],
          [
            [
              'field' => 'text_row_field_cols_num',
              'operator' => '==',
              'value' => '3',
            ],
          ],
        ],
        'wrapper' => [
          'width' => '33.333',
          'class' => 'mlmi-builder-column no-label',
          'id' => '',
        ],
        'default_value' => '',
        'tabs' => 'all',
        'toolbar' => 'full',
        'media_upload' => 1,
        'delay' => 0,
      ],
      [
        'key' => 'text_row_field_col_3',
        'label' => '',
        'name' => 'col_3',
        'type' => 'wysiwyg',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => [
          [
            [
              'field' => 'text_row_field_cols_num',
              'operator' => '==',
              'value' => '3',
            ],
          ],
        ],
        'wrapper' => [
          'width' => '33.333',
          'class' => 'mlmi-builder-column no-label',
          'id' => '',
        ],
        'default_value' => '',
        'tabs' => 'all',
        'toolbar' => 'full',
        'media_upload' => 1,
        'delay' => 0,
      ],
      [
        'key' => 'text_row_tab_options',
        'label' => '<span class="dashicons dashicons-admin-generic"></span>',
        'name' => '',
        'type' => 'tab',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '',
          'class' => '',
          'id' => '',
        ],
        'placement' => 'left',
        'endpoint' => 0,
      ],
      [
        'key' => 'text_row_field_cols_num',
        'label' => __('Nombre de colonnes', 'mlmi-builder'),
        'name' => 'cols_num',
        'type' => 'select',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '50',
          'class' => 'select-cols-number',
          'id' => '',
        ],
        'choices' => [
          1 => __('1 colonne', 'mlmi-builder'),
          2 => __('2 colonnes', 'mlmi-builder'),
          3 => __('3 colonnes', 'mlmi-builder')
        ],
        'default_value' => 1,
        'allow_null' => 0,
        'multiple' => 0,
        'ui' => 0,
        'ajax' => 0,
        'return_format' => 'value',
        'placeholder' => '',
      ],
      [
        'key' => 'text_row_field_cols_config_1',
        'label' => __('Configuration des colonnes', 'mlmi-builder'),
        'name' => 'cols_config',
        'type' => 'radio',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => [
          [
            [
              'field' => 'text_row_field_cols_num',
              'operator' => '==',
              'value' => '1',
            ],
          ],
        ],
        'wrapper' => [
          'width' => '50',
          'class' => 'cols_config',
          'id' => '',
        ],
        'choices' => $column_choices_1_column,
        'allow_null' => 0,
        'other_choice' => 0,
        'save_other_choice' => 0,
        'default_value' => '',
        'layout' => 'horizontal',
        'return_format' => 'value',
      ],
      [
        'key' => 'text_row_field_cols_config_2',
        'label' => __('Configuration des colonnes', 'mlmi-builder'),
        'name' => 'cols_config',
        'type' => 'radio',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => [
          [
            [
              'field' => 'text_row_field_cols_num',
              'operator' => '==',
              'value' => '2',
            ],
          ],
        ],
        'wrapper' => [
          'width' => '50',
          'class' => 'cols_config',
          'id' => '',
        ],
        'choices' => $column_choices_2_columns,
        'allow_null' => 0,
        'other_choice' => 0,
        'save_other_choice' => 0,
        'default_value' => '3-3',
        'layout' => 'horizontal',
        'return_format' => 'value',
      ],
      [
        'key' => 'text_row_field_cols_config_3',
        'label' => __('Configuration des colonnes', 'mlmi-builder'),
        'name' => 'cols_config',
        'type' => 'radio',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => [
          [
            [
              'field' => 'text_row_field_cols_num',
              'operator' => '==',
              'value' => '3',
            ],
          ],
        ],
        'wrapper' => [
          'width' => '50',
          'class' => 'cols_config',
          'id' => '',
        ],
        'choices' => $column_choices_3_columns,
        'allow_null' => 0,
        'other_choice' => 0,
        'save_other_choice' => 0,
        'default_value' => '2-2-2',
        'layout' => 'horizontal',
        'return_format' => 'value',
      ],
      [
        'key' => 'text_row_field_col_1_order',
        'label' => __('Colonne 1', 'mlmi-builder'),
        'name' => 'col_1_order',
        'type' => 'select',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '33.333',
          'class' => 'mlmi-builder-column-option',
          'id' => '',
        ],
        'choices' => [
          'normal' => __('Ordre régulier', 'mlmi-builder'),
          'first' => __('En premier', 'mlmi-builder'),
          'last' => __('En dernier', 'mlmi-builder')
        ],
        'default_value' => 'normal',
        'allow_null' => 0,
        'multiple' => 0,
        'ui' => 0,
        'ajax' => 0,
        'return_format' => 'value',
        'placeholder' => '',
      ],
      [
        'key' => 'text_row_field_col_2_order',
        'label' => __('Colonne 2', 'mlmi-builder'),
        'name' => 'col_2_order',
        'type' => 'select',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => [
          [
            [
              'field' => 'text_row_field_cols_num',
              'operator' => '==',
              'value' => '2',
            ],
          ],
          [
            [
              'field' => 'text_row_field_cols_num',
              'operator' => '==',
              'value' => '3',
            ],
          ],
        ],
        'wrapper' => [
          'width' => '33.333',
          'class' => 'mlmi-builder-column-option',
          'id' => '',
        ],
        'choices' => [
          'normal' => __('Ordre régulier', 'mlmi-builder'),
          'first' => __('En premier', 'mlmi-builder'),
          'last' => __('En dernier', 'mlmi-builder')
        ],
        'default_value' => 'normal',
        'allow_null' => 0,
        'multiple' => 0,
        'ui' => 0,
        'ajax' => 0,
        'return_format' => 'value',
        'placeholder' => '',
      ],
      [
        'key' => 'text_row_field_col_3_order',
        'label' => __('Colonne 3', 'mlmi-builder'),
        'name' => 'col_3_order',
        'type' => 'select',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => [
          [
            [
              'field' => 'text_row_field_cols_num',
              'operator' => '==',
              'value' => '3',
            ],
          ],
        ],
        'wrapper' => [
          'width' => '33.333',
          'class' => 'mlmi-builder-column-option',
          'id' => '',
        ],
        'choices' => [
          'normal' => __('Ordre régulier', 'mlmi-builder'),
          'first' => __('En premier', 'mlmi-builder'),
          'last' => __('En dernier', 'mlmi-builder')
        ],
        'default_value' => 'normal',
        'allow_null' => 0,
        'multiple' => 0,
        'ui' => 0,
        'ajax' => 0,
        'return_format' => 'value',
        'placeholder' => '',
      ],
      [
        'key' => 'text_row_field_col_1_option',
        'label' => '',
        'name' => 'col_1_option',
        'type' => 'checkbox',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '33.333',
          'class' => 'mlmi-builder-column-option',
          'id' => '',
        ],
        'choices' => $content_type_text_row_column_options,
        'allow_custom' => 1,
        'save_custom' => 0,
        'default_value' => [],
        'layout' => 'vertical',
        'toggle' => 0,
        'return_format' => 'value',
      ],
      [
        'key' => 'text_row_field_col_2_option',
        'label' => '',
        'name' => 'col_2_option',
        'type' => 'checkbox',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => [
          [
            [
              'field' => 'text_row_field_cols_num',
              'operator' => '==',
              'value' => '2',
            ],
          ],
          [
            [
              'field' => 'text_row_field_cols_num',
              'operator' => '==',
              'value' => '3',
            ],
          ],
        ],
        'wrapper' => [
          'width' => '33.333',
          'class' => 'mlmi-builder-column-option',
          'id' => '',
        ],
        'choices' => $content_type_text_row_column_options,
        'allow_custom' => 1,
        'save_custom' => 0,
        'default_value' => [],
        'layout' => 'vertical',
        'toggle' => 0,
        'return_format' => 'value',
      ],
      [
        'key' => 'text_row_field_col_3_option',
        'label' => '',
        'name' => 'col_3_option',
        'type' => 'checkbox',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => [
          [
            [
              'field' => 'text_row_field_cols_num',
              'operator' => '==',
              'value' => '3',
            ],
          ],
        ],
        'wrapper' => [
          'width' => '33.333',
          'class' => 'mlmi-builder-column-option',
          'id' => '',
        ],
        'choices' => $content_type_text_row_column_options,
        'allow_custom' => 1,
        'save_custom' => 0,
        'default_value' => [],
        'layout' => 'vertical',
        'toggle' => 0,
        'return_format' => 'value',
      ],
      [
        'key' => 'field_58cacac3c8c37',
        'label' => __('ID de rangée', 'mlmi-builder'),
        'name' => 'row_id',
        'type' => 'text',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '50',
          'class' => '',
          'id' => '',
        ],
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
      ],
      [
        'key' => 'text_row_field_row_class',
        'label' => __('Classes de rangée', 'mlmi-builder'),
        'name' => 'row_class',
        'type' => 'text',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '50',
          'class' => '',
          'id' => '',
        ],
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
      ],
      [
        'key' => 'text_row_field_padding_top',
        'label' => __('Espacement haut', 'mlmi-builder'),
        'name' => 'padding_top',
        'type' => 'select',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '50',
          'class' => '',
          'id' => '',
        ],
        'choices' => $padding_top_options,
        'default_value' => $padding_top_default,
        'allow_null' => 0,
        'multiple' => 0,
        'ui' => 0,
        'ajax' => 0,
        'return_format' => 'value',
        'placeholder' => '',
      ],
      [
        'key' => 'text_row_field_padding_bottom',
        'label' => __('Espacement bas', 'mlmi-builder'),
        'name' => 'padding_bottom',
        'type' => 'select',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '50',
          'class' => '',
          'id' => '',
        ],
        'choices' => $padding_bottom_options,
        'default_value' => $padding_bottom_default,
        'allow_null' => 0,
        'multiple' => 0,
        'ui' => 0,
        'ajax' => 0,
        'return_format' => 'value',
        'placeholder' => '',
      ],
    ];
    $additional_standard_row_fields = apply_filters('mlmi_builder_standard_row_add_fields', []);
    $additional_standard_row_group = apply_filters('mlmi_builder_standard_row_add_group', '');
    $standard_row_fields = array_merge($standard_row_fields, $additional_standard_row_fields);
    if ($additional_standard_row_group){
      $standard_row_fields[] = [
        'key' => 'mlmi_builder_cloned_'.$additional_standard_row_group,
        'type' => 'clone',
        'clone' => [
          0 => $additional_standard_row_group,
        ],
        'display' => 'seamless',
        'layout' => 'block',
      ];
    }
    
    $content_type_text_row = [
      'key' => 'mlmi_builder_layout_text_row',
      'fields' => $standard_row_fields,
      'location' => [],
      'menu_order' => 0,
      'position' => 'normal',
      'style' => 'seamless',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'hide_on_screen' => '',
      'active' => 0,
      'description' => '',
    ];
    $content_type_text_row = apply_filters('mlmi_builder_content_type_text_row', $content_type_text_row);
    acf_add_local_field_group($content_type_text_row);
    
    /*
    *   Content type: Gallery
    */
    $accept_mime_types = apply_filters('mlmi_builder_accept_mime_types', 'jpg, jpeg');
    $gallery_row_fields = [
      [
        'key' => 'gallery_row_field_gallery',
        'label' => __('Galerie d\'images', 'mlmi-builder'),
        'name' => 'gallery',
        'type' => 'gallery',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '',
          'class' => '',
          'id' => '',
        ],
        'min' => '',
        'max' => '',
        'insert' => 'append',
        'library' => 'all',
        'min_width' => '',
        'min_height' => '',
        'min_size' => '',
        'max_width' => '',
        'max_height' => '',
        'max_size' => '',
        'mime_types' => $accept_mime_types,
      ],
    ];
    $additional_gallery_row_fields = apply_filters('mlmi_builder_gallery_row_add_fields', []);
    $additional_gallery_row_group = apply_filters('mlmi_builder_gallery_row_add_group', '');
    $gallery_row_fields = array_merge($gallery_row_fields, $additional_gallery_row_fields);
    if ($additional_gallery_row_group){
      $gallery_row_fields[] = [
        'key' => 'mlmi_builder_cloned_'.$additional_gallery_row_group,
        'type' => 'clone',
        'clone' => [
          0 => $additional_gallery_row_group,
        ],
        'display' => 'seamless',
        'layout' => 'block',
      ];
    }
    $content_type_gallery_row = [
      'key' => 'mlmi_builder_layout_gallery_row',
      'fields' => $gallery_row_fields,
      'location' => [],
      'menu_order' => 0,
      'position' => 'normal',
      'style' => 'default',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'hide_on_screen' => '',
      'active' => 0,
      'description' => '',
    ];
    $content_type_gallery_row = apply_filters('mlmi_builder_content_type_gallery_row', $content_type_gallery_row);
    acf_add_local_field_group($content_type_gallery_row);
    
    /*
    * Content Type: Shortcode
    */
    $code_row_fields = [
      [
        'key' => 'code_row_field_shortcode',
        'label' => '',
        'name' => 'shortcode',
        'type' => 'text',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '',
          'class' => 'no-label',
          'id' => '',
        ],
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
      ],
    ];
    $additional_code_row_fields = apply_filters('mlmi_builder_code_row_add_fields', []);
    $additional_code_row_group = apply_filters('mlmi_builder_code_row_add_group', '');
    $code_row_fields = array_merge($code_row_fields, $additional_code_row_fields);
    if ($additional_code_row_group){
      $code_row_fields[] = [
        'key' => 'mlmi_builder_cloned_'.$additional_code_row_group,
        'type' => 'clone',
        'clone' => [
          0 => $additional_code_row_group,
        ],
        'display' => 'seamless',
        'layout' => 'block',
      ];
    }
    $content_type_code_row = [
      'key' => 'mlmi_builder_layout_code_row',
      'fields' => $code_row_fields,
      'location' => [],
      'menu_order' => 0,
      'position' => 'normal',
      'style' => 'default',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'hide_on_screen' => '',
      'active' => 0,
      'description' => '',
    ];
    $content_type_code_row = apply_filters('mlmi_builder_content_type_code_row', $content_type_code_row);
    acf_add_local_field_group($content_type_code_row);
    
    /*
    *   Layout types
    */
    $layout_types = [
      "text_row" => [
        "label" => __('Rangée standard', 'mlmi-builder'),
        "group" => 'mlmi_builder_layout_text_row'
      ],
      "code_row" => [
        "label" => __('Rangée programmée', 'mlmi-builder'),
        "group" => 'mlmi_builder_layout_code_row'
      ],
      "gallery_row" => [
        "label" => __('Galerie d\'images', 'mlmi-builder'),
        "group" => 'mlmi_builder_layout_gallery_row'
      ],
    ];
    $layout_types = apply_filters('mlmi_builder_layout_types', $layout_types);
    
    /*
    *   Layouts
    */
    $layouts = [];
    foreach ($layout_types as $key => $settings) {
      $layouts[$key] = mlmi_builder_create_acf_layout($key, $settings);
    }
    
    /*
    *   Locations
    */
    $builder_location = [
      [
        [
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'page',
        ],
        [
          'param' => 'page_template',
          'operator' => '==',
          'value' => 'views/grid.blade.php',
        ],
      ],
    ];
    $builder_location = apply_filters('mlmi_builder_location', $builder_location);
    
    /*
    *   Section fields
    */
    $section_fields = [
      [
        'key' => 'mlmi_builder_tab_section',
        'label' => '<span class="dashicons dashicons-editor-table"></span>',
        'name' => '',
        'type' => 'tab',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '',
          'class' => '',
          'id' => '',
        ],
        'placement' => 'left',
        'endpoint' => 0,
      ],
      [
        'key' => 'mlmi_builder_field_rows',
        'label' => '',
        'name' => 'rows',
        'type' => 'flexible_content',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '',
          'class' => 'mlmi-builder-row',
          'id' => '',
        ],
        'layouts' => $layouts,
        'button_label' => __('Ajouter une rangée', 'mlmi-builder'),
        'min' => '',
        'max' => '',
      ],
      [
        'key' => 'mlmi_builder_tab_presentation',
        'label' => '<span class="dashicons dashicons-desktop"></span>',
        'name' => '',
        'type' => 'tab',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '',
          'class' => '',
          'id' => '',
        ],
        'placement' => 'top',
        'endpoint' => 0,
      ],
      [
        'key' => 'mlmi_builder_field_section_id',
        'label' => __('ID de section', 'mlmi-builder'),
        'name' => 'section_id',
        'type' => 'text',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '50',
          'class' => '',
          'id' => '',
        ],
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
      ],
      [
        'key' => 'mlmi_builder_field_section_class',
        'label' => __('Classes de section', 'mlmi-builder'),
        'name' => 'section_class',
        'type' => 'text',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '50',
          'class' => '',
          'id' => '',
        ],
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
      ],
      [
        'key' => 'mlmi_builder_field_section_padding_top',
        'label' => __('Espacement haut', 'mlmi-builder'),
        'name' => 'padding_top',
        'type' => 'select',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '50',
          'class' => '',
          'id' => '',
        ],
        'choices' => $padding_top_options,
        'default_value' => $padding_top_default,
        'allow_null' => 0,
        'multiple' => 0,
        'ui' => 0,
        'ajax' => 0,
        'return_format' => 'value',
        'placeholder' => '',
      ],
      [
        'key' => 'mlmi_builder_field_section_padding_bottom',
        'label' => __('Espacement bas', 'mlmi-builder'),
        'name' => 'padding_bottom',
        'type' => 'select',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '50',
          'id' => '',
        ],
        'choices' => $padding_bottom_options,
        'default_value' => $padding_bottom_default,
        'allow_null' => 0,
        'multiple' => 0,
        'ui' => 0,
        'ajax' => 0,
        'return_format' => 'value',
        'placeholder' => '',
      ],
    ];
    $additional_section_fields = apply_filters('mlmi_builder_section_add_fields', []);
    $additional_section_group = apply_filters('mlmi_builder_section_add_group', '');
    $section_fields = array_merge($section_fields, $additional_section_fields);
    if ($additional_section_group){
      $cloned_fields = [
        [
          'key' => 'mlmi_builder_cloned_'.$additional_section_group,
          'name' => 'mlmi_builder_cloned_'.$additional_section_group,
          'type' => 'clone',
          'clone' => [
            0 => $additional_section_group,
          ],
          'display' => 'seamless',
          'layout' => 'block',
        ]
      ];
      array_splice($section_fields, 3, 0, $cloned_fields);
    }
    
    /*
    *   MLMI Builder
    */
    $config = [
      'key' => 'mlmi_builder_main',
      'title' => __('MLMI Builder', 'mlmi-builder'),
      'fields' => [
        [
          'key' => 'mlmi_builder_field_sections',
          'label' => '',
          'name' => 'sections',
          'type' => 'repeater',
          'instructions' => '',
          'required' => 0,
          'wpml_cf_preferences' => 3,
          'conditional_logic' => 0,
          'wrapper' => [
            'width' => '',
            'class' => 'mlmi-builder-section no-label',
            'id' => '',
          ],
          'collapsed' => '',
          'min' => 1,
          'max' => 0,
          'layout' => 'block',
          'button_label' => __('Ajouter une section', 'mlmi-builder'),
          'sub_fields' => $section_fields
        ],
      ],
      'location' => $builder_location,
      'menu_order' => 0,
      'position' => 'normal',
      'style' => 'seamless',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'hide_on_screen' => $hide_on_screen,
      'active' => 1,
      'description' => '',
    ];
    
    /*
    *   Filter and add global builder group
    */
    $config = apply_filters('mlmi_builder_config', $config);
    acf_add_local_field_group($config);
  });
  
endif;
