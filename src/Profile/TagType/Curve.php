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
 * @since     12.04.13
 * @link      https://github.com/heiglandreas/
 */

namespace Org_Heigl\Color\Profile\TagType;

class Curve implements \Countable, TagTypeInterface
{
    protected $curve = array();

    public function __construct($data)
    {
        $this->render($data);
    }

    public function render($data)
    {
        $curve = unpack('NID/NNull/NCounter/n*', $data);
        $counter = $curve['Counter'];
        unset($curve['ID']);
        unset($curve['Null']);
        unset($curve['Counter']);
        if ($counter === count($curve)) {
            $this->curve = array_values($curve);
        }
        return $this;
    }

    public function count()
    {
        return count($this->curve);
    }

    public function getKey($key)
    {
        return $this->curve[$key];
    }

    /**
     * Get the value for a given color-part.
     *
     * @param float $value
     *
     * @return float
     */
    public function getValue($value)
    {
        $value = $value * ($this->count() - 1);
        $min   = floor($value);
        if ($min == $value) {
            return $this->getKey($min)/65535;
        }
        $diff = $value - $min;

        $minVal = $this->getKey($min);
        $maxVal = $this->getKey($min + 1);

        $result = $minVal;

        $difference = $maxVal - $minVal;
        $result = $result + $difference * $diff;
        $result = $result / 65535;

        return $result;
    }
}
