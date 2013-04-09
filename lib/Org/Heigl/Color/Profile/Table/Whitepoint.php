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
 * @since     26.03.13
 * @link      https://github.com/heiglandreas/
 */

namespace Org\Heigl\Color\Profile\Table;

use Org\Heigl\Color\Color;
use Org\Heigl\Color\Parser\S15Fixed16Number;


class Whitepoint implements TableInterface{

    /**
     * Color of the whitepoint
     *
     * @var Color $whitepoint
     */
    protected $whitepoint = null;

    /**
     * Set the whitepoint
     *
     * @param Color $whitepoint
     *
     * @return Whitespace
     */
    public function setWhitepoint(Color $whitepoint)
    {
        $this->whitepoint = $whitepoint;

        return $this;
    }

    /**
     * Get the whitespace
     *
     * @return Color
     */
    public function getWhitepoint()
    {
        return $this->whitepoint;
    }

    /**
     * Set the content of this class
     *
     * @param string $content
     */
    public function setContent($content)
    {
        $x = substr($content, 8, 4);
        $y = substr($content, 12, 4);
        $z = substr($content, 16, 4);
        $x = S15Fixed16Number::toFloat($x);
    }

    /**
     * Create an instance of the class
     *
     * @param Color $whitepoint
     */
    public function __construct(Color $whitepoint = null)
    {
        if (null !== $whitepoint) {
            $this->setWhitepoint($whitepoint);
        }
    }

}