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
 * a log pagination class factory
 *
 * paginations made by this factory show the current, the first and the last page
 * as well as pages that lie x^1, x^2, ..., x^n pages before and after the current page
 *
 * @author Nikolas Schmidt-Voigt <n.schmidtvoigt@googlemail.com>
 * @license LGPL-3.0 <http://opensource.org/licenses/LGPL-3.0>
 */

 class LogPaginationFactory implements PaginationFactoryInterface
 {
	public static function makeNewPagination($max, $steps, $current = 1, $min = 1)
	{
		if (min($min, $max) < 1) {
			throw new InvalidArgumentException('logarithmic paginations must begin at page 1 or higher');
		}

		$min	= min($current, $min);
		$max	= max($current, $max);
		$total	= $max - $min + 1;
		$head	= $current - $min;	// number of pages before the current page
		$tail	= $max - $current;	// number of pages after the current page

		if ($total <= $steps) {
			/* we have less pages in our list than the maximal number of steps.
				therefore the pagination will show all the pages.
			*/
			$elements = range($min, $max);
		} else {

			// the first, the last and the current page belong to the pagination in any case
			$elements	= array_unique(array((int) $current, (int) $min, (int) $max));
			$steps		-= count($elements);
			
			if ($steps > 0) {
				$scale		= new LogStepDivision($head, $tail, $steps);
				$scale->makeInt();

				/**
				 * if the calculatet number of steps does not fit before or after the current
				 * element, we re-adjust the division
				 */
				if ($scale->stepsFirst > $head) {
					$scale->stepsFirst	= $head;
					$scale->stepsSecond	= $steps - $scale->stepsFirst;
				}
				if ($scale->stepsSecond > $tail) {
					$scale->stepsSecond	= $tail;
					$scale->stepsFirst	= $steps - $scale->stepsSecond;
				}

				if ($scale->stepsFirst > 0) {
					$elementsBefore = self::getLogSteps($head, $scale->stepsFirst);
				} else {
					$elementsBefore = array();
				}
				if ($scale->stepsSecond > 0) {
					$elementsAfter	= self::getLogSteps($tail, $scale->stepsSecond);
				} else {
					$elementsAfter	= array();
				}
				
				foreach ($elementsBefore as $e) {
					array_push($elements, $current - $e);
				}
				foreach ($elementsAfter as $e) {
					array_push($elements, $current + $e);
				}
			}
		}
		return new PaginationIterator($elements);
	}

	/**
	 * divide a given integer number in a given number of steps on a log scale
	 *
	 * for a given number of steps $s and a given integer $n it will produce a set
	 * of numbers x^0, x^1, x^2, ... , x^($s - 1) and x^($s - 1) = $n.
	 *
	 * this method only returns integer values and always the demanded number of 
	 * distinct values. if round(x^1) = round(x^2) or round(x^2) = round(x^3) it will decrease both
	 * the number of steps and the given integer by the same amount and recalculate a new 
	 * set. the recalculation is recursive. it will keep track of the depth of recursion
	 * in the parameter $r.
	 * 
	 * @param	int		n	the size of the largest number
	 * @param	int		s	the size of the set of number
	 * @param	int		r	the recursion level
	 * @return	array		the resultset
	 */
	public static function getLogSteps($n, $s, $r = 0)
	{
		if (!(
				is_int($n) 
			 && is_int($s)
			)) {
			throw new InvalidArgumentException('expected integer arguments');
		}

		if (!(
				($n > 0) 
			 && ($s > 0)
			)) {
			throw new InvalidArgumentException('expected all arguments to be bigger than zero');
		}

		if ($s < 1) {
			return array();
		}

		/**
		 * if the largest number is equal or less our number of steps we cannot return
		 * a set of $s disctinct integers. instead we return $n distinct integers.
		 */
		if ($n < $s) {
			return range($r + 1, $n + $r);
		}

		$stepSize = pow($n, (1 / $s));

		/**
		 * to ensure that round(stepsize ^ i) is a different number for each i stepsize
		 * must be bigger than 1.6
		 */
		if ($stepSize <= 1.6) {
			return array_merge(array($r + 1), self::getLogSteps($n - 1, $s - 1, $r + 1));
		}
		
		$resultSet = array();
		for ($i = 0; $i < $s; $i++) {
			array_push($resultSet, (int) round(pow($stepSize, $i) + $r));
		}

		return $resultSet;
	}

}
