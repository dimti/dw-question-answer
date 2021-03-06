<?php  

class DWQA_Latest_Answered_Question_Widget extends WP_Widget {

	/**
	 * Constructor
	 *
	 * @return void
	 **/
	function __construct() {
		$widget_ops = array( 'classname' => 'dwqa-widget dwqa-latest-answered-questions', 'description' => __( 'Show a list of questions that was ordered by answered time.', 'dwqa' ) );
		parent::__construct( 'dwqa-latest-answered-question', __( 'DWQA Latest Answered Questions', 'dwqa' ), $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );
		$instance = wp_parse_args( $instance, array( 
			'title' => __( 'Latest Answered Questions' , 'dwqa' ),
			'number' => 5,
		) );

		$link = get_the_permalink(PERMANENT_ID_DWQA_QUESTIONS);
		
		echo $before_widget;
		echo $before_title;
		echo '<a href="' . $link . '"><h4 class="widget-title">' . $instance['title'] . '</h4></a>';
		echo $after_title;
		
		$args = array(
			'posts_per_page'    => $instance['number'],
			'post_type'         => 'dwqa-question',
			'suppress_filters'  => false,
			'orderby'  => array( 'meta_value_num' => 'DESC', 'post_date' => 'DESC' ),
			'meta_key' => '_dwqa_answered_time',
		);
		$questions = new WP_Query( $args );
		if ( $questions->have_posts() ) {
			echo '<div class="dwqa-popular-questions hkb_widget_articles">';
			echo '<ul>';
			while ( $questions->have_posts() ) { $questions->the_post( );
				echo '
				<li class="latest-answered-question"><a href="'.get_permalink().'" class="question-title hkb-widget__entry-title">'.get_the_title( ).'</a> <span>'.__( 'asked by', 'dwqa' ).' ' . ( dwqa_is_anonymous( get_the_ID() ) ? __( 'Anonymous', 'dwqa' ) : get_the_author_link() ) . ', ' .  human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) . ' назад</span>';
				'</li>';
			}
			echo '<li class="ht-kb-read-more">' .
				'<a href="' . $link . '">Читать все</a>' .
				'</li>';
			echo '</ul>';
			echo '</div>';
		}
		wp_reset_query( );
		wp_reset_postdata( );
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {

		// update logic goes here
		$updated_instance = $new_instance;
		return $updated_instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( $instance, array( 
			'title' => '',
			'number' => 5,
		) );
		?>
		<p><label for="<?php echo $this->get_field_id( 'title' ) ?>"><?php _e( 'Widget title', 'dwqa' ) ?></label>
		<input type="text" name="<?php echo $this->get_field_name( 'title' ) ?>" id="<?php echo $this->get_field_id( 'title' ) ?>" value="<?php echo $instance['title'] ?>" class="widefat">
		</p>
		<p><label for="<?php echo $this->get_field_id( 'number' ) ?>"><?php _e( 'Number of posts', 'dwqa' ) ?></label>
		<input type="text" name="<?php echo $this->get_field_name( 'number' ) ?>" id="<?php echo $this->get_field_id( 'number' ) ?>" value="<?php echo $instance['number'] ?>" class="widefat">
		</p>
		<?php
	}
}
add_action( 'widgets_init', create_function( '', "register_widget( 'DWQA_Latest_Answered_Question_Widget' );" ) );

?>
