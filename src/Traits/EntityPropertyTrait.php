<?php
// src/Traits/EntityPropertyTrait.php
namespace App\Traits;

trait EntityPropertyTrait
{
    /**
     * Set multiple properties on the object.
     *
     * @param object $object The object to set properties on.
     * @param array  $properties An associative array of properties to set.
     */
    public function setProperties(object $object, array $properties): void
    {
        foreach ($properties as $property => $value) {
            // Check if the property exists before setting it
            if (property_exists($object, $property)) {
                $object->{$property} = $value;
            }
        }
    }

    /**
     * Get an associative array of properties from the object.
     *
     * @return array An associative array of properties.
     */
    public function getProperties(): array
    {
        $properties = [];

        // Iterate through all properties of the object
        foreach (get_object_vars($this) as $property => $value) {
            $properties[$property] = $value;
        }

        return $properties;
    }
}
