<?php
/**
* Plugin Name: GitHub repos 
* Plugin URI: http://msewell.com
* Description: Show all repositories for github user
* Version: 1.0.0
* Author: Mike Sewell
* Author URI: http://msewell.com
* License: GLP2
*/
function load_github_widget(){
    register_widget('github_widget');
}
add_action('widgets_init','load_github_widget');
class github_widget extends WP_Widget{
    function __construct(){
        parent::__construct('github_widget',__('GitHub Widget','github_widget'),['description'=>'Show all repositories for github user']);
    }
    public function widget($args, $instance){
        echo $args['before_widget'];
        echo $args['before_title'].'GitHub Repositories'.$args['after_title'];
        $response = wp_remote_get('https://api.github.com/users/'.$instance['gitHubUserName'].'/repos?sort=updated');
        $info = json_decode($response['body'],true);
        ?>
        <p><img src="<?=$info[0]['owner']['avatar_url']?>" alt="icon"></p>
        <?php
        foreach ($info as $value) {
        ?>
        <strong></strong>
            <p><strong><a href="<?=$value['url']?>"><?=$value['name']?></a></strong></p>
            <p><strong>Last updated:</strong> <?=$value['updated_at']?></p>
        <?php 
        }   
        echo $args['after_widget'];
    }
    public function form($instance) {
        $gitHubUserName = isset($instance['gitHubUserName']) ? $instance['gitHubUserName']:'';
        ?>
        <p>
        <label for="<?=$this->get_field_id('gitHubUserName')?>">Username:</label>
        <input type="text" class="widefat" name="<?=$this->get_field_name('gitHubUserName')?>" id="<?=$this->get_field_id('gitHubUserName')?>" value="<?=$gitHubUserName?>">
        </p>
        <?php
    }
}