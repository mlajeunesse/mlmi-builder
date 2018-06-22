<?php
/*
* MLMI Builder
* Advanced Custom Fields — Basic fields
*/

/*
*   Dynamically create ACF layout using basic settings
*/
function mlmi_builder_create_acf_layout($key, $settings)
{
    // Default settings
    $settings = array_merge(array(
        'name' => 'row',
        'label' => __('Rangée', 'mlmi-builder'),
        'display' => 'block',
        'group' => 'mlmi_builder_layout_text_row'
    ), $settings);

    // Generated layout
    return array(
		'key' => 'mlmi_builder_layout_'.$key,
		'name' => $key,
		'label' => $settings['label'],
		'display' => $settings['display'],
		'sub_fields' => array(
			array(
				'key' => 'mlmi_builder_cloned_group_'.$key,
				'label' => 'Clone',
				'name' => 'replaced_field',
				'type' => 'clone',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'clone' => array(
					0 => $settings['group'],
				),
				'display' => 'seamless',
				'layout' => 'block',
				'prefix_label' => 0,
				'prefix_name' => 0,
			),
		),
		'min' => '',
		'max' => '',
	);
}

if (function_exists('acf_add_local_field_group')):

add_action('after_setup_theme', function()
{
    /*
    *   Hide on screen (defaults)
    */
    $hidden_full_list = array(
        'permalink', 'the_content', 'excerpt', 'custom_fields', 'discussion', 'comments', 'revisions',
        'slug', 'author', 'format', 'page_attributes', 'featured_image', 'categories', 'tags', 'send-trackbacks'
    );
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
    $hide_on_screen = apply_filters('mlmi_builder_hide_on_screen', $hidden, $hidden_full_list);

    /*
    * Content Type: Standard Row
    */
    $content_type_text_row_column_options = array(
        'text-center' => __('Centrer le texte', 'mlmi-builder'),
    );
    $content_type_text_row_column_options = apply_filters('mlmi_builder_column_options', $content_type_text_row_column_options);
    $content_type_text_row_padding_bottom_options = array(
        'pb-5' => '5',
        'pb-4' => 'Par défaut (4)',
        'pb-3' => '3',
        'pb-0' => 'Aucun (0)',
    );
    $content_type_text_row_padding_bottom_options = apply_filters('mlmi_builder_padding_bottom_options', $content_type_text_row_padding_bottom_options);
    $content_type_text_row_padding_bottom_default = apply_filters('mlmi_builder_padding_bottom_default', "pb-4");
    $content_type_text_row_padding_top_options = array(
        'pt-5' => '5',
        'pt-4' => 'Par défaut (4)',
        'pt-3' => '3',
        'pt-0' => 'Aucun (0)',
    );
    $content_type_text_row_padding_top_options = apply_filters('mlmi_builder_padding_top_options', $content_type_text_row_padding_top_options);
    $content_type_text_row_padding_top_default = apply_filters('mlmi_builder_padding_top_default', "pt-4");
    $content_type_text_row = array(
    	'key' => 'mlmi_builder_layout_text_row',
    	'fields' => array(
    		array(
    			'key' => 'text_row_tab_content',
    			'label' => __('Contenu', 'mlmi-builder'),
    			'name' => '',
    			'type' => 'tab',
    			'instructions' => '',
    			'required' => 0,
    			'conditional_logic' => 0,
    			'wrapper' => array(
    				'width' => '',
    				'class' => '',
    				'id' => '',
    			),
    			'placement' => 'top',
    			'endpoint' => 0,
    		),
    		array(
    			'key' => 'text_row_field_col_1',
    			'label' => 'Colonne 1',
    			'name' => 'col_1',
    			'type' => 'wysiwyg',
    			'instructions' => '',
    			'required' => 0,
    			'conditional_logic' => 0,
    			'wrapper' => array(
    				'width' => '33.333',
    				'class' => 'mlmi-builder-column',
    				'id' => '',
    			),
    			'default_value' => '',
    			'tabs' => 'all',
    			'toolbar' => 'full',
    			'media_upload' => 1,
    			'delay' => 0,
    		),
    		array(
    			'key' => 'text_row_field_col_2',
    			'label' => 'Colonne 2',
    			'name' => 'col_2',
    			'type' => 'wysiwyg',
    			'instructions' => '',
    			'required' => 0,
    			'conditional_logic' => array(
    				array(
    					array(
    						'field' => 'text_row_field_cols_num',
    						'operator' => '==',
    						'value' => '2',
    					),
    				),
    				array(
    					array(
    						'field' => 'text_row_field_cols_num',
    						'operator' => '==',
    						'value' => '3',
    					),
    				),
    			),
    			'wrapper' => array(
    				'width' => '33.333',
    				'class' => 'mlmi-builder-column',
    				'id' => '',
    			),
    			'default_value' => '',
    			'tabs' => 'all',
    			'toolbar' => 'full',
    			'media_upload' => 1,
    			'delay' => 0,
    		),
    		array(
    			'key' => 'text_row_field_col_3',
    			'label' => 'Colonne 3',
    			'name' => 'col_3',
    			'type' => 'wysiwyg',
    			'instructions' => '',
    			'required' => 0,
    			'conditional_logic' => array(
    				array(
    					array(
    						'field' => 'text_row_field_cols_num',
    						'operator' => '==',
    						'value' => '3',
    					),
    				),
    			),
    			'wrapper' => array(
    				'width' => '33.333',
    				'class' => 'mlmi-builder-column',
    				'id' => '',
    			),
    			'default_value' => '',
    			'tabs' => 'all',
    			'toolbar' => 'full',
    			'media_upload' => 1,
    			'delay' => 0,
    		),
    		array(
    			'key' => 'text_row_tab_options',
    			'label' => __('Options', 'mlmi-builder'),
    			'name' => '',
    			'type' => 'tab',
    			'instructions' => '',
    			'required' => 0,
    			'conditional_logic' => 0,
    			'wrapper' => array(
    				'width' => '',
    				'class' => '',
    				'id' => '',
    			),
    			'placement' => 'top',
    			'endpoint' => 0,
    		),
    		array(
    			'key' => 'text_row_field_cols_num',
    			'label' => 'Nombre de colonnes',
    			'name' => 'cols_num',
    			'type' => 'select',
    			'instructions' => '',
    			'required' => 0,
    			'conditional_logic' => 0,
    			'wrapper' => array(
    				'width' => '33.3333',
    				'class' => 'select-cols-number one-third',
    				'id' => '',
    			),
    			'choices' => array(
    				1 => __('1 colonne', 'mlmi-builder'),
    				2 => __('2 colonnes', 'mlmi-builder'),
    				3 => __('3 colonnes', 'mlmi-builder')
    			),
    			'default_value' => 1,
    			'allow_null' => 0,
    			'multiple' => 0,
    			'ui' => 0,
    			'ajax' => 0,
    			'return_format' => 'value',
    			'placeholder' => '',
    		),
    		array(
    			'key' => 'text_row_field_cols_config_1',
    			'label' => __('Configuration des colonnes', 'mlmi-builder'),
    			'name' => 'cols_config',
    			'type' => 'radio',
    			'instructions' => '',
    			'required' => 0,
    			'conditional_logic' => array(
    				array(
    					array(
    						'field' => 'text_row_field_cols_num',
    						'operator' => '==',
    						'value' => '1',
    					),
    				),
    			),
    			'wrapper' => array(
    				'width' => '33.3333',
    				'class' => 'cols_config one-third',
    				'id' => '',
    			),
    			'choices' => array(
    				6 => __('Pleine largeur', 'mlmi-builder'),
    			),
    			'allow_null' => 0,
    			'other_choice' => 0,
    			'save_other_choice' => 0,
    			'default_value' => '',
    			'layout' => 'horizontal',
    			'return_format' => 'value',
    		),
    		array(
    			'key' => 'text_row_field_cols_config_2',
    			'label' => __('Configuration des colonnes', 'mlmi-builder'),
    			'name' => 'cols_config',
    			'type' => 'radio',
    			'instructions' => '',
    			'required' => 0,
    			'conditional_logic' => array(
    				array(
    					array(
    						'field' => 'text_row_field_cols_num',
    						'operator' => '==',
    						'value' => '2',
    					),
    				),
    			),
    			'wrapper' => array(
    				'width' => '33.3333',
    				'class' => 'cols_config one-third',
    				'id' => '',
    			),
    			'choices' => array(
    				'3-3' => __('Moitié-moitié', 'mlmi-builder'),
    				'2-4' => __('1 / 2', 'mlmi-builder'),
    				'4-2' => __('2 / 1', 'mlmi-builder'),
    			),
    			'allow_null' => 0,
    			'other_choice' => 0,
    			'save_other_choice' => 0,
    			'default_value' => '3-3',
    			'layout' => 'horizontal',
    			'return_format' => 'value',
    		),
    		array(
    			'key' => 'text_row_field_cols_config_3',
    			'label' => __('Configuration des colonnes', 'mlmi-builder'),
    			'name' => 'cols_config',
    			'type' => 'radio',
    			'instructions' => '',
    			'required' => 0,
    			'conditional_logic' => array(
    				array(
    					array(
    						'field' => 'text_row_field_cols_num',
    						'operator' => '==',
    						'value' => '3',
    					),
    				),
    			),
    			'wrapper' => array(
    				'width' => '33.3333',
    				'class' => 'cols_config one-third',
    				'id' => '',
    			),
    			'choices' => array(
    				'2-2-2' => __('Trois colonnes', 'mlmi-builder'),
    			),
    			'allow_null' => 0,
    			'other_choice' => 0,
    			'save_other_choice' => 0,
    			'default_value' => '2-2-2',
    			'layout' => 'horizontal',
    			'return_format' => 'value',
    		),
            array(
    			'key' => 'field_58cacac3c8c37',
    			'label' => __('ID de la rangée', 'mlmi-builder'),
    			'name' => 'row_id',
    			'type' => 'text',
    			'instructions' => '',
    			'required' => 0,
    			'conditional_logic' => 0,
    			'wrapper' => array(
    				'width' => '33.3333',
    				'class' => 'one-third',
    				'id' => '',
    			),
    			'default_value' => '',
    			'placeholder' => '',
    			'prepend' => '',
    			'append' => '',
    			'maxlength' => '',
    		),
            array(
    			'key' => 'text_row_field_col_1_order',
    			'label' => __('Colonne 1', 'mlmi-builder'),
    			'name' => 'col_1_order',
    			'type' => 'select',
    			'instructions' => '',
    			'required' => 0,
    			'conditional_logic' => 0,
    			'wrapper' => array(
    				'width' => '33.333',
    				'class' => 'mlmi-builder-column-option',
    				'id' => '',
    			),
    			'choices' => array(
                    'normal' => __('Ordre régulier', 'mlmi-builder'),
                    'first' => __('En premier', 'mlmi-builder'),
                    'last' => __('En dernier', 'mlmi-builder')
                ),
                'default_value' => 'normal',
    			'allow_null' => 0,
    			'multiple' => 0,
    			'ui' => 0,
    			'ajax' => 0,
    			'return_format' => 'value',
    			'placeholder' => '',
    		),
    		array(
    			'key' => 'text_row_field_col_2_order',
    			'label' => __('Colonne 2', 'mlmi-builder'),
    			'name' => 'col_2_order',
    			'type' => 'select',
    			'instructions' => '',
    			'required' => 0,
    			'conditional_logic' => array(
    				array(
    					array(
    						'field' => 'text_row_field_cols_num',
    						'operator' => '==',
    						'value' => '2',
    					),
    				),
    				array(
    					array(
    						'field' => 'text_row_field_cols_num',
    						'operator' => '==',
    						'value' => '3',
    					),
    				),
    			),
    			'wrapper' => array(
    				'width' => '33.333',
    				'class' => 'mlmi-builder-column-option',
    				'id' => '',
    			),
                'choices' => array(
                    'normal' => __('Ordre régulier', 'mlmi-builder'),
                    'first' => __('En premier', 'mlmi-builder'),
                    'last' => __('En dernier', 'mlmi-builder')
                ),
                'default_value' => 'normal',
    			'allow_null' => 0,
    			'multiple' => 0,
    			'ui' => 0,
    			'ajax' => 0,
    			'return_format' => 'value',
    			'placeholder' => '',
    		),
    		array(
    			'key' => 'text_row_field_col_3_order',
    			'label' => __('Colonne 3', 'mlmi-builder'),
    			'name' => 'col_3_order',
    			'type' => 'select',
    			'instructions' => '',
    			'required' => 0,
    			'conditional_logic' => array(
    				array(
    					array(
    						'field' => 'text_row_field_cols_num',
    						'operator' => '==',
    						'value' => '3',
    					),
    				),
    			),
    			'wrapper' => array(
    				'width' => '33.333',
    				'class' => 'mlmi-builder-column-option',
    				'id' => '',
    			),
                'choices' => array(
                    'normal' => __('Ordre régulier', 'mlmi-builder'),
                    'first' => __('En premier', 'mlmi-builder'),
                    'last' => __('En dernier', 'mlmi-builder')
                ),
                'default_value' => 'normal',
    			'allow_null' => 0,
    			'multiple' => 0,
    			'ui' => 0,
    			'ajax' => 0,
    			'return_format' => 'value',
    			'placeholder' => '',
    		),
    		array(
    			'key' => 'text_row_field_col_1_option',
    			'label' => '',
    			'name' => 'col_1_option',
    			'type' => 'checkbox',
    			'instructions' => '',
    			'required' => 0,
    			'conditional_logic' => 0,
    			'wrapper' => array(
    				'width' => '33.333',
    				'class' => 'mlmi-builder-column-option',
    				'id' => '',
    			),
    			'choices' => $content_type_text_row_column_options,
    			'allow_custom' => 1,
    			'save_custom' => 0,
    			'default_value' => array(),
    			'layout' => 'vertical',
    			'toggle' => 0,
    			'return_format' => 'value',
    		),
    		array(
    			'key' => 'text_row_field_col_2_option',
    			'label' => '',
    			'name' => 'col_2_option',
    			'type' => 'checkbox',
    			'instructions' => '',
    			'required' => 0,
    			'conditional_logic' => array(
    				array(
    					array(
    						'field' => 'text_row_field_cols_num',
    						'operator' => '==',
    						'value' => '2',
    					),
    				),
    				array(
    					array(
    						'field' => 'text_row_field_cols_num',
    						'operator' => '==',
    						'value' => '3',
    					),
    				),
    			),
    			'wrapper' => array(
    				'width' => '33.333',
    				'class' => 'mlmi-builder-column-option',
    				'id' => '',
    			),
    			'choices' => $content_type_text_row_column_options,
    			'allow_custom' => 1,
    			'save_custom' => 0,
    			'default_value' => array(),
    			'layout' => 'vertical',
    			'toggle' => 0,
    			'return_format' => 'value',
    		),
    		array(
    			'key' => 'text_row_field_col_3_option',
    			'label' => '',
    			'name' => 'col_3_option',
    			'type' => 'checkbox',
    			'instructions' => '',
    			'required' => 0,
    			'conditional_logic' => array(
    				array(
    					array(
    						'field' => 'text_row_field_cols_num',
    						'operator' => '==',
    						'value' => '3',
    					),
    				),
    			),
    			'wrapper' => array(
    				'width' => '33.333',
    				'class' => 'mlmi-builder-column-option',
    				'id' => '',
    			),
    			'choices' => $content_type_text_row_column_options,
    			'allow_custom' => 1,
    			'save_custom' => 0,
    			'default_value' => array(),
    			'layout' => 'vertical',
    			'toggle' => 0,
    			'return_format' => 'value',
    		),
    		array(
    			'key' => 'text_row_field_row_class',
    			'label' => __('Classes', 'mlmi-builder'),
    			'name' => 'row_class',
    			'type' => 'text',
    			'instructions' => '',
    			'required' => 0,
    			'conditional_logic' => 0,
    			'wrapper' => array(
    				'width' => '33.333',
    				'class' => 'one-third',
    				'id' => '',
    			),
    			'default_value' => '',
    			'placeholder' => '',
    			'prepend' => '',
    			'append' => '',
    			'maxlength' => '',
    		),
            array(
    			'key' => 'text_row_field_padding_top',
    			'label' => __('Espacement haut', 'mlmi-builder'),
    			'name' => 'padding_top',
    			'type' => 'select',
    			'instructions' => '',
    			'required' => 0,
    			'conditional_logic' => 0,
    			'wrapper' => array(
    				'width' => '33.333',
    				'class' => 'one-third',
    				'id' => '',
    			),
    			'choices' => $content_type_text_row_padding_top_options,
    			'default_value' => $content_type_text_row_padding_top_default,
    			'allow_null' => 0,
    			'multiple' => 0,
    			'ui' => 0,
    			'ajax' => 0,
    			'return_format' => 'value',
    			'placeholder' => '',
    		),
    		array(
    			'key' => 'text_row_field_padding_bottom',
    			'label' => __('Espacement bas', 'mlmi-builder'),
    			'name' => 'padding_bottom',
    			'type' => 'select',
    			'instructions' => '',
    			'required' => 0,
    			'conditional_logic' => 0,
    			'wrapper' => array(
    				'width' => '33.333',
    				'class' => 'one-third',
    				'id' => '',
    			),
    			'choices' => $content_type_text_row_padding_bottom_options,
    			'default_value' => $content_type_text_row_padding_bottom_default,
    			'allow_null' => 0,
    			'multiple' => 0,
    			'ui' => 0,
    			'ajax' => 0,
    			'return_format' => 'value',
    			'placeholder' => '',
    		)
    	),
    	'location' => array(),
    	'menu_order' => 0,
    	'position' => 'normal',
    	'style' => 'seamless',
    	'label_placement' => 'top',
    	'instruction_placement' => 'label',
    	'hide_on_screen' => '',
    	'active' => 0,
    	'description' => '',
    );
    $content_type_text_row = apply_filters('mlmi_builder_content_type_text_row', $content_type_text_row);
    acf_add_local_field_group($content_type_text_row);

    /*
    *   Content type: Gallery
    */
    $accept_mime_types = apply_filters('mlmi_builder_accept_mime_types', 'jpg, jpeg');
    $content_type_gallery_row = array(
    	'key' => 'mlmi_builder_layout_gallery_row',
    	'fields' => array(
    		array(
    			'key' => 'gallery_row_field_gallery',
    			'label' => __('Galerie d\'images', 'mlmi-builder'),
    			'name' => 'gallery',
    			'type' => 'gallery',
    			'instructions' => '',
    			'required' => 0,
    			'conditional_logic' => 0,
    			'wrapper' => array(
    				'width' => '',
    				'class' => '',
    				'id' => '',
    			),
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
    		),
    	),
    	'location' => array(),
    	'menu_order' => 0,
    	'position' => 'normal',
    	'style' => 'default',
    	'label_placement' => 'top',
    	'instruction_placement' => 'label',
    	'hide_on_screen' => '',
    	'active' => 0,
    	'description' => '',
    );
    $content_type_gallery_row = apply_filters('mlmi_builder_content_type_gallery_row', $content_type_gallery_row);
    acf_add_local_field_group($content_type_gallery_row);

    /*
    * Content Type: Shortcode
    */
    $content_type_code_row = array(
    	'key' => 'mlmi_builder_layout_code_row',
    	'fields' => array(
    		array(
    			'key' => 'code_row_field_shortcode',
    			'label' => 'Code',
    			'name' => 'shortcode',
    			'type' => 'text',
    			'instructions' => '',
    			'required' => 0,
    			'conditional_logic' => 0,
    			'wrapper' => array(
    				'width' => '',
    				'class' => '',
    				'id' => '',
    			),
    			'default_value' => '',
    			'placeholder' => '',
    			'prepend' => '',
    			'append' => '',
    			'maxlength' => '',
    		),
    	),
    	'location' => array(),
    	'menu_order' => 0,
    	'position' => 'normal',
    	'style' => 'default',
    	'label_placement' => 'top',
    	'instruction_placement' => 'label',
    	'hide_on_screen' => '',
    	'active' => 0,
    	'description' => '',
    );
    $content_type_code_row = apply_filters('mlmi_builder_content_type_code_row', $content_type_code_row);
    acf_add_local_field_group($content_type_code_row);

    /*
    *   Layout types
    */
    $layout_types = array(
        "text_row" => array(
            "label" => __('Rangée standard', 'mlmi-builder'),
            "group" => 'mlmi_builder_layout_text_row'
        ),
        "code_row" => array(
            "label" => __('Rangée programmée', 'mlmi-builder'),
            "group" => 'mlmi_builder_layout_code_row'
        ),
        "gallery_row" => array(
            "label" => __('Galerie d\'images', 'mlmi-builder'),
            "group" => 'mlmi_builder_layout_gallery_row'
        )
    );
    $layout_types = apply_filters('mlmi_builder_layout_types', $layout_types);

    /*
    *   Layouts
    */
    $layouts = array();
    foreach ($layout_types as $key => $settings) {
        $layouts[$key] = mlmi_builder_create_acf_layout($key, $settings);
    }

    /*
    *   MLMI Builder
    */
    $config = array(
    	'key' => 'mlmi_builder_main',
    	'title' => __('MLMI Builder', 'mlmi-builder'),
    	'fields' => array(
    		array(
    			'key' => 'mlmi_builder_field_sections',
    			'label' => __('MLMI Builder', 'mlmi-builder'),
    			'name' => 'sections',
    			'type' => 'repeater',
    			'instructions' => '',
    			'required' => 0,
    			'conditional_logic' => 0,
    			'wrapper' => array(
    				'width' => '',
    				'class' => 'mlmi-builder-section',
    				'id' => '',
    			),
    			'collapsed' => '',
    			'min' => 1,
    			'max' => 0,
    			'layout' => 'block',
    			'button_label' => __('Ajouter une section', 'mlmi-builder'),
    			'sub_fields' => array(
    				array(
    					'key' => 'mlmi_builder_tab_section',
    					'label' => __('Section', 'mlmi-builder'),
    					'name' => '',
    					'type' => 'tab',
    					'instructions' => '',
    					'required' => 0,
    					'conditional_logic' => 0,
    					'wrapper' => array(
    						'width' => '',
    						'class' => '',
    						'id' => '',
    					),
    					'placement' => 'top',
    					'endpoint' => 0,
    				),
    				array(
    					'key' => 'mlmi_builder_field_rows',
    					'label' => __('Rangées', 'mlmi-builder'),
    					'name' => 'rows',
    					'type' => 'flexible_content',
    					'instructions' => '',
    					'required' => 0,
    					'conditional_logic' => 0,
    					'wrapper' => array(
    						'width' => '',
    						'class' => 'mlmi-builder-row',
    						'id' => '',
    					),
    					'layouts' => $layouts,
    					'button_label' => __('Ajouter une rangée', 'mlmi-builder'),
    					'min' => '',
    					'max' => '',
    				),
    				array(
    					'key' => 'mlmi_builder_tab_presentation',
    					'label' => __('Présentation', 'mlmi-builder'),
    					'name' => '',
    					'type' => 'tab',
    					'instructions' => '',
    					'required' => 0,
    					'conditional_logic' => 0,
    					'wrapper' => array(
    						'width' => '',
    						'class' => '',
    						'id' => '',
    					),
    					'placement' => 'top',
    					'endpoint' => 0,
    				),
    				array(
    					'key' => 'mlmi_builder_field_section_id',
    					'label' => __('ID', 'mlmi-builder'),
    					'name' => 'section_id',
    					'type' => 'text',
    					'instructions' => '',
    					'required' => 0,
    					'conditional_logic' => 0,
    					'wrapper' => array(
    						'width' => '30',
    						'class' => '',
    						'id' => '',
    					),
    					'default_value' => '',
    					'placeholder' => '',
    					'prepend' => '',
    					'append' => '',
    					'maxlength' => '',
    				),
    				array(
    					'key' => 'mlmi_builder_field_section_class',
    					'label' => __('Classes', 'mlmi-builder'),
    					'name' => 'section_class',
    					'type' => 'text',
    					'instructions' => '',
    					'required' => 0,
    					'conditional_logic' => 0,
    					'wrapper' => array(
    						'width' => '30',
    						'class' => '',
    						'id' => '',
    					),
    					'default_value' => '',
    					'placeholder' => '',
    					'prepend' => '',
    					'append' => '',
    					'maxlength' => '',
    				),
    			),
    		),
    	),
    	'location' => array(
    		array(
    			array(
    				'param' => 'post_type',
    				'operator' => '==',
    				'value' => 'post',
    			),
    			array(
    				'param' => 'post_taxonomy',
    				'operator' => '!=',
    				'value' => 'category:non-classe',
    			),
    			array(
    				'param' => 'post_taxonomy',
    				'operator' => '!=',
    				'value' => 'category:non-classe',
    			),
    		),
    		array(
    			array(
    				'param' => 'post_type',
    				'operator' => '==',
    				'value' => 'page',
    			),
    			array(
    				'param' => 'post_template',
    				'operator' => '==',
    				'value' => 'default',
    			),
    		),
    		array(
    			array(
    				'param' => 'post_type',
    				'operator' => '==',
    				'value' => 'page',
    			),
    			array(
    				'param' => 'page_template',
    				'operator' => '==',
    				'value' => 'views/grid.blade.php',
    			),
    		),
    	),
    	'menu_order' => 0,
    	'position' => 'normal',
    	'style' => 'seamless',
    	'label_placement' => 'top',
    	'instruction_placement' => 'label',
    	'hide_on_screen' => $hide_on_screen,
    	'active' => 1,
    	'description' => '',
    );

    /**
    *   Filter and add global builder group
    */
    $config = apply_filters('mlmi_builder_config', $config);
    acf_add_local_field_group($config);
});

endif;
