<?php
namespace TYPO3Fluid\Fluid\Tests\Unit\ViewHelpers;

/*
 * This file belongs to the package "TYPO3 Fluid".
 * See LICENSE.txt that was shipped with this package.
 */

use TYPO3Fluid\Fluid\ViewHelpers\SpacelessViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;

/**
 * Testcase for SpacelessViewHelper
 */
class SpacelessViewHelperTest extends ViewHelperBaseTestcase {

	/**
	 * @param string $input
	 * @param string $expected
	 * @dataProvider getRenderStaticData
	 * @test
	 */
	public function testRender($input, $expected) {
		$instance = new SpacelessViewHelper();
		$instance->setRenderChildrenClosure(function() use ($input) { return $input; });
		$instance->setRenderingContext($this->getMock('TYPO3Fluid\\Fluid\\Core\\Rendering\\RenderingContextInterface'));
		$instance->setArguments(array());
		$this->assertEquals($expected, $instance->render());
	}

	/**
	 * @param string $input
	 * @param string $expected
	 * @dataProvider getRenderStaticData
	 * @test
	 */
	public function testRenderStatic($input, $expected) {
		$context = $this->getMock('TYPO3Fluid\\Fluid\\Core\\Rendering\\RenderingContextInterface');
		$this->assertEquals($expected, SpacelessViewHelper::renderStatic(array(), function() use ($input) { return $input; }, $context));
	}

	/**
	 * @return array
	 */
	public function getRenderStaticData() {
		return array(
			'extra whitespace between tags' => array('<div>foo</div>  <div>bar</div>', '<div>foo</div><div>bar</div>'),
			'whitespace preserved in text node' => array(PHP_EOL . '<div>' . PHP_EOL . 'foo</div>', '<div>' . PHP_EOL . 'foo</div>'),
			'whitespace removed from non-text node' => array(PHP_EOL . '<div>' . PHP_EOL . '<div>foo</div></div>', '<div><div>foo</div></div>')
		);
	}

}