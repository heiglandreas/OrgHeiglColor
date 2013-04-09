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
 * @since     25.03.13
 * @link      https://github.com/heiglandreas/
 */

namespace Org\Heigl\Color\Profile;

use Org\Heigl\Color\Exception\UnexpectedKeyException;
use Org\Heigl\Color\Profile\Table\TableInterface;


class Profile
{
    /**
     * The header of the profile
     *
     * This is a hashtable
     *
     * @param array $header
     */
    protected $header = array(
        'size'     => null,
        'cmm'      => null,
        'version'  => null,
        'class'    => null,
        'space'    => null,
        'pcs'      => null,
        'datetime' => null,
        'sig'      => null,
        'platform' => null,
        'flags'    => null,
        'manufacturer' => null,
        'model'    => null,
        'attribs'  => null,
        'intent'   => null,
        'XYZ'      => null,
        'creator'  => null,
        'id'       => null,
    );

    /**
     * The table of contained profile-informations
     *
     * @param TableInterface[] $table
     */
    protected $table = array();

    /**
     * Add a table to the profile
     *
     * @param string $key
     * @param TableInterface  $table
     *
     * @return Profile
     */
    public function addTable($key, TableInterface $table)
    {
        if (! $this->hasTable($key)) {
            $this->table[$key] = $table;
        }

        return $this;
    }

    /**
     * Check whether a given Table already exists
     *
     * @param string $key
     *
     * @return boolean
     */
    public function hasTable($key)
    {
        return isset($this->table[$key]);
    }

    /**
     * Get a certain table
     *
     * @param string $key
     *
     * @return TableInterface
     */
    public function getTable($key)
    {
        if (! $this->hasTable($key)) {
            throw new UnexpectedKeyException(sprintf(
                'The key %1$s does not exist for this profile',
                $key
            ));
        }

        return $this->table[$key];
    }

    /**
     * Set a certain header value
     *
     * @param string $key
     * @param strnig $value
     *
     * @return Profile
     */
    public function setHeader($key, $value)
    {
        if (array_key_exists($key, $this->header)) {
            $this->header[$key] = $value;
        }
        return $this;
    }
}