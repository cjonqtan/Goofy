<?php
/**
 * This is a Goofy pagecontroller.
 *
 */
include __DIR__.'/config.php';

$db = new CDatabase($goofy['database']);

////////////////////
// Functions here //
////////////////////



/**
 * Use the current querystring as base, modify it according to $options and return the modified query string.
 *
 * @param array $options to set/change.
 * @param string $prepend this to the resulting query string
 * @return string with an updated query string.
 */
function getQueryString($options, $prepend='?') {
  // parse query string into array
  $query = array();
  parse_str($_SERVER['QUERY_STRING'], $query);
 
  // Modify the existing query string with new options
  $query = array_merge($query, $options);
 
  // Return the modified querystring
  return $prepend . http_build_query($query);
}
/**
 * Create links for hits per page.
 *
 * @param array $hits a list of hits-options to display.
 * @return string as a link to this page.
 */
function getHitsPerPage($hits) {
  $nav = "Träffar per sida: ";
  foreach($hits AS $val) {
    $nav .= "<a href='" . getQueryString(array('hits' => $val)) . "'>$val</a> ";
  }  
  return $nav;
}
/**
 * Function to create links for sorting
 *
 * @param string $column the name of the database column to sort by
 * @return string with links to order by column.
 */
function orderby($column) {
  return "<span class='orderby'><a href='?orderby={$column}&order=asc'>&darr;</i></a><a href='?orderby={$column}&order=desc'>&uarr;</a></span>";
}
/**
 * Create navigation among pages.
 *
 * @param integer $hits per page.
 * @param integer $page current page.
 * @param integer $max number of pages. 
 * @param integer $min is the first page number, usually 0 or 1. 
 * @return string as a link to this page.
 */
function getPageNavigation($hits, $page, $max, $min=1) {
  $nav  = "<a href='" . getQueryString(array('page' => $min)) . "'>&lt;&lt;</a> ";
  $nav .= "<a href='" . getQueryString(array('page' => ($page > $min ? $page - 1 : $min) )) . "'>&lt;</a> ";
 
  for($i=$min; $i<=$max; $i++) {
    $nav .= "<a href='" . getQueryString(array('page' => $i)) . "'>$i</a> ";
  }
 
  $nav .= "<a href='" . getQueryString(array('page' => ($page < $max ? $page + 1 : $max) )) . "'>&gt;</a> ";
  $nav .= "<a href='" . getQueryString(array('page' => $max)) . "'>&gt;&gt;</a> ";
  return $nav;
}

///////////////
// Page here //
///////////////

$genres = null;

// incoming varibles checks and sets here...
$title    = isset($_GET['title']) ? $_GET['title'] : null;
$genre    = isset($_GET['genre']) ? $_GET['genre'] : null;
$hits     = isset($_GET['hits'])  ? $_GET['hits']  : 8;
$page     = isset($_GET['page'])  ? $_GET['page']  : 1;
$year1    = isset($_GET['year1']) && !empty($_GET['year1']) ? $_GET['year1'] : null;
$year2    = isset($_GET['year2']) && !empty($_GET['year2']) ? $_GET['year2'] : null;
$orderby  = isset($_GET['orderby']) ? strtolower($_GET['orderby']) : 'id';
$order    = isset($_GET['order'])   ? strtolower($_GET['order'])   : 'asc';

// Check if varibles are valid
is_numeric($hits) or die('Check: Hits must be numeric.');
is_numeric($page) or die('Check: Page must be numeric.');
is_numeric($year1) || !isset($year1) or die('Check: Year must be numeric or not set.');
is_numeric($year2) || !isset($year2) or die('Check: Year must be numeric or not set.');

// Get genres and save into genres
$sqlGenre = '
  SELECT DISTINCT G.name
  FROM genre AS G
    INNER JOIN Movie2Genre AS M2G
      ON G.id = M2G.idGenre
';
$res = $db->Select($sqlGenre);
$genres = null;
foreach($res as $val) {
  if($val->name == $genre) {
    $genres .= "$val->name ";
  }
  else {
    $genres .= "<a class='g' href='" . getQueryString(array('genre' => $val->name)) . "'>{$val->name}</a> ";
  }
}

$sqlOriginal = '
SELECT 
M.*,
GROUP_CONCAT(G.name) AS genre
FROM Movie_kmom4 AS M
LEFT OUTER JOIN Movie2Genre_kmom4 AS M2G
	ON M.id = M2G.idMovie
INNER JOIN Genre_kmom4 AS G
	ON M2G.idGenre = G.id
';
$where = null;
$groupby = ' GROUP BY M.id';
$limit = null;
$sort = " ORDER BY $orderby $order";
$params = array();

if($title) {
    $where .= ' AND title LIKE ?';
    $params[] = $title;
}

if($year1) {
    $where .= ' AND year >= ?';
    $params[] = $year1;
} 
if($year2) {
    $where .= ' AND year <= ?';
    $params[] = $year2;
}

if($genre) {
    $where .= ' AND G.name = ?';
    $params[] = $genre;
}

// Pagination
if($hits && $page) {
    $limit = " LIMIT $hits OFFSET " . (($page - 1) * $hits);
}

$where = $where ? " WHERE 1 {$where}" : null;
$sql = $sqlOriginal . $where . $groupby . $sort . $limit;
$res = $db->Select($sql, $params);

$table =     "<tr>
                <th>Id ".orderby('id')."</th>
                <th>Bild</th>
                <th>Titel ".orderby('title')."</th>
                <th>År ".orderby('year')."</th>
                <th>Genre</th>
            </tr>";

foreach ($res as $key => $value) {
     $table .= "<tr>
                    <td>{$value->id}</td>
                    <td><img src='{$value->image}' alt='{$value->title}' width='80' height='40'></td>
                    <td>{$value->title}</td>
                    <td>{$value->YEAR}</td>
                    <td>{$value->genre}</td>
                </tr>";
}

// get max pages from table for navigation
$sql = "SELECT COUNT(id) AS rows FROM ($sqlOriginal $where $groupby) AS Movie";

$res = $db->Select($sql, $params);
$max = ceil($res[0]->rows / $hits);

$rows = $res[0]->rows;

$hitsPerPage = getHitsPerPage(array(2, 4, 8), $hits);
$navigatePage = getPageNavigation($hits, $page, $max);
$sqlDebug = $db->dump();



// get max pages from table for navigation
$sql = "SELECT COUNT(id) AS rows FROM ($sqlOriginal $where $groupby) AS Movie";

$res = $db->Select($sql, $params);
$max = ceil($res[0]->rows / $hits);

$rows = $res[0]->rows;

$hitsPerPage = getHitsPerPage(array(2, 4, 8), $hits);
$navigatePage = getPageNavigation($hits, $page, $max);
$sqlDebug = $db->Dump();


// Sets the html page...
$goofy['title'] = "Filmdatabas";
$goofy['stylesheets'][] = "css/moviedb.css";
$goofy['main'] = <<<EOD
<h1>Filmdatabas</h1>
<div class="search">
    <form method="get">
        <fieldset>
          <legend>Sök</legend>
              <input type='hidden' name='genre' value='{$genre}'>
              <input type='hidden' name='hits' value='{$hits}'>
              <input type='hidden' name='page' value='1'>
              <p><label>Titel: <input type='search' name='title' value='{$title}' placeholder="Title..."/></label></p>
              <p><label>Genre:</label> {$genres}</p>
              <p><label>Sök år: 
              <input type='text' name='year1' value='{$year1}' placeholder="1993..."/></label>
              - 
              <label><input type='text' name='year2' value='{$year2}' placeholder="2013..."/></label>
              </p>
              <p><input type='submit' name='submit' value='Sök'/></p>
              <p><a href='?'>Visa alla</a></p>
          </fieldset>
    </form>
</div>
<div class='dbtable'>
	<div class='rows'>{$rows} träffar. {$hitsPerPage}</div>
	<table>
	{$table}
	</table>
	<div class='pages'>{$navigatePage}</div>
</div>
EOD;
// render page
include GOOFY_THEME_PATH;