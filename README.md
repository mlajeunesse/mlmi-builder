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

`mlmi_builder_layout_types` : Permet de supprimer et d'ajouter des types de rangées.

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

### Champs spécifiques

`mlmi_builder_gallery_attributes` : Modifie les attributs par défaut de la galerie Wordpress dans le template par défaut de Wordpress.

`mlmi_builder_use_container` : Si retourne `false`, n'utilisera pas de `<div class="container"></div>` dans cette rangée.

`mlmi_builder_use_row` : Si retourne `false`, n'utilisera pas de `<div class="row"></div>` dans cette rangée.

### Gabarits personnalisés

`mlmi_builder_code_row_template` : Permet de remplacer le gabarit utilisé pour la rangée programmée. Doit retourner un chemin relatif au dossier `resources` (ex: `/views/partials/custom-template.php`) ou `false` si le gabarit est affiché directement dans le filtre.

`mlmi_builder_gallery_row_template` : Permet de remplacer le gabarit utilisé pour la galerie photos. Doit retourner un chemin relatif au dossier `resources` (ex: `/views/partials/custom-template.php`) ou `false` si le gabarit est affiché directement dans le filtre.

### Attributs HTML

`mlmi_builder_*_attributes` : Permet de modifier la liste d'attributs HTML de l'élément. Les choix d'élément sont `section`, `row`, `column` et `content`.

`mlmi_builder_*_classes` : Permet de modifier la liste des classes de l'élément. Les choix d'élément sont `section`, `row`, `column` et `content`.

### Actions

`mlmi_builder_before_*` : Permet d'ajouter une action (ex: afficher du contenu) au début d'un élément `section` ou `row`.

`mlmi_builder_after_*` : Permet d'ajouter une action (ex: afficher du contenu) à la fin d'un élément `section` ou `row`.

`mlmi_builder_*_output` : Permet d'inclure un gabarit partiel pour afficher un type de contenu personnalisé. Remplacer `*` par le nom de votre type de contenu personnalisé.

## Affichage de la grille

Pour afficher la grille, il suffit d'appeler la fonction `the_grid()` dans un gabarit Wordpress.

Les gabarits sont à l'intérieur d'un loop `have_rows()` de ACF. Pour cette raison, il faut utiliser la fonction `get_sub_field()` (et non `get_field()`) pour obtenir les valeurs de champs.
