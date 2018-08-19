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

namespace Org_Heigl\Color\Renderer;

use Org_Heigl\Color\Color;
use Org_Heigl\Color\Converter\ConverterInterface;

class Renderer implements RendererInterface
{

    /**
     * Stores the converter for this Renderer
     *
     * @var ConverterInterface $converter
     */
    protected $converter = null;

    /**
     * Stores the render String
     *
     * @var string $renderString
     */
    protected $renderString = '';

    /**
     * The callback-function that is applied to every element of the converted
     * array
     *
     * This can be a function to round float values for instance
     *
     * @var callable null
     */
    protected $walker = null;

    /**
     * Create the instance of the renderer
     */
    public function __construct()
    {
        $this->setWalker(function ($a) {
            return $a;
        });
    }

    /**
     * Implements RendererInterface::render()
     *
     * @param Color $color
     *
     * @see RendererInterface::render()
     * @return string
     */
    public function render(Color $color)
    {
        $converter = $this->getConverter();
        $result = $converter->convertColor($color);
        $result = array_map($this->walker, $result);
        return vsprintf($this->getRenderString(), $result);
    }

    /**
     * Get the converters for this renderer
     *
     * @return ConverterInterface
     */
    public function getConverter()
    {
        return $this->converter;
    }

    /**
     * Set the converter for this renderer
     *
     * @param ConverterInterface $converter
     *
     * @return Renderer
     */
    public function setConverter(ConverterInterface $converter)
    {
        $this->converter = $converter;

        return $this;
    }

    /**
     * Get the renderer string
     *
     * @return string
     */
    public function getRenderString()
    {
        return $this->renderString;
    }

    /**
     * Set the string to render the values into
     *
     * This string is passed to the sprintf-function and gets the
     * result of the conversion as parameters
     *
     * @param string $renderString
     *
     * @return Renderer
     */
    public function setRenderString($renderString)
    {
        $this->renderString = $renderString;

        return $this;
    }

    /**
     * Set the walker-method
     *
     * @param callable $walker
     *
     * @return Renderer
     */
    public function setWalker($walker)
    {
        $this->walker = $walker;
        return $this;
    }
}
