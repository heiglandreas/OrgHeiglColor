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
 * @since     02.04.13
 * @link      https://github.com/heiglandreas/
 */

namespace Org_Heigl\ColorTest\Parser;

use Org_Heigl\Color\Parser\S15Fixed16Number;
use PHPUnit\Framework\TestCase;

class S15Fixed16NumberTest extends TestCase
{

    /**
     * @param $bin
     * @param $expect
     * @dataProvider toFloatConversionProvider
     */
    public function testToFloatConversion($bin, $expect)
    {
      //  $bin = pack('n*', 0x0001, 0x0000);
        $result = S15Fixed16Number::toFloat($bin);
        $this->assertEquals($expect, $result);
    }

    public function toFloatConversionProvider()
    {
        return array(
            array(pack('n*', 0x0001, 0x0000), 1.0),
            array(pack('n*', 0x0000, 0x0000), 0.0),
            array(pack('n*', 0x7FFF, 0xFFFF), 32767 + (65535/65536)),
            array(pack('n*', 0x8000, 0x0000), -32768.0),
        );
    }
}
