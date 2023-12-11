<?php
// src/Dto/ApplicationDto.php

namespace App\Dto;

class ApplicationDto
{
    public ?string $name;
    public ?string $type;
    public ?string $status;
    public ?string $alias;
    public ?string $description;
    public ?string $logo;

    /**
     * Convert the ApplicationDto to an associative array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'type' => $this->type,
            'status' => $this->status,
            'alias' => $this->alias,
            'description' => $this->description,
            'logo' => $this->logo,
            // Add other properties as needed
        ];
    }
    /**
     * Get an associative array of properties from the object.
     *
     * @return array An associative array of properties.
     */
    public function getProperties(): array
    {
        // Use get_object_vars to retrieve public properties
        return get_object_vars($this);
    }
}
