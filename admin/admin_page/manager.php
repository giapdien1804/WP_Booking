<?php

/** @var AdminPageFramework $this */

$this->addSettingFields(
    [ // Single Export Button
        'field_id' => 'export_single',
        'type' => 'export',
        'description' => __('Download the saved option data.', 'admin-page-framework-loader'),
    ],
    [ // Single Import Button
        'field_id' => 'import_single',
        'title' => __('Single Import Field', 'admin-page-framework-loader'),
        'type' => 'import',
        'description' => __('Upload the saved option data.', 'admin-page-framework-loader'),
        'label' => __('Import Options', 'admin-page-framework-loader'),
    ]
);
