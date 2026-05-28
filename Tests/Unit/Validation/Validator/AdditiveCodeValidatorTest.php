<?php

declare(strict_types=1);

namespace Maispace\MaiCanteen\Tests\Unit\Validation\Validator;

use Maispace\MaiCanteen\Validation\Validator\AdditiveCodeValidator;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class AdditiveCodeValidatorTest extends TestCase
{
    private AdditiveCodeValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new AdditiveCodeValidator();
    }

    // -------------------------------------------------------------------------
    // Empty / edge cases
    // -------------------------------------------------------------------------

    #[Test]
    public function emptyStringIsValid(): void
    {
        $result = $this->validator->validate('');
        self::assertFalse($result->hasErrors());
    }

    #[Test]
    public function whitespaceOnlyStringIsValid(): void
    {
        $result = $this->validator->validate('   ');
        self::assertFalse($result->hasErrors());
    }

    // -------------------------------------------------------------------------
    // Valid codes
    // -------------------------------------------------------------------------

    #[Test]
    public function singleValidCodeIsValid(): void
    {
        $result = $this->validator->validate('1');
        self::assertFalse($result->hasErrors());
    }

    #[Test]
    public function zeroCodeIsValid(): void
    {
        $result = $this->validator->validate('0');
        self::assertFalse($result->hasErrors());
    }

    #[Test]
    public function multipleValidCodesAreValid(): void
    {
        $result = $this->validator->validate('1, 3, 5');
        self::assertFalse($result->hasErrors());
    }

    #[Test]
    public function allKnownCodesAreValid(): void
    {
        $codes = AdditiveCodeValidator::KNOWN_CODES;
        $result = $this->validator->validate(implode(', ', $codes));
        self::assertFalse($result->hasErrors());
    }

    #[Test]
    public function deduplicatedCodesDoNotCauseError(): void
    {
        $result = $this->validator->validate('1, 1, 1');
        self::assertFalse($result->hasErrors());
    }

    // -------------------------------------------------------------------------
    // Invalid codes
    // -------------------------------------------------------------------------

    #[Test]
    public function letterCodeReturnsError(): void
    {
        $result = $this->validator->validate('A');
        self::assertTrue($result->hasErrors());
    }

    #[Test]
    public function outOfRangeCodeReturnsError(): void
    {
        $result = $this->validator->validate('10');
        self::assertTrue($result->hasErrors());
    }

    #[Test]
    public function mixedValidAndInvalidCodesReturnError(): void
    {
        $result = $this->validator->validate('1, X, 3');
        self::assertTrue($result->hasErrors());
    }

    #[Test]
    public function errorContainsUnknownCodes(): void
    {
        $result = $this->validator->validate('99, X');
        $errors = $result->getErrors();
        self::assertCount(1, $errors);
        $errorMessage = $errors[0]->getMessage();
        $messageText = method_exists($errorMessage, 'render') ? $errorMessage->render() : (string) $errorMessage;
        // The normalizer strips non-numeric tokens, so only '99' may survive
        self::assertStringContainsString('99', $messageText);
    }

    #[Test]
    public function nonStringValueReturnsError(): void
    {
        $result = $this->validator->validate(123);
        self::assertTrue($result->hasErrors());
    }

    #[Test]
    public function nullValueIsValid(): void
    {
        $result = $this->validator->validate(null);
        self::assertFalse($result->hasErrors());
    }

    // -------------------------------------------------------------------------
    // Known codes constant
    // -------------------------------------------------------------------------

    #[Test]
    public function knownCodesContainsAllDigitsZeroToNine(): void
    {
        $codes = AdditiveCodeValidator::KNOWN_CODES;
        for ($i = 0; $i <= 9; $i++) {
            self::assertContains((string) $i, $codes);
        }
    }

    #[Test]
    public function knownCodesHasExactlyTenEntries(): void
    {
        self::assertCount(10, AdditiveCodeValidator::KNOWN_CODES);
    }
}
