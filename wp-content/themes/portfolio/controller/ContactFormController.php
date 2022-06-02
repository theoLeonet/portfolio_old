<?php

namespace Portfolio\Controllers;

use Portfolio\Validators\EmailValidator;
use Portfolio\Validators\RequiredValidator;
use Portfolio\Validators\Sanitizers\TextSanitizer;
use Portfolio\Validators\Sanitizers\EmailSanitizer;

class ContactFormController extends BaseFormController
{
    protected function getNonceKey(): string
    {
        return 'nonce_submit_contact_form';
    }

    protected function getSanitizableAttributes(): array
    {
        return [
            'fullname' => TextSanitizer::class,
            'email' => EmailSanitizer::class,
            'message' => TextSanitizer::class,
        ];
    }

    protected function getValidatableAttributes(): array
    {
        return [
            'fullname' => [RequiredValidator::class],
            'email' => [RequiredValidator::class, EmailValidator::class],
            'message' => [RequiredValidator::class],
        ];
    }

    protected function redirectWithErrors($errors)
    {
        // C'est pas OK, on place les erreurs de validation dans la session
        $_SESSION['contact_form_feedback'] = [
            'success' => false,
            'data' => $this->data,
            'errors' => $errors,
        ];

        // On redirige l'utilisateur vers le formulaire pour y afficher le feedback d'erreurs.
        return wp_safe_redirect(($this->data['_wp_http_referer'] ?? ''), 302);
    }

    protected function handle()
    {
        $recipient = 'dev@theoleonet.be';
        $subject = $this->data['fullname'] . 'sent you a message.';
        $message = $this->data['message'];
        $headers[] = 'From: ' . '<' . $this->data['email'] . '>';

        // Envoyer l'email à l'admin
        wp_mail(
            $recipient,
            $subject,
            $message,
            $headers
        );
    }

    protected function redirectWithSuccess()
    {
        // Ajouter le feedback positif à la session
        $_SESSION['contact_form_feedback'] = [
            'success' => true,
        ];

        return wp_safe_redirect($this->data['_wp_http_referer'], 302);
    }
}