<?php

declare(strict_types=1);

namespace Maispace\MaiCanteen\Utility;

/**
 * Normalises the comma-separated allergen / additive code lists entered for a
 * dish in the backend into a clean, canonical form.
 *
 * The `allergens` and `additives` fields are free-text, comma-separated code
 * lists (e.g. "A, C, G" or "1,2,3"). Editor input is inconsistent: stray
 * whitespace, blank entries, duplicates, mixed case, and accidental markup all
 * occur. This normaliser strips markup, trims and collapses whitespace, drops
 * empty entries, upper-cases each code so the rendered `data-canteen-allergen`
 * hook stays stable, and removes duplicates while preserving first-seen order.
 *
 * Note: only truly empty tokens are dropped — a literal "0" code is preserved
 * (plain array_filter() would have discarded it).
 */
final class TagListNormalizer
{
    /**
     * Splits a raw comma-separated code string into a sanitised, de-duplicated
     * list of upper-cased codes.
     *
     * @return list<string>
     */
    public static function toList(string $raw): array
    {
        $codes = [];

        foreach (explode(',', $raw) as $token) {
            $code = self::normalizeToken($token);
            if ($code === '') {
                continue;
            }
            if (!in_array($code, $codes, true)) {
                $codes[] = $code;
            }
        }

        return $codes;
    }

    /**
     * Returns the canonical comma-separated representation of the given raw code
     * string (the sanitised list re-joined with ", ").
     */
    public static function toCanonicalString(string $raw): string
    {
        return implode(', ', self::toList($raw));
    }

    private static function normalizeToken(string $token): string
    {
        $token = strip_tags($token);
        $token = preg_replace('/\s+/', ' ', $token) ?? '';

        return mb_strtoupper(trim($token), 'UTF-8');
    }
}
