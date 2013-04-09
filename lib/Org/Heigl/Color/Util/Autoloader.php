<?php
/**
 * Copyright (c) 2008-2011 Andreas Heigl<andreas@heigl.org>
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
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @category   Geolocation
 * @package    Org\Heigl\Geo
 * @subpackage Utilities
 * @author     Andreas Heigl <andreas@heigl.org>
 * @copyright  2008-2011 Andreas Heigl<andreas@heigl.org>
 * @license    http://www.opensource.org/licenses/mit-license.php MIT-License
 * @version    0.0
 * @link       http://github.com/heiglandreas/geo
 * @since      24.02.2012
 */

namespace Org\Heigl\Color\Util;

/**
 * This Runs the autoloader
 *
 * @subpackage Utilities
 * @author     Andreas Heigl <a.heigl@wdv.de>
 * @copyright  2008-2011 Andreas Heigl
 * @license    http://www.opensource.org/licenses/mit-license.php MIT-License
 * @version    0.0
 * @link       http://github.com/heiglandreas/geo
 * @since      24.02.2012
 */
class Autoloader
{
    /**
     * Store the packages path.
     *
     * @var string $packagePath
     */
    protected $packagePath = null;

    /**
     * autoload classes.
     *
     * @param string $className the name of the class to load
     *
     * @return void
     */
    public function __autoload($className)
    {
        if ( 0 !== strpos($className, 'Org\\Heigl\\Color') ) {
            return false;
        }
        $className = substr($className, strlen('Org\\Heigl\\Color\\'));
        $file = str_replace('\\', '/', $className) . '.php';
        $fileName = realpath($this->packagePath . DIRECTORY_SEPARATOR . $file);
        if ( ! file_exists($fileName) ) {
            return false;
        }
        if ( ! @include_once $fileName ) {
            return false;
        }
        return true;
    }

    /**
     * Register this packages autoloader with the autoload-stack
     *
     * @return void
     */
    public function __construct()
    {

        $this->packagePath = dirname(__DIR__);
        return spl_autoload_register(array($this, '__autoload'));
    }
}