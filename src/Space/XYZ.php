<?php
/**
 * Copyright (c)2015-2015 heiglandreas
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
 * @copyright ©2015-2015 Andreas Heigl
 * @license   http://www.opesource.org/licenses/mit-license.php MIT-License
 * @version   0.0
 * @since     11.02.15
 * @link      https://github.com/heiglandreas/
 */

namespace Org_Heigl\Color\Space;

class XYZ
{
	protected $X = null;

	protected $Y = null;

	protected $Z = null;

    /**
     * XYZ constructor.
     *
     * @param $X Within Range 0 to 96.42
     * @param $Y Within range 0 to 100.00
     * @param $Z Within range 0 to 82.52
     */
	public function __construct($X, $Y, $Z)
	{
        $this->X = $X;
		$this->Y = $Y;
		$this->Z = $Z;
	}

	public function getX()
	{
		return $this->X;
	}

	public function getY()
	{
		return $this->Y;
	}

	public function getZ()
	{
		return $this->Z;
	}
}
