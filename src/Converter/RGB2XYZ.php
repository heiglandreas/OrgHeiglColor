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

use Org_Heigl\Color\Space\XYZ;

class RGB2XYZ extends AbstractConverter implements ConverterInterface
{

    /**
     * Convert an RGB-triplet into an XYZ-triplet
     *
     * The RGB-Triplet has to be given in values from 0 through 255
     *
     * @param array $input An array containing rgb-values
     *
     * @return array Containing XYZ-Values
     */
    public function convert(array $input)
    {
        $var_R = ($input[0] / 255); //R from 0 to 255
        $var_G = ($input[1] / 255); //G from 0 to 255
        $var_B = ($input[2] / 255); //B from 0 to 255

        if ($var_R > 0.04045) {
            $var_R = pow((($var_R + 0.055) / 1.055), 2.4);
        } else {
            $var_R = $var_R / 12.92;
        }
        if ($var_G > 0.04045) {
            $var_G = pow((($var_G + 0.055) / 1.055), 2.4);
        } else {
            $var_G = $var_G / 12.92;
        }
        if ($var_B > 0.04045) {
            $var_B = pow((($var_B + 0.055) / 1.055), 2.4);
        } else {
            $var_B = $var_B / 12.92;
        }

        $var_R = $var_R * 100;
        $var_G = $var_G * 100;
        $var_B = $var_B * 100;

        //Observer. = 2°, Illuminant = D65
        $X = $var_R * 0.4124 + $var_G * 0.3576 + $var_B * 0.1805;
        $Y = $var_R * 0.2126 + $var_G * 0.7152 + $var_B * 0.0722;
        $Z = $var_R * 0.0193 + $var_G * 0.1192 + $var_B * 0.9505;

        return array($X, $Y, $Z);
    }

}