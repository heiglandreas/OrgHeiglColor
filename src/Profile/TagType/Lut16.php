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

use Org_Heigl\Color\Color;
use Org_Heigl\Color\ColorFactory;
use Org_Heigl\Color\Parser\S15Fixed16Number;
use Org_Heigl\Color\Profile\Table\ClutFactory;
use Org_Heigl\Color\Profile\TableFactory;

class Lut16 implements \Countable, TagTypeInterface
{
    protected $curve = array();

    protected $matrix = array();

    protected $inputChannels = 0;

    protected $outputChannels = 0;

    protected $numberOfCLUTPoints = 0;

    /**
     * @var OneDimensionalTable[] $inputTables
     */
    protected $inputTables = array();

    protected $clut = array();

    protected $outputTables = array();

    public function __construct($data)
    {
        $this->render($data);
    }

    public function render($data)
    {
        $curve = unpack('NID/NNull/cInputChannels/cOutputChannels/cClutPoints/cOtherNull/V9e/n*', $data);
        $this->inputChannels      = $curve['InputChannels'];
        $this->outputChannels     = $curve['OutputChannels'];
        $this->numberOfCLUTPoints = $curve['ClutPoints'];

        $this->matrix = array(
            array(
                S15Fixed16Number::toFloat($curve['e1']),
                S15Fixed16Number::toFloat($curve['e2']),
                S15Fixed16Number::toFloat($curve['e3']),
            ),
            array(
                S15Fixed16Number::toFloat($curve['e4']),
                S15Fixed16Number::toFloat($curve['e5']),
                S15Fixed16Number::toFloat($curve['e6']),
            ),
            array(
                S15Fixed16Number::toFloat($curve['e7']),
                S15Fixed16Number::toFloat($curve['e8']),
                S15Fixed16Number::toFloat($curve['e9']),
            ),
        );

        $inputTableCount = $curve[1];//S15Fixed16Number::toFloat(substr($data, 48, 4));
        $outputTableCount = $curve[2];

        $inputTableSize = $inputTableCount * $this->inputChannels;
        $clutTableSize  = pow($this->numberOfCLUTPoints, $this->inputChannels) * $this->outputChannels;
        $outputTableSize = $outputTableCount * $this->outputChannels;
        $inputTable = array_slice($curve, 17, $inputTableSize);
        $clutTable  = array_slice($curve, (17 + $inputTableSize), $clutTableSize);
        $outputTable = array_slice($curve, (17 + $inputTableSize + $clutTableSize), $outputTableSize);

        for ($i = 0; $i < $this->inputChannels; $i++) {
            $this->inputTables[$i] = TableFactory::getOneDimensionalTable(
                array_slice($inputTable, $i * $inputTableCount, $inputTableCount)
            );
        }

        $this->clut = ClutFactory::getEntry($clutTable, $this->inputChannels, $this->numberOfCLUTPoints, $this->outputChannels);

        for ($i = 0; $i < $this->outputChannels; $i++) {
            $this->outputTables[$i] = TableFactory::getOneDimensionalTable(
                array_slice($outputTable, $i * $outputTableCount, $outputTableCount)
            );
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

    /**
     * Parse the given color-values of the array and convert them to a Color-
     * object in ProfileColorSpace
     *
     * @param array $color
     *
     * @return \Org\Heigl\Color\Color
     */
    public function getPCSColor(array $color)
    {

        // Pass through 3x3-matrix
        // Pass through InputTables
        $color = $this->getValuesFromInputTable($color);
        // Pass through CLUT
        $color = $this->getValuesFromCLUT($color);
        // Pass through OutputTables
        $color = $this->getValuesFromOutputTable($color);

        $oColor = new Color();
        $oColor->setXYZ($color[0], $color[1], $color[2]);

        return $oColor;
    }

    /**
     * Get the value from the input table
     *
     * @param array $values
     *
     * @return float
     */
    public function getValuesFromInputTable($values)
    {
        $table  = 0;
        $return = array();
        foreach ($values as $value) {
            $return[$table] = $this->inputTable[$table]->getValue($value);
            $table ++;
        }

        return $return;
    }

    public function getValuesFromOutputTable($values)
    {
        $table = 0;
        $return = array();
        foreach ($values as $value) {
            $return[$table] = $this->outputTables[$table]->getValue($value);
            $table ++;
        }

        return $return;
    }

    public function getValuesFromCLUT($values)
    {

    }


}