<?php

//------------------------------------------------
// ** UPDATE CHECKER **
//------------------------------------------------

require_once get_template_directory() . '/includes/plugin-update-checker/plugin-update-checker.php';
function theme_setup_updater() {
    if (!is_admin()) {
        return;
    }
    
    $update_checker = YahnisElsts\PluginUpdateChecker\v5\PucFactory::buildUpdateChecker(
        'https://github.com/pomeg-dev/glion-2025-theme/',
        __FILE__,
        'glion-2025-theme'
    );
}
add_action('init', 'theme_setup_updater');

//------------------------------------------------
// ** THEME SCRIPTS, STYLES AND SUPPORTS **
//------------------------------------------------

function add_theme_supports() {
    // This theme uses post thumbnails
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');
}
add_action('after_setup_theme', 'add_theme_supports');

function enqueue_figma_variables() {
    wp_enqueue_style( 'figma-variables', get_template_directory_uri() . '/admin/figma-variables.css' );
    wp_enqueue_style( 'admin-styles', get_template_directory_uri() . '/admin/admin.css' );
}
add_action( 'admin_enqueue_scripts', 'enqueue_figma_variables' );

// remove comments page.
function remove_comments_menu() {
    remove_menu_page( 'edit-comments.php' );
}
add_action( 'admin_menu', 'remove_comments_menu' );

function trim_excerpt( $length ) {
    return 15;
}
add_filter( 'excerpt_length', 'trim_excerpt', 999 );

function amend_excerpt_more( $more ) {
    return '&hellip;';
}
add_filter( 'excerpt_more', 'amend_excerpt_more' );

//------------------------------------------------
// ** TAXONOMIES **
//------------------------------------------------

// Add custom taxonomy 'event_type'
function create_event_type_taxonomy()
{
    register_taxonomy(
        'event_type',
        [ 'event' ],
        [
            'labels' => [
                'name' => __('Event Types', 'nextpress'),
                'singular_name' => __('Event Type', 'nextpress')
            ],
            'hierarchical' => true,
            'show_in_rest' => true,
            'public' => true,
            'show_admin_column' => true
        ]
    );
}
add_action('init', 'create_event_type_taxonomy');

// Add custom taxonomy 'blog_type'
function create_blog_type_taxonomy()
{
    register_taxonomy(
        'blog_type',
        [ 'post' ],
        [
            'labels' => [
                'name' => __('Blog Types', 'nextpress'),
                'singular_name' => __('Blog Type', 'nextpress')
            ],
            'hierarchical' => true,
            'show_in_rest' => true,
            'public' => true,
            'show_admin_column' => true
        ]
    );
}
add_action('init', 'create_blog_type_taxonomy');

// Add custom taxonomy 'program_type'
function create_program_type_taxonomy()
{
    register_taxonomy(
        'program_type',
        [ 'post', 'program' ],
        [
            'labels' => [
                'name' => __('Program Types', 'nextpress'),
                'singular_name' => __('Program Type', 'nextpress')
            ],
            'hierarchical' => true,
            'show_in_rest' => true,
            'public' => true,
            'show_admin_column' => true
        ]
    );
}
add_action('init', 'create_program_type_taxonomy');

// Add custom taxonomy 'persona'
function create_program_type_taxonomy()
{
    register_taxonomy(
        'persona',
        [ 'post' ],
        [
            'labels' => [
                'name' => __('Personas', 'nextpress'),
                'singular_name' => __('Persona', 'nextpress')
            ],
            'hierarchical' => true,
            'show_in_rest' => true,
            'public' => true,
            'show_admin_column' => true
        ]
    );
}
add_action('init', 'create_persona_taxonomy');

// Add custom taxonomy 'theme'
function create_theme_taxonomy()
{
    register_taxonomy(
        'theme',
        [ 'post' ],
        [
            'labels' => [
                'name' => __('Themes', 'nextpress'),
                'singular_name' => __('Theme', 'nextpress')
            ],
            'hierarchical' => true,
            'show_in_rest' => true,
            'public' => true,
            'show_admin_column' => true
        ]
    );
}
add_action('init', 'create_theme_taxonomy');

// Add custom taxonomy 'department'
function create_department_taxonomy()
{
    register_taxonomy(
        'department',
        [ 'faculty' ],
        [
            'labels' => [
                'name' => __('Departments', 'nextpress'),
                'singular_name' => __('Department', 'nextpress')
            ],
            'hierarchical' => true,
            'show_in_rest' => true,
            'public' => true,
            'show_admin_column' => true
        ]
    );
}
add_action('init', 'create_department_taxonomy');

// Add custom taxonomy 'location'
function create_location_taxonomy()
{
    register_taxonomy(
        'location',
        [ 'faculty', 'campus', 'event', 'testimonial' ],
        [
            'labels' => [
                'name' => __('Locations', 'nextpress'),
                'singular_name' => __('Location', 'nextpress')
            ],
            'hierarchical' => true,
            'show_in_rest' => true,
            'public' => true,
            'show_admin_column' => true
        ]
    );
}
add_action('init', 'create_location_taxonomy');

// Add custom taxonomy 'testimonial_type'
function create_testimonial_type_taxonomy()
{
    register_taxonomy(
        'testimonial_type',
        [ 'testimonial' ],
        [
            'labels' => [
                'name' => __('Testimonial Types', 'nextpress'),
                'singular_name' => __('Testimonial Type', 'nextpress')
            ],
            'hierarchical' => true,
            'show_in_rest' => true,
            'public' => true,
            'show_admin_column' => true
        ]
    );
}
add_action('init', 'create_testimonial_type_taxonomy');

//------------------------------------------------
// ** POST TYPES **
//------------------------------------------------

// Add custom post type 'event'
function create_event_post_type() {
    register_post_type(
        'event',
        [
            'labels' => [
                'name' => __( 'Events', 'nextpress' ),
                'singular_name' => __( 'Event', 'nextpress' )
            ],
            'public' => true,
            'publicly_queryable' => false,
            'has_archive' => false,
            'show_in_rest' => true,
            'rest_base' => 'event',
            'taxonomies'  => [ 'event_type', 'location' ],
            'supports' => [
                'title', 'thumbnail', 'custom-fields'
            ],
        ]
    );
}
add_action('init', 'create_event_post_type');

// Add custom post type 'program'
function create_program_post_type() {
    register_post_type(
        'program',
        [
            'labels' => [
                'name' => __( 'Programs', 'nextpress' ),
                'singular_name' => __( 'Program', 'nextpress' )
            ],
            'public' => true,
            'has_archive' => false,
            'show_in_rest' => true,
            'rest_base' => 'program',
            'taxonomies'  => [ 'category', 'program_type' ],
            'supports' => [
                'title', 'author', 'editor', 'excerpt', 'page-attributes', 'thumbnail', 'custom-fields'
            ],
            'rewrite' => [
                'with_front' => false,
                'slug' => 'programs'
            ],
        ]
    );
}
add_action('init', 'create_program_post_type');

// Add custom post type 'module'
function create_module_post_type() {
    register_post_type(
        'module',
        [
            'labels' => [
                'name' => __( 'Modules', 'nextpress' ),
                'singular_name' => __( 'Module', 'nextpress' )
            ],
            'public' => true,
            'publicly_queryable' => false,
            'has_archive' => false,
            'show_in_rest' => true,
            'rest_base' => 'module',
            'supports' => [
                'title', 'author', 'custom-fields'
            ],
        ]
    );
}
add_action('init', 'create_module_post_type');

// Add custom post type 'faculty'
function create_faculty_post_type() {
    register_post_type(
        'faculty',
        [
            'labels' => [
                'name' => __( 'Faculty', 'nextpress' ),
                'singular_name' => __( 'Faculty', 'nextpress' )
            ],
            'public' => true,
            'publicly_queryable' => false,
            'has_archive' => false,
            'show_in_rest' => true,
            'rest_base' => 'faculty',
            'taxonomies'  => [ 'department', 'location' ],
            'supports' => [
                'title', 'author', 'excerpt', 'page-attributes', 'thumbnail', 'custom-fields'
            ],
        ]
    );
}
add_action('init', 'create_faculty_post_type');

// Add custom post type 'campus'
function create_campus_post_type() {
    register_post_type(
        'campus',
        [
            'labels' => [
                'name' => __( 'Campus Slides', 'nextpress' ),
                'singular_name' => __( 'Campus Slide', 'nextpress' )
            ],
            'public' => true,
            'publicly_queryable' => false,
            'has_archive' => false,
            'show_in_rest' => true,
            'rest_base' => 'campus',
            'taxonomies'  => [ 'location' ],
            'supports' => [
                'title', 'author', 'excerpt', 'page-attributes', 'thumbnail', 'custom-fields'
            ],
        ]
    );
}
add_action('init', 'create_campus_post_type');

// Add custom post type 'internship'
function create_internship_post_type() {
    register_post_type(
        'internship',
        [
            'labels' => [
                'name' => __( 'Internship Slides', 'nextpress' ),
                'singular_name' => __( 'Internship Slide', 'nextpress' )
            ],
            'public' => true,
            'publicly_queryable' => false,
            'has_archive' => false,
            'show_in_rest' => true,
            'rest_base' => 'internship',
            'supports' => [
                'title', 'author', 'excerpt', 'page-attributes', 'thumbnail', 'custom-fields'
            ],
        ]
    );
}
add_action('init', 'create_internship_post_type');

// Add custom post type 'industry'
function create_industry_post_type() {
    register_post_type(
        'industry',
        [
            'labels' => [
                'name' => __( 'Industry Slides', 'nextpress' ),
                'singular_name' => __( 'Industry Slide', 'nextpress' )
            ],
            'public' => true,
            'publicly_queryable' => false,
            'has_archive' => false,
            'show_in_rest' => true,
            'rest_base' => 'industry',
            'supports' => [
                'title', 'author', 'excerpt', 'page-attributes', 'thumbnail', 'custom-fields'
            ],
        ]
    );
}
add_action('init', 'create_industry_post_type');

// Add custom post type 'testimonial'
function create_testimonial_post_type() {
    register_post_type(
        'testimonial',
        [
            'labels' => [
                'name' => __( 'Testimonial Slides', 'nextpress' ),
                'singular_name' => __( 'Testimonial Slide', 'nextpress' )
            ],
            'public' => true,
            'publicly_queryable' => false,
            'has_archive' => false,
            'show_in_rest' => true,
            'rest_base' => 'testimonial',
            'taxonomies' => [ 'testimonial_type', 'location' ],
            'supports' => [
                'title', 'author', 'custom-fields'
            ],
        ]
    );
}
add_action('init', 'create_testimonial_post_type');

//------------------------------------------------
// ** NAVS **
//------------------------------------------------

// Register standard nav menus.
function create_theme_nav_menus() {
    register_nav_menus(
        array(
            'header_nav' => __('Header Nav', 'nextpress'),
            'footer_nav' => __('Footer Nav', 'nextpress'),
        )
    );
}
add_action('after_setup_theme', 'create_theme_nav_menus');

//------------------------------------------------
// ** EDITOR **
//------------------------------------------------

function create_custom_editor_styles( $buttons ) {
	array_unshift( $buttons, 'styleselect ');
	return $buttons;
}
add_filter('mce_buttons_2', 'create_custom_editor_styles');

// Adds 'Serif' as a Format style for tinymce.
function add_custom_format_styles( $init_array ) {
    $style_formats = [
        [
            'title' => 'Serif',  
            'inline' => 'span',  
            'classes' => 'serif',
            'wrapper' => true,
        ],
        [
            'title' => 'Cursive',  
            'inline' => 'span',  
            'classes' => 'cursive',
            'wrapper' => true,
        ],
        [
            'title' => 'Text Primary',  
            'inline' => 'span',  
            'classes' => 'text-primary',
            'wrapper' => false,
        ],
        [
            'title' => 'Text Secondary',  
            'inline' => 'span',  
            'classes' => 'text-secondary',
            'wrapper' => false,
        ],
    ];

    $heading_styles = ['3xl', '2xl', 'xl', 'lg', 'md', 'sm', 'xs'];
    foreach ( $heading_styles as $heading ) {
        $style_formats[] = [
            'title' => 'Heading ' . $heading,
            'inline' => 'span',
            'classes' => 'text-heading-'  . $heading,
            'wrapper' => false,
        ];
    }

    $style_formats[] = [
        'title' => 'USP Grid',
        'block' => 'div',
        'classes' => 'usp-grid',
        'wrapper' => true,
        'selector' => 'ul'
    ];

    $init_array['style_formats'] = json_encode( $style_formats );
    return $init_array;  
} 
add_filter( 'tiny_mce_before_init', 'add_custom_format_styles' );

//------------------------------------------------
// ** ACF **
//------------------------------------------------

require_once get_template_directory() . '/acf/mega-menu.php';
require_once get_template_directory() . '/acf/block-options.php';
require_once get_template_directory() . '/acf/page-settings.php';
require_once get_template_directory() . '/acf/post-settings.php';
require_once get_template_directory() . '/acf/events.php';
require_once get_template_directory() . '/acf/industry.php';
require_once get_template_directory() . '/acf/internship.php';
require_once get_template_directory() . '/acf/modules.php';
require_once get_template_directory() . '/acf/faculty.php';
require_once get_template_directory() . '/acf/campus.php';
require_once get_template_directory() . '/acf/testimonial.php';

function add_to_block_layouts( $layout ) {
    $layout->addAccordion('Block Options')
        ->addSelect('padding_top', [
            'label' => 'Padding Top',
            'choices' => [
                '' => 'Default',
				0 => 'None',
				'xs' => 'Extra Small',
				'sm' => 'Small',
				'md' => 'Medium',
				'lg' => 'Large',
            ],
            'default_value' => ''
        ])
        ->addSelect('padding_bottom', [
            'label' => 'Padding Bottom',
            'choices' => [
                '' => 'Default',
				0 => 'None',
				'xs' => 'Extra Small',
				'sm' => 'Small',
				'md' => 'Medium',
				'lg' => 'Large',
            ],
            'default_value' => ''
        ])
        ->addSelect('theme_override', [
            'label' => 'Block Theme',
            'choices' => [
                'sommet' => 'Default',
				'glion-light' => 'Glion Light',
				'glion-blue' => 'Glion Blue',
				'glion-bronze' => 'Glion Bronze',
            ],
            'default_value' => 'sommet'
        ]);
    return $layout;
}
add_filter( 'nextpress_block_layouts', 'add_to_block_layouts' );

// Ensure correct post object is returned for required fields.
function format_next_post_object( $value, $post_id, $field ) {
    if ( is_array( $value ) && class_exists( 'nextpress\Post_Formatter' ) ) {
        foreach ( $value as $key => $post_object ) {
            if ( is_object( $post_object ) ) {
                $formatter = new nextpress\Post_Formatter();
                $value[ $key ] = $formatter->format_post( $post_object, false, false );
            }
        }
    }
    return $value;
}
add_filter('acf/format_value/name=testimonials', 'format_next_post_object', 10, 3);
add_filter('acf/format_value/name=modules', 'format_next_post_object', 10, 3);
add_filter('acf/format_value/name=events', 'format_next_post_object', 10, 3);
