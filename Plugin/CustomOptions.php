<?php

namespace CodeAesthetix\SwatchOptions\Plugin;

use Magento\Catalog\Block\Product\View\Options;

class CustomOptions
{
    /**
     * Modify custom options block to support swatches
     */
    public function afterGetOptions(Options $subject, $result)
    {
        foreach ($result as $option) {
            if ($option->getType() === 'drop_down') {
                foreach ($option->getValues() as $value) {
                    // Fetch swatch data
                    $swatchType = $value->getSwatchType(); // Should return 'color' or 'image'
                    $swatchValue = $value->getSwatchValue(); // Hex color or Image URL

                    // Attach swatch data to option
                    if ($swatchType) {
                        $value->setData('swatch_type', $swatchType);
                        $value->setData('swatch_value', $swatchValue);
                    }
                }
            }
        }
        return $result;
    }
}
