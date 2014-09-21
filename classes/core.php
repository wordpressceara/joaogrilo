<?php

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

class Core{
	// Remove as tags do admin 
	public function removeTags(){
		add_action( 'admin_menu', array($this, 'removeTags_publish_box') );
		add_filter( 'manage_edit-post_columns', array($this, 'removeTags_columns_filter'));
		add_action( 'admin_enqueue_scripts', array($this, 'restrictTags_link') );
	}
	public function removeTags_publish_box(){
		remove_meta_box( 'tagsdiv-post_tag', 'post', 'side' );
		remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=post_tag' );
	}
	public function removeTags_columns_filter( $columns ){
		unset($columns['tags']);
    	return $columns;
	}
	function restrictTags_link()
	{
	    $screen = get_current_screen();
		if($screen->id == 'edit-post_tag'){
			wp_die(__("Essa área foi desabilitada. Favor contatar o administrador."));
		}
	}
}
