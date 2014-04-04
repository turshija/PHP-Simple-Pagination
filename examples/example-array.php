<?php
require '../src/pagination.class.php';

// We create 1000 dummy elements in array
$myData = array();
for ($i=1; $i<=1000; $i++) {
    $myData[] = $i . '. Dummy element ';
}

$numberOfElements = count($myData);
$currentPage = $_GET['page'];
$elementsPerPage = 20;
$paginationWidth = 7;
$data = Pagination::load($numberOfElements, $currentPage, $elementsPerPage, $paginationWidth);

// We add [prev] button if prev is enabled
if ($data['previousEnabled']) echo '<a href="?page=' . ($data['currentPage']-1) . '">[prev]</a>';
else echo '<span class="prev disabled">[prev]</span>';

// We add all page numbers based on "width"
foreach ($data['numbers'] as $number) {
    echo ' <a href="?page=' . $number . '">' .  $number . '</a> ';
    echo '&nbsp;&nbsp;'; // WOW MUCH MARGIN
}

// We add [next] button if next is enabled
if ($data['nextEnabled']) echo '<a href="?page=' . ($data['currentPage']+1) . '">[next]</a>';
else echo '<span class="next disabled">[next]</span>';

echo '<hr />'; // SO PRETTY !

// Now we just output our "paginated" data
for ($i = 0; $i < $elementsPerPage; $i++) {
    echo $myData[ ($data['currentPage'] - 1) * $elementsPerPage + $i ] . '<br />'; // SUCH HTML5 !
}

?>