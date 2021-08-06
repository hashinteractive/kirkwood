<?php
/**
 * Plugin Name:       Kirkwood 
 * Plugin URI:        https://github.com/hashinteractive/kirkwood 
 * Description:       Custom Plugin for Kirkwood functionalty to extend WordPress.
 * Version:           1.0
 * Author:            Hash Interactive 
 * Author URI:        https://hashinteractive.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       kirkwood 
 */
add_filter('use_block_editor_for_post', '__return_false', 10);

/**
 * Register Custom Post Types.
 */
function register_custom_post_types()
{
  $types = [
    'testimonial' => [
      'icon' => 'dashicons-format-quote',
      'plural' => 'Testimonials',
      'has_archive' => true,
      'hierarchical' => false,
      'with_front' => true,
      'show_in_graphql' => true,
      'supports' => [
        'title',
        'editor',
        'thumbnail',
        'revisions',
        'custom-fields'
      ]
    ],
    'team_member' => [
      'icon' => 'dashicons-businessperson',
      'plural' => 'Team Members',
      'has_archive' => true,
      'hierarchical' => false,
      'with_front' => true,
      'show_in_graphql' => true,
      'supports' => [
        'title',
        'editor',
        'thumbnail',
        'revisions',
        'custom-fields'
      ]
    ],
    'faq' => [
      'icon' => 'dashicons-admin-comments',
      'plural' => 'FAQs',
      'has_archive' => true,
      'hierarchical' => false,
      'with_front' => true,
      'show_in_graphql' => true,
      'supports' => [
        'title',
        'editor',
        'revisions',
        'custom-fields'
      ]
    ],
    'branch' => [
      'icon' => 'dashicons-building',
      'plural' => 'Branches',
      'has_archive' => true,
      'hierarchical' => false,
      'with_front' => true,
      'show_in_graphql' => true,
      'supports' => [
        'title',
        'editor',
        'thumbnail',
        'revisions',
        'custom-fields'
      ]
    ],
    'atm' => [
      'icon' => 'dashicons-location-alt',
      'plural' => 'atms',
      'has_archive' => true,
      'hierarchical' => false,
      'with_front' => true,
      'show_in_graphql' => true,
      'supports' => [
        'title',
        'editor',
        'revisions',
        'custom-fields'
      ]
    ],
  ];

  foreach ($types as $type => $data) {
    $slug = str_replace(["/", "  ", " "], ["", " ", "_"], $type);
    $plural = isset($data['plural']) ? $data['plural'] : $type . 's';
    $plural_slug = str_replace(["/", "  ", " "], ["", " ", "_"], $plural);
    $graphql_single_name = str_replace('_', '', ucwords($slug, '_'));
    $graphql_plural_name = str_replace('_', '', ucwords($plural_slug, '_'));

    $labels = [
      'name' => ucwords($plural),
      'singular_name' => ucwords($type),
      'add_new_item' => 'Add New ' . ucwords($type),
      'edit_item' => 'Edit ' . ucwords($type),
      'new_item' => 'New ' . ucwords($type),
      'view_item' => 'View ' . ucwords($type),
      'search_items' => 'Search ' . ucwords($plural),
      'not_found' => 'No ' . strtolower($plural) . ' found',
      'not_found_in_trash' => 'No ' . strtolower($plural) . ' found in Trash',
      'parent_item_colon' => 'Parent ' . ucwords($type) . ':',
      'all_items' => 'All ' . ucwords($plural),
      'archives' => ucwords($type) . ' Archives',
    ];

    $args = [
      'labels' => $labels,
      'description' => 'Sortable/filterable ' . $plural,
      'public' => true,
      'has_archive' => isset($data['has_archive']) ? $data['has_archive'] : false,
      'show_ui' => isset($data['show']) ? $data['show'] : true,
      'show_in_nav_menus' => isset($data['show']) ? $data['show'] : true,
      'show_in_menu' => isset($data['show']) ? $data['show'] : true,
      'show_in_admin_bar' => isset($data['show']) ? $data['show'] : true,
      'menu_position' => 20,
      'menu_icon' => $data['icon'],
      'hierarchical' => isset($data['hierarchical']) ? $data['hierarchical'] : true,
      'rewrite' => [
        'slug' => isset($data['slug_base']) ? $data['slug_base'] . $slug : $slug,
        'with_front' => isset($data['with_front']) ? $data['with_fron'] : false,
        'feeds' => true,
      ],
      'query_var' => true,
      'show_in_rest' => true,
      'supports' => isset($data['supports']) ? $data['supports'] : [
        'title',
        'editor',
        'revisions',
        'custom-fields'
      ],
      'show_in_graphql' => isset($data['show_in_graphql']) ? $data['show_in_graphql'] : true,
      'graphql_single_name' => $graphql_single_name,
      'graphql_plural_name' => $graphql_plural_name,
    ];

    register_post_type($slug, $args);
    flush_rewrite_rules();
  }

  $taxonomies = [
    'location' => [
      'plural' => 'Locations',
      'object_type' => ['branch', 'atm'],
      'hierarchical' => false,
      'meta_box_cb' => 'post_categories_meta_box',
      'show_in_graphql' => true
    ],
    'faq_category' => [
      'plural' => 'Faqs Categories',
      'object_type' => ['faq'],
      'hierarchical' => false,
      'meta_box_cb' => 'post_categories_meta_box',
      'show_in_graphql' => true
    ]
  ];
  foreach ($taxonomies as $taxonomy => $data) {
    $slug = str_replace(["/", "  ", " "], ["", " ", "_"], $taxonomy);
    $plural = isset($data['plural']) ? $data['plural'] : $taxonomy . 's';
    $plural_slug = str_replace(["/", "  ", " "], ["", " ", "_"], $plural);
    $graphql_single_name = str_replace('_', '', ucwords($slug, '_'));
    $graphql_plural_name = str_replace('_', '', ucwords($plural_slug, '_'));

    $labels = [
      'name' => ucwords($plural),
    ];

    $args = [
      'labels' => $labels,
      'description' => 'Custom Taxonomy ' . $plural,
      'public' => true,
      'show_ui' => isset($data['show']) ? $data['show'] : true,
      'show_in_nav_menus' => isset($data['show']) ? $data['show'] : true,
      'show_in_menu' => isset($data['show']) ? $data['show'] : true,
      'show_admin_column' => isset($data['show']) ? $data['show'] : true,
      'show_tagcloud' => false,
      'menu_position' => 20,
      'menu_icon' => $data['icon'],
      'hierarchical' => isset($data['hierarchical']) ? $data['hierarchical'] : true,
      'meta_box_cb' => isset($data['meta_box_cb']) ? $data['meta_box_cb'] : 'post_categories_meta_box',
      'rewrite' => [
        'slug' => isset($data['slug_base']) ? $data['slug_base'] . $slug : $slug,
        'with_front' => false,
      ],
      'query_var' => true,
      'show_in_rest' => true,
      'show_in_graphql' => isset($data['show_in_graphql']) ? $data['show_in_graphql'] : true,
      'graphql_single_name' => $graphql_single_name,
      'graphql_plural_name' => $graphql_plural_name,
    ];

    register_taxonomy($slug, $data['object_type'], $args);
    flush_rewrite_rules();
  }
}
add_action('init', 'register_custom_post_types');

/** Allow SVG types */
function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  $mimes['webp'] = 'image/webp';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

/**
 * Register Menus
 */
function kirkwood_register_nav_menus(){
  register_nav_menus( array(
      'top' => __( 'Top Header', 'kirkwood' ),
      'main' => __( 'Main Menu', 'kirkwood' ),
      'footer_personal' => __( 'Footer Personal', 'kirkwood' ),
      'footer_business'  => __( 'Footer Business', 'kirkwood' ),
      'footer_wealth'  => __( 'Footer Wealth', 'kirkwood' ),
      'footer_quick'  => __( 'Footer Quick Links', 'kirkwood' ),
  ) );
}
add_action( 'after_setup_theme', 'kirkwood_register_nav_menus', 0 );

/** Add Page Templates Using Plugin */
require_once( plugin_dir_path( __FILE__ ) . 'page-templater.php' );
add_action( 'plugins_loaded', array( 'PageTemplater', 'get_instance' ) );

add_action('graphql_register_types', function () {
  register_graphql_field('Page', 'pageTemplate', [
      'type' => 'String',
      'description' => 'WordPress Page Template',
      'resolve' => function ($post) {
          $template = get_post_meta( $post->ID, '_wp_page_template', true );
          $ext = pathinfo($template, PATHINFO_EXTENSION);
          $slug = basename($template,".".$ext);
          return $slug;
      },
  ]);
});