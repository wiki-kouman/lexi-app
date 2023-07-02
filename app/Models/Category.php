<?php

namespace App\Models;

class Category
{
    public int $id;
    public int $lexemeId;
    public string $code;
    public string $label;
    public Language $language;
    public array $definitions;

    /**
     * @param int $lexemeId
     * @param string $code
     * @param string $label
     * @param Language $language
     * @param array $definitions
     */
    public function __construct(int $lexemeId, string $code, string $label, Language $language, array $definitions)
    {
        $this->lexemeId = $lexemeId;
        $this->code = $code;
        $this->label = $label;
        $this->language = $language;
        $this->definitions = $definitions;
    }


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getLexemeId(): int
    {
        return $this->lexemeId;
    }

    /**
     * @param int $lexemeId
     */
    public function setLexemeId(int $lexemeId): void
    {
        $this->lexemeId = $lexemeId;
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

    /**
     * @return Language
     */
    public function getLanguage(): Language
    {
        return $this->language;
    }

    /**
     * @param Language $language
     */
    public function setLanguage(Language $language): void
    {
        $this->language = $language;
    }

    /**
     * @return Definition[]
     */
    public function getDefinitions(): array
    {
        return $this->definitions;
    }

    /**
     * @param Definition[] $definitions
     */
    public function setDefinitions(array $definitions): void
    {
        $this->definitions = $definitions;
    }


}
