<?php

spl_autoload_register(function($classname) {
	require_once($classname.'.php');
});

$pagination = LogPaginationFactory::makeNewPagination(112, 7, 2);

foreach ($pagination as $item) {
	if ($item instanceof GapItemInterface) {
		echo '... ';
	} else {
		echo $item->getPageNumber().' ';
	}
}

echo PHP_EOL;
