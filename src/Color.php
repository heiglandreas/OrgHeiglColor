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
 * @category  Color
 * @author    Andreas Heigl<andreas@heigl.org>
 * @copyright © 2013-2013 Andreas Heigl
 * @license   http://www.opesource.org/licenses/mit-license.php MIT-License
 * @version   0.0
 * @since     21.03.13
 * @link      https://github.com/heiglandreas/
 */

namespace Org_Heigl\Color;

use Org_Heigl\Color\Converter as C;
use Org_Heigl\Color\Space\XYZ;

/**
 * Class Color
 *
 * This class represents a PCS-Color which can be defined either as XYZ or L*a*b*
 * Color.
 *
 * @package   Org\Heigl\Color
 * @author    Andreas Heigl<andreas@heigl.org>
 * @copyright © 2013-2013 Andreas Heigl
 * @license   http://www.opesource.org/licenses/mit-license.php MIT-License
 * @version   0.0
 * @since     21.03.13
 * @link      https://github.com/heiglandreas/
 */
class Color
{
    const Lab = 'Lab';
    const XYZ = 'XYZ';

    /**
     * The L-value of the color
     *
     * @var float $L
     */
    protected $L = null;

    /**
     * The a-value of the color
     *
     * @var float $a
     */
    protected $a = null;

    /**
     * The b-value of the color
     *
     * @var float $b
     */
    protected $b = null;

    /**
     * The X-Value of a color
     *
     * @var float $X
     */
    protected $X = null;

    /**
     * The Y-Value of a color
     *
     * @var float $Y
     */
    protected $Y = null;

    /**
     * The Z-Value of a color
     *
     * @var float $Z
     */
    protected $Z = null;

    /**
     * The Whitepoint for conversion of PCSLab to PCSXYZ and back
     *
     * This conversion whitepoint is defined in Section 6.3.4.3 - Table 14 of
     * Specification ICC.1:2010 (Profile version 4.3.0.0)
     *
     * @var float[] PCSwhitepoint
     */
    protected $PCSwhitepoint = array(
        'X' => 0.9642,
        'Y' => 1.0000,
        'Z' => 0.8249,
        'L' => 1.0000,
        'a' => 0.0000,
        'b' => 0.0000,
    );

    /**
     * Set Lab-values
     *
     * @param float $L The L-Value of the color
     * @param float $a The a-value of the color
     * @param float $b The b-value of the color
     *
     * @return Color
     */
    public function setLab($L, $a, $b)
    {
        $this->L = $L;
        $this->a = $a;
        $this->b = $b;

        $this->setXYZfromLab();

        return $this;
    }

    /**
     * Set XYZ-values from existing Lab-Values
     *
     * @return Color
     */
    protected function setXYZfromLab()
    {
        $var_Y = ($this->L + 16) / 116;
        $var_X = $this->a / 500 + $var_Y;
        $var_Z = $var_Y - $this->b / 200;

        if (pow($var_Y, 3) > 0.008856) {
            $var_Y = pow($var_Y, 3);
        } else {
            $var_Y = ($var_Y - 16 / 116 ) / 7.787;
        }
        if (pow($var_X, 3) > 0.008856 ) {
            $var_X = pow($var_X, 3);
        } else {
            $var_X = ($var_X - 16 / 116 ) / 7.787;
        }
        if (pow($var_Z, 3) > 0.008856) {
            $var_Z = pow($var_Z, 3);
        } else {
            $var_Z = ($var_Z - 16 / 116 ) / 7.787;
        }

        $this->X = $this->PCSwhitepoint['X'] /* 100*/ * $var_X;
        $this->Y = $this->PCSwhitepoint['Y'] /* 100*/ * $var_Y;
        $this->Z = $this->PCSwhitepoint['Z'] /* 100*/ * $var_Z;

        return $this;
    }

    /**
     * Set the Lab Values from existing XYZ-Values
     *
     * @return Color
     */
    protected function setLabFromXYZ()
    {
        $var_X = $this->X / $this->PCSwhitepoint['X'];
        $var_Y = $this->Y / $this->PCSwhitepoint['Y'];
        $var_Z = $this->Z / $this->PCSwhitepoint['Z'];

        if ($var_X > 0.008856) {
            $var_X = pow($var_X, (1/3));
        } else {
            $var_X = (7.787 * $var_X) + (16 / 116);
        }
        if ($var_Y > 0.008856) {
            $var_Y = pow($var_Y, (1/3));
        } else {
            $var_Y = (7.787 * $var_Y) + (16 / 116);
        }
        if ($var_Z > 0.008856) {
            $var_Z = pow($var_Z, (1/3));
        } else {
            $var_Z = (7.787 * $var_Z) + (16 / 116);
        }

        $this->L = (116 * $var_Y) - 16;
        $this->a = 500 * ($var_X - $var_Y);
        $this->b = 200 * ($var_Y - $var_Z);
    }

    /**
     * Get the L-value
     *
     * @return float
     */
    public function getL()
    {
        return $this->L;
    }

    /**
     * Get the a-value
     *
     * @return float
     */
    public function geta()
    {
        return $this->a;
    }

    /**
     * Get the b-value
     *
     * @return float
     */
    public function getb()
    {
        return $this->b;
    }


    /**
     * Set the XYZ
     *
     * @param XYZ $xyz
     * @param float $Y
     * @param float $Z
     *
     * @return Color
     */
    public function setXYZ(XYZ $xyz)
    {
        $this->XYZ = $xyz;

        $this->setLabFromXYZ();

        return $this;
    }

    /**
     * Get the X-Value
     *
     * @return float
     */
    public function getX()
    {
        return $this->X;
    }

    /**
     * Get the Y-value
     *
     * @return float
     */
    public function getY()
    {
        return $this->Y;
    }

    /**
     * Get the Z-value
     *
     * @return float
     */
    public function getZ()
    {
        return $this->Z;
    }

}