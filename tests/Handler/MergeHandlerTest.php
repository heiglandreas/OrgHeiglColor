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
 * @since     10.04.13
 * @link      https://github.com/heiglandreas/
 */

namespace Org_Heigl\ColorTest\Handler;


use Org_Heigl\Color\Color;
use Org_Heigl\Color\Handler\MergeHandler;
use Org_Heigl\Color\Space\XYZ;
use PHPUnit\Framework\TestCase;

class MergeHandlerTest extends TestCase
{
    /**
     * @dataProvider mergeProvider
     */
    public function testMerge($input, $merge, $expect)
    {
        $c1 = new Color(new XYZ($input[0], $input[1], $input[2]));
        $c2 = new Color(new XYZ($merge[0], $merge[1], $merge[2]));
        $c3 = new Color(new XYZ($expect[0], $expect[1], $expect[2]));
        $handler = new MergeHandler($c1);
        $handler->merge($c2);

        $this->assertEquals($c3, $handler->getColor());
    }

    public function mergeProvider()
    {
        return array(
            array(array(1,2,3), array(2,3,4), array(3,5,7)),
        );
    }

}
