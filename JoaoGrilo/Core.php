<?php
namespace JoaoGrilo;

class Core{
	// Remove as tags do admin 
	public function bytags(){
		add_action('admin_menu', array($this, 'bytags_remove_publish_box') );
		add_filter( 'manage_edit-post_columns', array($this, 'bytags_columns_filter'));
	}
	public function bytags_remove_publish_box(){
		remove_meta_box( 'tagsdiv-post_tag', 'post', 'side' );
		remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=post_tag' );
	}
	public function bytags_columns_filter( $columns ){
		unset($columns['tags']);
    	return $columns;
	}
}
