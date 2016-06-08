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


class HSL2RGB extends AbstractConverter implements ConverterInterface
{
    /**
     * Implements ConverterInterface::convert()
     *
     * HSL-Input from 0 to 1
     *
     * @param array $input
     *
     * @see http://www.easyrgb.com/index.php?X=MATH&H=19#text19
     * @return array
     */
    public function convert(array $input)
    {
        $RGB = array();
        if (0 == $input[1]) {
            $RGB[0] = $input[2] * 255;                      //RGB results from 0 to 255
            $RGB[1] = $input[2] * 255;
            $RGB[2] = $input[2] * 255;
        } else {
            if ($input[2] < 0.5 ) {
                $var_2 = $input[2] * (1 + $input[1]);
            } else {
                $var_2 = ($input[2] + $input[1]) - ($input[1] * $input[2]);
            }
            $var_1 = 2 * $input[2] - $var_2;

            $RGB[0] = 255 * $this->Hue_2_RGB($var_1, $var_2, $input[0] + (1/3));
            $RGB[1] = 255 * $this->Hue_2_RGB($var_1, $var_2, $input[0]);
            $RGB[2] = 255 * $this->Hue_2_RGB($var_1, $var_2, $input[0] - (1/3));
        }

        return $RGB;
    }

    /**
     * Convert a Hue to an RGB-Value
     *
     * @param float $v1
     * @param float $v2
     * @param float $vH
     *
     * @return float
     */
    protected function Hue_2_RGB($v1, $v2, $vH)             //Function Hue_2_RGB
    {
        if ($vH < 0) {
            $vH += 1;
        }
        if ($vH > 1) {
            $vH -= 1;
        }
        if ((6 * $vH ) < 1) {
            return ($v1 + ($v2 - $v1) * 6 * $vH);
        }
        if ((2 * $vH) < 1) {
            return ($v2);
        }
        if ((3 * $vH) < 2) {
            return ($v1 + ($v2 - $v1) * ((2 / 3) - $vH) * 6);
        }

        return ($v1);
    }
}