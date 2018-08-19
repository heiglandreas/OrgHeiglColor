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

class RGB2HSL extends AbstractConverter implements ConverterInterface
{
    /**
     * Implements ConverterInterface::convert()
     *
     * @param array $input
     *
     * @see http://www.easyrgb.com/index.php?X=MATH&H=18#text18
     * @return array
     */
    public function convert(array $input)
    {
        $var_R = ($input[0]/255);                     //RGB from 0 to 255
        $var_G = ($input[1]/255);
        $var_B = ($input[2]/255);

        $var_Min = min($var_R, $var_G, $var_B);    //Min. value of RGB
        $var_Max = max($var_R, $var_G, $var_B);  //Max. value of RGB
        $del_Max = $var_Max - $var_Min;             //Delta RGB value

        $L = ($var_Max + $var_Min)/2;

        if (0 == $del_Max) {                     //This is a gray, no chroma...
            $H = 0;                                //HSL results from 0 to 1
            $S = 0;
        } else {
            if ($L < 0.5) {
                $S = $del_Max/($var_Max + $var_Min);
            } else {
                $S = $del_Max/(2 - $var_Max - $var_Min);
            }
            $del_R = ((($var_Max - $var_R)/6) + ($del_Max/2))/$del_Max;
            $del_G = ((($var_Max - $var_G)/6) + ($del_Max/2))/$del_Max;
            $del_B = ((($var_Max - $var_B)/6) + ($del_Max/2))/$del_Max;

            if ($var_R == $var_Max) {
                $H = $del_B - $del_G;
            } elseif ($var_G == $var_Max) {
                $H = (1/3) + $del_R - $del_B;
            } elseif ($var_B == $var_Max) {
                    $H = (2/3) + $del_G - $del_R;
            }


            if ($H < 0) {
                $H += 1;
            }
            if ($H > 1) {
                $H -= 1;
            }
        }

        return array($H, $S, $L);
    }

    /**
     * Convert a color to RGB
     *
     * @param Color $color
     *
     * @return array
     */
    public function convertColor(\Org\Heigl\Color\Color $color)
    {
        $array = array($color->getX(), $color->getY(), $color->getZ());
        return $this->convert($array);
    }
}
