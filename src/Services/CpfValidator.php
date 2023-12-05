<?php

namespace App\Service;

class CpfValidator
{
    public function isValid(string $cpf): bool
    {
        // Remova pontos e traços do CPF
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        // Verifica se o CPF tem 11 dígitos
        if (strlen($cpf) !== 11) {
            return false;
        }

        // Calcula os dígitos verificadores
        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum += intval($cpf[$i]) * (10 - $i);
        }

        $digit1 = ($sum % 11 < 2) ? 0 : 11 - ($sum % 11);

        $sum = 0;
        for ($i = 0; $i < 10; $i++) {
            $sum += intval($cpf[$i]) * (11 - $i);
        }

        $digit2 = ($sum % 11 < 2) ? 0 : 11 - ($sum % 11);

        // Verifica os dígitos verificadores
        return ($cpf[9] == $digit1) && ($cpf[10] == $digit2);
    }
}