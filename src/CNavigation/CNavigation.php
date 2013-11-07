<?php


/**
 *  Dynamic navbar 
 *  Todo: connect to db and select nice links from there... 
 *  Class not in use
 */
class CNavigation {


	public function GenerateMenu($items, $class) {
		$html = "<nav class='$class'>";
		foreach($items as $key => $item) {
		$selected = (isset($_GET['p'])) && $_GET['p'] == $key ? "class='selected'>" : null; 
		$html .= "<a href='{$item['url']}' {$selected}{$item['text']}</a>";
		}
		$html .= "</nav>";
		return $html;
	}
};