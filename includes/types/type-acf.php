<?php
/*
* MLMI Builder
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
    'group' => 'mlmi_builder_layout_text_row',
    'options' => false,
  ], $settings);
  
  // Get cloned group
  $cloned = [
    $settings['group']
  ];
  
  // Get cloned options
  if ($settings['options'] == true && $key != 'text_row') {
    $cloned[] = 'text_row_tab_options';
    $cloned[] = 'text_row_field_padding_top';
    $cloned[] = 'text_row_field_padding_bottom';
    $cloned[] = 'text_row_field_row_class';
    $cloned[] = 'text_row_field_row_id';
  }
  
  // Generated layout
  $layout = [
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
        'clone' => $cloned,
        'display' => 'seamless',
        'layout' => 'block',
        'prefix_label' => 0,
        'prefix_name' => 0,
      ],
    ],
    'min' => '',
    'max' => '',
  ];
  return $layout;
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
    * Grid system base
    */
    $grid_system_base = apply_filters('mlmi_builder_grid_columns', 12);
    
    /*
    * Number of columns allowed
    */
    // global $columns_choices;
    global $columns_choices;
    $columns_choices = apply_filters('mlmi_builder_columns_choices', [
      1 => __('1 colonne', 'mlmi-builder'),
      2 => __('2 colonnes', 'mlmi-builder'),
      3 => __('3 colonnes', 'mlmi-builder')
    ]);
    
    /*
    * Columns conditional logic
    */
    function mlmi_builder_get_conditional_logic($column) {
      global $columns_choices;
      $logic = [];
      
      /* Standard logic */
      if ($column == 2) {
        $logic[] = [
          [
            'field' => 'text_row_field_cols_num',
            'operator' => '==',
            'value' => 2,
          ],
        ];
      }
      if ($column == 2 || $column == 3) {
        $logic[] = [
          [
            'field' => 'text_row_field_cols_num',
            'operator' => '==',
            'value' => 3,
          ],
        ];
      }
      
      /* Custom logic */
      foreach ($columns_choices as $key => $value) {
        if (is_numeric($key)) {
          continue;
        }
        
        if ($column == 2 && intval($key) == 2) {
          $logic[] = [
            [
              'field' => 'text_row_field_cols_num',
              'operator' => '==',
              'value' => $key,
            ],
          ];
        }
        
        if (($column == 2 || $column == 3) && intval($key) == 3) {
          $logic[] = [
            [
              'field' => 'text_row_field_cols_num',
              'operator' => '==',
              'value' => $key,
            ],
          ];
        }
      }
      return $logic;
    }
    
    /*
    * Content Type: Standard Row
    */
    $content_type_text_row_column_options = apply_filters('mlmi_builder_column_options', []);
    $padding_bottom_options = apply_filters('mlmi_builder_padding_bottom_options', [
      'pb-md-15' => '15',
      'pb-md-12' => '12',
      'pb-md-10' => '10',
      'pb-md-9' => '9',
      'pb-md-8' => '8',
      'pb-md-7' => '7',
      'pb-md-6' => '6',
      'pb-md-5' => '5',
      'pb-md-4' => '4',
      'pb-md-3' => '3',
      'pb-md-2' => '2',
      'pb-md-1' => '1',
      'pb-md-0' => __('Aucun', 'mlmi-builder'),
      'pb-auto' => __('Auto', 'mlmi-builder'),
    ]);
    $padding_bottom_default = apply_filters('mlmi_builder_padding_bottom_default', 'pb-auto');
    $padding_top_options = apply_filters('mlmi_builder_padding_top_options', [
      'pt-md-15' => '15',
      'pt-md-12' => '12',
      'pt-md-10' => '10',
      'pt-md-9' => '9',
      'pt-md-8' => '8',
      'pt-md-7' => '7',
      'pt-md-6' => '6',
      'pt-md-5' => '5',
      'pt-md-4' => '4',
      'pt-md-3' => '3',
      'pt-md-2' => '2',
      'pt-md-1' => '1',
      'pt-md-0' => __('Aucun', 'mlmi-builder'),
      'pt-auto' => __('Auto', 'mlmi-builder'),
    ]);
    $padding_top_default = apply_filters('mlmi_builder_padding_top_default', 'pt-auto');
    
    /*
    * Container options
    */
    $container_options = apply_filters('mlmi_builder_container_options', [
      0 => __('Aucun', 'mlmi-builder'),
      'container' => __('Standard', 'mlmi-builder'),
    ]);
    
    /*
    * Background color options
    */
    $background_color_options = apply_filters('mlmi_builder_background_color_options', [
      'transparent' => '<span class="badge badge-transparent">'.__('transparent', 'mlmi-builder').'</span>',
      'white' => '<span class="badge badge-white">'.__('blanc', 'mlmi-builder').'</span>',
      'black' => '<span class="badge badge-black">'.__('noir', 'mlmi-builder').'</span>',
    ]);
    
    /*
    * Column options
    */
    $column_choices = [];
    $offset_choices = [];
    for ($i = 1; $i <= $grid_system_base; $i++) {
      $column_choices[$i] = $i;
    }
    for ($o = 0; $o <= $grid_system_base; $o++) {
      $offset_choices[$o] = $o;
    }
    $column_group_option_fields = [
      [
        'key' => 'column_width',
        'label' => __('Largeur', 'mlmi-builder'),
        'name' => 'column_width',
        'type' => 'select',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '',
          'class' => 'flex-field',
          'id' => '',
        ],
        'choices' => $column_choices,
        'default_value' => $i - 1,
        'return_format' => 'value',
      ],
      [
        'key' => 'column_offset',
        'label' => __('Décalage', 'mlmi-builder'),
        'name' => 'column_offset',
        'type' => 'select',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '',
          'class' => 'flex-field',
          'id' => '',
        ],
        'choices' => $offset_choices,
        'default_value' => 0,
        'return_format' => 'value',
      ],
      [
        'key' => 'column_order',
        'label' => __('Ordre', 'mlmi-builder'),
        'name' => 'column_order',
        'type' => 'select',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '',
          'class' => 'flex-field',
          'id' => '',
        ],
        'choices' => [
          2 => __('Standard', 'mlmi-builder'),
          1 => __('En premier', 'mlmi-builder'),
          3 => __('En dernier', 'mlmi-builder')
        ],
        'default_value' => 2,
        'return_format' => 'value',
      ],
      [
        'key' => 'column_options',
        'label' => '',
        'name' => 'column_options',
        'type' => 'checkbox',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '',
          'class' => '',
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
    ];
    
    /*
    * Standard row fields
    */
    $standard_row_fields = [
      'text_row_tab_content' => [
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
      'text_row_field_col_1' => [
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
          'class' => 'mlmi-builder-column no-label d-none',
          'id' => '',
        ],
        'default_value' => '',
        'tabs' => 'all',
        'toolbar' => 'full',
        'media_upload' => 1,
        'delay' => 0,
      ],
      'text_row_field_col_2' => [
        'key' => 'text_row_field_col_2',
        'label' => '',
        'name' => 'col_2',
        'type' => 'wysiwyg',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => mlmi_builder_get_conditional_logic(2),
        'wrapper' => [
          'width' => '33.333',
          'class' => 'mlmi-builder-column no-label d-none',
          'id' => '',
        ],
        'default_value' => '',
        'tabs' => 'all',
        'toolbar' => 'full',
        'media_upload' => 1,
        'delay' => 0,
      ],
      'text_row_field_col_3' => [
        'key' => 'text_row_field_col_3',
        'label' => '',
        'name' => 'col_3',
        'type' => 'wysiwyg',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => mlmi_builder_get_conditional_logic(3),
        'wrapper' => [
          'width' => '33.333',
          'class' => 'mlmi-builder-column no-label d-none',
          'id' => '',
        ],
        'default_value' => '',
        'tabs' => 'all',
        'toolbar' => 'full',
        'media_upload' => 1,
        'delay' => 0,
      ],
      'text_row_tab_options' => [
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
      'text_row_field_cols_num' => [
        'key' => 'text_row_field_cols_num',
        'label' => __('Nombre de colonnes', 'mlmi-builder'),
        'name' => 'cols_num',
        'type' => 'select',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '',
          'class' => 'select-cols-number',
          'id' => '',
        ],
        'choices' => $columns_choices,
        'allow_null' => 0,
        'multiple' => 0,
        'ui' => 0,
        'ajax' => 0,
        'return_format' => 'value',
        'placeholder' => '',
      ],
      'text_row_field_col_1_group' => [
        'key' => 'text_row_field_col_1_group',
        'label' => __('Colonne 1', 'mlmi-builder'),
        'name' => 'col_1_group',
        'type' => 'group',
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '33.333',
          'class' => 'no-group column-label mlmi-builder-column-option',
          'id' => '',
        ),
        'layout' => 'block',
        'sub_fields' => $column_group_option_fields,
      ],
      'text_row_field_col_2_group' => [
        'key' => 'text_row_field_col_2_group',
        'label' => __('Colonne 2', 'mlmi-builder'),
        'name' => 'col_2_group',
        'type' => 'group',
        'wpml_cf_preferences' => 3,
        'conditional_logic' => mlmi_builder_get_conditional_logic(2),
        'wrapper' => array(
          'width' => '33.333',
          'class' => 'no-group column-label mlmi-builder-column-option',
          'id' => '',
        ),
        'layout' => 'block',
        'sub_fields' => $column_group_option_fields,
      ],
      'text_row_field_col_3_group' => [
        'key' => 'text_row_field_col_3_group',
        'label' => __('Colonne 3', 'mlmi-builder'),
        'name' => 'col_3_group',
        'type' => 'group',
        'wpml_cf_preferences' => 3,
        'conditional_logic' => mlmi_builder_get_conditional_logic(3),
        'wrapper' => array(
          'width' => '33.333',
          'class' => 'no-group column-label mlmi-builder-column-option',
          'id' => '',
        ),
        'layout' => 'block',
        'sub_fields' => $column_group_option_fields,
      ],
      'text_row_field_padding_top' => [
        'key' => 'text_row_field_padding_top',
        'label' => __('Espacement haut', 'mlmi-builder'),
        'name' => 'padding_top',
        'type' => 'select',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '25',
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
      'text_row_field_padding_bottom' => [
        'key' => 'text_row_field_padding_bottom',
        'label' => __('Espacement bas', 'mlmi-builder'),
        'name' => 'padding_bottom',
        'type' => 'select',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '25',
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
      'text_row_field_row_class' => [
        'key' => 'text_row_field_row_class',
        'label' => __('Classes de rangée', 'mlmi-builder'),
        'name' => 'row_class',
        'type' => 'text',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '25',
          'class' => '',
          'id' => '',
        ],
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
      ],
      'text_row_field_row_id' => [
        'key' => 'text_row_field_row_id',
        'label' => __('ID de rangée', 'mlmi-builder'),
        'name' => 'row_id',
        'type' => 'text',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '25',
          'class' => '',
          'id' => '',
        ],
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
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
      'text_row' => [
        'label' => __('Rangée standard', 'mlmi-builder'),
        'group' => 'mlmi_builder_layout_text_row',
        'options' => true,
      ],
      'code_row' => [
        'label' => __('Rangée programmée', 'mlmi-builder'),
        'group' => 'mlmi_builder_layout_code_row',
        'options' => false,
      ],
      'gallery_row' => [
        'label' => __('Galerie d\'images', 'mlmi-builder'),
        'group' => 'mlmi_builder_layout_gallery_row',
        'options' => false,
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
    $builder_location = apply_filters('mlmi_builder_location', []);
    
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
        'key' => 'mlmi_builder_field_section_bg_color',
        'label' => __('Couleur d\'arrière-plan', 'mlmi-builder'),
        'name' => 'bg_color',
        'type' => 'radio',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '50',
          'class' => '',
          'id' => '',
        ],
        'choices' => $background_color_options,
        'allow_null' => 0,
        'other_choice' => 0,
        'default_value' => '',
        'layout' => 'horizontal',
        'return_format' => 'value',
        'save_other_choice' => 0,
      ],
      [
        'key' => 'mlmi_builder_field_section_use_container',
        'label' => __('Conteneur', 'mlmi-builder'),
        'name' => 'use_container',
        'type' => 'select',
        'instructions' => '',
        'required' => 1,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '50',
          'class' => '',
          'id' => '',
        ],
        'choices' => $container_options,
        'default_value' => 'container',
        'allow_null' => 0,
        'multiple' => 0,
        'ui' => 0,
        'return_format' => 'value',
        'ajax' => 0,
        'placeholder' => '',
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
          'width' => '25',
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
          'width' => '25',
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
          'width' => '25',
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
        'key' => 'mlmi_builder_field_section_id',
        'label' => __('ID de section', 'mlmi-builder'),
        'name' => 'section_id',
        'type' => 'text',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '25',
          'class' => '',
          'id' => '',
        ],
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
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
          'min' => 0,
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
