<?php
/*
* Plugin Name: Leverage FeatureBox
* Plugin URI: http://www.increasingleverage.com/leverage-featurebox-wordpress-plugin
* Description: The Leverage FeatureBox widget creates responsive, formatted, high converting optin feature boxes that turn your website visitors into subscribers.
* Version: 1.1
* Author: Zachary Smith | Increasing Leverage
* Author URI: http://www.increasingleverage.com
* Copyright 2015 Zachary Smith
*/
class leverage_featurebox extends WP_Widget {
public function __construct() {
		parent::__construct(
	 		'leverage_featurebox', // Base ID
			'Leverage FeatureBox', // Name
 
			array( 'description' => __( 'The Leverage FeatureBox widget converts website visitors into subscribers', 'zs' ), ) // Args
		);
	}
public function widget( $args, $instance )
	{
		extract( $args );
		$input = $before_widget;
		static $i = 0;
		$i++;

		$input .= '<div class="widget_' . $i . '">

		<h2>' . $instance['title'] . '</h2>';
		$input .= '<img src="' . $instance[ 'image_uri'] . '" class="alignright">';
		$input .= '<p>' . $instance['copy'] . '</p>';
		$input .= '</br>';
		$input .= $instance[ 'form' ];
		$input .= '</div>';
		$input .= $after_widget;
		echo apply_filters( 'widget_leverage_feature_box', $input );
	}
	public function update( $new_instance, $old_instance )  
	{
		$instance = $old_instance;
		foreach( $new_instance as $key=>$val )
		{
			$instance[ $key ] = $val;
		}
		return $instance;
	}
	public function form( $instance )
	{
	    if ( isset( $instance[ 'image_uri' ] ) ) {
			$image_uri = $instance[ 'image_uri' ];
		}
		else {
			$image_uri = __( '', 'zs' );
		}
		// Output admin widget options form
		$defaults = array(
			'title' => '',
			'copy' => '',
			'form' => '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults);
		?>
		<p>Title: <input class="widefat" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" /></p>
		<p>Copy: <textarea rows="8" cols="20" class="widefat" name="<?php echo $this->get_field_name( 'copy' ); ?>"><?php echo esc_attr( $instance['copy'] ); ?></textarea></p>
		<p>HTML form: <textarea rows="8" cols="20" class="widefat" name="<?php echo $this->get_field_name( 'form' ); ?>"><?php echo esc_attr( $instance['form'] ); ?></textarea></p>
	    <p>
	      <label for="<?php echo $this->get_field_id('image_uri'); ?>">Image</label><br />
	        <img class="custom_media_image" src="<?php echo $image_uri; ?>" style="margin:0;padding:0;max-width:100px;float:left;display:inline-block" />
	        <input type="text" class="widefat custom_media_url" name="<?php echo $this->get_field_name('image_uri'); ?>" id="<?php echo $this->get_field_id('image_uri'); ?>" value="<?php echo $image_uri; ?>">
	       </p>
	       <p>
	        <input type="button" value="<?php _e( 'Upload Image', 'zs' ); ?>" class="button custom_media_upload" id="custom_image_uploader"/>
	    </p>
		<?php 
	}
}
add_action( 'widgets_init', create_function( '', 'register_widget( "leverage_featurebox" );' ) );
function leverage_script(){
  wp_enqueue_media();
  wp_enqueue_script('adsScript', plugins_url( '/js/leveragebox.js' , __FILE__ ));
}
add_action('admin_enqueue_scripts', 'leverage_script');