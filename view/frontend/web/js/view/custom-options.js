define(['jquery', 'Magento_Catalog/js/price-box'], function ($) {
    'use strict';

    console.log("✅ SwatchOptions script loaded");

    /**
     * Helper: get price from selected <select> options
     */
    function getSelectedCustomOptionsPrice() {
        let total = 0;

        $('.custom-swatch-options select.option-select').each(function () {
            const selected = $(this).find('option:selected');
            const price = parseFloat(selected.data('price'));
            if (!isNaN(price)) {
                total += price;
            }
        });

        return total;
    }

    /**
     * Apply final calculated price (configurable + custom option total)
     */
    function applyFinalPrice() {
        const priceBox = $('[data-role="priceBox"]');
        const baseFinalPrice = priceBox.find('[data-price-type="finalPrice"]').data('price-amount');

        if (typeof baseFinalPrice === 'undefined') return;

        const total = baseFinalPrice + getSelectedCustomOptionsPrice();

        priceBox.priceBox('updatePrice', {
            'finalPrice': { amount: total },
            'basePrice': { amount: total }
        });
    }


    /**
     * Expose this globally for swatch button click: triggers selection
     */
    window.setCustomOption = function (optionId, valueId) {
        const $select = $(`select[name="options[${optionId}]"]`);
        const $group = $(`[data-option-id="${optionId}"]`);

        if ($select.length) {
            $select.val(valueId).trigger('change');
            $select.attr('aria-invalid', 'false');

            $group.find('.swatch-option').removeClass('selected');
            $group.find(`[data-value="${valueId}"]`).addClass('selected');

            applyFinalPrice();
        }
    };

    /**
     * Watch changes on configurable swatches + custom selects
     */
    $(document).on('change', '.super-attribute-select, .swatch-option', function () {
        setTimeout(applyFinalPrice, 200);
    });

    $(document).on('change', '.custom-swatch-options select.option-select', function () {
        applyFinalPrice();
    });

    /**
     * Reset custom options when configurable product changes
     */
    $(document).on('change', '.super-attribute-select', function () {
        $('.custom-swatch-options .swatch-option').removeClass('selected');
        $('.custom-swatch-options select.option-select').val('').trigger('change');
    });

    /**
     * Initial load – recalculate price
     */
    $(document).ready(function () {
        setTimeout(applyFinalPrice, 500);
    });
});
