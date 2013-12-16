<?php
/**
 * Theme related functions. 
 *
 */

/**
 * Get title for the webpage by concatenating page specific title with site-wide title.
 *
 * @param string $title for this page.
 * @return string/null wether the favicon is defined or not.
 */
function get_title($title) {
  global $goofy;
  return $title . (isset($goofy['title_append']) ? $goofy['title_append'] : null);
}

/**
 * Generates a menubar
 * 
 */
function get_navbar($menu) {
	$html = "<nav>";
  	foreach($menu['items'] as $item) {
  		$selected = $menu['callback_selected']($item['url']) ? " class='selected' " : null;
		$html .= "<a href='{$item['url']}' {$selected}>{$item['text']}</a>";
	}
	$html .= "</nav>";
	return $html;
}

