<?php

namespace Internetcode\LaravelUserSettings\Traits;

use Internetcode\LaravelUserSettings\Exceptions\InvalidUserSettingsFieldUsed;
use Internetcode\LaravelUserSettings\Helpers\BitwiseConverter;

trait HasSettingsTrait {

    /**
     * setting function.
     * Get or set a setting, based on the value.
     *
     * @param      $key
     * @param null $value
     *
     * @return boolean
     * @throws InvalidUserSettingsFieldUsed
     */
    public function setting($key, $value = null)
    {
        $this->validateKey($key);

        // If the value is not null, it means we are trying to set it. So update the value.
        // Otherwise return the setting.
        if($value === null) {
            return $this->getSetting($key);
        } else {
            return $this->setSetting($key, $value);
        }
    }

    /**
     * setSetting function.
     * Update the setting in the table.
     *
     * @param $key
     * @param $value
     *
     * @return bool
     * @throws InvalidUserSettingsFieldUsed
     */
    public function setSetting($key, $value)
    {
        $this->validateKey($key);

        $currentSettings = $this->getAttribute($this->getSettingsColumn());
        $bitwiseList     = $this->getBitwiseList();

        // First check if the bit is set in the current column.
        if($this->getSetting($key) && !$value) {
            $currentSettings = $currentSettings ^ $bitwiseList[$key];
        } else if(!$this->getSetting($key)&& $value ) {
            $currentSettings = $currentSettings | $bitwiseList[$key];
        }

        $this->setAttribute($this->getSettingsColumn(), $currentSettings);
        return $this->getSetting($key);
    }

    /**
     * getSetting function.
     * Returns a bool if the setting is true.
     *
     * @param $key
     *
     * @return bool
     * @throws InvalidUserSettingsFieldUsed
     */
    public function getSetting($key)
    {
        $this->validateKey($key);
        $currentSetting = (integer)$this->getAttribute($this->getSettingsColumn());
        $bitwiseList    = $this->getBitwiseList();

        return ($currentSetting & $bitwiseList[$key]) > 1 ? true : false;
    }

    /**
     * getSettingFields function.
     * Get the default possible settings for the user. Can be overwritten
     * in the user model.
     *
     * @return array
     */
    public function getSettingFields()
    {
        return config('user-settings.setting_fields', []);
    }

    /**
     * getSettingsColumn function.
     * Returns the default settings column used for this model.
     * This can be overwritten in the user model.
     *
     * @return string
     */
    public function getSettingsColumn()
    {
        return config('user-settings.settings_column', 'settings');
    }

    /**
     * getBitwiseList function.
     * Get the converted list of settings and bits
     *
     * @return array
     */
    protected function getBitwiseList()
    {
        return BitwiseConverter::arrayToBitwiseList($this->getSettingFields());
    }

    /**
     * validateKey function.
     * Validate and make sure if the key exists in the bitwise list.
     *
     * @param $key
     *
     * @return void
     * @throws InvalidUserSettingsFieldUsed
     */
    protected function validateKey($key)
    {
        if(!isset($this->getBitwiseList()[$key])) {
            throw new InvalidUserSettingsFieldUsed("Invalid settings field key given, this object is not allowed to use this key.");
        }
    }
}