<?php
/*
Template Name: Contact Template
*/

get_header(); ?>


<?php

	// Globalizing Meta Variables
	global $template_metabox;
	$template_meta = $template_metabox->the_meta();
	
	// Fields Requirement ('1' for required, '0' for not required)
	$req_name = 1;
	$req_email = 1;
	$req_msg = 1;
	
	// symbol for required fields
	$req_name_symbol = ($req_name == 1 ? '<small>*</small>' : '');
	$req_email_symbol = ($req_email == 1 ? '<small>*</small>' : '');
	
	// class for required fields
	$req_name_class = ($req_name == 1 ? 'required' : '');
	$req_email_class = ($req_email == 1 ? 'required' : '');
	$req_msg_class = ($req_msg == 1 ? 'required' : '');
	
	// class for invalid fields
	$name_error_class = NULL;
	$email_error_class = NULL;
	$msg_error_class = NULL;
	
	$email_sent = false;
	$email_validate_error = false;
	$form_error = false;
	
				
	// PHP Validation Code
	if(isset($_POST['submit'])) {
		
			if( trim($_POST['ms_author']) === '' && $req_name == 1 ) { // Name Validation
				$form_error = true;
				$name_error_class = 'error';
			} else {
				$name = trim($_POST['ms_author']);
			}
			
			if( trim($_POST['ms_email']) === '' && $req_email == 1 )  { // Email Validation
				$email_error_class = 'error';
				$form_error = true;
			} else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['ms_email'])) && trim($_POST['ms_email']) !== '') {
				$email_error_class = 'error';
				$email_validate_error = true;
				$form_error = true;
			} else {
				$ms_email = trim($_POST['ms_email']);
			}
			
			if( trim($_POST['ms_comment']) === '' && $req_msg == 1 ) { // Message Validation
				$msg_error_class = 'error';
				$form_error = true;
			} else {
				if(function_exists('stripslashes')) {
					$ms_comments = stripslashes(trim($_POST['ms_comment']));
				} else {
					$ms_comments = trim($_POST['ms_comment']);
				}
			}
				
			if($form_error == false) { // Send Email through PHP mail() function
				$ms_email_to = !empty($template_meta['contact_email']) ? $template_meta['contact_email'] : get_option('admin_email');
				$subject = '['. get_bloginfo('name'). '] From '. trim($_POST['ms_author']);
				$body = trim($_POST['ms_comment']);
				
				$headers  = "From: ". trim($_POST['ms_author']) ." <". trim($_POST['ms_email']) .">\r\n";
				
				mail($ms_email_to, $subject, $body, $headers);
				$email_sent = true;
			}
			
	} 

?>
    <!-- Page Content starts here -->
    <section class="page_content with_sidebar">
    
        <?php if(isset($_POST['submit']) && $email_sent == true) { // if form submitted successfully ?>
        
            <p><?php echo $template_meta['contact_success_msg']; ?></p> 
    
        <?php } elseif(isset($_POST['submit']) && $email_sent == false) { // if form NOT submitted successfully ?>
        
            <p><?php echo $template_meta['contact_failure_msg']; ?></p>
               
        <?php } ?>
        
        
       <?php if(!isset($_POST['submit']) || $email_sent == false) { // if form NOT submitted or unsuccessfully submitted ?>
       
            <?php if(!isset($_POST['submit'])) { // if form NOT submitted ?>
            
                <p><?php echo $template_meta['contact_default_msg']; ?></p>  
            
            <?php } ?>
                      
            <!-- Contact Form starts here -->
            <form id="contact_form" method="post" action="<?php echo get_permalink(); ?>" data-req-name="<?php echo $req_name; ?>" data-req-email="<?php echo $req_email; ?>" data-req-msg="<?php echo $req_msg; ?>">
            
                <p>
                    <input type="text" tabindex="1" size="22" value="<?php isset($_POST['ms_author']) ? print $_POST['ms_author'] : ''; ?>" id="ms_author" name="ms_author" class="name_field <?php echo $req_name_class .' '. $name_error_class; ?>">
                    <?php isset($name_error_class) ? print '<span class="error">'. __('Required', 'framework') .'</span>' : ''; ?>
                    <label for="ms_author"><?php _e( 'Name', 'framework' ); ?> <?php echo $req_name_symbol; ?></label>
                    <span class="field_icon name_icon"><em class="icon"></em><em class="arrow"></em></span>
                </p>
                
                <p>
                    <input type="text" tabindex="2" size="22" value="<?php isset($_POST['ms_email']) ? print $_POST['ms_email'] : ''; ?>" id="ms_email" name="ms_email" class="email_field <?php echo $req_email_class .' '. $email_error_class; ?>">
                    <?php !empty($email_validate_error) ? print '<span class="error">'. __('Invalid!', 'framework') .'</span>' : ( isset($email_error_class) ? print '<span class="error">Required</span>' : ''); ?>
                    <label for="ms_email"><?php _e( 'E-Mail', 'framework' ); ?> <?php echo $req_email_symbol; ?><span>(never published)</span></label>
                    <span class="field_icon email_icon"><em class="icon"></em><em class="arrow"></em></span>
                </p>
                
                <p class="textarea">
                    <textarea tabindex="4" rows="10" cols="58" class="msg_field <?php echo $req_msg_class .' '. $msg_error_class; ?>" id="ms_comment" name="ms_comment"><?php isset($_POST['ms_comment']) ? print stripslashes($_POST['ms_comment']) : ''; ?></textarea>
                   <?php isset($msg_error_class) ? print '<span class="error">'. __('Required', 'framework') .'</span>' : ''; ?>
                </p>
                
                <p>
                    <input type="hidden" name="submit" value="true" />
                    <input type="submit" value="<?php _e('Send Message', 'framework') ?>" id="submit" name="submit">
                </p>
                
            </form>
            <!-- Contact Form ends here -->
            
        <?php } ?>
                
    </section>
    
	<?php get_sidebar(); ?>
    <!-- Page Content ends here -->

<?php get_footer(); ?>