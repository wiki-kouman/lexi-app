<?php

namespace App\Models;

class Definition
{
    public int $id;
    public string $label;
    public int $lexemeId;
    public array $examples;

    /**
     * @param string $label
     * @param int $lexemeId
     * @param array $examples
     */
    public function __construct(string $label, int $lexemeId, array $examples)
    {
        $this->label = $label;
        $this->lexemeId = $lexemeId;
        $this->examples = $examples;
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
     * @return string[]
     */
    public function getExamples(): array
    {
        return $this->examples;
    }

    /**
     * @param string[] $examples
     */
    public function setExamples(array $examples): void
    {
        $this->examples = $examples;
    }



}
