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
 * @since     26.03.13
 * @link      https://github.com/heiglandreas/
 */

namespace Org\Heigl\Color\Profile\Table;

use Org\Heigl\Color\Color;
use Org\Heigl\Color\Parser\S15Fixed16Number;


class Bluepoint implements TableInterface{

    /**
     * Color of the Blue-Max-Point
     *
     * @var Color $bluepoint
     */
    protected $bluepoint = null;

    /**
     * Set the Blue-Point
     *
     * @param Color $bluepoint
     *
     * @return Bxyz
     */
    public function setBluepoint(Color $bluepoint)
    {
        $this->bluepoint = $bluepoint;

        return $this;
    }

    /**
     * Get the Bluepoint
     *
     * @return Color
     */
    public function getBluepoint()
    {
        return $this->bluepoint;
    }

    /**
     * Set the content of this class
     *
     * @param string $content
     */
    public function setContent($content)
    {
        $x = substr($content, 8, 4);
        $y = substr($content, 12, 4);
        $z = substr($content, 16, 4);
        $x = S15Fixed16Number::toFloat($x);
        $y = S15Fixed16Number::toFloat($y);
        $z = S15Fixed16Number::toFloat($z);

        $color = new Color();
        $color->setXYZ($x, $y, $z);

        $this->setBluepoint($color);

        return $this;
    }

    /**
     * Create an instance of the class
     *
     * @param Color $bluepoint
     */
    public function __construct(Color $bluepoint = null)
    {
        if (null !== $bluepoint) {
            $this->setBluepoint($bluepoint);
        }
    }

}