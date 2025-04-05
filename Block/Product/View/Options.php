<?php

namespace CodeAesthetix\SwatchOptions\Block\Product\View;

use Magento\Catalog\Block\Product\View\Options as MagentoOptions;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Pricing\Helper\Data as PricingHelper;
use Magento\Directory\Model\Currency;
use Magento\Catalog\Helper\Data as CatalogHelper;
use Magento\Framework\Json\EncoderInterface;
use Magento\Catalog\Model\Product\Option;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\ArrayUtils;

/**
 * Custom Swatch Options Block
 */
class Options extends MagentoOptions
{
    /** @var PricingHelper */
    protected $pricingHelper;

    /** @var Currency */
    protected $currencyModel;

    /** @var EncoderInterface */
    protected $jsonEncoder;

    /**
     * Options constructor.
     *
     * @param Context $context
     * @param PricingHelper $pricingHelper
     * @param CatalogHelper $catalogHelper
     * @param EncoderInterface $jsonEncoder
     * @param Option $productOption
     * @param Registry $registry
     * @param ArrayUtils $arrayUtils
     * @param array $data
     */
    public function __construct(
        Context $context,
        PricingHelper $pricingHelper,
        CatalogHelper $catalogHelper,
        EncoderInterface $jsonEncoder,
        Option $productOption,
        Registry $registry,
        ArrayUtils $arrayUtils,
        array $data = []
    ) {
        parent::__construct($context, $pricingHelper, $catalogHelper, $jsonEncoder, $productOption, $registry, $arrayUtils, $data);

        $this->pricingHelper = $pricingHelper;
        $this->currencyModel = $context->getLocaleCurrency();
        $this->jsonEncoder = $jsonEncoder;
    }

    /**
     * Convert base currency price to store currency.
     *
     * @param float $price
     * @return float
     */
    public function convertPriceToStoreCurrency(float $price): float
    {
        return $this->currencyModel->convert($price);
    }

    /**
     * Format price based on current store currency.
     *
     * @param float $price
     * @return string
     */
    public function getFormattedPrice(float $price): string
    {
        $convertedPrice = $this->convertPriceToStoreCurrency($price);
        return $this->pricingHelper->currency($convertedPrice, true, false);
    }
}
