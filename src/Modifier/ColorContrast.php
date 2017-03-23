<?php
/**
 * Copyright (c) Andreas Heigl<andreas@heigl.org>
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
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @author    Andreas Heigl<andreas@heigl.org>
 * @copyright Andreas Heigl
 * @license   http://www.opensource.org/licenses/mit-license.php MIT-License
 * @since     22.03.2017
 * @link      http://github.com/heiglandreas/pdfcalendar
 */

namespace Org_Heigl\Color\Modifier;

use Org_Heigl\Color\Color;

class ColorContrast
{
    public function __invoke(Color $color)
    {
        $contrast = clone $color;

        $arg1 = pow(1 - $color->getL(), 2);
        $arg2 = pow(1 - $color->geta(), 2);
        $arg3 = pow(1 - $color->getb(), 2);
        $deltaE1 = sqrt($arg1 + $arg2 + $arg3);

        $arg1 = pow(-1 - $color->getL(), 2);
        $arg2 = pow(-1 - $color->geta(), 2);
        $arg3 = pow(-1 - $color->getb(), 2);
        $deltaE2 = sqrt($arg1 + $arg2 + $arg3);

        if ($deltaE1 > $deltaE2) {
            return $contrast->setLab(1, 1, 1);
        }

        return $contrast->setLab(-1, -1, -1);
    }
}
