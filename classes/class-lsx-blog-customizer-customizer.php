<?php
/**
 * LSX_Blog_Customizer_Customizer
 *
 * @package   lsx-blog-customizer
 * @author    LightSpeed
 * @license   GPL-2.0+
 * @link      
 * @copyright 2016 LightSpeedDevelopment
 */

if ( ! class_exists( 'LSX_Blog_Customizer_Customizer' ) ) {

	/**
	 * Customizer plugin class.
	 *
	 * @package LSX_Blog_Customizer_Customizer
	 * @author  LightSpeed
	 */
	class LSX_Blog_Customizer_Customizer extends LSX_Blog_Customizer {

		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'customize_register', array( $this, 'customize_register' ), 20 );
			add_filter( 'body_class',         array( $this, 'body_class' ) );
			add_filter( 'post_class',         array( $this, 'post_class' ) );
			add_action( 'wp',                 array( $this, 'layout' ), 999 );
		}

		/**
		 * Customizer Controls and Settings
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 * @since 1.0.0
		 */
		public function customize_register( $wp_customize ) {
			/**
			 * Add the blog panel
			 */
			$wp_customize->add_panel( 'lsx_blog_customizer_panel', array(
				'priority'       	=> 60,
				'capability'     	=> 'edit_theme_options',
				'theme_supports' 	=> '',
				'title'				=> esc_html__( 'Blog', 'lsx-blog-customizer' ),
				'description'    	=> esc_html__( 'Customise the appearance of your blog posts and archives.', 'lsx-blog-customizer' ),
			) );

			/**
			 * General section
			 */
			$wp_customize->add_section( 'lsx_blog_customizer_general' , array(
				'title'      	=> esc_html__( 'General', 'lsx-blog-customizer' ),
				'priority'   	=> 10,
				'description' 	=> esc_html__( 'Customise the look & feel of the blog archives and blog post pages', 'lsx-blog-customizer' ),
				'panel'			=> 'lsx_blog_customizer_panel',
			) );

			/**
			 * Blog archives section
			 */
			$wp_customize->add_section( 'lsx_blog_customizer_archive' , array(
				'title'      	=> esc_html__( 'Archives', 'lsx-blog-customizer' ),
				'priority'   	=> 20,
				'description' 	=> esc_html__( 'Customise the look & feel of the blog archives', 'lsx-blog-customizer' ),
				'panel'			=> 'lsx_blog_customizer_panel',
			) );

			/**
			 * Single blog post section
			 */
			$wp_customize->add_section( 'lsx_blog_customizer_single' , array(
				'title'      	=> esc_html__( 'Single posts', 'lsx-blog-customizer' ),
				'priority'   	=> 30,
				'description' 	=> esc_html__( 'Customise the look & feel of the blog post pages', 'lsx-blog-customizer' ),
				'panel'			=> 'lsx_blog_customizer_panel',
			) );

			/**
			 * General section: display date
			 */
			$wp_customize->add_setting( 'lsx_blog_customizer_general_date', array(
				'default'           => true,
				'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lsx_blog_customizer_general_date', array(
				'label'         => esc_html__( 'Display date', 'lsx-blog-customizer' ),
				'description'   => esc_html__( 'Display post date in blog archives and blog post pages.', 'lsx-blog-customizer' ),
				'section'       => 'lsx_blog_customizer_general',
				'settings'      => 'lsx_blog_customizer_general_date',
				'type'          => 'checkbox',
				'priority'      => 10,
			) ) );

			/**
			 * General section: display author
			 */
			$wp_customize->add_setting( 'lsx_blog_customizer_general_author', array(
				'default'           => true,
				'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lsx_blog_customizer_general_author', array(
				'label'         => esc_html__( 'Display author', 'lsx-blog-customizer' ),
				'description'   => esc_html__( 'Display post author in blog archives and blog post pages.', 'lsx-blog-customizer' ),
				'section'       => 'lsx_blog_customizer_general',
				'settings'      => 'lsx_blog_customizer_general_author',
				'type'          => 'checkbox',
				'priority'      => 20,
			) ) );

			/**
			 * General section: display categories
			 */
			$wp_customize->add_setting( 'lsx_blog_customizer_general_category', array(
				'default'           => true,
				'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lsx_blog_customizer_general_category', array(
				'label'         => esc_html__( 'Display categories', 'lsx-blog-customizer' ),
				'description'   => esc_html__( 'Display post categories in blog archives and blog post pages.', 'lsx-blog-customizer' ),
				'section'       => 'lsx_blog_customizer_general',
				'settings'      => 'lsx_blog_customizer_general_category',
				'type'          => 'checkbox',
				'priority'      => 30,
			) ) );

			/**
			 * General section: display tags
			 */
			$wp_customize->add_setting( 'lsx_blog_customizer_general_tags', array(
				'default'           => true,
				'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lsx_blog_customizer_general_tags', array(
				'label'         => esc_html__( 'Display tags', 'lsx-blog-customizer' ),
				'description'   => esc_html__( 'Display post tags in blog archives and blog post pages.', 'lsx-blog-customizer' ),
				'section'       => 'lsx_blog_customizer_general',
				'settings'      => 'lsx_blog_customizer_general_tags',
				'type'          => 'checkbox',
				'priority'      => 30,
			) ) );

			/**
			 * Post section: display thumbnail
			 */
			$wp_customize->add_setting( 'lsx_blog_customizer_single_thumbnail', array(
				'default'           => true,
				'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lsx_blog_customizer_single_thumbnail', array(
				'label'         => esc_html__( 'Display thumbnail', 'lsx-blog-customizer' ),
				'description'   => esc_html__( 'Display post thumbnail in blog post pages.', 'lsx-blog-customizer' ),
				'section'       => 'lsx_blog_customizer_single',
				'settings'      => 'lsx_blog_customizer_single_thumbnail',
				'type'          => 'checkbox',
				'priority'      => 10,
			) ) );
		}

		/**
		 * Layout
		 */
		public function layout() {
			$body_classes               = get_body_class();
			
			$is_archive                 = in_array( 'blog', $body_classes ) || is_archive() || is_category() || is_tag() || is_date() || is_search();
			$is_single_post             = is_singular( 'post' );
			$is_archive_or_single_post  = $is_archive || $is_single_post;

			$general_date               = get_theme_mod( 'lsx_blog_customizer_general_date', true );
			$general_author             = get_theme_mod( 'lsx_blog_customizer_general_author', true );
			$general_category           = get_theme_mod( 'lsx_blog_customizer_general_category', true );
			$general_tags               = get_theme_mod( 'lsx_blog_customizer_general_tags', true );

			$single_thumbnail           = get_theme_mod( 'lsx_blog_customizer_single_thumbnail', true );

			if ( $is_archive_or_single_post && false == $general_date ) {
				remove_action( 'lsx_content_post_meta', 'lsx_post_meta_date', 10 );
			}

			if ( $is_archive_or_single_post && false == $general_author ) {
				remove_action( 'lsx_content_post_meta', 'lsx_post_meta_author', 20 );
			}

			if ( $is_archive_or_single_post && false == $general_category ) {
				remove_action( 'lsx_content_post_meta', 'lsx_post_meta_category', 30 );
			}

			if ( $is_archive_or_single_post && false == $general_tags ) {
				remove_action( 'lsx_content_post_tags', 'lsx_post_tags', 10 );
			}

			if ( $is_single_post && false == $single_thumbnail ) {
				add_filter( 'lsx_allowed_post_type_banners', function( $post_types ) {
					if ( ( $key = array_search( 'post', $post_types ) ) !== false ) {
						unset( $post_types[$key] );
					}

					return $post_types;
				} );
			}
		}

		/**
		 * Body class
		 *
		 * @param array $classes the classes applied to the body tag.
		 * @return array $classes the classes applied to the body tag.
		 */
		public function body_class( $body_classes ) {
			$is_archive                 = in_array( 'blog', $body_classes ) || is_archive() || is_category() || is_tag() || is_date() || is_search();
			$is_single_post             = is_singular( 'post' );
			$is_archive_or_single_post  = $is_archive || $is_single_post;

			$general_date               = get_theme_mod( 'lsx_blog_customizer_general_date', true );
			$general_author             = get_theme_mod( 'lsx_blog_customizer_general_author', true );
			$general_category           = get_theme_mod( 'lsx_blog_customizer_general_category', true );
			
			if ( $is_archive_or_single_post && false == $general_date ) {
				$body_classes[] = 'lsx-hide-post-date';
			}

			if ( $is_archive_or_single_post && false == $general_author ) {
				$body_classes[] = 'lsx-hide-post-author';
			}

			if ( $is_archive_or_single_post && false == $general_category ) {
				$body_classes[] = 'lsx-hide-post-category';
			}

			return $body_classes;
		}

		/**
		 * Post class.
		 *
		 * @param  array $classes The classes.
		 * @return array $classes The classes.
		 */
		function post_class( $classes ) {
			$body_classes               = get_body_class();
			
			$is_archive                 = in_array( 'blog', $body_classes ) || is_archive() || is_category() || is_tag() || is_date() || is_search();
			$is_single_post             = is_singular( 'post' );
			$is_archive_or_single_post  = $is_archive || $is_single_post;

			$general_tags               = get_theme_mod( 'lsx_blog_customizer_general_tags', true );

			if ( $is_single_post && false == $general_tags ) {
				if ( ! function_exists( 'sharing_display' ) && ! class_exists( 'Jetpack_Likes' ) ) {
					$classes[] = 'lsx-hide-post-tags';
				}
			} elseif ( $is_archive && false == $general_tags ) {
				if ( ! comments_open() || empty( get_comments_number() ) ) {
					$classes[] = 'lsx-hide-post-tags';
				}
			}

			return $classes;
		}

	}

	new LSX_Blog_Customizer_Customizer;

}
