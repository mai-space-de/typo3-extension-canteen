<?php

declare(strict_types=1);

namespace Maispace\MaiCanteen\Validation\Validator;

use Maispace\MaiCanteen\Utility\TagListNormalizer;
use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

/**
 * Validates a comma-separated allergen code string against known EU allergen codes.
 *
 * Each code is expected to be a single uppercase letter (A–H, L–P, R).
 * Empty input and whitespace-only input are considered valid (no allergens declared).
 *
 * Known EU allergen codes (per EU FIC Regulation 1169/2011):
 *   A  – Gluten-containing cereals (wheat, rye, barley, oats, spelt, kamut)
 *   B  – Crustaceans (crabs, prawns, lobster, crawfish)
 *   C  – Eggs
 *   D  – Fish
 *   E  – Peanuts
 *   F  – Soybeans
 *   G  – Milk (including lactose)
 *   H  – Tree nuts (almonds, hazelnuts, walnuts, cashews, pecans, brazil, pistachio, macadamia)
 *   L  – Celery
 *   M  – Mustard
 *   N  – Sesame seeds
 *   O  – Sulphur dioxide / sulphites
 *   P  – Lupin
 *   R  – Molluscs
 */
final class AllergenCodeValidator extends AbstractValidator
{
    public const KNOWN_CODES = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'L', 'M', 'N', 'O', 'P', 'R'];

    protected function isValid(mixed $value): void
    {
        if (!is_string($value)) {
            $this->addError(
                'Allergen codes must be a comma-separated string.',
                1738592001,
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
                sprintf('Unknown allergen code(s): %s', implode(', ', $invalid)),
                1738592002,
                [implode(', ', $invalid)],
            );
        }
    }
}
