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
 * a neighbour pagination class factory
 *
 * pagination made by this factory show a certain amount of pages
 * around the current page
 *
 * @author Nikolas Schmidt-Voigt <n.schmidtvoigt@googlemail.com>
 * @license LGPL-3.0 <http://opensource.org/licenses/LGPL-3.0>
 */

 class NeighbourPaginationFactory implements PaginationFactoryInterface
 {
	public static function makeNewPagination($max, $steps, $current = 1, $min = 1)
	{
		$min	= min($current, $min);
		$max	= max($current, $max);

		if ($max -  $min + 1 < $steps) {
			/* we have less pages in our list than the maximal number of steps.
				therefore the pagination will show all the pages.
			*/
			$elements = range($min, $max);
		} else {

			// first, last and current page belong to the pagination in any case
			$elements	= array_unique(array((int) $min, (int) $max, (int) $current));
			$steps		= $steps - count($elements);

			// calculate how many pages are shown before an after the current page
			$before = (int) ($steps / 2);
			
			if ($steps % 2 == 1) {
				$after = $before + 1;
			} else {
				$after = $before;
			}

			/* take into account that there may not be enough space before or after the 
				current page to show the same number of pages before and after the current
				page.
			*/
			$spaceBefore	= max($current - ($min + 1), 0);
			$spaceAfter		= max($max - ($current + 1), 0);

			if ($spaceBefore < $before) {
				$after	+= $before - $spaceBefore;
				$before	= $spaceBefore;
			}

			if ($spaceAfter < $after) {
				$before += $after - $spaceAfter;
				$after	= $spaceAfter;
			}

			// push the pages before and after the current page into the pagination elements
			for ($i = $current - $before; $i < $current; $i++) {
				array_push($elements, $i);
			}
			for ($i = $current + 1; $i <= $current + $after; $i++) {
				array_push($elements, $i);
			}
		}
		return new PaginationIterator($elements);
	}
 }
