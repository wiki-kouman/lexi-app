<?php

namespace App\DTO;

class TermDTO {
	public function __construct(
		public string $category,
		public string $language,
		public string $label,
		public string $labelTranslation,
		public ?array $exampleLabels,
		public ?array $exampleTranslations,
	) {

	}
}
