<?php

class CMovie extends CDatabase {

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
				'table' => 'Movie_kmom07'
		);
		$this->database = array_merge($default, $options);
	}

	public function initDatabase($options = array()) {
			$this->database = array_merge($this->database, $options);

			$sql ="
				USE {$this->database['database']};
				DROP TABLE IF EXISTS {$this->database['table']}; 
				CREATE TABLE {$this->database['table']} 
				(
				  id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
				  title VARCHAR(100) NOT NULL,
				  slug VARCHAR(100) NOT NULL,
				  director VARCHAR(100) NULL DEFAULT NULL,
				  price INT NOT NULL DEFAULT 50,
				  length INT DEFAULT NULL,
				  year INT NOT NULL DEFAULT 1900,
				  plot TEXT, 
				  image VARCHAR(100) DEFAULT NULL,
				  trailer VARCHAR(100) DEFAULT NULL,
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
	/**
	 * Returns a simple-form
	 * @return string html-form
	 */
	public function getForm() {
		
		return '<form method="post" style="width:700px; margin:0 auto;">
				<p><label>Titel <small>(Max: 80 tecken)</small></label></p>
				<p><input type="text" style="min-width:60%;" name="title"  required placeholder="title"></p>
				<p><label>Regissör</label></p>
				<p><input type="text" style="min-width:60%;" name="director" required placeholder="Författare"></p>
				<p><label>Publiceringsdatum <small>(Lämna tomt för <strong>nu</strong>)</small></label></p>
				<p><input type="date" style="min-width:30%;" name="date"><input type="time" style="min-width:30%;" name="time"></p>
				<p><label>Pris <small>(summa SEK)</small></label>
				<p><input type="text" requierd style="min-width:60%;" name="price"></p>
			
				<p><label>Längd</label></p>
				<p><input type="text" name="length" requierd style="min-width:60%;">
				<p><label>Bild</label></p>
				<p><input type="text" name="image" requierd style="min-width:60%;">
				<p><label>År</label></p>
				<p><input type="text" name="year" requierd style="min-width:60%;">

				<p><label>Trailer</label></p>
				<p><input type="text" name="trailer" requierd style="min-width:60%;">

				<p><label>Plot</label></p>
				<p><textarea name="plot" style="min-width:60%; max-width:100%; min-height:300px;" placeholder="Text" required></textarea></p>
				<p><input type="submit" name="createMovie" value="Skapa"></p>
			</form>';
	}
	public function getEditForm($data) {
		return "<form method='post' style='width:700px; margin:0 auto;'>
				<input type='hidden' value='{$data[0]->id}' name='id'>
					<p><label>Titel <small>(Max: 80 tecken)</small></label></p>
					<p><input type='text' style='min-width:60%;' name='title' value='{$data[0]->title}' required placeholder='title'></p>
					<p><label>Regissör</label></p>
					<p><input type='text' style='min-width:60%;' name='director' value='{$data[0]->director}' required placeholder='Författare'></p>

					<p><label>Pris <small>(summa SEK)</small></label>
					<p><input type='text' requierd style='min-width:60%;' value='{$data[0]->price}' name='price'></p>
					
					<p><label>Längd</label></p>
					<p><input type='text' name='length' value='{$data[0]->length}' requierd style='min-width:60%;'>

					<p><label>Bild</label></p>
					<p><input type='text' name='image' value='{$data[0]->image}' requierd style='min-width:60%;'>

					<p><label>År</label></p>
					<p><input type='text' name='year' value='{$data[0]->year}'requierd style='min-width:60%;'>

					<p><label>Trailer</label></p>
					<p><input type='text' name='trailer'value='{$data[0]->trailer}' requierd style='min-width:60%;'>

					<p><label>Plot</label></p>
					<p><textarea name='plot' style='min-width:60%; max-width:100%; min-height:300px;' placeholder='Text' required>{$data[0]->plot}</textarea></p>
					<p><input type='submit' name='doEditMovie' value='Skapa'></p>
				</form>";
	}

	public function getMovies($slug = null, $limit = null) {
		$slug = isset($slug) ? strip_tags($slug) : null;

		if(!is_null($slug)) {
			$slug = " WHERE slug='$slug'";
		}

		if(!is_null($limit)) {
			$limit = " LIMIT 0, {$limit} ";
		}

		$sql = "SELECT *, (published <= NOW()) AS available FROM {$this->database['table']}  {$slug} AND deleted <> 1 ORDER BY published, id DESC {$limit} ;";

		return $this->Select($sql);
	}

	public function getForFront($limit = null, $orderBy = null) {
		if(!is_null($limit)) {
			$limit = " LIMIT 0, {$limit} ";
		}
		if(!is_null($orderBy)) {
			$orderBy = " {$orderBy}, ";
		}

		$sql = "SELECT  CONCAT(left(`plot`, 250), '...') AS plot, `title`, `image`,`slug`,  `id`,(published <= NOW()) AS available FROM {$this->database['table']}  WHERE deleted <> 1 ORDER BY {$orderBy} published, id DESC {$limit} ;";

		return $this->Select($sql);
	}

	public function getSearch($searchValue) {
		$searchValue = isset($searchValue) ? strip_tags($searchValue) : null;
		$searchValue = $this->slugify($searchValue);
		$sql = "SELECT * FROM {$this->database['table']}
		WHERE 
		`title` LIKE '%{$searchValue}%' OR `slug` LIKE '%{$searchValue}%'";
		
		return $this->Select($sql);
	}

	public function editMovie($data) {

		$title = isset($data['title']) && !empty($data['title']) ? strip_tags($data['title']) : null;
		$director = isset($data['director']) && !empty($data['director']) ? strip_tags($data['director']) : null;
		$price = isset($data['price']) && !empty($data['price']) ? strip_tags($data['price']) : null;
		$length = isset($data['length']) && !empty($data['length']) ? strip_tags($data['length']) : null;
		$year = isset($data['year']) && !empty($data['year']) ? strip_tags($data['year']) : null;
		$plot = isset($data['plot']) && !empty($data['plot']) ? htmlentities($data['plot']) : null;
		$image = isset($data['image']) && !empty($data['image']) ? strip_tags($data['image']) : null;
		$trailer = isset($data['trailer']) && !empty($data['trailer']) ? strip_tags($data['trailer']) : null;
		$updated = " NOW() ";

		$slug = $this->slugify($title);

		$sql = "UPDATE {$this->database['table']}
		 SET
		 `title`=?,
		 `director`=?,
		 `price`=?,
		 `length`=?,
		 `year`=?,
		 `plot`=?,
		 `image`=?,
		 `trailer`=?,
		 `updated`=?,
		 `slug`=?
		WHERE id=?";

		$params = array($title,$director,$price,$length,$year,$plot,$image,$trailer,$updated,$slug,$data['id']);

		$this->Execute($sql, $params,true);

	}
	public function removeMovie($id) {
		dump("id: " . $id);
		$sql = "UPDATE {$this->database['table']} SET `deleted`='1' WHERE id=?";

		$this->Execute($sql,array($id));
	}

	public function createMovie($data) {

		$title = isset($data['title']) && !empty($data['title']) ? strip_tags($data['title']) : null;
		$director = isset($data['director']) && !empty($data['director']) ? strip_tags($data['director']) : null;
		$price = isset($data['price']) && !empty($data['price']) ? strip_tags($data['price']) : null;
		$length = isset($data['length']) && !empty($data['length']) ? strip_tags($data['length']) : null;
		$year = isset($data['year']) && !empty($data['year']) ? strip_tags($data['year']) : null;
		$plot = isset($data['plot']) && !empty($data['plot']) ? htmlentities($data['plot']) : null;
		$image = isset($data['image']) && !empty($data['image']) ? strip_tags($data['image']) : null;
		$trailer = isset($data['trailer']) && !empty($data['trailer']) ? strip_tags($data['trailer']) : null;
		$published 	= ((isset($data['date']) && !empty($data['date']))) && ((isset($data['time']) && !empty($data['time']))) 	? $data['date'] . ' ' .  $data['time'] : " NOW() ";

		$slug = $this->slugify($title);

		$sql = "INSERT INTO {$this->database['table']} 
		(`title`, `director`, `price`, `length`, `year`, `plot`, `image`, `trailer`,`slug`) 
		VALUES 
		(?,?,?,?,?,?,?,?,?)";
		$params = array($title,$director,$price,$length,$year,$plot,$image,$trailer,$slug);
		if(!$this->Execute($sql, $params)) {
			throw new Exception("Something went wrong with this: {$sql}", 1);			
		}
	}

	/**
	 * Create a slug of a string, to be used as url.
	 *
	 * @param string $str the string to format as slug.
	 * @return str the formatted slug. 
	 */
	public function slugify($str) {
	  $str = mb_strtolower(trim($str));
	  $str = str_replace(array('å','ä','ö'), array('a','a','o'), $str);
	  $str = preg_replace('/[^a-z0-9-]/', '-', $str);
	  $str = trim(preg_replace('/-+/', '-', $str), '-');
	  return $str;
	}
}