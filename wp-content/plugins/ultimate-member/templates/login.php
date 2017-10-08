<div class="um <?php echo $this->get_class( $mode ); ?> ">

	<div class="um-form">
	
		<form method="post" action="" autocomplete="off">
		<h3>Sign In</h3>
		<?php

			do_action("um_before_form", $args);
			
			do_action("um_before_{$mode}_fields", $args);
			
			do_action("um_main_{$mode}_fields", $args);
			
			do_action("um_after_form_fields", $args);
			
			do_action("um_after_{$mode}_fields", $args);
			
			do_action("um_after_form", $args);
			
		?>
		
		</form>
	
	</div>
	
</div>

<div class="reg-form-login">
	<div class="um-form">
		<h3>First Time</h3>
		<p class="sub-title-reg">If you are not registered than join us.</p>
		<a href="http://realrajmahalmasala.com/sample/sign-up/" class="um-alt reg-btn"><input type="submit" value="Join Us" class="um-button" id="reg-btn"></a>
	</div>
</div>