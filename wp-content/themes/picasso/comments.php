    <div class="clear"></div>
    
<?php $template_directory = get_template_directory_uri(); ?>
<?php

// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e('This entry is password protected. Enter the password to view comments.', 'framework') ?></p>
	<?php
		return;
	}

/*-----------------------------------------------------------------------------------*/
/*	Display the comments + Pings
/*-----------------------------------------------------------------------------------*/

		if ( have_comments() ) : // if there are comments ?>
        
        <?php if ( ! empty($comments_by_type['comment']) ) : // if there are normal comments ?>
		
        <!-- Comments starts here -->
        <section id="comments">
        
        <!-- Comments Heading starts -->
        <h1>Comments</h1>
        <!-- Comments Heading ends -->
        
        
        <!-- Calling Comments Template from functions.php -->
        <ul id="commentlist">
			<?php wp_list_comments( array( 'callback' => 'ms_comments' ) ); ?>
        </ul>
        <!-- Calling Comments Template ends -->

        <?php endif; ?>
		
		<div class="navigation">
			<div class="alignleft"><?php previous_comments_link(); ?></div>
			<div class="alignright"><?php next_comments_link(); ?></div>
		</div>
        
		</section>
        
		<?php
		
		
/*-----------------------------------------------------------------------------------*/
/*	Deal with no comments or closed comments
/*-----------------------------------------------------------------------------------*/
		
		if ('closed' == $post->comment_status ) : // if the post has comments but comments are now closed ?>
		
		<p class="nocomments"><?php _e('Comments are now closed for this entry.', 'framework') ?></p>
		
		<?php endif; ?>

 		<?php else :  ?>
		
        <?php if ('open' == $post->comment_status) : // if comments are open but no comments so far ?>

        <?php else : // if comments are closed ?>
		
		<?php if (is_single()) { ?><p class="nocomments"><?php _e('Comments are closed.', 'framework') ?></p><?php } ?>

        <?php endif; ?>
        
<?php endif;


/*-----------------------------------------------------------------------------------*/
/*	Comment Form
/*-----------------------------------------------------------------------------------*/

	if ( comments_open() ) : ?>
    
	<?php
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	
    $fields =  array(
        'author' => '<p class="comment-form-author">' .
					'<input id="author" class="name_field '. ( $req ? 'required' : '' ) . '" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' />',
					'<label for="author">' . __( 'Name', 'framework' ) . ( $req ? '<small>*</small>' : '' ) . '</label> ' .
					'<span class="field_icon name_icon"><em class="icon"></em><em class="arrow"></em></span>' .
					'</p>',
					
		'email'  => '<p class="comment-form-email">' .
					'<input id="email" class="email_field" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' />' .
					'<label for="email">' . __( 'Email', 'framework' ) . ( $req ? '<small>*</small>' : '' ) . '</label> ' .
					'<span class="field_icon email_icon"><em class="icon"></em><em class="arrow"></em></span>' .
					'</p>',
        
		'url'    => '<p class="comment-form-url">' .
					'<input id="url" class="url_field" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" />' .
					'<label for="url">' . __( 'Website', 'framework' ) . '</label>' .
					'<span class="field_icon url_icon"><em class="icon"></em><em class="arrow"></em></span>' .
					'</p>',
    );
	
	$comments_args = array(
			// change the form title 
			'title_reply'=> '<h1>'.  __( 'Leave a Reply', 'framework' ) .'</h1>',
			'title_reply_to'=> '<h1>'.  __( 'Leave a Reply to %s', 'framework' ) .'</h1>',
			// remove "Text or HTML to be displayed after the set of comment fields"
			'comment_notes_after' => '',
			// redefine your own textarea (the comment body)
			'comment_field' => '<p class="comment-form-comment"><label for="comment"></label><textarea id="comment" class="msg_field '. ( $req ? 'required' : '' ) . '" name="comment" aria-required="true" rows="10"></textarea></p>',
			// redefine comment form fields
			'fields' => $fields,
	);	
	
	?>    
    
    
	<?php comment_form($comments_args); ?>   
                   
    <div class="clear"></div>
	<?php endif; // if you delete this the sky will fall on your head ?>
