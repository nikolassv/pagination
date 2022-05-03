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
 * the pagination factory interface
 *
 * pagination factories produce pagination iterator instances and fill them
 * with the appropriate values
 *
 * @author Nikolas Schmidt-Voigt <n.schmidtvoigt@googlemail.com>
 * @license LGPL-3.0 <http://opensource.org/licenses/LGPL-3.0>
 */

 interface PaginationFactoryInterface
 {
	/**
	 * produces a new pagination iterator instance
	 *
	 * @param	int	min	the lowest element in the pagination
	 * @param	int max	the highest element in the pagination
	 * @param	int steps	the number of items displayed in the pagination
	 * @param	int current	the current page
	 * @return	PaginationIteratorInterface	the new pagination iterator
	 */
	public static function makeNewPagination($max, $steps, $current, $min);
 }


