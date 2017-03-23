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


use Org_Heigl\Color\Color;

class XYZ2RGB extends AbstractConverter implements ConverterInterface
{
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
        $var_X = $input[0] / 100; //X from 0 to  95.047      (Observer = 2°, Illuminant = D65)
        $var_Y = $input[1] / 100; //Y from 0 to 100.000
        $var_Z = $input[2] / 100; //Z from 0 to 108.883

        $var_R = $var_X *  3.2406 + $var_Y * -1.5372 + $var_Z * -0.4986;
        $var_G = $var_X * -0.9689 + $var_Y *  1.8758 + $var_Z *  0.0415;
        $var_B = $var_X *  0.0557 + $var_Y * -0.2040 + $var_Z *  1.0570;

        if ($var_R > 0.0031308) {
            $var_R = 1.055 * pow($var_R, (1 / 2.4)) - 0.055;
        } else {
            $var_R = 12.92 * $var_R;
        }
        if ($var_G > 0.0031308) {
            $var_G = 1.055 * pow($var_G, (1 / 2.4)) - 0.055;
        } else {
            $var_G = 12.92 * $var_G;
        }
        if ($var_B > 0.0031308) {
            $var_B = 1.055 * pow($var_B, (1 / 2.4)) - 0.055;
        } else {
            $var_B = 12.92 * $var_B;
        }

        $R = $var_R * 255;
        $G = $var_G * 255;
        $B = $var_B * 255;

        return array($R, $G, $B);
    }

    /**
     * Convert a color to RGB
     *
     * @param Color $color
     *
     * @return array
     */
    public function convertColor(Color $color)
    {
        $array = array($color->getX(), $color->getY(), $color->getZ());
        return $this->convert($array);
    }
}
