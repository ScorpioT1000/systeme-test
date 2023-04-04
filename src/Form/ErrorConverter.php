<?php
namespace App\Form;

use Symfony\Component\Form\FormInterface;

abstract class ErrorConverter
{
    public static function toPrimitives(FormInterface $form): array
    {
        $errors = [];

        // Global
        foreach ($form->getErrors() as $error) {
            $errors[$form->getName()][] = $error->getMessage();
        }

        // Fields
        foreach ($form as $child /** @var Form $child */) {
            if (!$child->isValid()) {
                foreach ($child->getErrors() as $error) {
                    $errors[$child->getName()][] = $error->getMessage();
                }
            }
        }
        return $errors;
    }
}