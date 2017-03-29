<?php
 /*
 Plugin Name: Jw filter
 Plugin URI : http://themesflow.com
 Description: demo
 Author :amit
 Author URI: http://themesflow.com
 Version: 1.0
 */
 
 
add_filter('the_content',function($content){
	$id = get_the_id();
	if(!is_singular('post')){
		return $content;
		
	}
		$terms = get_the_terms('id', 'category');
		$cats= array();
		
		foreach($terms as $term){
			$cats[]= $term->cat_ID;
		}
		$loop= new WP_Query(
		array(
		'post_per_page' => 3,
		'category__in' => $cats,
		'order_by' => 'rand',
		'post__not_in' => array($id)
		) 
);

if($loop -> have_post()){
	$content .='
	<h2> You also might like ... </h2>
	<ul class="related-category-post">';
while($loop->have_posts()){
	
	$loop->the_post();
	$content .='
	<li>
	<a href="' .get_permalink() . '">' . get_the_title() . </a>
	</li>';
	
	
}	
$content .='</ul>';
wp_reset_query();
}
return $content;
});