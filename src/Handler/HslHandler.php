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
 * @since     05.04.13
 * @link      https://github.com/heiglandreas/
 */

namespace Org_Heigl\Color\Handler;

use \Org_Heigl\Color\Color;
use \Org_Heigl\Color\Converter as C;
use Org_Heigl\Color\Space\XYZ;

/**
 * Class HslHandler
 *
 * Change a color acording to the HSL-Values
 */
class HslHandler extends AbstractHandler
{

    /**
     * This objects HSL-Vlaues
     *
     * @param float[] $hsl
     */
    protected $hsl = array();

    /**
     * Add a value to the given hue
     *
     * @param float|int $adapt
     *
     * @return HslHandler
     */
    public function addHue($hue)
    {
        if (is_int($hue)) {
            if (360 < $hue) {
                $hue = $hue % 360;
            }
            $hue = $hue / 360;
        }

        $hsl = $this->getHsl();
        $hsl[0] = $hsl[0] + $hue;

        if (1 < $hsl[0]) {
            $hsl[0] = $hsl[0] - (int) $hsl[0];
        }

        $this->setHsl($hsl);

        return $this;
    }

    /**
     * Get the current colors HSl-values
     *
     * @return array
     */
    protected function getHsl()
    {
        if (! $this->hsl) {
            $converter = new C\ConverterChain();
            $converter->addConverter(new C\XYZ2RGB())
                      ->addConverter(new C\RGB2HSL());

            $color = $this->getColor();

            $array = array(
                $color->getX(),
                $color->getY(),
                $color->getZ(),
            );
            $this->hsl = $converter->convert($array);
        }

        return $this->hsl;

    }

    /**
     * Set the HSL-values
     *
     * @param array
     *
     * @return HslHandler
     */
    protected function setHsl(array $hsl)
    {
        $this->hsl = $hsl;

        return $this;
    }

    /**
     * Get the color-object
     *
     * @return Color
     */
    public function getColor()
    {
        if ($this->hsl) {
            $converter = new C\ConverterChain();
            $converter->addConverter(new C\HSL2RGB())
                      ->addConverter(new C\RGB2XYZ());

            $XYZ = $converter->convert($this->getHsl());

            $this->color->setXYZ(new XYZ($XYZ[0], $XYZ[1], $XYZ[2]));
        }
        return parent::getColor();
    }

    /**
     * Set a new Saturation value
     *
     * @param float $saturation
     *
     * @return HslHandler
     */
    public function setSaturation($saturation)
    {
        if (0 > $saturation || 1 < $saturation) {
            return $this;
        }

        $hsl = $this->getHsl();
        $hsl[1] = $saturation;

        $this->setHsl($hsl);

        return $this;
    }

    /**
     * Add the given saturation to the existing one
     *
     * This will add a positive value to the saturation, a newgative value will
     * be subtracted. When 0 or 1 is reached the value will be trunkated at
     * these boundaries.
     *
     * @param float $saturation
     *
     * @return HslHandler
     */
    public function addSaturation($saturation)
    {
        $hsl = $this->getHsl();

        $hsl[1] = $hsl[1] + $saturation;

        if (0 > $hsl[1]) {
            $hsl[1] = 0;
        }
        if (1 < $hsl[1]) {
            $hsl[1] = 1;
        }

        $this->setHsl($hsl);

        return $this;
    }

    /**
     * Sets the luminance to the given one
     *
     * @param float $luminance
     *
     * @return HslHandler
     */
    public function setLuminance($luminance)
    {
        $hsl = $this->getHsl();

        $hsl[2] = $luminance;

        $this->setHsl($hsl);

        return $this;
    }

    /**
     * Adds the given luminance to the existing one
     *
     * @param float $luminance
     *
     * @return HslHandler
     */
    public function addLuminance($luminance)
    {
        $hsl = $this->getHsl();

        $hsl[2] = $hsl[2] + $luminance;

        if (0 > $hsl[2]) {
            $hsl[2] = 0;
        }
        if (1 < $hsl[2]) {
            $hsl[2] = 1;
        }

        $this->setHsl($hsl);

        return $this;
    }

    /**
     * Set the given Hue
     *
     * The hue must be given as float or integer.
     *
     * When a float is given it must be between 0.0 and 1.0 where 0.0 (and 1.0)
     * are red, 0.33 represents green and 0.66 represents blue.
     *
     * When given as integer it has to be between 0 and 360 where 0 (and 360)
     * are red, 120 represents green and 240 represents blue
     *
     * When the hue is greater that 1 or 360 respectively only the decimal part
     * or the modulo of 360 is used.
     *
     * @param float|int $hue
     *
     * @return HslHandler
     */
    public function setHue($hue)
    {
        if (is_int($hue)) {
            if (360 < $hue) {
                $hue = $hue % 360;
            }
            $hue = $hue / 360;
        }

        $hsl = $this->getHsl();

        $hsl[0] = $hue;

        $this->setHsl($hsl);

        return $this;
    }
}