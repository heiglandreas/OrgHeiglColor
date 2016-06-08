# Color - Handling for PHP

This library helps handling colors and ICC-Profiles in PHP

[![Build Status](https://travis-ci.org/heiglandreas/OrgHeiglColor.png?branch=master)](https://travis-ci.org/heiglandreas/OrgHeiglColor)

## Installation

Installation is best done using composer like this:

    composer require org_heigl/color

## Requirements

This library requires at least PHP 5.5 and is tested up to PHP 7.0

## Usage

Reading different informations from an ICC-Profile.

    ```php
    use Org_Heigl\Color\Profile as P;

    $profile = P\Renderer::renderProfile('/path/tp/profile', new P\Profile());
    echo $profile->getTable('desc')->getContent() // Outputs the Name of the profile
    ```

You can use it as described in this short example. For more examples have a look at the documentation.

    ```php
    // This uses a gras-green and changes it to a lighter variation 
    // for usage as background-color
    use Org_Heigl\Color as C;
    $color   = C\ColorFactory::createFromRgb(123,234,12);
    $handler = C\Handler\HandlerFactory::getHslHandler($color);
    $handler->setLuminance(0.8);
    echo C\Renderer\RendererFactory::getRgbHexRenderer()->render($handler->getColor());
    // Prints #ccfa9e
    ```

alternate Example using a CMYK-Color as input and merging it with an RGB-Color
to get a new color as HSL-Value

    ```php
    // This uses a dark green as input color and merges it with a light red
    use Org_Heigl\Color as C
    $green = C\ColorFactory::createFromCmyk(100, 0, 100, 0);
    $red   = C\ColorFactory::createFromRgb(255, 128, 128);
    $handler = C\Handler\HandlerFactory::getMergeHandler($green);
    $handler->merge($red);
    echo C\Renderer\RendererFactory::getHslRenderer()->render($handler->getColor());
    // Prints hsl(h.hh,s.ss,l.ll);
    ```

## License

This library is licensed unser the MIT-License
