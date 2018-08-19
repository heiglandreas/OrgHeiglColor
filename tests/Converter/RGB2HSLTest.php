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
 * @since     09.04.13
 * @link      https://github.com/heiglandreas/
 */

namespace Org_Heigl\ColorTest\Converter;


use Org_Heigl\Color\Converter\RGB2HSL;
use PHPUnit\Framework\TestCase;

class RGB2HSLTest extends TestCase
{

    /**
     * @dataProvider rgb2HslConversionProvider
     */
    public function testRgb2HslConversion($result, $input)
    {
        $converter = new RGB2HSL();

        $this->assertEquals($result, $converter->convert($input));
    }

    public function rgb2HslConversionProvider()
    {
        return array(
            array(array(0,0,0),array(0,0,0)),
            array(array(0.5, 0.75, 0.43921568627451),array(28, 196, 196)),
            array(array(0,0,1),array(255,255,255)),
            array(array(0,0,0.5),array(127.5,127.5,127.5)),
            array(array(0.25,0.903,0.482), array(122.91,233.89773,11.92227)),
        );
    }
}
