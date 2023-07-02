<?php

namespace App\Models;

class Language
{
    public int $id;
    public string $code;
    public string $label;

    /**
     * @param string $code
     * @param string $label
     */
    public function __construct(string $code, string $label)
    {
        $this->code = $code;
        $this->label = $label;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

}
