<?php
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
 * a full pagination class factory
 *
 * paginations made by this factory show each page in the list 
 * without any gaps
 *
 * @author Nikolas Schmidt-Voigt <n.schmidtvoigt@googlemail.com>
 * @license LGPL-3.0 <http://opensource.org/licenses/LGPL-3.0>
 */

 class FullPaginationFactory implements PaginationFactoryInterface
 {
	public static function makeNewPagination($max, $steps = 1, $current = 1, $min = 1)
	{
		$elements = range((int) $min, (int) $max);
		return new PaginationIterator($elements);
	}
 }

