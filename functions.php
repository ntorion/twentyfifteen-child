<?php

add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );
function enqueue_parent_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}

/* New Post Type */

function custom_post_article() {
  $labels = array(
    'name'               => _x( 'Articles', 'post type general name' ),
    'singular_name'      => _x( 'Article', 'post type singular name' ),
    'add_new'            => _x( 'Add New', 'book' ),
    'add_new_item'       => __( 'Add New Article' ),
    'edit_item'          => __( 'Edit Article' ),
    'new_item'           => __( 'New Article' ),
    'all_items'          => __( 'All Articles' ),
    'view_item'          => __( 'View Article' ),
    'search_items'       => __( 'Search Articles' ),
    'not_found'          => __( 'No articles found' ),
    'not_found_in_trash' => __( 'No articles found in the Trash' ),
    'parent_item_colon'  => '',
    'menu_name'          => 'Articles'
  );
  $args = array(
    'labels'        => $labels,
    'description'   => 'Holds our articles and product specific data',
    'public'        => true,
    'menu_position' => 5,
    'supports'      => array( 'title', 'editor', 'comments' ),
    'has_archive'   => true,
  );
  register_post_type( 'article', $args );
}
add_action( 'init', 'custom_post_article' );

/* Messages */

function updated_messages( $messages ) {
  global $post, $post_ID;
  $messages['article'] = array(
    0 => '',
    1 => sprintf( __('Article updated. <a href="%s">View article</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Article updated.'),
    5 => isset($_GET['revision']) ? sprintf( __('Article restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Article published. <a href="%s">View product</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Product saved.'),
    8 => sprintf( __('Article submitted. <a target="_blank" href="%s">Preview article</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Article scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview article</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Article draft updated. <a target="_blank" href="%s">Preview article</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );
  return $messages;
}
add_filter( 'post_updated_messages', 'updated_messages' );

/* Contextual help */

function contextual_help( $contextual_help, $screen_id, $screen ) {
  if ( 'article' == $screen->id ) {

    $contextual_help = '<h2>Products</h2>
    <p>Articles</p> 
    <p>You can view/edit the conent of each article by clicking on its name, or you can perform bulk actions using the dropdown menu and selecting multiple items.</p>';

  } elseif ( 'edit-article' == $screen->id ) {

    $contextual_help = '<h2>Editing articles</h2>
    <p>This page allows you to view/modify articles content.</p>';

  }
  return $contextual_help;
}
add_action( 'contextual_help', 'contextual_help', 10, 3 );

/* Taxonomies (categories) article */

function taxonomies_article() {
    $labels = array(
        'name'              => _x( 'Article Categories', 'taxonomy general name' ),
        'singular_name'     => _x( 'Article Category', 'taxonomy singular name' ),
        'search_items'      => __( 'Search Article Categories' ),
        'all_items'         => __( 'All Article Categories' ),
        'parent_item'       => __( 'Parent Article Category' ),
        'parent_item_colon' => __( 'Parent Article Category:' ),
        'edit_item'         => __( 'Edit Article Category' ),
        'update_item'       => __( 'Update Article Category' ),
        'add_new_item'      => __( 'Add New Article Category' ),
        'new_item_name'     => __( 'New Article Category' ),
        'menu_name'         => __( 'Article Categories' ),
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
    );
    register_taxonomy( 'product_category', 'article', $args );
}
add_action( 'init', 'taxonomies_article', 0 );

/* Meta Boxes */

