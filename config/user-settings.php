<?php

return [
    /**
     * Default settings column used in the database.
     * Can be customized per entity by overriding the getSettingsColumn() method.
     */
    'settings_column'       => 'settings',

    /**
     * List of the default settings.
     * Can be customized per entity by overriding the getSettingFields() method.
     * @NOTE: Never ever, ever change the order of the fields below. The order is important.
     */
    'setting_fields'        => [],
];