# Color - Handling for PHP

This library helps handling colors in PHP

## Installation

Simply install it using composer. Add the requirement ``org_heigl/color`` to your projects composer.json file and run ``composer install``. That should do the trick.

## Requirements

This library simply requires at least PHP5.3.

## Usage

You can use it as described in this short example. For more examples have a look at the documentation.

    // This uses a gras-green and changes it to a lighter variation 
    // for usage as background-color
    use Org\Heigl\Color as C;
    $color   = C\ColorFactory::createFromRgb(123,234,12);
    $handler = C\Handler\HandlerFactory::getHslHandler($color);
    $handler->setSaturation(0.2);
    echo C\Renderer\RendererFactory::getRgbHexRenderer()->render($handler->getColor());
    // Prints #d3ebbc

alternate Example using a CMYK-Color as input and merging it with an RGB-Color
to get a new color as HSL-Value

    // This uses a dark green as input color and merges it with a light red
    use Org\Heigl\Color as C
    $green = C\ColorFactory::createFromCmyk(100, 0, 100, 0);
    $red   = C\ColorFactory::createFromRgb(255, 128, 128);
    $handler = C\Handler\HandlerFactory::getMergeHandler($green);
    $handler->merge($red);
    echo C\Renderer\RendererFactory::getHslRenderer()->render($handler->getColor());
    // Prints hsl(h.hh,s.ss,l.ll);

## License

This library is licensed unser the MIT-License
