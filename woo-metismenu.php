<?php
/**
* Plugin Name: Woo Responsive Product Category
* Plugin URI: http://sketsaweb.com/
* Description: Display WooCommerce Product Categories Widget in Responsive
* Version: 1.0
* Author: Ponco
* Author URI: http://sketsaweb.com
* License: GPL
*/

add_action( 'wp_enqueue_scripts', 'load_woometismenu_assets' );

function load_woometismenu_assets() {
	wp_enqueue_style( 'metismenu', plugin_dir_url( __FILE__ ) . 'assets/metismenu/metisMenu.min.css' );
	wp_enqueue_style( 'woo-metismenu', plugin_dir_url( __FILE__ ) . 'assets/woo-metismenu.css' );
	wp_enqueue_script( 'metismenu', plugin_dir_url( __FILE__ ) . 'assets/metismenu/metisMenu.min.js', array( 'jquery' ), '1.0', true );
	wp_enqueue_script( 'woo-metismenu', plugin_dir_url( __FILE__ ) . 'assets/woo-metismenu.js', array( 'jquery','metismenu' ), '1.0', true );
}

class WooMetisMenu {

function displayCategoriesMetis() {
	$list_args = array( 'show_count' => false, 'hierarchical' => true, 'taxonomy' => 'product_cat', 'hide_empty' => false );
	$list_args['title_li']  = NULL;
	echo '<ul class="product-categories metismenu" id="menumetis">';
	wp_list_categories( apply_filters( 'woocommerce_product_categories_widget_args', $list_args ) );
	echo '</ul>';
}

}

// Creating the widget 
class woometismenu_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'woometismenu_widget', 

// Widget name will appear in UI
__('Woo Responsive Product Category', 'woometismenu'), 

// Widget description
array( 'description' => __( 'Display WooCommerce MetisMenu Category Widget', 'woometismenu' ), ) 
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );
// before and after widget arguments are defined by themes
echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] . $title . $args['after_title'];

// This is where you run the code and display the output
$wsm = new WooMetisMenu;
echo '<nav class="sidebar-nav">';
$wsm->displayCategoriesMetis();
echo '</nav>';
echo $args['after_widget'];
}
		
// Widget Backend 
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'Categories', 'woometismenu' );
}
// Widget admin form
?>
<p>
  <label for="<?php echo $this->get_field_id( 'title' ); ?>">
    <?php _e( 'Title:' ); ?>
  </label>
  <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<?php 
}
	
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
return $instance;
}
} // Class woometismenu_widget ends here

// Register and load the widget
function woometismenu_load_widget() {
	register_widget( 'woometismenu_widget' );
}
add_action( 'widgets_init', 'woometismenu_load_widget' );
