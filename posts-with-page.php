add_shortcode('ws_podcast_cs','get_custom_podcast');

function get_custom_podcast(){
global $post;
		$atts = shortcode_atts( array(
			'featured' => '',
			'xs'       => '',
			'sm'       => '',
			'md'       => '',
			'lg'       => '',
			'class'    => '',
		), $atts, 'column' );
 

	 $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

		ws_load_isotope_scripts();

			$ws_podcast = array(
				'posts_per_page'   => 20,
				'orderby'          => 'date',
				//'orderby'          => 'rand',
				'order'            => 'DESC',
				'post_type'        => 'podcast',
				'post_status'      => 'publish',
				'paged'      => $paged,
				 
			);

		  $portfolio_array = new WP_Query( $ws_podcast );
		// //echo "<pre>"; print_r($portfolio_array);
		  $terms = get_terms( array( 'taxonomy' => 'podcast_category', 'hide_empty' => false ) );
//echo "<pre>"; print_r($terms);
		  ?>
		<div class="portfolio-button-group-container center-it">   
			<div class="btn-group button-group filters-button-group podcast_btn" role="group" aria-label="">
				<div class="portfolio-show-all-btn-container podcast_btn_show_all">
					<button class="btn btn-primary is-checked" data-filter="*">Show All</button>
				</div>
				<div class="portfolio-other-filters-btn-container podcast_btn_filters">
					<?php foreach( $terms as $term ) {
					   echo '<button class="btn btn-default" data-filter=".podcast-' . $term->slug . '">' . $term->name . '</button>';
					  }   ?>
			    </div> 
			 </div>        
		 </div> 
		 <div class="portfolio-grid row"> 
		<?php 
		  
		while ( $portfolio_array->have_posts() ) : $portfolio_array->the_post();
			$post_id = $post->ID;
			$terms_list = '';
			$term_list = wp_get_post_terms($post->ID, 'podcast_category', array("fields" => "all"));
			foreach($term_list as $term){
				$terms_list  = 'podcast-' . $term->slug  ;	
		  
			}
			   
			?> 
			 <div class="col-md-12 portfolio-item <?php echo $terms_list; ?> "> 
				 <div class="podcast_title">
				 	<a class="portfolio-single-item-link-mob" href="<?php the_permalink(); ?>"><span class="cs-model-title"><?php the_title(); ?></span></a>
				 </div> 
				 <div class="parent_podcast">
					 <div class="podcast_image"><?php the_post_thumbnail('full'); ?></div>
					 <div class="podcast_excerpt"><p><?php the_excerpt( $post_id ); ?></p></div> 
				 </div> 
			 </div> 
	<?php
		endwhile; ?>
 </div> 
		<?php

		$big = 999999999; // need an unlikely integer

	 echo paginate_links( array(
	    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	    'format' => '?paged=%#%',
	    'current' => max( 1, get_query_var('paged') ),
	    'total' =>  $portfolio_array->max_num_pages
	) ); 
}