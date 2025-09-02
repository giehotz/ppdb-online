<?php

if (!function_exists('get_setting')) {
    /**
     * Get setting value by key
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function get_setting($key, $default = null)
    {
        static $settings = null;
        
        // Load settings only once
        if ($settings === null) {
            $settingModel = new \App\Models\SettingModel();
            $allSettings = $settingModel->findAll();
            
            $settings = [];
            foreach ($allSettings as $setting) {
                $settings[$setting['key']] = $setting['value'];
            }
        }
        
        return isset($settings[$key]) ? $settings[$key] : $default;
    }
}

if (!function_exists('set_setting')) {
    /**
     * Set setting value by key
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    function set_setting($key, $value)
    {
        $settingModel = new \App\Models\SettingModel();
        return $settingModel->set($key, $value);
    }
}