<?php

namespace Internetcode\LaravelUserSettings\Traits;

trait HasSettingsTrait {


    public function getSettingFields()
    {
        return config('user-settings.setting_fields');
    }

    /**
     * Returns the default settings column used for this model.
     * This can be overwritten in the user model.
     *
     * @return string
     */
    public function getSettingsColumn()
    {
        return config('user-settings.settings_column');
    }
}