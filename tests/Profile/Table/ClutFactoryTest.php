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

use Org_Heigl\Color\Profile\Table\ClutFactory;
use PHPUnit\Framework\TestCase;

class ClutFactoryTest extends TestCase
{

    public function testSettingClutPoints()
    {
        $clutFactory = new ClutFactory();

        $this->assertAttributeEquals(0, 'clutPoints', $clutFactory);
        $this->assertSame($clutFactory, $clutFactory->setClutPoints(12));
        $this->assertAttributeEquals(12, 'clutPoints', $clutFactory);
        $this->assertEquals(12, $clutFactory->getClutPoints());
    }

    public function testSettingInputChannels()
    {
        $clutFactory = new ClutFactory();

        $this->assertAttributeEquals(0, 'inputChannels', $clutFactory);
        $this->assertSame($clutFactory, $clutFactory->setInputChannels(12));
        $this->assertAttributeEquals(12, 'inputChannels', $clutFactory);
        $this->assertEquals(12, $clutFactory->getInputChannels());
    }

    public function testOutputChannels()
    {
        $clutFactory = new ClutFactory();

        $this->assertAttributeEquals(0, 'outputChannels', $clutFactory);
        $this->assertSame($clutFactory, $clutFactory->setOutputChannels(12));
        $this->assertAttributeEquals(12, 'outputChannels', $clutFactory);
        $this->assertEquals(12, $clutFactory->getOutputChannels());
    }

    public function testSettingValues()
    {
        $clutFactory = new ClutFactory();
        $values = array('foo');

        $this->assertAttributeEquals(null, 'values', $clutFactory);
        $this->assertSame($clutFactory, $clutFactory->setValue($values));
        $this->assertAttributeEquals($values, 'values', $clutFactory);
        $this->assertEquals($values, $clutFactory->getValue());
    }

    public function testParsingSingleValue()
    {
        $factory = new ClutFactory();
        $factory->setInputChannels(0)
                ->setOutputChannels(2)
                ->setClutPoints(1);
        $this->assertEquals(array(1,2), $factory->parseEntry(array(1,2), 0));
    }

    public function testParsingMultiValues()
    {
        $factory = new ClutFactory();
        $factory->setInputChannels(1)
                ->setOutputChannels(2)
                ->setClutPoints(1);
        $result = $factory->parseEntry(array(1,2), 1);
        $this->assertEquals(array(array(1,2)), $result);
    }

    public function testParsingValues()
    {
        $entry = array(
            0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18,
            19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35,
            36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47
        );

        $result = array(
            0 => array(
                0 => array(
                    0 => array(
                        0 => array(0,1,2),
                        1 => array(3,4,5),
                    ),
                    1 => array(
                        0 => array(6,7,8),
                        1 => array(9,10,11),
                    ),
                ),
                1 => array(
                    0 => array(
                        0 => array(12,13,14),
                        1 => array(15,16,17),
                    ),
                    1 => array(
                        0 => array(18,19,20),
                        1 => array(21,22,23),
                    ),
                ),
            ),
            1 => array(
                0 => array(
                    0 => array(
                        0 => array(24,25,26),
                        1 => array(27,28,29),
                    ),
                    1 => array(
                        0 => array(30,31,32),
                        1 => array(33,34,35),
                    ),
                ),
                1 => array(
                    0 => array(
                        0 => array(36,37,38),
                        1 => array(39,40,41),
                    ),
                    1 => array(
                        0 => array(42,43,44),
                        1 => array(45,46,47),
                    ),
                ),
            ),
        );

        $factory = new ClutFactory();
        $factory->setClutPoints(2)
                ->setValue($entry)
                ->setOutputChannels(3)
                ->setInputChannels(4);
        $this->assertEquals($result, $factory->parseEntry($entry, $factory->getInputChannels()));
    }


}
