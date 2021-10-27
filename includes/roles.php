<?php

function cagov_design_system_headless_wordpress_new_role() {  
    $editor_role_set = get_role( 'editor' )->capabilities;
    $role = 'content_admin';
    $display_name = 'Content Admin';
    add_role( $role, $display_name, $editor_role_set );

    $content_admin_role = get_role('content_admin');

    // Should be same as editor, dunno why array wasn't setting, had to do this the long way.
    $content_admin_role->add_cap( 'manage_categories' );
    $content_admin_role->add_cap( 'manage_links' );
    $content_admin_role->add_cap( 'upload_files' );
    $content_admin_role->add_cap( 'edit_posts' );
    $content_admin_role->add_cap( 'edit_others_posts' );
    $content_admin_role->add_cap( 'edit_published_posts' );
    $content_admin_role->add_cap( 'edit_pages' );
    $content_admin_role->add_cap( 'delete_posts' );
    $content_admin_role->add_cap( 'delete_others_posts' );
    $content_admin_role->add_cap( 'delete_published_posts' );
    $content_admin_role->add_cap( 'delete_private_posts' );
    $content_admin_role->add_cap( 'edit_private_posts' );
    $content_admin_role->add_cap( 'read_private_posts' );
    $content_admin_role->add_cap( 'delete_private_pages' );
    $content_admin_role->add_cap( 'edit_private_pages' );
    $content_admin_role->add_cap( 'read_private_pages' );
    $content_admin_role->add_cap( 'edit_attachments' );
    $content_admin_role->add_cap( 'delete_attachments' );
    $content_admin_role->add_cap( 'read_others_attachments' );
    $content_admin_role->add_cap( 'edit_others_attachments' );
    $content_admin_role->add_cap( 'delete_others_attachments' );
    $content_admin_role->add_cap( 'read_others_posts' );
    $content_admin_role->add_cap( 'create_posts' );
    $content_admin_role->add_cap( 'create_pages' );
    $content_admin_role->add_cap( 'read' );
    $content_admin_role->add_cap( 'read_others_pages' );
    $content_admin_role->add_cap( 'edit_others_pages' );
    $content_admin_role->add_cap( 'edit_published_pages' );
    $content_admin_role->add_cap( 'publish_pages' );
    $content_admin_role->add_cap( 'delete_pages' );
    $content_admin_role->add_cap( 'moderate_comments' );
    $content_admin_role->add_cap( 'level_0' );
    $content_admin_role->add_cap( 'level_1' );
    $content_admin_role->add_cap( 'level_2' );
    $content_admin_role->add_cap( 'level_3' );
    $content_admin_role->add_cap( 'level_4' );
    $content_admin_role->add_cap( 'level_5' );
    $content_admin_role->add_cap( 'level_6' );
    $content_admin_role->add_cap( 'level_7' );

    // Option to make this Content Admin only...if approved.
    $content_admin_role->add_cap( 'publish_pages' );
    // Upcoming: 'cagov_design_system_headless_wordpress_approvals' => true,
    // Add menu
    $content_admin_role->add_cap( 'edit_theme_options' );
 
}
add_action('admin_init', 'cagov_design_system_headless_wordpress_new_role');