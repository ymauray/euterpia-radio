<?php
add_action('plugins_loaded', 'euterpia_radio_linkexchange');

function euterpia_radio_linkexchange() {
	echo '<!-- Euterpia Radio Link Exchange -->';
}

add_filter('the_content', 'er_internal_links', 0);

function er_internal_links($content) {
	$posttags = get_the_tags();
	$voir_aussi = array();
	if ($posttags != null) {
		foreach ($posttags as $tag) {
			$results = get_posts(array('tag' => $tag->slug, 'post__not_in' => array(get_the_ID())));
			foreach($results as $result) {
				$voir_aussi[] = array($tag->name, $result);
//				error_log($tag->slug);
//				error_log($tag->name);
//				error_log($result->post_title);
//				error_log($result->ID);
//				error_log(get_permalink($result->ID));
			}
		}
	}

	$new_content = '';

	if (count($voir_aussi) > 0) {
		$new_content = '<p>Voir aussi :<ul>';
		foreach ($voir_aussi as $item) {
			$artist = $item[0];
			$post = $item[1];
			//error_log($artist . ' dans ' . $post->post_title);
			$new_content .= '<li>' . $artist . ' dans <a href="' . get_permalink($post->ID) . '">' . $post->post_title . '</a></li>';
		}
		$new_content .= '</ul></p>';
	}

	//error_log($new_content);

	return $content . $new_content;
}
?>
