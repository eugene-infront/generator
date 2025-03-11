<?php

function computeCheckDigit($value) {
    $weights = [7, 3, 1];
    $total = 0;
    $length = strlen($value);

    for ($i = 0; $i < $length; $i++) {
        $char = $value[$i];

        if (is_numeric($char)) {
            $num = (int)$char;
        } elseif ($char === '<') {
            $num = 0;
        } else {
            $num = ord($char) - 55; // Convert A-Z to 10-35
        }

        $total += $num * $weights[$i % 3];
    }

    return $total % 10;
}

function generateMRZ($passportNumber, $birthDate, $expiryDate, $country = "IDN", $gender = "M", $name = "TEST USER") {
    // Compute check digits
    $passportCheckDigit = computeCheckDigit($passportNumber);
    $birthCheckDigit = computeCheckDigit($birthDate);
    $expiryCheckDigit = computeCheckDigit($expiryDate);

    // Construct MRZ string
    $firstLine = "P<" . strtoupper($country) . str_replace(" ", "<", strtoupper($name)) . "<<<<<<<<<<<<<<";
    $secondLine = strtoupper($passportNumber) . $passportCheckDigit .
                  strtoupper($country) . $birthDate . $birthCheckDigit .
                  strtoupper($gender) . $expiryDate . $expiryCheckDigit . "<<<<<<<<<<<<<<";

    // Compute the final check digit
    $finalCheckString = $passportNumber . $passportCheckDigit . $birthDate . $birthCheckDigit . $expiryDate . $expiryCheckDigit;
    $finalCheckDigit = computeCheckDigit($finalCheckString);

    // Append final check digit
    $secondLine .= $finalCheckDigit;

    return substr($firstLine, 0, 44) . "\n" . substr($secondLine, 0, 44);
}

// Get data from POST request
$passportNumber = $_POST['passport_number'] ?? 'B81464123';
$birthDate = $_POST['birth_date'] ?? '920211';
$expiryDate = $_POST['expiry_date'] ?? '291117';
$country = $_POST['country'] ?? 'IDN';
$gender = $_POST['gender'] ?? 'M';
$name = $_POST['name'] ?? 'TEST USER';

// Generate MRZ
echo generateMRZ($passportNumber, $birthDate, $expiryDate, $country, $gender, $name);
