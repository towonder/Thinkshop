<?php 
/* SVN FILE: $Id$ */
/* ProductsController Test cases generated on: 2009-12-30 17:12:48 : 1262190828*/
App::import('Controller', 'Products');

class TestProducts extends ProductsController {
	var $autoRender = false;
}

class ProductsControllerTest extends CakeTestCase {
	var $Products = null;

	function setUp() {
		$this->Products = new TestProducts();
		$this->Products->constructClasses();
	}

	function testProductsControllerInstance() {
		$this->assertTrue(is_a($this->Products, 'ProductsController'));
	}

	function tearDown() {
		unset($this->Products);
	}
}
?>