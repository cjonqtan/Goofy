<?php

class CContent extends CDatabase {

	protected $database = array();

	public function __construct($options = array()) {
		if(!isset($this->db) || ($this->db == null)) {
				 
				if(empty($options)) {
					throw new Exception("What shall I connect to ?", 1);
				} else {
					parent::__construct($options);
				}
		}
		$default = array(
				'database' => 'jokd13', 
				'table' => 'Content_kmom07'
		);
		$this->database = array_merge($default, $options);
	}
	/**
	 * initialize the database 
	 * @param  array  $options database and table name
	 * @return bool            true if it initialized it
	 */
	public function initDatabase($options = array()) {
			$this->database = array_merge($this->database, $options);

			$sql =
			"USE {$this->database['database']};
				DROP TABLE IF EXISTS {$this->database['table']}; 
				CREATE TABLE {$this->database['table']} 
				(
					id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
					slug CHAR(80) UNIQUE,
					url CHAR(80) UNIQUE,
				 
					TYPE CHAR(80),
					title VARCHAR(80),
					DATA TEXT,
					FILTER CHAR(80),
				 
					published DATETIME,
					created DATETIME,
					updated DATETIME,
					deleted DATETIME
				 
				) ENGINE INNODB CHARACTER SET utf8;
			";
			if(!$this->Execute($sql)) {
				throw new Exception("Something went wrong when initializing the database", 1);
			}
			return true;
	}
	public function removePost($id) {
		$sql = "UPDATE {$this->database['table']} SET `deleted`='1' WHERE id=?";

		$this->Execute($sql,array($id));
	}

	public function createPost($data) {
		$title 		= isset($data[0]['title'])  	&& !empty($data[0]['title']) 	? strip_tags($data[0]['title']) : null;
		$type   	= isset($data[0]['type'])  		&& !empty($data[0]['type']) 	? strip_tags($data[0]['type']) : "post";
		$content 	= isset($data[0]['content'])  	&& !empty($data[0]['content']) 	? htmlentities($data[0]['content']) : null;
		$filter 	= isset($data[0]['filter'])  	&& !empty($data[0]['filter']) 	? strip_tags($data[0]['filter']) : null;
		$slug 		= isset($data[0]['slug']) 		&& !empty($data[0]['slug']) 	? $this->slugify($data[0]['slug']) : $this->slugify($title);
		$url 		= isset($data[0]['url']) 		&& !empty($data[0]['url'])		? strip_tags($data[0]['url']) : null;
		$published 	= ((isset($data[0]['date']) 	&& !empty($data[0]['date']))) 
				  	&& ((isset($data[0]['time']) 	&& !empty($data[0]['time']))) 	? $data[0]['date'] . ' ' .  $data[0]['time'] : " NOW() ";

		$sql = "
		INSERT INTO {$this->database['table']} 
		 (
		 	title,
		    slug,
		    url,
		    data,
		    type,
		    filter,
		    published
		) 
		VALUES 
		(
			?,
			?,
			?,
			?,
			?,
			?,
			?			
		);
		";
		
		$params = array($title, $slug, $url, $content,$type, $filter, $published);
		dump($slug);
		dump($data[0]['slug']);
		if(!$this->Execute($sql, $params)) {
			throw new Exception("Something went wrong when you inserted the table", 1);
		} 
	}
	public function deletePost($id) {
		$id = is_numeric($id) ? $id : die("Skulle inte tror de va");
		$sql = "DELETE FROM {$this->database['table']} WHERE id=?";

		$this->Execute($sql,$id);
	}
	public function editPost($data) {
		$title= isset($data[0]['title'])&& !empty($data[0]['title']) ? strip_tags($data[0]['title']) : null;
		$type= isset($data[0]['type'])&& !empty($data[0]['type']) ? strip_tags($data[0]['type']) : "post";
		$content= isset($data[0]['content'])&& !empty($data[0]['content']) ? htmlentities($data[0]['content']) : null;
		$filter=  isset($data[0]['filter'])&& !empty($data[0]['filter']) ? strip_tags($data[0]['filter']) : null;
		$slug= $this->slugify($title);
		$url= isset($data[0]['url'])&& !empty($data[0]['url'])? strip_tags($data[0]['url']) : null;

		$sql = "UPDATE `Content_kmom07` 
		SET `slug`=?,
		`url`=?,
		`TYPE`=?,
		`title`=?,
		`DATA`=?,
		`FILTER`=?,
		`updated`=? 
		WHERE id=?";

		$params = array($slug,$type,$title,$content,$filter,"NOW()",$data['id']);

		$this->Execute($sql,$params,true);

	}
	public function getContent($type = 'content', $slug = null, $limit = null, $offset=null) {
		$html = false;

		$slug = isset($slug) ? strip_tags($slug) : null;

		if(!is_null($offset)) {
			$offset = "offset={$offset}";
		}

		if(!is_null($slug)) {
			$slug = " slug='$slug' AND ";
		}

		if(!is_null($limit)) {
			$limit = " LIMIT 0, {$limit} ";
		}

		$sql = "SELECT `title`,`id`,`slug`,`DATA`,`TYPE`,`published`, (published <= NOW()) AS available FROM {$this->database['table']} WHERE {$slug}  type='$type' AND deleted <> 1 ORDER BY published DESC {$offset} {$limit} ;";

		$data = $this->Select($sql);

		foreach ($data as $key => $value) {
			$html .= "<article><header><h2><a href='news.php?slug={$value->slug}'>{$value->title}</a></h2><small>{$value->published}</small></header><div>{$value->DATA}</div></article>";
		}

		return $html;
	}

	/**
	 * Create a slug of a string, to be used as url.
	 *
	 * @param string $str the string to format as slug.
	 * @return str the formatted slug. 
	 */
	protected function slugify($str) {
	  $str = mb_strtolower(trim($str));
	  $str = str_replace(array('å','ä','ö'), array('a','a','o'), $str);
	  $str = preg_replace('/[^a-z0-9-]/', '-', $str);
	  $str = trim(preg_replace('/-+/', '-', $str), '-');
	  return $str;
	}
	/**
	 * Returns an simple-form for createing a new post
	 * @return string html-form
	 */
	public function getBloggForm() {
		return '<form method="post" style="width:700px; margin:0 auto;">
					<p><label>Titel <small>(Max: 80 tecken)</small></label></p>
					<p><input type="text" style="min-width:60%;" name="title" required placeholder="title"></p>

					<p><label>Publiceringsdatum <small>(Lämna tomt för <strong>nu</strong>)</small></label></p>
					<p><input type="date" style="min-width:30%;" name="date"><input type="time" style="min-width:30%;" name="time"></p>

					<p><label>Typ <small>(content, post)</small></label>
					<p><input type="text" requierd style="min-width:60%;" name="type"></p>
					<p><label>Slug<small>(Blir <strong>Titlen</strong> om tom. Max: 80 tecken)</small></label></p>
					<p><input type="text" name="slug" style="min-width:60%;"></p>
					<p><label>Url</label></p>
					<p><input type="text" name="url" requierd >
					<p><label>Filter</label></p>
					<p><input type="text" name="filter" style="min-width:60%;">
					<p><label>Text</label></p>
					<p><textarea name="content" style="min-width:60%; max-width:100%; min-height:300px;" placeholder="Text" required></textarea></p>
					<p><input type="submit" name="createPost" value="Skapa"></p>
				</form>';
	}
	public function getEditForm($data) {
		return "<form method='post' style='width:700px; margin:0 auto;'>
				<input type='hidden' name='id' value='{$data[0]->id}'>
					<p><label>Titel <small>(Max: 80 tecken)</small></label></p>
					<p><input type='text' style='min-width:60%;' name='title' value='{$data[0]->title}' required placeholder='title'></p>
					
					<p><label>Typ <small>(content, post)</small></label>
					<p><input type='text' requierd style='min-width:60%;' value='{$data[0]->TYPE}' name='type'></p>
					
					<p><label>Url</label></p>
					<p><input type='text' name='url' value='{$data[0]->url}' requierd>
					<p><label>Filter</label></p>
					<p><input type='text' name='filter' value='{$data[0]->FILTER}' style='min-width:60%;'>
					<p><label>Text</label></p>
					<p><textarea name='content'  style='min-width:60%; max-width:100%; min-height:300px;' placeholder='Text' required>{$data[0]->DATA}</textarea></p>
					<p><input type='submit' name='createPost' value='Skapa'></p>
				</form>";
	}	
}