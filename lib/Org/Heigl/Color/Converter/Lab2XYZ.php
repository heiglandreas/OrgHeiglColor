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
 * @since     25.03.13
 * @link      https://github.com/heiglandreas/
 */

namespace Org\Heigl\Color\Converter;


class Lab2XYZ
{

    /**
     * Adapts XYZ to Observer= 2°, Illuminant= D65
     *
     * @var array $whitepoint
     */
    protected $whitepoint = null;

    /**
     * Create a new instance
     */
    public function __construct()
    {
        $this->whitepoint = new Color();
        $this->whitepoint->setX(0.95)->setY(1.00)->setZ(1.08883);
    }

    /**
     * Implements ConverterInterface::convert()
     *
     * @param array $input
     *
     * @see http://www.easyrgb.com/index.php?X=MATH&H=01#text1
     * @return array
     */
    public function convert(array $input)
    {
        $var_Y = ($input[0] + 16) / 116;
        $var_X = $input[1] / 500 + $var_Y;
        $var_Z = $var_Y - $input[2] / 200;

        if ($var_Y^3 > 0.008856) {
            $var_Y = $var_Y^3;
        } else {
            $var_Y = ($var_Y - 16 / 116 ) / 7.787;
        }
        if ($var_X^3 > 0.008856 ) {
            $var_X = $var_X^3;
        } else {
            $var_X = ($var_X - 16 / 116 ) / 7.787;
        }
        if ($var_Z^3 > 0.008856) {
            $var_Z = $var_Z^3;
        } else {
            $var_Z = ($var_Z - 16 / 116 ) / 7.787;
        }

        $X = $this->whitepoint->getX() * 100 * $var_X;
        $Y = $this->whitepoint->getY() * 100 * $var_Y;
        $Z = $this->whitepoint->getZ() * 100 * $var_Z;

    }
}