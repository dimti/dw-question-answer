<?php 

if ( ! dwqa_current_user_can( 'read_question' ) ) : 
	?>
	<div class="alert"><?php _e( 'You do not have permission to view questions', 'dwqa' ) ?></div>
	<?php 
endif; 

?>
<p class="not-found">
	
<?php 

_e( 'Sorry, but nothing matched your filter.', 'dwqa' ); 

if ( is_user_logged_in() ) : 
	dwqa_get_ask_question_link();
else :
	$redirect = get_post_permalink(PERMANENT_ID_DWQA_QUESTIONS);

	$register_link = wp_register( '', '', false );

	printf( '<br><br>%1$s <a href="%2$s" onclick="event.preventDefault();jQuery(\'#redirect_to\').val(\'' . $redirect . '\');jQuery(\'#modal-registration\').modal(\'show\');" title="%3$s">%3$s</a>', 'Если у вас еще нет аккаунта на нашем сайте, вам надо', wp_registration_url(), 'зарегистрироваться' );
	wp_login_form();
endif; ?>

</p>