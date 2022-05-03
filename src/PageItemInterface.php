<?php

namespace Pagination;

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
 * interface for a page item
 *
 * a pagination iterator will return object implementing this interface
 * for each item in the pagination that links to a page
 *
 * @author Nikolas Schmidt-Voigt <n.schmidtvoigt@googlemail.com>
 * @license LGPL-3.0 <http://opensource.org/licenses/LGPL-3.0>
 */

interface PageItemInterface
{
	/**
	 * constructs a new page item
	 *
	 * @param	int	pageNumber	the number of the represented page
	 */
	public function __construct($pageNumber);

	/**
	 * returns the number of the represented page
	 *
	 * @return	int	the number of the represented page
	 */
	public function getPageNumber();
}
