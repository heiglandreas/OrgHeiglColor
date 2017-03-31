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
use Org_Heigl\Color\Space\Lab;
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
    /** @var  \Org_Heigl\Color\Space\Lab */
    private $Lab;

    /** @var  \Org_Heigl\Color\Space\XYZ */
    private $XYZ;

    /**
     * The Whitepoint for conversion of PCSLab to PCSXYZ and back
     *
     * This conversion whitepoint is defined in Section 6.3.4.3 - Table 14 of
     * Specification ICC.1:2010 (Profile version 4.3.0.0)
     *
     * @var float[] PCSwhitepoint
     */
    private $PCSwhitepoint = array(
        'X' => 96.42,
        'Y' => 100.00,
        'Z' => 82.49,
        'L' => 100.00,
        'a' => 0.0000,
        'b' => 0.0000,
    );

    /**
     * Color constructor.
     *
     * @param Lab|XYZ $colorspace
     */
    public function __construct($colorspace)
    {
        if ($colorspace instanceof Lab) {
            $this->setLab($colorspace);
            return;
        }

        if ($colorspace instanceof XYZ) {
            $this->setXYZ($colorspace);
            return;
        }

        throw new \UnexpectedValueException('The provided value was neither Lab nor XYZ');
    }

    /**
     * @return \Org_Heigl\Color\Space\Lab
     */
    public function getLab()
    {
        return $this->Lab;
    }

    /**
     * @return \Org_Heigl\Color\Space\XYZ
     */
    public function getXYZ()
    {
        return $this->XYZ;
    }

    /**
     * Get the L-value
     *
     * @deprecated use Color::getLab instead
     * @return float
     */
    public function getL()
    {
        return $this->getLab()->getL();
    }

    /**
     * Get the a-value
     *
     * @deprecated use Color::getLab instead
     * @return float
     */
    public function geta()
    {
        return $this->getLab()->getA();
    }

    /**
     * Get the b-value
     *
     * @deprecated use Color::getLab instead
     * @return float
     */
    public function getb()
    {
        return $this->getLab()->getB();
    }

    /**
     * Get the X-Value
     *
     * @deprecated use Color::getXYZ instead
     * @return float
     */
    public function getX()
    {
        return $this->getXYZ()->getX();
    }

    /**
     * Get the Y-value
     *
     * @deprecated use Color::getXYZ instead
     * @return float
     */
    public function getY()
    {
        return $this->getXYZ()->getY();
    }

    /**
     * Get the Z-value
     *
     * @deprecated use Color::getXYZ instead
     * @return float
     */
    public function getZ()
    {
        return $this->getXYZ()->getZ();
    }


    /**
     * Set Lab-values
     *
     * @param Lab $lab
     *
     * @return Color
     */
    private function setLab(Lab $lab)
    {
        $this->Lab = $lab;
        $this->setXYZfromLab();

        return $this;
    }

    /**
     * Set XYZ-values from existing Lab-Values
     *
     * @return Color
     */
    private function setXYZfromLab()
    {
        $var_Y = ($this->Lab->getL() + 16) / 116;
        $var_X = $this->Lab->getA() / 500 + $var_Y;
        $var_Z = $var_Y - $this->Lab->getB() / 200;

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

        $this->XYZ = new XYZ(
            $this->PCSwhitepoint['X'] * $var_X,
            $this->PCSwhitepoint['Y'] * $var_Y,
            $this->PCSwhitepoint['Z'] * $var_Z
        );

        return $this;
    }

    /**
     * Set the Lab Values from existing XYZ-Values
     *
     * @return void
     */
    private function setLabFromXYZ()
    {
        $var_X = $this->XYZ->getX() / $this->PCSwhitepoint['X'];
        $var_Y = $this->XYZ->getY() / $this->PCSwhitepoint['Y'];
        $var_Z = $this->XYZ->getZ() / $this->PCSwhitepoint['Z'];

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

        $this->Lab = new Lab(
            (116 * $var_Y) - 16,
            500 * ($var_X - $var_Y),
            200 * ($var_Y - $var_Z)
        );

        }

    /**
     * Set the XYZ
     *
     * @param XYZ $xyz
     *
     * @return void
     */
    private function setXYZ(XYZ $xyz)
    {
        $this->XYZ = $xyz;
        $this->setLabFromXYZ();
    }
}
