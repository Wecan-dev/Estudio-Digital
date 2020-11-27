<?php 
the_post_thumbnail();
the_post_thumbnail('thumbnail');       // Thumbnail (por defecto 150px x 150px max)
the_post_thumbnail('medium');          // Media resolución (por defecto 300px x 300px max)
the_post_thumbnail('large');           // Alta resolución (por defecto 640px x 640px max)
the_post_thumbnail('full');            // Resolución original de la imagen (sin modificar)

add_theme_support( 'post-thumbnails' );
the_post_thumbnail( array(100,100) ); 


/*******truncar cantidad de palabras******/
function excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  }
  $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
  return $excerpt;
}
/*******truncar cantidad de palabras******/

function my_theme_setup() {
  add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'my_theme_setup' );



// Register Custom Banner Home
function Banner() {

  $labels = array(
    'name'                  => _x( 'Banner ', 'Post Type General Name', 'EstudioDigital' ),
    'singular_name'         => _x( 'Banner', 'Post Type Singular Name', 'EstudioDigital' ),
    'menu_name'             => __( 'Banners', 'EstudioDigital' ),
    'name_admin_bar'        => __( 'Banners', 'EstudioDigital' ),
    'archives'              => __( 'Archivo', 'EstudioDigital' ),
    'attributes'            => __( 'Atributos', 'EstudioDigital' ),
    'parent_item_colon'     => __( 'Artículo principal', 'EstudioDigital' ),
    'all_items'             => __( 'Todos los artículos', 'EstudioDigital' ),
    'add_new_item'          => __( 'Agregar ítem nuevo', 'EstudioDigital' ),
    'add_new'               => __( 'Añadir nuevo', 'EstudioDigital' ),
    'new_item'              => __( 'Nuevo artículo', 'EstudioDigital' ),
    'edit_item'             => __( 'Editar elemento', 'EstudioDigital' ),
    'update_item'           => __( 'Actualizar artículo', 'EstudioDigital' ),
    'view_item'             => __( 'Ver ítem', 'EstudioDigital' ),
    'view_items'            => __( 'Ver artículos', 'EstudioDigital' ),
    'search_items'          => __( 'Buscar artículo', 'EstudioDigital' ),
    'not_found'             => __( 'Extraviado', 'EstudioDigital' ),
    'not_found_in_trash'    => __( 'No se encuentra en la basura', 'EstudioDigital' ),
    'featured_image'        => __( 'Foto principal', 'EstudioDigital' ),
    'set_featured_image'    => __( 'Establecer imagen destacada', 'EstudioDigital' ),
    'remove_featured_image' => __( 'Remove featured image', 'EstudioDigital' ),
    'use_featured_image'    => __( 'Usar como imagen destacada', 'EstudioDigital' ),
    'insert_into_item'      => __( 'Insertar en el elemento', 'EstudioDigital' ),
    'uploaded_to_this_item' => __( 'Subido a este artículo', 'EstudioDigital' ),
    'items_list'            => __( 'Lista de artículos', 'EstudioDigital' ),
    'items_list_navigation' => __( 'Lista de elementos de navegación', 'EstudioDigital' ),
    'filter_items_list'     => __( 'Lista de elementos de filtro', 'EstudioDigital' ),
  );
  $args = array(
    'label'                 => __( 'Banner Home', 'EstudioDigital' ),
    'description'           => __( 'Post Type Description', 'EstudioDigital' ),
    'labels'                => $labels,
    'supports'              => array( 'title','editor', 'thumbnail' ),
    'taxonomies'            => array(  ),
    'hierarchical'          => false,
    'public'                => true,
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 5,
    'menu_icon'             => 'dashicons-images-alt2',
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => true,
    'can_export'            => true,
    'has_archive'           => true,
    'exclude_from_search'   => false,
    'publicly_queryable'    => true,
    'capability_type'       => 'page',
  );
  register_post_type( 'Banner', $args );

}
add_action( 'init', 'Banner', 0 );




// Register Custom Services
function Hacemos() {

    $labels = array(
        'name'                  => _x( 'Hacemos ', 'Post Type General Name', 'EstudioDigital' ),
        'singular_name'         => _x( 'Hacemos', 'Post Type Singular Name', 'EstudioDigital' ),
        'menu_name'             => __( 'Hacemos', 'EstudioDigital' ),
        'name_admin_bar'        => __( 'Hacemos', 'EstudioDigital' ),
        'archives'              => __( 'Archivo', 'EstudioDigital' ),
        'attributes'            => __( 'Atributos', 'EstudioDigital' ),
        'parent_item_colon'     => __( 'Artículo principal', 'EstudioDigital' ),
        'all_items'             => __( 'Todos los artículos', 'EstudioDigital' ),
        'add_new_item'          => __( 'Agregar ítem nuevo', 'EstudioDigital' ),
        'add_new'               => __( 'Añadir nuevo', 'EstudioDigital' ),
        'new_item'              => __( 'Nuevo artículo', 'EstudioDigital' ),
        'edit_item'             => __( 'Editar elemento', 'EstudioDigital' ),
        'update_item'           => __( 'Actualizar artículo', 'EstudioDigital' ),
        'view_item'             => __( 'Ver ítem', 'EstudioDigital' ),
        'view_items'            => __( 'Ver artículos', 'EstudioDigital' ),
        'search_items'          => __( 'Buscar artículo', 'EstudioDigital' ),
        'not_found'             => __( 'Extraviado', 'EstudioDigital' ),
        'not_found_in_trash'    => __( 'No se encuentra en la basura', 'EstudioDigital' ),
        'featured_image'        => __( 'Foto principal', 'EstudioDigital' ),
        'set_featured_image'    => __( 'Establecer imagen destacada', 'EstudioDigital' ),
        'remove_featured_image' => __( 'Remove featured image', 'EstudioDigital' ),
        'use_featured_image'    => __( 'Usar como imagen destacada', 'EstudioDigital' ),
        'insert_into_item'      => __( 'Insertar en el elemento', 'EstudioDigital' ),
        'uploaded_to_this_item' => __( 'Subido a este artículo', 'EstudioDigital' ),
        'items_list'            => __( 'Lista de artículos', 'EstudioDigital' ),
        'items_list_navigation' => __( 'Lista de elementos de navegación', 'EstudioDigital' ),
        'filter_items_list'     => __( 'Lista de elementos de filtro', 'EstudioDigital' ),
    );
    $args = array(
        'label'                 => __( 'Hacemos Home', 'EstudioDigital' ),
        'description'           => __( 'Post Type Description', 'EstudioDigital' ),
        'labels'                => $labels,
        'supports'              => array( 'title','editor', 'thumbnail' ),
        'taxonomies'            => array(  ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-clipboard',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
    );
    register_post_type( 'Hacemos', $args );

}
add_action( 'init', 'Hacemos', 0 );



// Register Custom Coments
function Comentarios() {

    $labels = array(
        'name'                  => _x( 'Comentarios ', 'Post Type General Name', 'EstudioDigital' ),
        'singular_name'         => _x( 'Comentarios', 'Post Type Singular Name', 'EstudioDigital' ),
        'menu_name'             => __( 'Comentarios', 'EstudioDigital' ),
        'name_admin_bar'        => __( 'Comentarios', 'EstudioDigital' ),
        'archives'              => __( 'Archivo', 'EstudioDigital' ),
        'attributes'            => __( 'Atributos', 'EstudioDigital' ),
        'parent_item_colon'     => __( 'Artículo principal', 'EstudioDigital' ),
        'all_items'             => __( 'Todos los artículos', 'EstudioDigital' ),
        'add_new_item'          => __( 'Agregar ítem nuevo', 'EstudioDigital' ),
        'add_new'               => __( 'Añadir nuevo', 'EstudioDigital' ),
        'new_item'              => __( 'Nuevo artículo', 'EstudioDigital' ),
        'edit_item'             => __( 'Editar elemento', 'EstudioDigital' ),
        'update_item'           => __( 'Actualizar artículo', 'EstudioDigital' ),
        'view_item'             => __( 'Ver ítem', 'EstudioDigital' ),
        'view_items'            => __( 'Ver artículos', 'EstudioDigital' ),
        'search_items'          => __( 'Buscar artículo', 'EstudioDigital' ),
        'not_found'             => __( 'Extraviado', 'EstudioDigital' ),
        'not_found_in_trash'    => __( 'No se encuentra en la basura', 'EstudioDigital' ),
        'featured_image'        => __( 'Foto principal', 'EstudioDigital' ),
        'set_featured_image'    => __( 'Establecer imagen destacada', 'EstudioDigital' ),
        'remove_featured_image' => __( 'Remove featured image', 'EstudioDigital' ),
        'use_featured_image'    => __( 'Usar como imagen destacada', 'EstudioDigital' ),
        'insert_into_item'      => __( 'Insertar en el elemento', 'EstudioDigital' ),
        'uploaded_to_this_item' => __( 'Subido a este artículo', 'EstudioDigital' ),
        'items_list'            => __( 'Lista de artículos', 'EstudioDigital' ),
        'items_list_navigation' => __( 'Lista de elementos de navegación', 'EstudioDigital' ),
        'filter_items_list'     => __( 'Lista de elementos de filtro', 'EstudioDigital' ),
    );
    $args = array(
        'label'                 => __( 'Comentarios Home', 'EstudioDigital' ),
        'description'           => __( 'Post Type Description', 'EstudioDigital' ),
        'labels'                => $labels,
        'supports'              => array( 'title','editor', 'thumbnail' ),
        'taxonomies'            => array(  ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-format-chat',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
    );
    register_post_type( 'Comentarios', $args );

}
add_action( 'init', 'Comentarios', 0 );



// Register Custom Clientes
function Clientes() {

    $labels = array(
        'name'                  => _x( 'Clientes ', 'Post Type General Name', 'EstudioDigital' ),
        'singular_name'         => _x( 'Clientes', 'Post Type Singular Name', 'EstudioDigital' ),
        'menu_name'             => __( 'Clientes', 'EstudioDigital' ),
        'name_admin_bar'        => __( 'Clientes', 'EstudioDigital' ),
        'archives'              => __( 'Archivo', 'EstudioDigital' ),
        'attributes'            => __( 'Atributos', 'EstudioDigital' ),
        'parent_item_colon'     => __( 'Artículo principal', 'EstudioDigital' ),
        'all_items'             => __( 'Todos los artículos', 'EstudioDigital' ),
        'add_new_item'          => __( 'Agregar ítem nuevo', 'EstudioDigital' ),
        'add_new'               => __( 'Añadir nuevo', 'EstudioDigital' ),
        'new_item'              => __( 'Nuevo artículo', 'EstudioDigital' ),
        'edit_item'             => __( 'Editar elemento', 'EstudioDigital' ),
        'update_item'           => __( 'Actualizar artículo', 'EstudioDigital' ),
        'view_item'             => __( 'Ver ítem', 'EstudioDigital' ),
        'view_items'            => __( 'Ver artículos', 'EstudioDigital' ),
        'search_items'          => __( 'Buscar artículo', 'EstudioDigital' ),
        'not_found'             => __( 'Extraviado', 'EstudioDigital' ),
        'not_found_in_trash'    => __( 'No se encuentra en la basura', 'EstudioDigital' ),
        'featured_image'        => __( 'Foto principal', 'EstudioDigital' ),
        'set_featured_image'    => __( 'Establecer imagen destacada', 'EstudioDigital' ),
        'remove_featured_image' => __( 'Remove featured image', 'EstudioDigital' ),
        'use_featured_image'    => __( 'Usar como imagen destacada', 'EstudioDigital' ),
        'insert_into_item'      => __( 'Insertar en el elemento', 'EstudioDigital' ),
        'uploaded_to_this_item' => __( 'Subido a este artículo', 'EstudioDigital' ),
        'items_list'            => __( 'Lista de artículos', 'EstudioDigital' ),
        'items_list_navigation' => __( 'Lista de elementos de navegación', 'EstudioDigital' ),
        'filter_items_list'     => __( 'Lista de elementos de filtro', 'EstudioDigital' ),
    );
    $args = array(
        'label'                 => __( 'Clientes Home', 'EstudioDigital' ),
        'description'           => __( 'Post Type Description', 'EstudioDigital' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'thumbnail' ),
        'taxonomies'            => array(  ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-groups',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
    );
    register_post_type( 'Clientes', $args );

}
add_action( 'init', 'Clientes', 0 );

// Register Custom CreamosContenido
function CreamosContenido() {

    $labels = array(
        'name'                  => _x( 'Creamos Contenido ', 'Post Type General Name', 'EstudioDigital' ),
        'singular_name'         => _x( 'Creamos Contenido', 'Post Type Singular Name', 'EstudioDigital' ),
        'menu_name'             => __( 'Creamos Contenido', 'EstudioDigital' ),
        'name_admin_bar'        => __( 'Creamos Contenido', 'EstudioDigital' ),
        'archives'              => __( 'Archivo', 'EstudioDigital' ),
        'attributes'            => __( 'Atributos', 'EstudioDigital' ),
        'parent_item_colon'     => __( 'Artículo principal', 'EstudioDigital' ),
        'all_items'             => __( 'Todos los artículos', 'EstudioDigital' ),
        'add_new_item'          => __( 'Agregar ítem nuevo', 'EstudioDigital' ),
        'add_new'               => __( 'Añadir nuevo', 'EstudioDigital' ),
        'new_item'              => __( 'Nuevo artículo', 'EstudioDigital' ),
        'edit_item'             => __( 'Editar elemento', 'EstudioDigital' ),
        'update_item'           => __( 'Actualizar artículo', 'EstudioDigital' ),
        'view_item'             => __( 'Ver ítem', 'EstudioDigital' ),
        'view_items'            => __( 'Ver artículos', 'EstudioDigital' ),
        'search_items'          => __( 'Buscar artículo', 'EstudioDigital' ),
        'not_found'             => __( 'Extraviado', 'EstudioDigital' ),
        'not_found_in_trash'    => __( 'No se encuentra en la basura', 'EstudioDigital' ),
        'featured_image'        => __( 'Foto principal', 'EstudioDigital' ),
        'set_featured_image'    => __( 'Establecer imagen destacada', 'EstudioDigital' ),
        'remove_featured_image' => __( 'Remove featured image', 'EstudioDigital' ),
        'use_featured_image'    => __( 'Usar como imagen destacada', 'EstudioDigital' ),
        'insert_into_item'      => __( 'Insertar en el elemento', 'EstudioDigital' ),
        'uploaded_to_this_item' => __( 'Subido a este artículo', 'EstudioDigital' ),
        'items_list'            => __( 'Lista de artículos', 'EstudioDigital' ),
        'items_list_navigation' => __( 'Lista de elementos de navegación', 'EstudioDigital' ),
        'filter_items_list'     => __( 'Lista de elementos de filtro', 'EstudioDigital' ),
    );
    $args = array(
        'label'                 => __( 'Creamos Contenido', 'EstudioDigital' ),
        'description'           => __( 'Post Type Description', 'EstudioDigital' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'thumbnail' ),
        'taxonomies'            => array(  ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-welcome-write-blog',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
    );
    register_post_type( 'CreamosContenido', $args );

}
add_action( 'init', 'CreamosContenido', 0 );


// Register Custom Portafolio
function Portafolio() {

    $labels = array(
        'name'                  => _x( 'Portafolio ', 'Post Type General Name', 'EstudioDigital' ),
        'singular_name'         => _x( 'Portafolio', 'Post Type Singular Name', 'EstudioDigital' ),
        'menu_name'             => __( 'Portafolio', 'EstudioDigital' ),
        'name_admin_bar'        => __( 'Portafolio', 'EstudioDigital' ),
        'archives'              => __( 'Archivo', 'EstudioDigital' ),
        'attributes'            => __( 'Atributos', 'EstudioDigital' ),
        'parent_item_colon'     => __( 'Artículo principal', 'EstudioDigital' ),
        'all_items'             => __( 'Todos los artículos', 'EstudioDigital' ),
        'add_new_item'          => __( 'Agregar ítem nuevo', 'EstudioDigital' ),
        'add_new'               => __( 'Añadir nuevo', 'EstudioDigital' ),
        'new_item'              => __( 'Nuevo artículo', 'EstudioDigital' ),
        'edit_item'             => __( 'Editar elemento', 'EstudioDigital' ),
        'update_item'           => __( 'Actualizar artículo', 'EstudioDigital' ),
        'view_item'             => __( 'Ver ítem', 'EstudioDigital' ),
        'view_items'            => __( 'Ver artículos', 'EstudioDigital' ),
        'search_items'          => __( 'Buscar artículo', 'EstudioDigital' ),
        'not_found'             => __( 'Extraviado', 'EstudioDigital' ),
        'not_found_in_trash'    => __( 'No se encuentra en la basura', 'EstudioDigital' ),
        'featured_image'        => __( 'Foto principal', 'EstudioDigital' ),
        'set_featured_image'    => __( 'Establecer imagen destacada', 'EstudioDigital' ),
        'remove_featured_image' => __( 'Remove featured image', 'EstudioDigital' ),
        'use_featured_image'    => __( 'Usar como imagen destacada', 'EstudioDigital' ),
        'insert_into_item'      => __( 'Insertar en el elemento', 'EstudioDigital' ),
        'uploaded_to_this_item' => __( 'Subido a este artículo', 'EstudioDigital' ),
        'items_list'            => __( 'Lista de artículos', 'EstudioDigital' ),
        'items_list_navigation' => __( 'Lista de elementos de navegación', 'EstudioDigital' ),
        'filter_items_list'     => __( 'Lista de elementos de filtro', 'EstudioDigital' ),
    );
    $args = array(
        'label'                 => __( 'Portafolio Home', 'EstudioDigital' ),
        'description'           => __( 'Post Type Description', 'EstudioDigital' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'thumbnail' ),
        'taxonomies'            => array(  ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-portfolio',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
    );
    register_post_type( 'Portafolio', $args );

}
add_action( 'init', 'Portafolio', 0 );


// Register Custom Aliados
function Aliados() {

    $labels = array(
        'name'                  => _x( 'Aliados ', 'Post Type General Name', 'EstudioDigital' ),
        'singular_name'         => _x( 'Aliados', 'Post Type Singular Name', 'EstudioDigital' ),
        'menu_name'             => __( 'Aliados', 'EstudioDigital' ),
        'name_admin_bar'        => __( 'Aliados', 'EstudioDigital' ),
        'archives'              => __( 'Archivo', 'EstudioDigital' ),
        'attributes'            => __( 'Atributos', 'EstudioDigital' ),
        'parent_item_colon'     => __( 'Artículo principal', 'EstudioDigital' ),
        'all_items'             => __( 'Todos los artículos', 'EstudioDigital' ),
        'add_new_item'          => __( 'Agregar ítem nuevo', 'EstudioDigital' ),
        'add_new'               => __( 'Añadir nuevo', 'EstudioDigital' ),
        'new_item'              => __( 'Nuevo artículo', 'EstudioDigital' ),
        'edit_item'             => __( 'Editar elemento', 'EstudioDigital' ),
        'update_item'           => __( 'Actualizar artículo', 'EstudioDigital' ),
        'view_item'             => __( 'Ver ítem', 'EstudioDigital' ),
        'view_items'            => __( 'Ver artículos', 'EstudioDigital' ),
        'search_items'          => __( 'Buscar artículo', 'EstudioDigital' ),
        'not_found'             => __( 'Extraviado', 'EstudioDigital' ),
        'not_found_in_trash'    => __( 'No se encuentra en la basura', 'EstudioDigital' ),
        'featured_image'        => __( 'Foto principal', 'EstudioDigital' ),
        'set_featured_image'    => __( 'Establecer imagen destacada', 'EstudioDigital' ),
        'remove_featured_image' => __( 'Remove featured image', 'EstudioDigital' ),
        'use_featured_image'    => __( 'Usar como imagen destacada', 'EstudioDigital' ),
        'insert_into_item'      => __( 'Insertar en el elemento', 'EstudioDigital' ),
        'uploaded_to_this_item' => __( 'Subido a este artículo', 'EstudioDigital' ),
        'items_list'            => __( 'Lista de artículos', 'EstudioDigital' ),
        'items_list_navigation' => __( 'Lista de elementos de navegación', 'EstudioDigital' ),
        'filter_items_list'     => __( 'Lista de elementos de filtro', 'EstudioDigital' ),
    );
    $args = array(
        'label'                 => __( 'Aliados Home', 'EstudioDigital' ),
        'description'           => __( 'Post Type Description', 'EstudioDigital' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'thumbnail' ),
        'taxonomies'            => array(  ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-buddicons-buddypress-logo',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
    );
    register_post_type( 'Aliados', $args );

}
add_action( 'init', 'Aliados', 0 );



// Register Custom Servicio
function Servicios() {

    $labels = array(
        'name'                  => _x( 'Servicios ', 'Post Type General Name', 'EstudioDigital' ),
        'singular_name'         => _x( 'Servicios', 'Post Type Singular Name', 'EstudioDigital' ),
        'menu_name'             => __( 'Servicios', 'EstudioDigital' ),
        'name_admin_bar'        => __( 'Servicios', 'EstudioDigital' ),
        'archives'              => __( 'Archivo', 'EstudioDigital' ),
        'attributes'            => __( 'Atributos', 'EstudioDigital' ),
        'parent_item_colon'     => __( 'Artículo principal', 'EstudioDigital' ),
        'all_items'             => __( 'Todos los artículos', 'EstudioDigital' ),
        'add_new_item'          => __( 'Agregar ítem nuevo', 'EstudioDigital' ),
        'add_new'               => __( 'Añadir nuevo', 'EstudioDigital' ),
        'new_item'              => __( 'Nuevo artículo', 'EstudioDigital' ),
        'edit_item'             => __( 'Editar elemento', 'EstudioDigital' ),
        'update_item'           => __( 'Actualizar artículo', 'EstudioDigital' ),
        'view_item'             => __( 'Ver ítem', 'EstudioDigital' ),
        'view_items'            => __( 'Ver artículos', 'EstudioDigital' ),
        'search_items'          => __( 'Buscar artículo', 'EstudioDigital' ),
        'not_found'             => __( 'Extraviado', 'EstudioDigital' ),
        'not_found_in_trash'    => __( 'No se encuentra en la basura', 'EstudioDigital' ),
        'featured_image'        => __( 'Foto principal', 'EstudioDigital' ),
        'set_featured_image'    => __( 'Establecer imagen destacada', 'EstudioDigital' ),
        'remove_featured_image' => __( 'Remove featured image', 'EstudioDigital' ),
        'use_featured_image'    => __( 'Usar como imagen destacada', 'EstudioDigital' ),
        'insert_into_item'      => __( 'Insertar en el elemento', 'EstudioDigital' ),
        'uploaded_to_this_item' => __( 'Subido a este artículo', 'EstudioDigital' ),
        'items_list'            => __( 'Lista de artículos', 'EstudioDigital' ),
        'items_list_navigation' => __( 'Lista de elementos de navegación', 'EstudioDigital' ),
        'filter_items_list'     => __( 'Lista de elementos de filtro', 'EstudioDigital' ),
    );
    $args = array(
        'label'                 => __( 'Servicios Home', 'EstudioDigital' ),
        'description'           => __( 'Post Type Description', 'EstudioDigital' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'thumbnail' ),
        'taxonomies'            => array(  ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-image-filter',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
    );
    register_post_type( 'Servicios', $args );

}
add_action( 'init', 'Servicios', 0 );


// Register Custom Blog
function Blog() {

    $labels = array(
        'name'                  => _x( 'Blog ', 'Post Type General Name', 'EstudioDigital' ),
        'singular_name'         => _x( 'Blog', 'Post Type Singular Name', 'EstudioDigital' ),
        'menu_name'             => __( 'Blog', 'EstudioDigital' ),
        'name_admin_bar'        => __( 'Blog', 'EstudioDigital' ),
        'archives'              => __( 'Archivo', 'EstudioDigital' ),
        'attributes'            => __( 'Atributos', 'EstudioDigital' ),
        'parent_item_colon'     => __( 'Artículo principal', 'EstudioDigital' ),
        'all_items'             => __( 'Todos los artículos', 'EstudioDigital' ),
        'add_new_item'          => __( 'Agregar ítem nuevo', 'EstudioDigital' ),
        'add_new'               => __( 'Añadir nuevo', 'EstudioDigital' ),
        'new_item'              => __( 'Nuevo artículo', 'EstudioDigital' ),
        'edit_item'             => __( 'Editar elemento', 'EstudioDigital' ),
        'update_item'           => __( 'Actualizar artículo', 'EstudioDigital' ),
        'view_item'             => __( 'Ver ítem', 'EstudioDigital' ),
        'view_items'            => __( 'Ver artículos', 'EstudioDigital' ),
        'search_items'          => __( 'Buscar artículo', 'EstudioDigital' ),
        'not_found'             => __( 'Extraviado', 'EstudioDigital' ),
        'not_found_in_trash'    => __( 'No se encuentra en la basura', 'EstudioDigital' ),
        'featured_image'        => __( 'Foto principal', 'EstudioDigital' ),
        'set_featured_image'    => __( 'Establecer imagen destacada', 'EstudioDigital' ),
        'remove_featured_image' => __( 'Remove featured image', 'EstudioDigital' ),
        'use_featured_image'    => __( 'Usar como imagen destacada', 'EstudioDigital' ),
        'insert_into_item'      => __( 'Insertar en el elemento', 'EstudioDigital' ),
        'uploaded_to_this_item' => __( 'Subido a este artículo', 'EstudioDigital' ),
        'items_list'            => __( 'Lista de artículos', 'EstudioDigital' ),
        'items_list_navigation' => __( 'Lista de elementos de navegación', 'EstudioDigital' ),
        'filter_items_list'     => __( 'Lista de elementos de filtro', 'EstudioDigital' ),
    );
    $args = array(
        'label'                 => __( 'Blog Home', 'EstudioDigital' ),
        'description'           => __( 'Post Type Description', 'EstudioDigital' ),
        'labels'                => $labels,
        'supports'              => array( 'title','editor', 'thumbnail' ),
        'taxonomies'            => array(  ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-feedback',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
    );
    register_post_type( 'Blog', $args );

}
add_action( 'init', 'Blog', 0 );


/***************** Meta *****************/
function meta_value( $meta_key, $post_id ){
            global $wpdb;  
              $result_link = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."postmeta WHERE meta_key = '$meta_key' and post_id = '$post_id'"); 
              foreach($result_link as $r)
              {
                      $value = $r->meta_value;                      
              }
              $value = str_replace("\n", "<br>", $value); 
              return $value;
}
/***************** Meta IMG *****************/
function meta_value_img( $meta_key, $post_id ){
            global $wpdb;  
              $result_link = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."postmeta WHERE meta_key = '$meta_key' and post_id = '$post_id'"); 
              foreach($result_link as $r)
              {
                      $value = $r->meta_value;                      
              }
              $result_link1 = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."posts WHERE ID = '$value'"); 
              foreach($result_link1 as $r1)
               {
                      $value_img = $r1->guid;                      
              }              
              return $value_img;
}
