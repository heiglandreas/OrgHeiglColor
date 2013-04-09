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

namespace Org\Heigl\Color\Handler;

use \Org\Heigl\Color\Color;
use \Org\Heigl\Color\Converter as C;
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
     * Set a given Hue as new Hue for the color
     *
     * @param int|float $hue The hue-value to set either as int between 0 and 360
     * or as float between 0 and 1
     *
     * @return HueHandler
     */
    public function setHue($hue)
    {
        $hsl = $this->getHsl();
        $hsl[0] = $hue;
        $this->setHsl($hsl);

        return $this;
    }

    /**
     * Add a value to the given hue
     *
     * @param float|int $adapt
     *
     * @return HueHandler
     */
    public function addHue($hue)
    {
        $hsl = $this->getHsl();
        $hsl[0] = $hsl[0] + $hue;
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
        if (null === $this->hsl) {
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
        $converter = new C\ConverterChain();
        $converter->addConverter(new C\HSL2RGB())
                  ->addConverter(new C\RGB2XYZ());

        $XYZ = $converter->convert($this->hsl);

        $this->color->setXYZ($XYZ[0], $XYZ[1], $XYZ[2]);
        return parent::getColor();
    }
}