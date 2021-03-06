<?php

// This file is part of the Carrington Blog Theme for WordPress
// http://carringtontheme.com
//
// Copyright (c) 2008 Crowd Favorite, Ltd. All rights reserved.
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

<p id="you-must-be-logged-in-to-comment"><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.', 'carrington-blog'), get_bloginfo('wpurl').'/wp-login.php?redirect_to='.urlencode(get_permalink())); ?></p>

<?php
	}
	else { 
?>

<form action="<?php echo trailingslashit(get_bloginfo('wpurl')); ?>wp-comments-post.php" method="post" class="comment-form">
	<div id="comment-form-comment" class="section">
		<label id="respond" for="comment_<?php echo $post->ID; ?>"><?php _e('Post a comment', 'carrington-blog'); ?></label>
		<div>
			<textarea name="comment" id="comment_<?php echo $post->ID; ?>" rows="8" cols="40" tabindex="1"></textarea>
			<p class="some-html-is-ok"><abbr title="<?php printf(__('You can use: %s', 'carrington-blog'), allowed_tags()); ?>"><?php _e('Some HTML is OK', 'carrington-blog'); ?></abbr></p>
		</div>
	</div>
<?php // if you're logged in...
		if ($user_ID) {
?>
	<p class="logged-in section"><?php printf(__('Logged in as <a href="%s">%s</a>.', 'carrington-blog'), get_bloginfo('wpurl').'/wp-admin/profile.php', $user_identity); ?> <a href="<?php cfct_logout_url(get_permalink()) ?>" title="<?php _e('Log out of this account', 'carrington-blog'); ?>"><?php _e('Logout &rarr;', 'carrington-blog'); ?></a></p>
<?php
		}
		else { 
?>
	<p class="comment-form-name" class="section">
		<label for="author_<?php echo $post->ID; ?>"><?php _e('Name', 'carrington-blog'); ?></label>
		<input type="text" name="author" id="author_<?php echo $post->ID; ?>" value="<?php echo $comment_author; ?>" size="22" tabindex="2" />
		<?php if ($req) : ?><span class="note"><?php _e('(required)', 'carrington-blog'); ?></span><?php endif; ?>
	</p><!--/name-->
	<p class="comment-form-email" class="section">
		<label for="email_<?php echo $post->ID; ?>"><?php _e('Email', 'carrington-blog'); ?></label>
		<input type="text" name="email" id="email_<?php echo $post->ID; ?>" value="<?php echo $comment_author_email; ?>" size="22" tabindex="3" />
		<span class="note"><?php
			if ($req) {
				_e('(required, but never shared)', 'carrington-blog');
			}
			else {
				_e('(never shared)', 'carrington-blog');
			}
?></span>
	</p><!--/email-->
	<p class="comment-form-url" class="section">
		<label title="<?php _e('Your website address', 'carrington-blog'); ?>" for="url_<?php echo $post->ID; ?>"><?php _e('Web', 'carrington-blog'); ?></label>
		<input type="text" name="url" id="url_<?php echo $post->ID; ?>" value="<?php echo $comment_author_url; ?>" size="22" tabindex="4" />
	</p><!--/url-->
<?php 
		} 
?>
	<div class="section actions">
		<input name="submit" type="submit" id="submit_<?php echo $post->ID; ?>" value="<?php _e('Post comment', 'carrington-blog'); ?>" tabindex="5" />
		<span class="comment-form-trackback"><?php printf(__('or, reply to this post via <a rel="trackback" href="%s">trackback</a>.', 'carrington-blog'), get_trackback_url()); ?></span>
		<input type="hidden" name="comment_post_ID" value="<?php echo $post->ID; ?>" />
	</div><!--/controls-->
<?php
do_action('comment_form', $post->ID);
?>
</form>
<?php 
	} // If registration required and not logged in 
} // If you delete this the sky will fall on your head
?>