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

namespace Org_Heigl\Color\Converter;

use Org_Heigl\Color\Color;
use Org_Heigl\Color\Space\Lab;
use Org_Heigl\Color\Space\XYZ;

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
        $this->whitepoint = new Color(new XYZ(0.95, 1.00, 1.08883));
    }

    /**
     * Implements ConverterInterface::convert()
     *
     * @param array $input
     *
     * @see http://www.easyrgb.com/index.php?X=MATH&H=01#text1
     * @return array
     */
    public function convert(Lab $Lab)
    {
        $var_Y = (($Lab->getL() + 16) / 116) ;
        $var_X = ($Lab->getA() / 500 + $var_Y);
        $var_Z = ($var_Y - $Lab->getB() / 200);

        if (pow($var_Y, 3) > 0.008856) {
            $var_Y = pow($var_Y, 3);
        } else {
            $var_Y = ($var_Y - 16 / 116 ) / 7.787;
        }
        if (pow($var_X, 3) > 0.008856 ) {
            $var_X = pow($var_X, 3);
        } else {
            $var_X = ($var_X - 16 / 116 ) / 7.787;
        }
        if (pow($var_Z, 3) > 0.008856) {
            $var_Z = pow($var_Z, 3);
        } else {
            $var_Z = ($var_Z - 16 / 116 ) / 7.787;
        }

        $X = $this->whitepoint->getXYZ()->getX() * 100 * $var_X;
        $Y = $this->whitepoint->getXYZ()->getY() * 100 * $var_Y;
        $Z = $this->whitepoint->getXYZ()->getZ() * 100 * $var_Z;

        return new XYZ($X, $Y, $Z);

    }
}
