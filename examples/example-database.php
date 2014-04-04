<?php
require '../src/pagination.class.php';

// connect to database !

// we will demonstrate it with bad usage of deprecated mysql functions !
// only thing we need now is number of elements so we can generate pagination
$tmp = mysql_fetch_assoc( mysql_query("SELECT COUNT(*) as `num` FROM `my_table`") );   // SO MODERN, SUCH DEPRECATED

$numberOfElements = count($tmp['num']);
$currentPage = $_GET['page'];
$elementsPerPage = 20;
$paginationWidth = 7;
$data = Pagination::load($numberOfElements, $currentPage, $elementsPerPage, $paginationWidth);

// We add [prev] button if prev is enabled
if ($data['previousEnabled']) echo '<a href="?page=' . ($currentPage-1) . '">[prev]</a>';
else echo '<span class="prev disabled">[prev]</span>';

// We add all page numbers based on "width"
foreach ($data['numbers'] as $number) {
    echo ' <a href="?page=' . $number . '">' .  $number . '</a> ';
    echo '&nbsp;&nbsp;'; // WOW MUCH MARGIN
}

// We add [next] button if next is enabled
if ($data['nextEnabled']) echo '<a href="?page=' . ($currentPage+1) . '">[next]</a>';
else echo '<span class="next disabled">[next]</span>';

echo '<hr />'; // SO PRETTY !

// Now we just output our "paginated" data
$start = ($data['currentPage']-1) * intval($elementsPerPage);
$limit = intval($elementsPerPage); // MANY SECURE
$data_query = mysql_query("
    SELECT *
    FROM `my_table`

    ORDER BY `id`
    LIMIT {$start}, {$limit}
");
while ($row = mysql_fetch_assoc($data_query)) {
    echo $row['id'] . '<br />';
}

?>