<?php

declare(strict_types=1);

namespace Maispace\MaiCanteen\Validation\Validator;

use Maispace\MaiCanteen\Utility\TagListNormalizer;
use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

/**
 * Validates a comma-separated additive code string against known additive codes.
 *
 * Each code is expected to be a numeric string (e.g. "1", "2", "3").
 * Empty input and whitespace-only input are considered valid (no additives declared).
 *
 * Known additive codes follow the German Lebensmittelzusatzstoff convention:
 *   0 – No additives declared
 *   1 – Preservatives
 *   2 – Antioxidants
 *   3 – Flavour enhancers
 *   4 – Colours
 *   5 – Sweeteners
 *   6 – Raising agents
 *   7 – Acids and acidity regulators
 *   8 – Emulsifiers and stabilisers
 *   9 – Packaging gases
 */
final class AdditiveCodeValidator extends AbstractValidator
{
    public const KNOWN_CODES = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

    protected function isValid(mixed $value): void
    {
        if (!is_string($value)) {
            $this->addError(
                'Additive codes must be a comma-separated string.',
                1738592011,
            );
            return;
        }

        $trimmed = trim($value);
        if ($trimmed === '') {
            return;
        }

        $codes = TagListNormalizer::toList($trimmed);
        $invalid = array_diff($codes, self::KNOWN_CODES);

        if ($invalid !== []) {
            $this->addError(
                sprintf('Unknown additive code(s): %s', implode(', ', $invalid)),
                1738592012,
                [implode(', ', $invalid)],
            );
        }
    }
}
