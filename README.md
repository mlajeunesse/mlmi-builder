# MLMI Builder

Extension Wordpress basée sur Advanced Custom Fields Pro et Bootstrap pour éditer et générer des compositions de page web simples et complexes.

## Options de base

`MLMI_BUILDER_LOAD_ADMIN_CSS` : `true` par défaut, définir à `false` pour ne pas charger le fichier CSS de l'outil d'administration Wordpress.

`MLMI_BUILDER_LOAD_ADMIN_JS` : `true` par défaut, définir à `false` pour ne pas charger le fichier JS de l'outil d'administration Wordpress.

## Filtres Wordpress

Voici la liste des filtres disponibles pour personnaliser les champs disponible dans l'outil.

Sauf aux endroits où le format est spécifié, les filtres sont tous appliqués sur des `array()`.

### Configuration globale

`mlmi_builder_config` : Configuration ACF Pro complète.

`mlmi_builder_hide_on_screen` : Liste des éléments cachés dans l'écran d'administration.

`mlmi_builder_column_options` : Liste des options de colonnes disponibles (classes CSS).

`mlmi_builder_accept_mime_types` : MIME Types acceptés dans les champs d'images.

`mlmi_builder_location` : Liste des endroits où le MLMI Builder est utilisé.

### Espacements

`mlmi_builder_padding_bottom_option` : Liste des options d'espacement (padding-bottom) disponibles.

`mlmi_builder_padding_bottom_default` : Option d'espacement (padding-bottom) sélectionnée par défaut.

`mlmi_builder_padding_top_option` : Liste des options d'espacement (padding-top) disponibles.

`mlmi_builder_padding_top_default` : Option d'espacement (padding-top) sélectionnée par défaut.

### Ajout et édition des champs
`mlmi_builder_section_add_fields` : Permet de définir un `array` de champs à ajouter aux paramètres des sections.

`mlmi_builder_section_add_group` : Permet de définir une `string` correspondant au groupe de champs à ajouter aux sections.

`mlmi_builder_standard_row_add_fields` : Permet de définir un `array` de champs à ajouter aux paramètres des rangées standard.

`mlmi_builder_standard_row_add_group` : Permet de définir une `string` correspondant au groupe de champs à ajouter aux rangées standard.

`mlmi_builder_content_type_text_row` : Configuration d'une rangée standard.

`mlmi_builder_gallery_row_add_fields` : Permet de définir un `array` de champs à ajouter aux galeries d'images.

`mlmi_builder_gallery_row_add_group` : Permet de définir une `string` correspondant au groupe de champs à ajouter aux galeries d'images.

`mlmi_builder_content_type_gallery_row` : Configuration d'une galerie d'images.

`mlmi_builder_code_row_add_fields` : Permet de définir un `array` de champs à ajouter aux rangées programmées.

`mlmi_builder_code_row_add_group` : Permet de définir une `string` correspondant au groupe de champs à ajouter aux rangées programmées.

`mlmi_builder_content_type_code_row` : Configuration d'une rangée programmée.

`mlmi_builder_layout_types` : Permet de supprimer et d'ajouter des types de rangées.

## Affichage de la grille

Pour afficher la grille, il suffit d'appeler la fonction `the_grid()` dans un gabarit Wordpress.
