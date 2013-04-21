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
 * a log division object
 * 
 * for two intervalls $first and $second and a given number $s it calculates
 * two number $a and $b such that $a + $b = $s and $x^$a = $first and 
 * $x^$b = $second
 *
 * @author Nikolas Schmidt-Voigt <n.schmidtvoigt@googlemail.com>
 * @license LGPL-3.0 <http://opensource.org/licenses/LGPL-3.0>
 */

class LogStepDivision
{
	public	$stepsFirst;
	public	$stepsSecond;
	public	$stepSum;

	/**
	* creates a new log division
	 *
	 * @param	int	first	the size of the first set
	 * @param	int	second	the size of the second set
	 * @param	int	s		the total number of steps 
	 */
	public function __construct($first, $second, $s)
	{
			if (!(is_numeric($first)
					&& is_numeric($second)
					&& is_numeric($s))) {
				throw new InvalidArgumentException('expected numerical arguments');		
			}
			
			if ($s <= 0) {
				throw new InvalidArgumentException('number of steps must be bigger than zero');
			}

			if (($first > 0) && ($second > 0)) {
				$logFirst	= log($first);
				$logSecond	= log($second);
				$this->stepsFirst	= $s * $logFirst / ($logFirst + $logSecond);
			} else {
				if ($first <= 0) {
					$this->stepsFirst	= 0;
				} else {
					$this->stepsFirst	= $s;
				}
			}

			$this->stepsSecond	= $s- $this->stepsFirst;
			$this->stepSum		= $s;
	}

	/**
	 * make both the number of first as the number of second steps integer
	 *
	 * the sum of first and second steps will still be the same afterwards
	 */
	public function makeInt()
	{
		$this->stepsFirst	= (int) round($this->stepsFirst);
		$this->stepsSecond	= (int) ($this->stepSum - $this->stepsFirst);
	}
}
