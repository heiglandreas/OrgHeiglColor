<?php
/**
 * Copyright (c)2015-2015 heiglandreas
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIBILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @category 
 * @author    Andreas Heigl<andreas@heigl.org>
 * @copyright ©2015-2015 Andreas Heigl
 * @license   http://www.opesource.org/licenses/mit-license.php MIT-License
 * @version   0.0
 * @since     11.02.15
 * @link      https://github.com/heiglandreas/
 */

namespace Org_Heigl\ColorTest\Space;


use Org_Heigl\Color\Converter\RGB2XYZ;
use Org_Heigl\Color\Space\RGB;

class RGBTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @dataProvider creatingValueObjectProvider
	 * @param $red
	 * @param $green
	 * @param $blue
	 */
	public function testCreatingValueObject($red, $green, $blue)
	{
		$valObj = new RGB($red, $green, $blue);
		$this->assertAttributeEquals($red, 'red', $valObj);
		$this->assertAttributeEquals($green, 'green', $valObj);
		$this->assertAttributeEquals($blue, 'blue', $valObj);

		$this->assertEquals($red, $valObj->getRed());
		$this->assertEquals($green, $valObj->getGreen());
		$this->assertEquals($blue, $valObj->getBlue());
	}

	public function creatingValueObjectProvider()
	{
		return array(
			array(0,0,0),
			array(255,255,255),
		);
	}

	/**
	 * @dataProvider conversionToXyzProvider
	 * @param int $r
	 * @param int $g
	 * @param int $b
	 * @param float $X
	 * @param float $Y
	 * @param float $Z
	 */
	public function testConversionToXyz($r, $g, $b, $X, $Y, $Z)
	{
		$this->markTestSkipped('This test has to be carried out elsewhere');
		$valObj = new RGB($r, $g, $b);
		$converter = new RGB2XYZ();
		$xyz = $converter->convert($valObj);
		$this->assertEquals($X, $xyz->getX());
		$this->assertEquals($Y, $xyz->getY());
		$this->assertEquals($Z, $xyz->getZ());

	}

	public function conversionToXyzProvider()
	{
		return array(
			array(0,0,0,0.0,0.0,0.0),
			array(255,255,255,95.049999999999997,100.0,108.89999999999999),
	);
	}


}
