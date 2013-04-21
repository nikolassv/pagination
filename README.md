A generic pagination iterator
=============================

This repository provides a couple of php-classes for generic paginations. The main class
is **PaginationIterator**. It permits iterating over a set of integer values. Depending 
on the previous and next value it either returns a **PageItem**-Object or a **GapItem**-Object.

Several classes implementing the **PaginationFactoryInterface** may be used to create 
**PaginationIterators** for several purposes.

PaginationIteratorInterface
---------------------------

A class which implements the **PaginationIteratorInterface** allows to iterate over a set of numbers
which represent pages in a pagination. It takes an array as its only constructor argument.
When iterating over the object it will return either an object implementing the **PageItemInterface**
for each integer number in the sorted constructor array or an object implementing the
**GapItemInterface** for each gap between the numbers.

Objects which implement the **PaginationIteratorInterface** provide the methods _setGapItemClass()_
and _setPageItemClass()_. They may be used to determine which classes the respective objects
should instantiate.

The repository provides a class **PaginationIterator** which implements the **PaginationIteratorInterface**
and the classes **GapItem** and **PageItem** which implement the respective interfaces.

PaginationFactoryInterface
--------------------------

Classes which implement the **PaginationFactoryInterface** help producing new objects
implementing the **PaginationIteratorInterface**. They must provide a _makeNewPagination_ method.
This method takes four arguments:

- int **$max**: the last page in the pagination
- int **$steps**: the number of pages that the pagination should show / link to.
- int **$current**: the page currently shown 
- int **$min**: the first page in the pagination

The repository provides several implementations of the **PaginationFactoryInterface**:

- **FullPaginationFactory**: paginations produced by this factory will list each page in the pagination
	and ignore the _$steps_ and _$current_ arguments
- **LogPaginationFactory**: paginations produced by this factory will list the current page, the first and
	the last page and _$step_ pages in a distance from a^0 to a^n (respectivley a^m) with a^n = $min (and a^m = $max).
- **NeighbourPaginationFactory**: pagination produced by this factory will list the first, the last, and the current page as well as
	several pages in the direct neighbourhood of the current page.
- **StepPaginationFactory**: paginations produced by this factory will list the first, the last, the current, the 
	previous, and the next page as well as several pages between the first and the last page in equal distance.

Example
-------

  	$pagination = LogPaginationFactory::makeNewPagination(100, 20, 35);

	foreach ($pagination as $item) {
		if ($item instanceof GapItemInterface) {
			echo '...';
		} elseif ($item instanceof PageItemInterface) {
			echo '<a href="http://www.example.com/overview.php?page='.$item->getPageNumber().'">'.$item->getPageNumber().'</a>&nbsp;|&nbsp;';	
		}
  	}
