<?php

namespace App\model;

class Roles
{
    const Customer = 'Customer';
    const Employee = 'Employee';
    const Administrator = 'Administrator';

    private $value;

    /**
     * @param $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }
    public static function Administrator(): self
    {
        return new self(self::Administrator);
    }
    public static function Employee(): self
    {
        return new self(self::Employee);
    }
    public static function Customer(): self
    {
        return new self(self::Customer);
    }
    public static function getLabel(self $value): string
    {
        return match ($value->value) {
            self::Administrator => 'Administrator',
            self::Employee => 'Employee',
            self::Customer => 'Customer',
            default => throw new InvalidArgumentException("Invalid status value: $value"),
        };
    }
    public static function fromString(string $value): self
    {
        return match ($value) {
            self::Administrator => self::Administrator(),
            self::Employee => self::Employee(),
            self::Customer => self::Customer(),
            default => throw new InvalidArgumentException("Invalid status value: $value"),
        };
    }

    public function jsonSerialize(): mixed
    {
        return $this->value;
    }
    public static function getEnumValues(): array
    {
        $reflectionClass = new ReflectionClass(__CLASS__);
        $constants = $reflectionClass->getConstants();
        return array_values($constants);
    }
}