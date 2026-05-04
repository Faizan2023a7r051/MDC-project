<?php include 'functions.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>CyberPass Inspector</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div id="info-icon">ℹ️</div>

<div class="container">
    <h1>CyberPass Inspector 🔐</h1>

    <form method="POST">
        <input type="text" name="password" placeholder="Enter Password" required>
        <div id="strength-meter">
    <div id="strength-bar"></div>
</div>
<p id="strength-text"></p>

        <select name="action">
            <option value="strength">Check Strength</option>
            <option value="time">Estimate Crack Time</option>
            <option value="common">Check Common Password</option>
            <option value="entropy">Calculate Entropy</option>
	    <option value="full">Full Analysis 🚀</option>
        </select>

        <button type="submit">Analyze</button>
    </form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['password'];
    $action = $_POST['action'];

    echo "<div class='result'>";

    if ($action == "strength") {
        echo "Strength: " . checkStrength($password);
    }

    elseif ($action == "time") {
        echo "Estimated Crack Time: " . estimateTime($password);
    }

    elseif ($action == "common") {
        echo checkCommon($password)
            ? "⚠️ Common Password!"
            : "✅ Not Common";
    }

    elseif ($action == "entropy") {
        echo "Entropy: " . calculateEntropy($password) . " bits";
    }
    elseif ($action == "full") {

    echo "<b>🔍 Full Analysis Result:</b><br><br>";

    // Strength
    $strength = checkStrength($password);
    echo "Strength: $strength <br>";

    // Crack Time
    echo "Estimated Crack Time: " . estimateTime($password) . "<br>";

    // Common Password
    if (function_exists('checkCommon')) {
        $isCommon = checkCommon($password);
        echo $isCommon ? "⚠️ Common Password<br>" : "✅ Not Common<br>";
    }

    // Entropy
    if (function_exists('calculateEntropy')) {
        echo "Entropy: " . calculateEntropy($password) . " bits<br>";
    }

    // Suggestions (only if weak)
    if ($strength == "Weak ❌" && function_exists('suggestPassword')) {
        echo "<br><b>Suggestions:</b><br>";
        foreach (suggestPassword($password) as $s) {
            echo "- $s <br>";
        }
    }
}

    echo "</div>";
    
}
?>

</div>
<script>
const passwordInput = document.querySelector("input[name='password']");
const bar = document.getElementById("strength-bar");
const text = document.getElementById("strength-text");

passwordInput.addEventListener("input", () => {
    const password = passwordInput.value;

    let score = 0;

    if (password.length >= 8) score++;
    if (/[A-Z]/.test(password)) score++;
    if (/[a-z]/.test(password)) score++;
    if (/[0-9]/.test(password)) score++;
    if (/[^a-zA-Z0-9]/.test(password)) score++;

    // Update UI
    if (score <= 2) {
        bar.style.width = "30%";
        bar.style.background = "red";
        text.innerText = "Weak ❌";
    } 
    else if (score <= 4) {
        bar.style.width = "65%";
        bar.style.background = "orange";
        text.innerText = "Medium ⚠️";
    } 
    else {
        bar.style.width = "100%";
        bar.style.background = "green";
        text.innerText = "Strong ✅";
    }
});
</script>
<div id="info-modal" class="modal">
    <div class="modal-content">
        <span id="close-btn">&times;</span>

        <h2>Password Policies 🔐</h2>
        <ul>
            <li>Minimum 8–12 characters</li>
            <li>Use uppercase & lowercase letters</li>
            <li>Include numbers (0–9)</li>
            <li>Add special symbols (!@#$%^&*)</li>
            <li>Avoid common passwords</li>
        </ul>

        <h3>Created By</h3>
        <p>Faizan & Abrar</p>
    </div>
</div>
<div id="info-modal" class="modal">
    <div class="modal-content">
        <span id="close-btn">&times;</span>

        <h2>Password Policies 🔐</h2>
        <ul>
            <li>Minimum 8–12 characters</li>
            <li>Use uppercase & lowercase letters</li>
            <li>Include numbers (0–9)</li>
            <li>Add special symbols (!@#$%^&*)</li>
            <li>Avoid common passwords</li>
        </ul>

        <h3>Created By</h3>
        <p>Faizan & Abrar</p>
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const modal = document.getElementById("info-modal");
    const icon = document.getElementById("info-icon");
    const closeBtn = document.getElementById("close-btn");

    icon.addEventListener("click", function () {
        modal.style.display = "block";
    });

    closeBtn.addEventListener("click", function () {
        modal.style.display = "none";
    });

    window.addEventListener("click", function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    });

});
</script>
</body>
</html>
