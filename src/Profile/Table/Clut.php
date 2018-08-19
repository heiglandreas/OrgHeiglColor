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
 * @since     18.04.13
 * @link      https://github.com/heiglandreas/
 */

namespace Org_Heigl\Color\Profile\Table;

use Org_Heigl\Color\Exception as Ex;

class Clut implements ClutInterface
{

    protected $entry = array();

    /**
     * Add an entry to the ColorLookupTable
     *
     * @param ClutInterface $entry
     *
     * @see ClutInterface::addEntry()
     * @return ClutInterface
     */
    public function addEntry(ClutInterface $entry)
    {
        $this->entry[] = $entry;

        return $this;
    }

    /**
     * Create an instance of the class
     *
     * @param ClutInterface[] $content
     */
    public function __construct(array $content = null)
    {
        if (null === $content) {
            return ;
        }

        foreach ($content as $item) {
            if (! $item instanceof ClutInterface) {
                continue;
            }
            $this->addEntry($item);
        }
    }

    /**
     * set the number of input channels
     *
     * @param int $inputChannels
     *
     * @return ClutInterface
     */
    public function setInputChannels($inputChannels)
    {
        $this->inputChannels = $inputChannels;

        return $this;
    }

    /**
     * Set the number of outputChannels
     *
     * @param int $outputChannels
     *
     * @return ClutInterface
     */
    public function setOutputChannels($outputChannels)
    {
        $this->outputChannels = $outputChannels;

        return $this;
    }

    /**
     * Set the number of CLUT-Points
     *
     * @param int $clutPoints
     *
     * @return ClutInterface
     */
    public function setClutPoints($clutPoints)
    {
        $this->clutPoints = $clutPoints;

        return $this;
    }

    /**
     * Get the number of CLUT-Points
     *
     * @return int
     */
    public function getClutPoints()
    {
        return count($this->entry);
    }

    /**
     * Get a value
     *
     * The input value has to be given as float between 0 and 1 including.
     *
     * This method takes the input, multiplies it with the number of CLUT-Points
     * and returns the linearized result between the ceiling- and floor-values
     *
     * @param float[] $input
     *
     * @throws Ex\SizeMismatchException
     * @return array
     */
    public function getValue(array $input)
    {
        $value = array_shift($input);

        $value = $value * ($this->getClutPoints() - 1);

        $valueFloor = floor($value);
        $valueCeil  = ceil($value);

        $floor = $this->entry[$valueFloor]->getValue($input);
        $ceil  = $this->entry[$valueCeil]->getValue($input);
        if (count($floor) != count($ceil)) {
            throw new Ex\SizeMismatchException('The two arrays are not of the same size');
        }

        $returnValue = array();
        $count = count($floor);
        $diff  = $value - $valueFloor;
        for ($i = 0; $i < $count; $i++) {
            $myVal = ($ceil[$i] - $floor[$i]) * $diff;
            $returnValue[$i] = $floor[$i] + $myVal;
        }

        return $returnValue;
    }
}
