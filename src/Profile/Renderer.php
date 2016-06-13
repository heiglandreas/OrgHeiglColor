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
 * @since     28.03.13
 * @link      https://github.com/heiglandreas/
 */

namespace Org_Heigl\Color\Profile;

use Org_Heigl\Color\Exception\FileNotFoundException;

class Renderer
{

    /**
     * Render the given ICC-Profile-file
     *
     * @param string $file
     * @param Profile $profile
     *
     * @throws FileNotFoundException
     * @return Profile
     */
    public static function renderProfile($filepath, Profile $profile)
    {
        if (! file_exists($filepath)) {
            throw new FileNotFoundException(sprintf(
                'The file %1$s could not be found',
                $filepath
            ));
        }
        $fh = fopen($filepath, 'r');

        $profile->setHeader('size', fread($fh, 4))
                ->setHeader('cmm', fread($fh, 4))
                ->setHeader('version', fread($fh, 4))
                ->setHeader('class', fread($fh, 4))
                ->setHeader('space', fread($fh, 4))
                ->setHeader('pcs', fread($fh, 4))
                ->setHeader('datetime', fread($fh, 12))
                ->setHeader('sig', fread($fh, 4))
                ->setHeader('platform', fread($fh, 4))
                ->setHeader('flags', fread($fh, 4))
                ->setHeader('manufacturer', fread($fh, 4))
                ->setHeader('model', fread($fh, 4))
                ->setHeader('attribs', fread($fh, 8))
                ->setHeader('intent', fread($fh, 4))
                ->setHeader('XYZ', fread($fh, 12))
                ->setHeader('creator', fread($fh, 4))
                ->setHeader('id', fread($fh, 16))
            ;
        fseek($fh, 128);

        $tagCount = unpack('Nint', fread($fh, 4));
        for ($i = 0; $i<$tagCount['int']; $i++) {
            fseek($fh, 128+4+$i*12);
            $tagname = fread($fh, 4);
            $offset = unpack('Nint', fread($fh, 4));
            $size = unpack('Nint', fread($fh, 4));
            fseek($fh, $offset['int']);
            $tag = TableFactory::getInstance($tagname, fread($fh, $size['int']));
            $profile->addTable($tagname, $tag);
        }

        return $profile;
    }
}