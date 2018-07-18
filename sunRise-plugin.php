<?php
/**
* Plugin Name: SunRise
* Plugin URI: http://msewell.com
* Description: Display the sun set and sunri
* Version: 1.0.0
* Author: Mike Sewell
* Author URI: http://msewell.com
* License: GLP2
*/

function load_widget(){
    register_widget('sun_widget');
}
add_action('widgets_init','load_widget');

class sun_widget extends WP_Widget{
    function __construct(){
        parent::__construct('sun_widget',__('Sun Widget','sun_widget'),['description'=>'Display the sun set and sunri']);
    }
    public function widget($args, $instance){
        echo $args['before_widget'];
        echo $args['before_title'].'Sunrise/Sunset'.$args['after_title'];
        $response = wp_remote_get('http://api.sunrise-sunset.org/json?lat='.$instance['lat'].'&lng='.$instance['lng']);
        // var_dump($response);
        $info = json_decode($response['body'],true)['results'];
        ?>
        <p><strong>Sunrise: </strong><?=$info['sunrise']?></p>
        <p><strong>Sunset: </strong><?=$info['sunset']?></p>
        <?php
        echo $args['after_widget'];
    }
    public function form($instance) {
        $lat = isset($instance['lat']) ? $instance['lat']:'';
        $lng = isset($instance['lng']) ? $instance['lng']:'';
        ?>
        <p>
        <label for="<?=$this->get_field_id('lat')?>">Latitude:</label>
        <input type="text" class="widefat" name="<?=$this->get_field_name('lat')?>" id="<?=$this->get_field_id('lat')?>" value="<?=$lat?>">

        <label for="<?=$this->get_field_id('lng')?>">Longitude:</label>
        <input type="text" class="widefat" name="<?=$this->get_field_name('lng')?>" id="<?=$this->get_field_id('lng')?>" value="<?=$lng?>">

        </p>
        <?php
    }
}