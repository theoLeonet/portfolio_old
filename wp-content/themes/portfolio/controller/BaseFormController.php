<?php

namespace Portfolio\Controllers;

abstract class BaseFormController
{
    protected $data = [];

    public function __construct(array $data)
    {
        $this->data = $data;

        $this->verifyNonce();
        $this->sanitizeData();
        $this->validateData();
        $this->handle();
        $this->redirectWithSuccess();
        exit;
    }

    protected function verifyNonce(): void
    {
        $nonce = $this->data['_wpnonce'] ?? null;

        if (!$nonce || !wp_verify_nonce($nonce, $this->getNonceKey())) {
            die('Unauthorized.');
        }
    }

    abstract protected function getNonceKey(): string;

    protected function sanitizeData(): void
    {
        foreach ($this->getSanitizableAttributes() as $attribute => $sanitizer) {
            $sanitizer = new $sanitizer($this->data[$attribute] ?? null);

            $this->data[$attribute] = $sanitizer->getSanitizedValue();
        }
    }

    abstract protected function getSanitizableAttributes(): array;

    private function validateData(): void
    {
        $errors = [];

        foreach ($this->getValidatableAttributes() as $attribute => $validators) {
            $errors = $this->validateAttribute($errors, $attribute, $validators);
        }

        if ($errors) {
            $this->redirectWithErrors($errors);
            exit;
        }
    }

    abstract protected function redirectWithErrors($errors);

    private function validateAttribute(array $errors, int|string $attribute, mixed $validators): array
    {
        foreach ($validators as $validator) {
            $validator = new $validator($this->data[$attribute] ?? null);

            if (!$validator->hasError()) continue;

            $errors[$attribute] = $validator->getError();

            break;
        }

        return $errors;
    }

    abstract protected function getValidatableAttributes(): array;

    abstract protected function handle();

    abstract protected function redirectWithSuccess();

}

