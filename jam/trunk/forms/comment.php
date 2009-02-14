<?php

// This file is part of the Carrington JAM Theme for WordPress
// http://carringtontheme.com
//
// Copyright (c) 2008-2009 Crowd Favorite, Ltd. All rights reserved.
// http://crowdfavorite.com
//
// Released under the GPL license
// http://www.opensource.org/licenses/gpl-license.php
//
// **********************************************************************
// This program is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
// **********************************************************************

if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); }
if (CFCT_DEBUG) { cfct_banner(__FILE__); }

global $post, $user_ID, $user_identity, $comment_author, $comment_author_email, $comment_author_url;

$req = get_option('require_name_email');

// if post is open to new comments
if ('open' == $post->comment_status) {
	// if you need to be regestered to post comments..
	if ( get_option('comment_registration') && !$user_ID ) { ?>

<p id="you-must-be-logged-in-to-comment"><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.', 'carrington-jam'), get_bloginfo('wpurl').'/wp-login.php?redirect_to='.urlencode(get_permalink())); ?></p>

<?php
	}
	else { 
?>

<form action="<?php echo trailingslashit(get_bloginfo('wpurl')); ?>wp-comments-post.php" method="post">
	<label id="respond" for="comment"><?php _e('Post a comment', 'carrington-jam'); ?></label>
	<p><abbr title="<?php printf(__('You can use: %s', 'carrington-jam'), allowed_tags()); ?>"><?php _e('Some HTML is OK', 'carrington-jam'); ?></abbr></p>
	<textarea name="comment" id="comment" rows="8" cols="40" tabindex="1"></textarea>
<?php // if you're logged in...
		if ($user_ID) {
?>
	<p><?php printf(__('Logged in as <a href="%s">%s</a>. ', 'carrington-jam'), get_bloginfo('wpurl').'/wp-admin/profile.php', $user_identity); wp_loginout() ?> </p>
<?php
		}
		else { 
?>
	<p>
		<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="2" />
		<label for="author"><?php _e('Name', 'carrington-jam'); if ($req) { echo ' <em>' , _e('(required)', 'carrington-jam'), '</em>'; } ?></label>
	</p>
	<p>
		<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="3" />
		<label for="email"><?php _e('Email', 'carrington-jam');
					if ($req) {
						echo ' <em>', _e('(required, but never shared)', 'carrington-jam'), '</em>';
					}
					else {
						_e('(never shared)', 'carrington-jam');
					}
		?></label>
	</p>
	<p>
		<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="4" />
		<label title="<?php _e('Your website address', 'carrington-jam'); ?>" for="url"><?php _e('Web', 'carrington-jam'); ?></label>
	</p>
<?php 
		} 
?>
	<p>
		<input name="submit" type="submit" id="submit" value="<?php _e('Post comment', 'carrington-jam'); ?>" tabindex="5" />
		<?php printf(__('or, reply to this post via <a rel="trackback" href="%s">trackback</a>.', 'carrington-jam'), get_trackback_url()); ?>
		<input type="hidden" name="comment_post_ID" value="<?php echo $post->ID; ?>" />
	</p>
<?php
do_action('comment_form', $post->ID);
?>
</form>
<?php 
	} // If registration required and not logged in 
} // If you delete this the sky will fall on your head
?>