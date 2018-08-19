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

use Org_Heigl\Color\Profile\Table\ClutEntry;
use Org_Heigl\Color\Profile\Table\Clut;
use Org_Heigl\Color\Profile\Table\OneDimensionalTable;
use Org_Heigl\Color\Profile\TagType\Lut16;
use PHPUnit\Framework\TestCase;

class Lut16Test extends TestCase
{

    public function testParsingOfBinaryData()
    {
        //$this->markTestSkipped();
        $data = pack(
            'n*',
            0x6D66,
            0x7432,
            0x0000,
            0x0000,
            0x0403,
            0x0200,
            0x0001,
            0x0000,
            0x0000,
            0x0000,
            0x0000,
            0x0000,
            0x0000,
            0x0000,
            0x0001,
            0x0000,
            0x0000,
            0x0000,
            0x0000,
            0x0000,
            0x0000,
            0x0000,
            0x0001,
            0x0000,
            0x0002,
            0x0002,
            0x0000,
            0xFFFF,
            0x0000,
            0xFFFF,
            0x0000,
            0xFFFF,
            0x0000,
            0xFFFF,
            0x0000,
            0x0010,
            0x0180,
            0x0800,
            0x0011,
            0x0022,
            0x0033,
            0x0044,
            0x0000,
            0x0010,
            0x0180,
            0x0800,
            0x0011,
            0x0022,
            0x0033,
            0x0044,
            0x0000,
            0x0010,
            0x0180,
            0x0800,
            0x0011,
            0x0022,
            0x0033,
            0x0044,
            0x0000,
            0x0010,
            0x0180,
            0x0800,
            0x0011,
            0x0022,
            0x0033,
            0x0044,
            0x0000,
            0x0010,
            0x0180,
            0x0800,
            0x0011,
            0x0022,
            0x0033,
            0x0044,
            0x0000,
            0x0010,
            0x0180,
            0x0800,
            0x0011,
            0x0022,
            0x0033,
            0x0044,
            0x0000,
            0xFFFF,
            0x0000,
            0xFFFF,
            0x0000,
            0xFFFF
        );

        $tag = new Lut16($data);
        $clut0000 = new ClutEntry(array(0,16,384));
        $clut0001 = new ClutEntry(array(2048, 17, 34));
        $clut0010 = new ClutEntry(array(51, 68, 0));
        $clut0011 = new ClutEntry(array(16,384,2048));
        $clut0100 = new ClutEntry(array(17, 34, 51));
        $clut0101 = new ClutEntry(array(68, 0, 16));
        $clut0110 = new ClutEntry(array(384, 2048, 17));
        $clut0111 = new ClutEntry(array(34, 51, 68));
        $clut1000 = new ClutEntry(array(0,16,384));
        $clut1001 = new ClutEntry(array(2048, 17, 34));
        $clut1010 = new ClutEntry(array(51, 68, 0));
        $clut1011 = new ClutEntry(array(16,384,2048));
        $clut1100 = new ClutEntry(array(17, 34, 51));
        $clut1101 = new ClutEntry(array(68, 0, 16));
        $clut1110 = new ClutEntry(array(384, 2048, 17));
        $clut1111 = new ClutEntry(array(34, 51, 68));
        $clut000 = new Clut(array($clut0000, $clut0001));
        $clut001 = new Clut(array($clut0010, $clut0011));
        $clut010 = new Clut(array($clut0100, $clut0101));
        $clut011 = new Clut(array($clut0110, $clut0111));
        $clut100 = new Clut(array($clut1000, $clut1001));
        $clut101 = new Clut(array($clut1010, $clut1011));
        $clut110 = new Clut(array($clut1100, $clut1101));
        $clut111 = new Clut(array($clut1110, $clut1111));
        $clut00 = new Clut(array($clut000, $clut001));
        $clut01 = new Clut(array($clut010, $clut011));
        $clut10 = new Clut(array($clut100, $clut101));
        $clut11 = new Clut(array($clut110, $clut111));
        $clut0 = new Clut(array($clut00, $clut01));
        $clut1 = new Clut(array($clut10, $clut11));
        $clut = new Clut(array($clut0, $clut1));


        $this->assertAttributeEquals(3, 'outputChannels', $tag);
        $this->assertAttributeEquals(4, 'inputChannels', $tag);
        $this->assertAttributeEquals(2, 'numberOfCLUTPoints', $tag);

        $this->assertAttributeEquals(
            array(array(1,0,0), array(0,1,0), array(0,0,1)),
            'matrix',
            $tag
        );

        $table = new  OneDimensionalTable();
        $table->addEntries(array(0,65535));
        $this->assertAttributeEquals(
            array($table, $table, $table, $table),
            'inputTables',
            $tag
        );
        $this->assertAttributeEquals(
            array($table, $table, $table),
            'outputTables',
            $tag
        );

        $this->assertAttributeEquals($clut, 'clut', $tag);

//        $this->assertAttributeEquals(256, '');
    }

    /**
     * @param $expected
     * @param $requested
     * @dataProvider gettingOfValuesProvider
     */
    public function testGettingOfValues($expected, $requested)
    {
        $this->markTestSkipped();
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
