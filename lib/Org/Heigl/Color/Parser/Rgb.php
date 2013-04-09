<?php
/**
 * Copyright (c)2013-2013 Andreas Heigl
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
 * @since     21.03.13
 * @link      https://github.com/heiglandreas/
 */

namespace Org\Heigl\Color\Parser;

use Org\Heigl\Color\Converter as C;
use Org\Heigl\Color\Color;
/**
 * Class Rgb
 *
 * @package Org\Heigl\Color\Parser
 * @author    Andreas Heigl<andreas@heigl.org>
 * @copyright ©2013-2013 Andreas Heigl
 * @license   http://www.opesource.org/licenses/mit-license.php MIT-License
 * @version   0.0
 * @since     21.03.13
 * @link      https://github.com/heiglandreas/
 */
class Rgb extends AbstractParser
{
    /**
     * The fully namespaced name of the default Converter-Class
     *
     * @param string $defaultConverter
     */
    protected $defaultConverter = '\\Org\\Heigl\\Color\\Converter\\RGB2XYZ';

    /**
     * Parse the given RGB-Values
     *
     * TODO: Implement the usage of ColorProfiles for parsing
     * @param array $input
     *
     * @see ParserInterface::parse()
     * @return Color
     */
    public function parse(array $input)
    {
//        $converter = new C\ConverterChain();
//        $converter->addConverter(new C\RGB2XYZ())
//                  ->addConverter(new C\XYZ2Lab());
//
        $converter = $this->getConverter();
        $XYZ = $converter->convert($input);
        $color = new Color();
        return $color->setXYZ($XYZ[0], $XYZ[1], $XYZ[2]);
    }
}