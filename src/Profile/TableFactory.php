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
 * @since     02.04.13
 * @link      https://github.com/heiglandreas/
 */

namespace Org_Heigl\Color\Profile;


class TableFactory
{

    /**
     * Mapping of Table-Identifiers to Classnames
     *
     * @var array $tagMapper
     */
    protected static $tagMapper = array(
        'wtpt' => 'Whitepoint',
        'rXYZ' => 'Redpoint',
        'gXYZ' => 'Greenpoint',
        'bXYZ' => 'Bluepoint',
        'cprt' => 'Copyright',
        'rTRC' => 'RedCurve',
        'gTRC' => 'GreenCurve',
        'bTRC' => 'BlueCurve',
        'desc' => 'Description',
        'targ' => 'NullTable',
        'tech' => 'NullTable',
        'vued' => 'NullTable',
        'view' => 'NullTable',
        'a2b0' => 'NullTable',
        'a2b2' => 'NullTable',
        'a2b1' => 'NullTable',
        'b2a0' => 'NullTable',
        'b1a0' => 'NullTable',
        'b0a0' => 'NullTable',
        'b2a1' => 'NullTable',
        'b2a2' => 'NullTable',
        'gamt' => 'NullTable',
        'coat' => 'NullTable',
    );

    /**
     * Get an instance of a table
     *
     * @return Table\TableInterface
     */
    public static function getInstance($tagName, $content)
    {
        if (! isset(static::$tagMapper[strtolower($tagName)])) {
            return new \Org_Heigl\Color\Profile\Table\NullTable();
        }

        $class = static::$tagMapper[strtolower($tagName)];
        $class = '\\Org_Heigl\\Color\\Profile\\Table\\' . $class;
        $obj = new $class;
        $obj->setContent($content);
        return $obj;
    }

    /**
     * Get a one-dimensional table with the given content
     *
     * @param array $content
     *
     * @return Table\OneDimensionalTable
     */
    public static function getOneDimensionalTable($content)
    {
        $table = new Table\OneDimensionalTable();
        $table->addEntries($content);
        return $table;
    }
}