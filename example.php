<?php

use \Pagination\LogPaginationFactory;
use \Pagination\GapItemInterface;

$pagination = LogPaginationFactory::makeNewPagination(112, 7, 2);

foreach ($pagination as $item) {
	if ($item instanceof GapItemInterface) {
		echo '... ';
	} else {
		echo $item->getPageNumber().' ';
	}
}

echo PHP_EOL;
