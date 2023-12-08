<?php

declare(strict_types=1);

namespace App\Settings;

class Settings implements SettingsInterface
{
    private array $settings;

    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get(string $key = ''): mixed
    {
        if (empty($key)) {
            return $this->settings;
        }

        $keyComponents = explode('.', $key);

        if (count($keyComponents) === 1) {
            return $this->settings[$key];
        }

        $settings = $this->settings;

        foreach ($keyComponents as $i => $keyComponent) {
            $setting = $settings[$keyComponent] ?? null;

            if (null === $setting) {
                return null;
            }

            if (!is_array($setting) && $i+1 !== count($keyComponents)) {
                return null;
            }

            if ($i+1 === count($keyComponents)) {
                return $setting;
            }

            $settings = $setting;
        }

        return null;
    }
}
