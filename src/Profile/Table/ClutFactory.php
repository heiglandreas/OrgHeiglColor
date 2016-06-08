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


class ClutFactory
{

    /**
     * The number of input channesl
     *
     * @var int $inputChannels
     */
    protected $inputChannels = 0;

    /**
     * The number of CLUT-Points
     *
     * @var int $clutPoints
     */
    protected $clutPoints = 0;

    /**
     * The number of output Channels
     *
     * @var int $outputChannels
     */
    protected $outputChannels = 0;

    /**
     * The raw CLUT-Values
     *
     * @var string $values
     */
    protected $values = '';

    /**
     * Create a CLUT-Entry
     *
     * @return ClutInterface
     */
    public static function getEntry(array $values, $inputChannel, $clutEntries, $outputChannels)
    {

        $factory = new self();
        $factory->setInputChannels($inputChannel)
                ->setOutputChannels($outputChannels)
                ->setClutPoints($clutEntries)
                ->setValue($values);

        return $factory->parseEntryAsObject($values, $inputChannel);
    }

    /**
     * Set the inputChannels
     *
     * @param int $inputChannels
     *
     * @return ClutFactory
     */
    public function setInputChannels($inputChannels)
    {
        $this->inputChannels = $inputChannels;

        return $this;
    }

    /**
     * Get the number of input channels
     *
     * @return int
     */
    public function getInputChannels()
    {
        return $this->inputChannels;
    }

    /**
     * Set the outputChannels
     *
     * @param int $outputChannels
     *
     * @return ClutFactory
     */
    public function setOutputChannels($outputChannels)
    {
        $this->outputChannels = $outputChannels;

        return $this;
    }

    /**
     * Get the output Channels
     *
     * @return int
     */
    public function getOutputChannels()
    {
        return $this->outputChannels;
    }

    /**
     * Set the raw values
     *
     * @param array $values
     *
     * @return ClutFactory
     */
    public function setValue(array $value)
    {
        $this->values = $value;

        return $this;
    }

    /**
     * Get the raw value
     *
     * @return array
     */
    public function getValue()
    {
        return $this->values;
    }

    /**
     * set the number of CLUT-points
     *
     * @param int $clutPoints
     *
     * @return ClutFactory
     */
    public function setClutPoints($clutPoints)
    {
        $this->clutPoints = $clutPoints;

        return $this;
    }

    /**
     * Get the number of clut-points
     *
     * @return int
     */
    public function getClutPoints()
    {
        return $this->clutPoints;
    }

    /**
     * Get the values for a given combination of level, inputChannel, number of
     * CLUT-Points and outputChannel.
     *
     * array(
     *     0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18,
     *     19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35,
     *     36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47
     * );
     *
     * With a given inputChannel of 4, a given outputChannels of 3 and a
     * clutPoint value of 2 this shall result finally in the following structure
     *
     * 0 => array(
     *     0 => array(
     *         0 => array(
     *             0 => array(0,1,2),
     *             1 => array(3,4,5),
     *         ),
     *         1 => array(
     *             0 => array(6,7,8),
     *             1 => array(9,10,11),
     *         ),
     *     ),
     *     1 => array(
     *         0 => array(
     *             0 => array(12,13,14),
     *             1 => array(15,16,17),
     *         ),
     *         1 => array(
     *             0 => array(18,19,20),
     *             1 => array(21,22,23),
     *         ),
     *     ),
     * ),
     * 1 => array(
     *     0 => array(
     *         0 => array(
     *             0 => array(24,25,26),
     *             1 => array(27,28,29),
     *         ),
     *         1 => array(
     *             0 => array(30,31,32),
     *             1 => array(33,34,35),
     *         ),
     *     ),
     *     1 => array(
     *         0 => array(
     *             0 => array(36,37,38),
     *             1 => array(39,40,41),
     *         ),
     *         1 => array(
     *             0 => array(42,43,44),
     *             1 => array(45,46,47),
     *         ),
     *     ),
     * ),
     *
     * @param int $level
     * @param int $inputChannel
     * @param int $clutPoint
     *
     * @return array
     */
    public function parseEntry($values, $level)
    {
        if (0 == $level) {
            return $values;
        }
        $return = array();
        $length = pow($this->clutPoints, ($level - 1))*$this->getOutputChannels();
        for ($i = 0; $i < $this->clutPoints; $i++) {
            $return[] = $this->parseEntry(array_slice($values, $i*$length, $length), $level - 1);
        }

        return $return;
    }

    /**
     * Parse the entries for the given level.
     *
     * @param array $values
     * @param int $level
     *
     * @return ClutInterface
     */
    public function parseEntryAsObject($values, $level)
    {
        if (0 == $level) {
            return new ClutEntry($values);
        }
        $return = new Clut();
        $length = pow($this->clutPoints, ($level - 1))*$this->getOutputChannels();
        for ($i = 0; $i < $this->clutPoints; $i++) {
            $return->addEntry($this->parseEntryAsObject(array_slice($values, $i*$length, $length), $level - 1));
        }

        return $return;
    }

}