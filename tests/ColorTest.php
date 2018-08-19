<?php
/**
 * Copyright (c)2013-2013 heiglandreas
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
 * @copyright ©2013-2013 Andreas Heigl
 * @license   http://www.opesource.org/licenses/mit-license.php MIT-License
 * @version   0.0
 * @since     04.04.13
 * @link      https://github.com/heiglandreas/
 */

namespace Org_Heigl\ColorTest;

use Org_Heigl\Color\Color;
use Org_Heigl\Color\Space\Lab;
use Org_Heigl\Color\Space\XYZ;
use PHPUnit\Framework\TestCase;

class ColorTest extends TestCase
{

    /**
     * @param $XYZ
     * @param $Lab
     *
     * @dataProvider xyzColorConversionProvider
     */
    public function testXYZColorConversion($XYZ, $Lab)
    {
        $color = new Color(new XYZ($XYZ[0], $XYZ[1], $XYZ[2]));

        $this->assertEquals($XYZ[0], $color->getX());
        $this->assertEquals($XYZ[1], $color->getY());
        $this->assertEquals($XYZ[2], $color->getZ());

        $this->assertEquals($Lab[0], $color->getL());
        $this->assertEquals($Lab[1], $color->geta());
        $this->assertEquals($Lab[2], $color->getb());
    }

    public function xyzColorConversionProvider()
    {
        return array(
            array(array(96.42,100.00,82.49), array(100.0000, 0.0000, 0.0000)),
        );

    }

    /**
     * @dataProvider labColorConversionProvider
     */
    public function testLabColorConversion($Lab, $XYZ)
    {
        $color = new Color(new Lab($Lab[0], $Lab[1], $Lab[2]));

        $this->assertEquals($Lab[0], $color->getL());
        $this->assertEquals($Lab[1], $color->geta());
        $this->assertEquals($Lab[2], $color->getb());

        $this->assertEquals($XYZ[0], $color->getX());
        $this->assertEquals($XYZ[1], $color->getY());
        $this->assertEquals($XYZ[2], $color->getZ());
    }

    public function labColorConversionProvider()
    {
        return array(
            array(array(100.0000, 0.0000, 0.0000), array(96.42,100.00,82.49)),
        );

    }

    /** @dataProvider colorProvider */
    public function testThatXYZColorContainsCorrectLabValues(XYZ $xyz, Lab $lab)
    {
        $color = new Color($xyz);

        $this->assertEquals($lab->getL(), round($color->getLab()->getL(), 2));
        $this->assertEquals($lab->getA(), round($color->getLab()->getA(), 2));
        $this->assertEquals($lab->getB(), round($color->getLab()->getB(), 2));
    }

    /** @dataProvider colorProvider */
    public function testThatLabColorContainsCorrectXYZValues(XYZ $xyz, Lab $lab)
    {
        $color = new Color($lab);

        $this->assertEquals($xyz->getX(), round($color->getXYZ()->getX(), 2));
        $this->assertEquals($xyz->getY(), round($color->getXYZ()->getY(), 2));
        $this->assertEquals($xyz->getZ(), round($color->getXYZ()->getZ(), 2));
    }

    public function colorProvider()
    {
        return [
            [new XYZ(0, 0, 0), new Lab(0, 0, 0)],
            [new XYZ(96.42, 100, 82.49), new Lab(100, 0, 0)],
            [new XYZ(39.71, 100, 82.49), new Lab(100, -128, 0)],
            [new XYZ(63.93, 100, 25.94), new Lab(100, -64, 64)],
            [new XYZ(39.71, 100, 3.85), new Lab(100, -128, 127.99)],
            [new XYZ(39.71, 100, 363.86), new Lab(100, -128, -128)],
            [new XYZ(191.05, 100, 363.86), new Lab(100, 128, -128)],
            [new XYZ(191.05, 100, 3.85), new Lab(100, 128, 128)],
            [new XYZ(-3.17, 0, -6.78), new Lab(0, -128, 128)],
            [new XYZ(-3.17, 0, 38.84), new Lab(0, -128, -128)],
            [new XYZ(5.89, 0, 38.84), new Lab(0, 128, -128)],
            [new XYZ(5.89, 0, -6.78), new Lab(0, 128, 128)],
            [new XYZ(5.89, 0, 0), new Lab(0, 127.95, 0)],
        ];
    }
}
