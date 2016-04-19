<?php

namespace Pagination;

use \Pagination\PaginationFactoryInterface;
use \Pagination\PaginationIterator;

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
 * an equal steps pagination class factory
 *
 * pagination made by this factory show pages that are equal steps away
 * from each other
 *
 * @author Nikolas Schmidt-Voigt <n.schmidtvoigt@googlemail.com>
 * @license LGPL-3.0 <http://opensource.org/licenses/LGPL-3.0>
 */

 class StepPaginationFactory implements PaginationFactoryInterface
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
			$newSteps	= $steps - count($elements);

			// direct neighbours belong to the pagination too
			if ((($current - 1) > $min) && ($newSteps > 0)) {
				array_push($elements, (int) ($current - 1));
				$newSteps = $steps - count($elements);
			}
			if ((($current + 1) < $max) && ($newSteps > 0)) {
				array_push($elements, (int) ($current + 1));
				$newSteps = $steps - count($elements);
			}

			// add additional steps of equal length
			$stepLength = ($max - $min) / ($newSteps + 1);
			for ($i = 1; $i <= $newSteps; $i++) {
				array_push($elements, (int) round($min + ($i * $stepLength)));
			}

			/* if any page has been added to the pagination more than once,
				we have too few steps and need to add aditional steps */
			$elements = array_unique($elements);
			$i = 1;		// whether to add an additional step before or after the current page
			$j = 2;		// the distance from $current of the additional step
			while (count($elements) < $steps) {
				$additionalStep = $current + ($j * $i);
				if (($additionalStep > $min) && ($additionalStep < $max)) {
					array_push($elements, $additionalStep);
				} elseif (($additionalStep < $min) && ($additionalStep > $max)) {
					throw new OutOfBoundsException('could not add as much steps to the pagination as needed');
				}

				$i *= -1;	// change the direction
				if ($i > 0) {
					$j++;	// increase the distance to the current page, whenever we would add a new page in forward direction
				}
				$elements = array_unique($elements);
			}

		}
		return new PaginationIterator($elements);
	}
 }

