<?php
namespace CodeAesthetix\SwatchOptions\Plugin;

class CustomOptionColorField
{
    public function afterModifyMeta(
        \Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\CustomOptions $subject,
        array $meta
    ) {
        if (!isset($meta['custom_options']['children']['options']['children']['record']['children']['values']['children']['record']['children'])) {
            return $meta;
        }

        $fields = &$meta['custom_options']['children']['options']['children']['record']['children']['values']['children']['record']['children'];

        $fields['color'] = [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => __('Color'),
                        'componentType' => 'field',
                        'formElement' => 'input',
                        'dataType' => 'text',
                        'dataScope' => 'color',
                        'sortOrder' => 55,
                        'validation' => [
                            'required-entry' => false
                        ]
                    ]
                ]
            ]
        ];

        return $meta;
    }

    public function afterModifyData(
        \Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\CustomOptions $subject,
        array $data
    ) {
        // If you need to load 'color' value from DB to the UI form, do it here.
        return $data;
    }
}
