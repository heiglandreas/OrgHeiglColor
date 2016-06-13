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
 * @since     19.04.13
 * @link      https://github.com/heiglandreas/
 */

namespace Org_Heigl\ColorTest\Profile\Table;


use Org_Heigl\Color\Profile\Table\Clut;
use Org_Heigl\Color\Profile\Table\ClutEntry;
use Mockery as M;

class ClutTest extends \PHPUnit_Framework_TestCase
{
    public function testSettingEntry()
    {
        $entry = pack('n*',
            0x0000, 0x0010, 0x0180, 0x0800, 0x0011, 0x0022, 0x0033, 0x0044,
            0x0000, 0x0010, 0x0180, 0x0800, 0x0011, 0x0022, 0x0033, 0x0044,
            0x0000, 0x0010, 0x0180, 0x0800, 0x0011, 0x0022, 0x0033, 0x0044,
            0x0000, 0x0010, 0x0180, 0x0800, 0x0011, 0x0022, 0x0033, 0x0044,
            0x0000, 0x0010, 0x0180, 0x0800, 0x0011, 0x0022, 0x0033, 0x0044,
            0x0000, 0x0010, 0x0180, 0x0800, 0x0011, 0x0022, 0x0033, 0x0044
        );

        $clut = M::mock('\Org_Heigl\Color\Profile\Table\Clut');

        $obj = new Clut();
        $obj->addEntry($clut);

        $this->assertAttributeSame(array($clut), 'entry', $obj);
    }

    public function testGEttingValues()
    {
        $clutEntryFloor = new ClutEntry(array(0, 0.5, 1));
        $clutEntryCeil  = new ClutEntry(array(1, 0.5, 0));

        $obj = new Clut(array($clutEntryFloor, $clutEntryCeil));

        $result = $obj->getValue(array(0.5));

        $this->assertEquals(array(0.5, 0.5, 0.5), $result);
    }

    public function testGEttingMultipleValues()
    {
        $c0 = new ClutEntry(array(0));
        $c1 = new ClutEntry(array(0.25));
        $c2 = new ClutEntry(array(0.5));
        $c3 = new ClutEntry(array(0.25));
        $c4 = new ClutEntry(array(0.5));
        $c5 = new ClutEntry(array(0.75));
        $c6 = new ClutEntry(array(0.5));
        $c7 = new ClutEntry(array(0.75));
        $c8 = new ClutEntry(array(1));

        $oc1 = new Clut(array($c0, $c1, $c2));
        $oc2 = new Clut(array($c3, $c4, $c5));
        $oc3 = new Clut(array($c6, $c7, $c8));

        $obj = new Clut(array($oc1, $oc2, $oc3));

        $this->assertEquals(array(0.5), $obj->getValue(array(0.25, 0.75)));

    }

}
