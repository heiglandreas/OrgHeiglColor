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
use Org_Heigl\Color\ColorFactory;
use Org_Heigl\Color\Converter\XYZ2RGB;

class ColorContrast
{
    public function __invoke(Color $color)
    {
        $converter = new XYZ2RGB();
        $rgb = $converter->convertColor($color);

        $yiq = (($rgb[0]*256*299)+($rgb[1]*256*587)+($rgb[2]*256*114))/1000;
        if ($yiq >= 128) {
            return ColorFactory::createFromRgb(0, 0, 0);
        }

        return ColorFactory::createFromRgb(1, 1, 1);

    }
}
