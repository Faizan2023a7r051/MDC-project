<?php

function checkStrength($password) {
    $score = 0;

    if (strlen($password) >= 8) $score++;
    if (preg_match('/[A-Z]/', $password)) $score++;
    if (preg_match('/[a-z]/', $password)) $score++;
    if (preg_match('/[0-9]/', $password)) $score++;
    if (preg_match('/[^a-zA-Z0-9]/', $password)) $score++;

    if ($score <= 2) return "Weak ❌";
    elseif ($score <= 4) return "Medium ⚠️";
    else return "Strong ✅";
}

function estimateTime($password) {
    $charset = 0;

    if (preg_match('/[a-z]/', $password)) $charset += 26;
    if (preg_match('/[A-Z]/', $password)) $charset += 26;
    if (preg_match('/[0-9]/', $password)) $charset += 10;
    if (preg_match('/[^a-zA-Z0-9]/', $password)) $charset += 32;

    $length = strlen($password);
    $combinations = pow($charset, $length);

    $guesses = 1000000000; // 1 billion/sec
    $seconds = $combinations / $guesses;

    return formatTime($seconds);
}

function formatTime($seconds) {
    if ($seconds < 60) return round($seconds,2)." seconds";
    elseif ($seconds < 3600) return round($seconds/60,2)." minutes";
    elseif ($seconds < 86400) return round($seconds/3600,2)." hours";
    elseif ($seconds < 31536000) return round($seconds/86400,2)." days";
    else return round($seconds/31536000,2)." years";
}

// 🔥 Entropy Calculation
function calculateEntropy($password) {
    $charset = 0;

    if (preg_match('/[a-z]/', $password)) $charset += 26;
    if (preg_match('/[A-Z]/', $password)) $charset += 26;
    if (preg_match('/[0-9]/', $password)) $charset += 10;
    if (preg_match('/[^a-zA-Z0-9]/', $password)) $charset += 32;

    $length = strlen($password);
    return round($length * log($charset, 2), 2); // bits
}

// 🔥 Common Password Check using file
function checkCommon($password) {
    $file = file("small_rockyou.txt", FILE_IGNORE_NEW_LINES);
    return in_array(strtolower($password), $file);
}
?>
