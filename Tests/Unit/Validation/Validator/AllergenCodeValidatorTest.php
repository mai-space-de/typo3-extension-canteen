<?php

declare(strict_types=1);

namespace Maispace\MaiCanteen\Tests\Unit\Validation\Validator;

use Maispace\MaiCanteen\Validation\Validator\AllergenCodeValidator;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class AllergenCodeValidatorTest extends TestCase
{
    private AllergenCodeValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new AllergenCodeValidator();
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
        $result = $this->validator->validate('A');
        self::assertFalse($result->hasErrors());
    }

    #[Test]
    public function multipleValidCodesAreValid(): void
    {
        $result = $this->validator->validate('A, C, G');
        self::assertFalse($result->hasErrors());
    }

    #[Test]
    public function allKnownCodesAreValid(): void
    {
        $codes = AllergenCodeValidator::KNOWN_CODES;
        $result = $this->validator->validate(implode(', ', $codes));
        self::assertFalse($result->hasErrors());
    }

    #[Test]
    public function lowerCaseCodeIsNormalizedAndValid(): void
    {
        $result = $this->validator->validate('a, c');
        self::assertFalse($result->hasErrors());
    }

    #[Test]
    public function deduplicatedCodesDoNotCauseError(): void
    {
        $result = $this->validator->validate('A, A, A');
        self::assertFalse($result->hasErrors());
    }

    // -------------------------------------------------------------------------
    // Invalid codes
    // -------------------------------------------------------------------------

    #[Test]
    public function unknownCodeReturnsError(): void
    {
        $result = $this->validator->validate('X');
        self::assertTrue($result->hasErrors());
    }

    #[Test]
    public function mixedValidAndInvalidCodesReturnError(): void
    {
        $result = $this->validator->validate('A, X, C');
        self::assertTrue($result->hasErrors());
    }

    #[Test]
    public function errorContainsUnknownCodes(): void
    {
        $result = $this->validator->validate('X, Y');
        $errors = $result->getErrors();
        self::assertCount(1, $errors);
        $errorMessage = $errors[0]->getMessage();
        $messageText = method_exists($errorMessage, 'render') ? $errorMessage->render() : (string) $errorMessage;
        self::assertStringContainsString('X', $messageText);
        self::assertStringContainsString('Y', $messageText);
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
    public function knownCodesContainsExpectedAllergens(): void
    {
        $codes = AllergenCodeValidator::KNOWN_CODES;
        self::assertContains('A', $codes);
        self::assertContains('C', $codes);
        self::assertContains('G', $codes);
        self::assertContains('L', $codes);
        self::assertContains('R', $codes);
    }

    #[Test]
    public function knownCodesDoesNotContainInvalidLetters(): void
    {
        $codes = AllergenCodeValidator::KNOWN_CODES;
        self::assertNotContains('I', $codes);
        self::assertNotContains('J', $codes);
        self::assertNotContains('K', $codes);
        self::assertNotContains('Q', $codes);
        self::assertNotContains('S', $codes);
        self::assertNotContains('T', $codes);
    }
}
