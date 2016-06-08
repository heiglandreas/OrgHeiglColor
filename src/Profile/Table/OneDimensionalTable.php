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
 * @since     23.04.13
 * @link      https://github.com/heiglandreas/
 */

namespace Org_Heigl\Color\Profile\Table;


class OneDimensionalTable implements \Countable
{

    /**
     * The tables content
     *
     * @var array $table
     */
    protected $table = array();

    /**
     * Count the number of entries of this table
     *
     * @see Countable::count
     * @return int
     */
    public function count()
    {
        return count($this->table);
    }

    /**
     * Get the value of the given key
     *
     * @param float $key
     *
     * @return float
     */
    public function getKey($key)
    {
        return $this->curve[$key];
    }

    /**
     * Get the table-value for a given value.
     *
     * $value is expected in the range from 0 to 1
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

    /**
     * Add an entry to the table
     *
     * @param int $key
     * @param float $value
     *
     * @return OneDimensionalTable
     */
    public function addEntry($key, $value)
    {
        $this->table[$key] = $value;

        return $this;
    }

    /**
     * Add an array as entry
     *
     * @param array $values
     *
     * @return OneDimensionalTable
     */
    public function addEntries(array $values)
    {
        $i = 0;
        foreach ($values as $value) {
            $this->addEntry($i++, $value);
        }

        return $this;
    }
}