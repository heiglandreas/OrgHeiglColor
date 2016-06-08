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
 * @since     12.04.13
 * @link      https://github.com/heiglandreas/
 */

namespace Org_Heigl\ColorTest\Profile\TagType;

use Org_Heigl\Color\Profile\TagType\Curve;

class CurveTest extends \PHPUnit_Framework_TestCase
{

    public function testParsingOfBinaryData()
    {
        $data = pack('n*', 0x6375, 0x7276, 0x0000, 0x0000, 0x0000,
            0x002D, 0x0000, 0x0005, 0x000A, 0x000F, 0x0014, 0x0019,
            0x001E, 0x0023, 0x0028, 0x002D, 0x0032, 0x0037, 0x003B,
            0x0040, 0x0045, 0x004A, 0x004F, 0x0054, 0x0059, 0x005E,
            0x0063, 0x0068, 0x006D, 0x0072, 0x0077, 0x007C, 0x0081,
            0x0086, 0x008B, 0x0090, 0x0095, 0x009A, 0x009F, 0x00A4,
            0x00A9, 0x00AE, 0x00B2, 0x00B7, 0x00BC, 0x00C1, 0x00C6,
            0x00CB, 0x00D0, 0x00D5, 0xFFFF);

        $tag = new Curve($data);


        $this->assertEquals(45, $tag->count());
        $this->assertEquals(5, $tag->getKey(1));
    }

    /**
     * @param $expected
     * @param $requested
     * @dataProvider gettingOfValuesProvider
     */
    public function testGettingOfValues($expected, $requested)
    {
        $data = pack('n*',
            0x6375, 0x7276, 0x0000, 0x0000, 0x0000, 0x0011, 0x0000,
            0x0FFF, 0x1FFF, 0x2FFF, 0x3FFF, 0x4FFF, 0x5FFF, 0x6FFF, 0x7FFF,
            0x8FFF, 0x9FFF, 0xAFFF, 0xBFFF, 0xCFFF, 0xDFFF, 0xEFFF, 0xFFFF
        );

        $tag = new Curve($data);

        $this->assertEquals($expected, round($tag->getValue($requested),2));
    }

    public function gettingOfValuesProvider()
    {
        return array(
            array(0, 0),
            array(0.5, 0.5),
            array(0.51, 0.51),
            array(1.0, 1.0),
        );
    }
}
