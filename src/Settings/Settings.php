<?php

declare(strict_types=1);

namespace App\Settings;

/**
 * Class Settings
 *
 * Represents a configuration settings container with the ability to retrieve settings by key.
 */
class Settings implements SettingsInterface
{
    /**
     * @var array $settings The array containing settings data.
     */
    private array $settings;

    /**
     * Settings constructor.
     *
     * @param array $settings The array containing settings data.
     */
    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    /**
     * Get the value of a setting based on the provided key.
     *
     * @param string $key The key representing the setting. Use dot notation for nested settings.
     *
     * @return mixed|null The value of the specified setting or null if not found.
     */
    public function get(string $key = ''): mixed
    {
        // If no key is provided, return the entire settings array.
        if (empty($key)) {
            return $this->settings;
        }

        // Split the key into components using dot notation.
        $keyComponents = explode('.', $key);

        // If only one component, directly return the corresponding value.
        if (count($keyComponents) === 1) {
            return $this->settings[$key] ?? null;
        }

        $currentSettings = $this->settings;

        // Iterate through key components to find the nested setting.
        foreach ($keyComponents as $keyComponent) {
            // If the current setting is not an array, return null.
            if (!is_array($currentSettings) || !array_key_exists($keyComponent, $currentSettings)) {
                return null;
            }

            $currentSettings = $currentSettings[$keyComponent];
        }

        return $currentSettings;
    }
}
