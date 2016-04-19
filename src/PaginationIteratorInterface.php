<?php

namespace Pagination;

use \Iterator;

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
 * interface for pagination iterators
 *
 * pagination iterators will iterator over a set of items in a ascending
 * list. for each item it will either return a page item or a gap item.
 *
 * @author Nikolas Schmidt-Voigt <n.schmidtvoigt@googlemail.com>
 * @license LGPL-3.0 <http://opensource.org/licenses/LGPL-3.0>
 */

interface PaginationIteratorInterface extends Iterator
{
	/**
	 * construct a new PaginationIterator object
	 *
	 * @param	array	elements	the elements which are shown in the pagination
	 */
	public function __construct(array $elements);

	/**
	 * sets the page item class
	 *
	 * items of the element set will be returned as instances of this class
	 *
	 * @param	string	class name of the page items
	 */
	public function setPageItemClass($pageItemClass);

	/**
	 * sets the gap item class
	 *
	 * gaps between the elements of the element set will be returned as instances
	 * of this class
	 *
	 * @param	string	class name of the gap items
	 */
	public function setGapItemClass($gapItemClass);
}
