<?php
spl_autoload_register(function($classname) {
	require_once($classname.'.php');
});

class PaginationTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider	provider
	 */
	public function testLogPagination ($numberOfPages, $numberOfLinks, $currentPage)
	{
		$pagination = LogPaginationFactory::makeNewPagination($numberOfPages, $numberOfLinks, $currentPage);
		$pages			= $pagination->getElements();

		$this->assertContains($currentPage, $pages, 'did not contain current: '.$numberOfPages.' '.$numberOfLinks.' '.$currentPage);
		$this->assertContains(1, $pages, 'did not contain first: '.$numberOfPages.' '.$numberOfLinks.' '.$currentPage);
		$this->assertContains($numberOfPages, $pages, 'did not contain last: '.$numberOfPages.' '.$numberOfLinks.' '.$currentPage);
		$this->assertContains(max($currentPage - 1, 1), $pages, 'did not contain previous: '.$numberOfPages.' '.$numberOfLinks.' '.$currentPage);
		$this->assertContains(min($currentPage + 1, $numberOfPages), $pages, 'did not contain next: '.$numberOfPages.' '.$numberOfLinks.' '.$currentPage);
		$this->assertEquals($numberOfLinks, count($pages), 'number of links did not match: '.$numberOfPages.' '.$numberOfLinks.' '.$currentPage);
	}

	public function provider () 
	{
		return array(
			array(112, 7, 1),
			array(112, 7, 2),
			array(112, 7, 3),
			array(112, 7, 4),
			array(112, 7, 20),
			array(112, 7, 100),
			array(112, 7, 110),
			array(112, 7, 111),
			array(112, 7, 112),
			array(112, 5, 1),
			array(112, 5, 2),
			array(112, 5, 3),
			array(112, 5, 4),
			array(112, 5, 20),
			array(112, 5, 100),
			array(112, 5, 110),
			array(112, 5, 111),
			array(112, 5, 112),
		);
	}
}
