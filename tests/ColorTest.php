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

class ColorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @param $XYZ
     * @param $Lab
     *
     * @dataProvider xyzColorConversionProvider
     */
    public function testXYZColorConversion($XYZ, $Lab)
    {
        $color = new Color();
        $color->setXYZ(new XYZ($XYZ[0], $XYZ[1], $XYZ[2]));

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
            array(array(0.9642,1.0000,0.8249), array(100.0000, 0.0000, 0.0000)),
        );

    }

    /**
     * @dataProvider labColorConversionProvider
     */
    public function testLabColorConversion($Lab, $XYZ)
    {
        $color = new Color();
        $color->setLab($Lab[0], $Lab[1], $Lab[2]);

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
            array(array(100.0000, 0.0000, 0.0000), array(0.9642,1.0000,0.8249)),
        );

    }
}
