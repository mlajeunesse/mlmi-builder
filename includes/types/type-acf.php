<?php
/*
* MLMI Builder
* Advanced Custom Fields — Basic fields
*/

/*
* Dynamically create ACF layout using basic settings
*/
function mlmi_builder_create_acf_layout($key, $settings) {
  // Default settings
  $settings = array_merge([
    'name' => 'row',
    'label' => __('Rangée', 'mlmi-builder'),
    'display' => 'block',
    'group' => 'mlmi_builder_layout_text_row',
    'dashicon' => false,
    'options' => false,
    'subtitle' => false,
  ], $settings);
  
  $cloned = [];
  
  // Get cloned subtitle
  if ($settings['subtitle'] == true && $key != 'text_row') {
    $cloned['text_row_field_row_subtitle'] = 'text_row_field_row_subtitle';
    $cloned['text_row_field_row_subtitle_tag'] = 'text_row_field_row_subtitle_tag';
  }
  
  // Get cloned group
  $cloned[] = $settings['group'];
  
  // Get cloned options
  if ($settings['options'] == true && $key != 'text_row') {
    $cloned['text_row_tab_options'] = 'text_row_tab_options';
    $cloned['text_row_field_padding_top'] = 'text_row_field_padding_top';
    $cloned['text_row_field_padding_bottom'] = 'text_row_field_padding_bottom';
    $cloned['text_row_field_padding_top_md'] = 'text_row_field_padding_top_md';
    $cloned['text_row_field_padding_bottom_md'] = 'text_row_field_padding_bottom_md';
    $cloned['text_row_field_row_class'] = 'text_row_field_row_class';
    $cloned['text_row_field_row_id'] = 'text_row_field_row_id';
  }
  
  // Generated layout
  $layout = [
    'key' => 'mlmi_builder_layout_'.$key,
    'name' => $key,
    'label' => $settings['label'],
    'display' => $settings['display'],
    'sub_fields' => [
      'mlmi_builder_cloned_group_'.$key => [
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
  
  if ($settings['dashicon']) {
    array_insert_before('mlmi_builder_cloned_group_'.$key, $layout['sub_fields'], 'tab-'.$settings['dashicon'], [
      'key' => 'tab-'.$settings['dashicon'],
      'label' => '<span class="dashicons dashicons-'.$settings['dashicon'].'"></span>',
      'name' => '',
      'type' => 'tab',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => [
        'width' => '',
        'class' => '',
        'id' => '',
      ],
      'placement' => 'left',
      'endpoint' => 0,
    ]);
  }
  return $layout;
}

if (function_exists('acf_add_local_field_group')) {
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
    * Builder options
    */
    $grid_system_base = apply_filters('mlmi_builder_grid_columns', 12);
    $use_tabs_system = apply_filters('mlmi_builder_use_tabs_system', false);
    $use_gallery_row = apply_filters('mlmi_builder_use_gallery_row', false);
    $use_subtitle = apply_filters('mlmi_builder_use_subtitle', false);
    
    /*
    * Padding options
    */
    $padding_bottom_options = apply_filters('mlmi_builder_padding_bottom_options', [
      '15' => '15',
      '12' => '12',
      '10' => '10',
      '9' => '9',
      '8' => '8',
      '7' => '7',
      '6' => '6',
      '5' => '5',
      '4' => '4',
      '3' => '3',
      '2' => '2',
      '1' => '1',
      '0' => __('Aucun', 'mlmi-builder'),
      'auto' => __('Auto', 'mlmi-builder'),
    ]);
    $padding_bottom_default = apply_filters('mlmi_builder_padding_bottom_default', 'auto');
    $padding_top_options = apply_filters('mlmi_builder_padding_top_options', [
      '15' => '15',
      '12' => '12',
      '10' => '10',
      '9' => '9',
      '8' => '8',
      '7' => '7',
      '6' => '6',
      '5' => '5',
      '4' => '4',
      '3' => '3',
      '2' => '2',
      '1' => '1',
      '0' => __('Aucun', 'mlmi-builder'),
      'auto' => __('Auto', 'mlmi-builder'),
    ]);
    $padding_top_default = apply_filters('mlmi_builder_padding_top_default', 'auto');
    
    /*
    * Number of columns allowed
    */
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
    * Builder Plugin: Tabs
    */
    $tabs_formats_choices = apply_filters('mlmi_builder_tabset_format_choices', [
      'default' => __('Par défaut', 'mlmi-builder'),
    ]);
    $tabs_fields = [
      'mlmi_builder_tabs_tab' => [
        'key' => 'mlmi_builder_tabs_tab',
        'label' => '<span class="dashicons dashicons-category"></span>',
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
      'mlmi_builder_tab_cycle' => [
        'key' => 'mlmi_builder_tab_cycle',
        'label' => 'Onglet',
        'name' => 'tab_cycle',
        'type' => 'select',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => 33,
          'class' => '',
          'id' => '',
        ],
        'choices' => [
          'tab_none' => 'Par défaut',
          'tab_group' => 'Nouveau groupe d\'onglets',
          'tab_start' => 'Nouvel onglet',
          'tab_end' => 'Hors du groupe d\'onglets',
        ],
        'default_value' => [
        ],
        'allow_null' => 0,
        'multiple' => 0,
        'ui' => 0,
        'return_format' => 'value',
        'ajax' => 0,
        'placeholder' => '',
      ],
      'mlmi_builder_tab_label' => [
        'key' => 'mlmi_builder_tab_label',
        'label' => 'Libellé',
        'name' => 'tab_label',
        'type' => 'text',
        'instructions' => '',
        'required' => 1,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => [
          [
            [
              'field' => 'mlmi_builder_tab_cycle',
              'operator' => '==',
              'value' => 'tab_start',
            ],
          ],
          [
            [
              'field' => 'mlmi_builder_tab_cycle',
              'operator' => '==',
              'value' => 'tab_group',
            ],
          ],
        ],
        'wrapper' => [
          'width' => 34,
          'class' => '',
          'id' => '',
        ],
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
      ],
      'mlmi_builder_tabset_format' => [
        'key' => 'mlmi_builder_tabset_format',
        'label' => __('Format', 'mlmi-builder'),
        'name' => 'tabset_format',
        'type' => 'select',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => [
          [
            [
              'field' => 'mlmi_builder_tab_cycle',
              'operator' => '==',
              'value' => 'tab_group',
            ],
          ],
        ],
        'wrapper' => [
          'width' => 33,
          'class' => '',
          'id' => '',
        ],
        'choices' => $tabs_formats_choices,
        'allow_null' => 0,
        'multiple' => 0,
        'ui' => 0,
        'ajax' => 0,
        'return_format' => 'value',
        'placeholder' => '',
      ],
      'mlmi_builder_tabset_padding_top' => [
        'key' => 'mlmi_builder_tabset_padding_top',
        'label' => __('Haut', 'mlmi-builder'),
        'name' => 'tabset_padding_top',
        'type' => 'select',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => [
          [
            [
              'field' => 'mlmi_builder_tab_cycle',
              'operator' => '==',
              'value' => 'tab_group',
            ],
          ],
        ],
        'wrapper' => [
          'width' => '25',
          'class' => 'clear-left',
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
      'mlmi_builder_tabset_padding_bottom' => [
        'key' => 'mlmi_builder_tabset_padding_bottom',
        'label' => __('Bas', 'mlmi-builder'),
        'name' => 'tabset_padding_bottom',
        'type' => 'select',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => [
          [
            [
              'field' => 'mlmi_builder_tab_cycle',
              'operator' => '==',
              'value' => 'tab_group',
            ],
          ],
        ],
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
      'mlmi_builder_tabset_class' => [
        'key' => 'mlmi_builder_tabset_class',
        'label' => __('Classes', 'mlmi-builder'),
        'name' => 'tabset_class',
        'type' => 'text',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => [
          [
            [
              'field' => 'mlmi_builder_tab_cycle',
              'operator' => '==',
              'value' => 'tab_group',
            ],
          ],
        ],
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
      'mlmi_builder_tabset_id' => [
        'key' => 'mlmi_builder_tabset_id',
        'label' => __('ID de bloc', 'mlmi-builder'),
        'name' => 'tabset_id',
        'type' => 'text',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => [
          [
            [
              'field' => 'mlmi_builder_tab_cycle',
              'operator' => '==',
              'value' => 'tab_group',
            ],
          ],
        ],
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
    
    /*
    * Content Type: Standard Row
    */
    $content_type_text_row_column_options = apply_filters('mlmi_builder_column_options', []);
    
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
    if (apply_filters('mlmi_builder_background_color_custom_choice', false) === true) {
      $background_color_options['custom'] = '<span class="badge badge-transparent">'.__('personnalisé', 'mlmi-builder').'</span>';
    }
    
    /*
    * Background image options
    */
    $background_image_options = apply_filters('mlmi_builder_background_image_options', [
      'bg-container' => __('Appliquer au conteneur', 'mlmi-builder'),
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
      'column_width' => [
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
      'column_offset' => [
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
      'column_order' => [
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
      'column_options' => [
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
          'width' => 50,
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
      'text_row_field_cols_overflow_option' => [
        'key' => 'text_row_field_cols_overflow_option',
        'label' => __('Flux mobile', 'mlmi-builder'),
        'name' => 'overflow_option',
        'type' => 'select',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => 50,
          'class' => '',
          'id' => '',
        ],
        'choices' => [
          'none' => __('Colonnes distinctes', 'mlmi-builder'),
          'mobile-reverse' => __('Ordre inversé', 'mlmi-builder'),
          'overflow-content' => __('Texte en continu', 'mlmi-builder'),
        ],
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
        'wrapper' => [
          'width' => '33.333',
          'class' => 'no-group column-label mlmi-builder-column-option',
          'id' => '',
        ],
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
        'wrapper' => [
          'width' => '33.333',
          'class' => 'no-group column-label mlmi-builder-column-option',
          'id' => '',
        ],
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
        'wrapper' => [
          'width' => '33.333',
          'class' => 'no-group column-label mlmi-builder-column-option',
          'id' => '',
        ],
        'layout' => 'block',
        'sub_fields' => $column_group_option_fields,
      ],
      'text_row_field_padding_top' => [
        'key' => 'text_row_field_padding_top',
        'label' => __('Haut', 'mlmi-builder'),
        'name' => 'padding_top',
        'type' => 'select',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '16.667',
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
        'label' => __('Bas', 'mlmi-builder'),
        'name' => 'padding_bottom',
        'type' => 'select',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '16.667',
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
      'text_row_field_padding_top_md' => [
        'key' => 'text_row_field_padding_top_md',
        'label' => __('Haut +', 'mlmi-builder'),
        'name' => 'padding_top_md',
        'type' => 'select',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '16.667',
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
      'text_row_field_padding_bottom_md' => [
        'key' => 'text_row_field_padding_bottom_md',
        'label' => __('Bas +', 'mlmi-builder'),
        'name' => 'padding_bottom_md',
        'type' => 'select',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '16.667',
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
        'label' => __('Classes', 'mlmi-builder'),
        'name' => 'row_class',
        'type' => 'text',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '16.667',
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
          'width' => '16.667',
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
      $standard_row_fields['mlmi_builder_cloned_'.$additional_standard_row_group] = [
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
    if ($use_subtitle) {
      array_insert_after('text_row_tab_content', $content_type_text_row['fields'], 'text_row_field_row_subtitle', [
        'key' => 'text_row_field_row_subtitle',
        'label' => 'Sous-titre',
        'name' => 'row_subtitle',
        'type' => 'text',
        'wrapper' => [
          'width' => 80,
          'class' => 'no-label',
        ],
      ]);
      array_insert_after('text_row_field_row_subtitle', $content_type_text_row['fields'], 'text_row_field_row_subtitle_tag', [
        'key' => 'text_row_field_row_subtitle_tag',
        'label' => 'Tag HTML',
        'name' => 'row_subtitle_tag',
        'type' => 'select',
        'choices' => [
          'h2' => 'Sous-titre h2',
          'h3' => 'Sous-titre h3',
          'h4' => 'Sous-titre h4',
        ],
        'wrapper' => [
          'width' => 20,
          'class' => 'no-label',
        ]
      ]);
    }
    $content_type_text_row = apply_filters('mlmi_builder_content_type_text_row', $content_type_text_row);
    
    acf_add_local_field_group($content_type_text_row);
    
    /*
    * Content type: Gallery
    */
    $accept_mime_types = apply_filters('mlmi_builder_accept_mime_types', 'jpg, jpeg, svg, webp');
    if ($use_gallery_row) {
      $gallery_row_fields = [
        'text_row_tab_content' => [
          'key' => 'text_row_tab_content',
          'label' => '<span class="dashicons dashicons-format-gallery"></span>',
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
        'gallery_row_field_gallery' => [
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
            'class' => 'no-label',
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
        $gallery_row_fields['mlmi_builder_cloned_'.$additional_gallery_row_group] = [
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
    }
    
    /*
    * Content Type: Shortcode
    */
    $shortcode_items = apply_filters('mlmi_builder_shortcode_items', [
      'shortcode' => __('Shortcode', 'mlmi-builder'),
    ]);
    $shortcode_groups = [];
    foreach ($shortcode_items as $key => $item) {
      if (is_array($item)) {
        if (count($item) >= 2) {
          for ($i = 1; $i < count($item); $i++) {
            if ($i === 1) $shortcode_groups[$key] = [];
            $shortcode_groups[$key][] = $item[$i];
          }
        }
        $shortcode_items[$key] = $item[0];
      }
    }
    $code_row_fields = [
      'code_row_field_template_item' => [
        'key' => 'code_row_field_template_item',
        'label' => __('Item', 'mlmi-builder'),
        'name' => 'template_item',
        'type' => 'select',
        'instructions' => '',
        'required' => 1,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '50',
          'class' => 'no-label',
          'id' => '',
        ],
        'choices' => $shortcode_items,
        'default_value' => 'container',
        'allow_null' => 0,
        'multiple' => 0,
        'ui' => 0,
        'return_format' => 'value',
        'ajax' => 0,
        'placeholder' => '',
      ],
      'code_row_field_shortcode' => [
        'key' => 'code_row_field_shortcode',
        'label' => '',
        'name' => 'shortcode',
        'type' => 'text',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => [
          [
            [
              'field' => 'code_row_field_template_item',
              'operator' => '==',
              'value' => 'shortcode',
            ],
          ],
        ],
        'wrapper' => [
          'width' => '50',
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
    if ($additional_code_row_group) {
      $code_row_fields['mlmi_builder_cloned_'.$additional_code_row_group] = [
        'key' => 'mlmi_builder_cloned_'.$additional_code_row_group,
        'type' => 'clone',
        'clone' => [$additional_code_row_group],
        'display' => 'seamless',
        'layout' => 'block',
      ];
    }
    
    foreach ($shortcode_groups as $key => $field_ids) {
      foreach ($field_ids as $field_id) {
        $field = get_field_object($field_id);
        $unset_keys = ['ID', 'prefix', 'menu_order', 'value', 'id', 'class', 'parent', '_name', '_valid'];
        foreach ($unset_keys as $unset_key) {
          unset($field[$unset_key]);
        }
        $field['key'] = 'code_row_conditional_'.$field_id;
        $field['conditional_logic'] = [
          [
            'field' => 'code_row_field_template_item',
            'operator' => '==',
            'value' => $key,
          ]
        ];
        $code_row_fields[$field['key']] = $field;
      }
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
    * Layout types
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
    ];
    if ($use_gallery_row) {
      $layout_types[] = [
        'label' => __('Galerie d\'images', 'mlmi-builder'),
        'group' => 'mlmi_builder_layout_gallery_row',
        'options' => false,
      ];
    }
    $layout_types = apply_filters('mlmi_builder_layout_types', $layout_types);
    
    /*
    * Layouts
    */
    $layouts = [];
    foreach ($layout_types as $key => $settings) {
      $layouts[$key] = mlmi_builder_create_acf_layout($key, $settings);
    }
    
    /*
    * Locations
    */
    $builder_location = apply_filters('mlmi_builder_location', []);
    
    /*
    * Section fields
    */
    $background_image_types = apply_filters('mlmi_builder_background_image_types', [
      'auto' => [
        'title' => __('Automatique', 'mlmi-builder'),
        'fields' => ['horizontal_align', 'vertical_align', 'size', 'options'],
      ],
      'ratio' => [
        'title' => __('Ratio de l\'image', 'mlmi-builder'),
        'fields' => ['options'],
      ],
      'exact' => [
        'title' => __('Hauteur exacte', 'mlmi-builder'),
        'fields' => ['height_value', 'height_unit', 'horizontal_align', 'vertical_align', 'size', 'options'],
      ],
      'min' => [
        'title' => __('Hauteur minimum', 'mlmi-builder'),
        'fields' => ['height_value', 'height_unit', 'horizontal_align', 'vertical_align', 'size', 'options'],
      ],
      'max' => [
        'title' => __('Hauteur maximum', 'mlmi-builder'),
        'fields' => ['height_value', 'height_unit', 'horizontal_align', 'vertical_align', 'size', 'options'],
      ],
    ]);
    $background_image_choices = [];
    foreach ($background_image_types as $background_image_key => $background_image_type) {
      $background_image_choices[$background_image_key] = $background_image_type['title'];
    }
    
    function get_background_image_conditional_logic($field, $types) {
      $conditions = [];
      foreach ($types as $background_image_key => $background_image_type) {
        if (in_array($field, $background_image_type['fields'])) {
          $conditions[] = [
            [
              'field' => 'mlmi_builder_bg_height_basis',
              'operator' => '==',
              'value' => $background_image_key,
            ]
          ];
        }
      }
      return $conditions;
    }
    
    $section_fields = [
      'mlmi_builder_tab_section' => [
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
      'mlmi_builder_field_rows' => [
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
      'mlmi_builder_tab_presentation' => [
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
      'mlmi_builder_field_section_bg_image' => [
        'key' => 'mlmi_builder_field_section_bg_image',
        'label' => __('Image d\'arrière-plan', 'mlmi-builder'),
        'name' => 'bg_image',
        'type' => 'image',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '25',
          'class' => '',
          'id' => '',
        ],
        'return_format' => 'id',
        'preview_size' => 'thumbnail',
        'library' => 'all',
        'min_width' => '',
        'min_height' => '',
        'min_size' => '',
        'max_width' => '',
        'max_height' => '',
        'max_size' => '',
        'mime_types' => $accept_mime_types,
      ],
      'mlmi_builder_field_section_bg_properties' => [
        'key' => 'mlmi_builder_field_section_bg_properties',
        'label' => 'Propriétés de l\'image d\'arrière-plan',
        'name' => 'bg_properties',
        'type' => 'group',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => [
          [
            [
              'field' => 'mlmi_builder_field_section_bg_image',
              'operator' => '!=empty',
            ],
          ],
        ],
        'wrapper' => [
          'width' => '75',
          'class' => '',
          'id' => '',
        ],
        'layout' => 'block',
        'sub_fields' => [
          'mlmi_builder_bg_height_basis' => [
            'key' => 'mlmi_builder_bg_height_basis',
            'label' => __('Type d\'arrière-plan', 'mlmi-builder'),
            'name' => 'height_basis',
            'type' => 'select',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
              'width' => '50',
              'class' => 'no-label',
              'id' => '',
            ],
            'choices' => $background_image_choices,
            'default_value' => [
              0 => 'auto',
            ],
            'allow_null' => 0,
            'multiple' => 0,
            'ui' => 0,
            'return_format' => 'value',
            'ajax' => 0,
            'placeholder' => '',
          ],
          'mlmi_builder_bg_height_value' => [
            'key' => 'mlmi_builder_bg_height_value',
            'label' => __('Valeur de la hauteur', 'mlmi-builder'),
            'name' => 'height_value',
            'type' => 'number',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => get_background_image_conditional_logic('height_value', $background_image_types),
            'wrapper' => [
              'width' => '25',
              'class' => 'no-label',
              'id' => '',
            ],
            'default_value' => '',
            'placeholder' => 'Hauteur',
            'prepend' => '',
            'append' => '',
            'min' => '',
            'max' => '',
            'step' => '',
          ],
          'mlmi_builder_bg_height_unit' => [
            'key' => 'mlmi_builder_bg_height_unit',
            'label' => __('Unité de hauteur', 'mlmi-builder'),
            'name' => 'height_unit',
            'type' => 'select',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => get_background_image_conditional_logic('height_unit', $background_image_types),
            'wrapper' => [
              'width' => '25',
              'class' => 'no-label',
              'id' => '',
            ],
            'choices' => [
              'px' => 'pixels',
              'vh' => '% fenêtre',
            ],
            'default_value' => [
              'px',
            ],
            'allow_null' => 0,
            'multiple' => 0,
            'ui' => 0,
            'return_format' => 'value',
            'ajax' => 0,
            'placeholder' => '',
          ],
          'mlmi_builder_bg_horizontal_align' => [
            'key' => 'mlmi_builder_bg_horizontal_align',
            'label' => __('Alignement horizontal', 'mlmi-builder'),
            'name' => 'horizontal_align',
            'type' => 'select',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => get_background_image_conditional_logic('horizontal_align', $background_image_types),
            'wrapper' => [
              'width' => '33',
              'class' => 'no-label clear-left',
              'id' => '',
            ],
            'choices' => [
              'center' => __('Centré (largeur)', 'mlmi-builder'),
              'left' => __('Aligné à gauche', 'mlmi-builder'),
              'right' => __('Aligné à droite', 'mlmi-builder'),
            ],
            'default_value' => [
              0 => 'center',
            ],
            'allow_null' => 0,
            'multiple' => 0,
            'ui' => 0,
            'return_format' => 'value',
            'ajax' => 0,
            'placeholder' => '',
          ],
          'mlmi_builder_bg_vertical_align' => [
            'key' => 'mlmi_builder_bg_vertical_align',
            'label' => __('Alignement vertical', 'mlmi-builder'),
            'name' => 'vertical_align',
            'type' => 'select',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => get_background_image_conditional_logic('vertical_align', $background_image_types),
            'wrapper' => [
              'width' => '34',
              'class' => 'no-label',
              'id' => '',
            ],
            'choices' => [
              'center' => __('Centré (hauteur)', 'mlmi-builder'),
              'top' => __('Aligné en haut', 'mlmi-builder'),
              'bottom' => __('Aligné en bas', 'mlmi-builder'),
            ],
            'default_value' => [
              0 => 'center',
            ],
            'allow_null' => 0,
            'multiple' => 0,
            'ui' => 0,
            'return_format' => 'value',
            'ajax' => 0,
            'placeholder' => '',
          ],
          'mlmi_builder_bg_size' => [
            'key' => 'mlmi_builder_bg_size',
            'label' => __('Taille', 'mlmi-builder'),
            'name' => 'size',
            'type' => 'select',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => get_background_image_conditional_logic('size', $background_image_types),
            'wrapper' => [
              'width' => '33',
              'class' => 'no-label',
              'id' => '',
            ],
            'choices' => [
              'cover' => __('Couvrir la zone', 'mlmi-builder'),
              'auto-height' => __('Largeur de la zone', 'mlmi-builder'),
              'auto-width' => __('Hauteur de la zone', 'mlmi-builder'),
              'natural' => __('Taille naturelle', 'mlmi-builder'),
            ],
            'default_value' => [
              0 => 'cover',
            ],
            'allow_null' => 0,
            'multiple' => 0,
            'ui' => 0,
            'return_format' => 'value',
            'ajax' => 0,
            'placeholder' => '',
          ],
          'mlmi_builder_bg_options' => [
            'key' => 'mlmi_builder_bg_options',
            'label' => __('Options', 'mlmi-builder'),
            'name' => 'options',
            'type' => 'checkbox',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => get_background_image_conditional_logic('options', $background_image_types),
            'wrapper' => [
              'width' => '',
              'class' => 'no-label',
              'id' => '',
            ],
            'choices' => $background_image_options,
            'allow_custom' => 0,
            'default_value' => [],
            'layout' => 'horizontal',
            'toggle' => 0,
            'return_format' => 'value',
            'save_custom' => 0,
          ],
        ],
      ],
      'mlmi_builder_field_section_bg_color' => [
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
          'class' => 'clear-left',
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
      'mlmi_builder_field_section_bg_custom_color' => [
        'key' => 'mlmi_builder_field_section_bg_custom_color',
        'label' => __('Couleur personnalisée', 'mlmi-builder'),
        'name' => 'bg_custom_color',
        'type' => 'color_picker',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => [
          [
            [
              'field' => 'mlmi_builder_field_section_bg_color',
              'operator' => '==',
              'value' => 'custom',
            ],
          ],
        ],
        'wrapper' => array(
          'width' => 50,
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
      ],
      'mlmi_builder_field_section_use_container' => [
        'key' => 'mlmi_builder_field_section_use_container',
        'label' => __('Conteneur', 'mlmi-builder'),
        'name' => 'use_container',
        'type' => 'select',
        'instructions' => '',
        'required' => 1,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '25',
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
      'mlmi_builder_field_section_justify_content' => [
        'key' => 'mlmi_builder_field_section_justify_content',
        'label' => __('Alignement vertical', 'mlmi-builder'),
        'name' => 'justify_content',
        'type' => 'select',
        'instructions' => '',
        'required' => 1,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '25',
          'class' => '',
          'id' => '',
        ],
        'choices' => apply_filters('mlmi_builder_section_justify_content_choices', [
          'justify-content-center' => __('Aligner au centre', 'mlmi-builder'),
          'justify-content-start' => __('Aligner en haut', 'mlmi-builder'),
          'justify-content-end' => __('Aligner en bas', 'mlmi-builder'),
        ]),
        'default_value' => 'justify-content-center',
        'allow_null' => 0,
        'multiple' => 0,
        'ui' => 0,
        'return_format' => 'value',
        'ajax' => 0,
        'placeholder' => '',
      ],
      'mlmi_builder_field_section_padding_top' => [
        'key' => 'mlmi_builder_field_section_padding_top',
        'label' => __('Haut', 'mlmi-builder'),
        'name' => 'padding_top',
        'type' => 'select',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '16.667',
          'class' => 'clear-left',
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
      'mlmi_builder_field_section_padding_bottom' => [
        'key' => 'mlmi_builder_field_section_padding_bottom',
        'label' => __('Bas', 'mlmi-builder'),
        'name' => 'padding_bottom',
        'type' => 'select',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '16.667',
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
      'mlmi_builder_field_section_padding_top_md' => [
        'key' => 'mlmi_builder_field_section_padding_top_md',
        'label' => __('Haut +', 'mlmi-builder'),
        'name' => 'padding_top_md',
        'type' => 'select',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '16.667',
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
      'mlmi_builder_field_section_padding_bottom_md' => [
        'key' => 'mlmi_builder_field_section_padding_bottom_md',
        'label' => __('Bas +', 'mlmi-builder'),
        'name' => 'padding_bottom_md',
        'type' => 'select',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '16.667',
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
      'mlmi_builder_field_section_class' => [
        'key' => 'mlmi_builder_field_section_class',
        'label' => __('Classes', 'mlmi-builder'),
        'name' => 'section_class',
        'type' => 'text',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '16.667',
          'class' => '',
          'id' => '',
        ],
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
      ],
      'mlmi_builder_field_section_id' => [
        'key' => 'mlmi_builder_field_section_id',
        'label' => __('ID de section', 'mlmi-builder'),
        'name' => 'section_id',
        'type' => 'text',
        'instructions' => '',
        'required' => 0,
        'wpml_cf_preferences' => 3,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '16.667',
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
    if ($additional_section_fields) {
      $section_fields = array_merge($section_fields, $additional_section_fields);
    }
    if ($additional_section_group){
      $cloned_fields = mlmi_builder_cloned_group($additional_section_group);
      array_splice($section_fields, 3, 0, [$cloned_fields]);
    }
    if ($use_tabs_system) {
      $section_fields = array_merge($section_fields, $tabs_fields);
    }
    $section_fields = apply_filters('mlmi_section_fields', $section_fields);
    
    /*
    * MLMI Builder
    */
    $config = [
      'key' => 'mlmi_builder_main',
      'title' => __('MLMI Builder', 'mlmi-builder'),
      'fields' => [
        'mlmi_builder_field_sections' => [
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
    * Filter and add global builder group
    */
    $config = apply_filters('mlmi_builder_config', $config);
    acf_add_local_field_group($config);
  });
}
