<?php

namespace Pagination;

use \Pagination\PaginationIteratorInterface;

/**************************************************************
 * Copyright notice
 *
 * (c) 2013 Nikolas Schmidt-Voigt (n.schmidtvoigt@googlemail.com)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 *
 * The GNU Lesser General Public License can be found at
 * http://www.gnu.org/licenses/lgpl-3.0.de.html
 *
 **************************************************************/

/**
 * a simple pagination iterator
 *
 * see the documentation of PaginationIteratorInterface for further
 * information.
 *
 * @author Nikolas Schmidt-Voigt <n.schmidtvoigt@googlemail.com>
 */

class PaginationIterator implements PaginationIteratorInterface
{

	// a list of all pages that this pagination links to
	protected $elements			= array();
	protected $pageItemClass	= '\Pagination\PageItem';
	protected $gapItemClass		= '\Pagination\GapItem';

	// the index of the next element from the elements array
	protected $index			= 0;
	// the position in the pagination - counting gaps and page items
	protected $position			= 0;
	// the last shown element from the elements array
	protected $currentPage		= 0;
	// the last returned item - either a PageItem or a GapItem
	protected $currentItem;

	public function __construct(array $elements)
	{
		$elements = array_filter($elements, 'is_integer');
		$elements = array_unique($elements);
		sort($elements);

		$this->elements = $elements;
		$this->rewind();
	}

	/**
	 * return the array with all elements
	 *
	 * @return	array	the elements
	 */
	public function getElements()
	{
		return $this->elements;
	}

	public function setPageItemClass($pageItemClass)
	{
		if (!is_string($pageItemClass) || empty($pageItemClass)) {
			throw new InvalidArgumentException('class name for page items must be a string');
		}

		$this->pageItemClass = $pageItemClass;
	}

	public function setGapItemClass($gapItemClass)
	{
		if (!is_string($gapItemClass) || empty($gapItemClass)) {
			throw new InvalidArgumentException('class name for gap items must be a string');
		}

		$this->gapItemClass = $gapItemClass;
	}

	public function rewind(): void
	{
		$this->index		= 0;
		$this->position		= 0;
		$this->currentPage	= 0;

		if (isset($this->elements[0])) {
			$this->currentPage = $this->elements[0] - 1;
		}
	}

	public function next(): void
	{
		++$this->index;
		++$this->position;
	}

	public function valid(): bool
	{
		if (!isset($this->elements[$this->index])) {
			return false;
		}

		$nextPage = $this->elements[$this->index];

		if ($nextPage == ($this->currentPage + 1)) {
			$this->currentItem = new $this->pageItemClass($nextPage);
			$this->currentPage	= $nextPage;
		} else {
			$this->currentItem = new $this->gapItemClass();
			$this->currentPage	= $nextPage - 1;
			--$this->index;
		}

		return true;
	}

	public function key(): mixed
	{
		return $this->position;
	}

	public function current(): mixed
	{
		return $this->currentItem;
	}
}

