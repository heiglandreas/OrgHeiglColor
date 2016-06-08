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
 * @since     22.03.13
 * @link      https://github.com/heiglandreas/
 */

namespace Org_Heigl\Color\Converter;


class XYZ2Lab extends AbstractConverter implements ConverterInterface
{
    /**
     * Adapts XYZ to ICC-Profile whitepoint
     *
     * @var array $whitepoint
     */
    protected $whitepoint = null;

    /**
     * Create a new instance
     */
    public function __construct()
    {
        // Use default sRGB-Whitepoint
        $this->whitepoint = new Color();
        $this->whitepoint->setX(0.95047)->setY(1.00)->setZ(1.08883);
    }

    /**
     * Convert an XYZ-Triplet into an Lab-Triplet
     *
     * @param array $input An array containing XYZ-values
     *
     * @see AbstractConverter::convert()
     * @see http://www.easyrgb.com/index.php?X=MATH&H=07#text7
     * @return array Containing Lab-Values
     */
    public function convert(array $input)
    {
        $var_X = $input[0] / $this->whitepoint->getX() * 100;
        $var_Y = $input[1] / $this->whitepoint->getY() * 100;
        $var_Z = $input[2] / $this->whitepoint->getZ() * 100;

        if ($var_X > 0.008856) {
            $var_X = $var_X ^ (1/3);
        } else {
            $var_X = (7.787 * $var_X) + (16 / 116);
        }
        if ($var_Y > 0.008856) {
            $var_Y = $var_Y ^ (1/3);
        } else {
            $var_Y = (7.787 * $var_Y) + (16 / 116);
        }
        if ($var_Z > 0.008856) {
            $var_Z = $var_Z ^ (1/3);
        } else {
            $var_Z = (7.787 * $var_Z) + (16 / 116);
        }

        $CIE_L = (116 * $var_Y) - 16;
        $CIE_a = 500 * ($var_X - $var_Y);
        $CIE_b = 200 * ($var_Y - $var_Z);

        return array($CIE_L, $CIE_a, $CIE_b);
    }
}