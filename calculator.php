<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Очистка истории по GET-параметру
if (isset($_GET['clear_history'])) {
    $_SESSION['history'] = [];
    $_SESSION['last_result'] = 'Введите выражение и нажмите "Вычислить"';
    $_SESSION['last_expression'] = '';
    header('Location: ?p=calculator');
    exit;
}

/* ========== ФУНКЦИИ ========== */
function isnum($x) {
    if ($x === '' || $x === null) return false;
    $x = trim($x);
    if ($x === '') return false;
    if ($x[0] == '.' || $x[strlen($x)-1] == '.') return false;
    $dotCount = 0;
    for ($i = 0; $i < strlen($x); $i++) {
        $ch = $x[$i];
        if ($ch === '.') {
            $dotCount++;
            if ($dotCount > 1) return false;
        } elseif (!ctype_digit($ch)) {
            return false;
        }
    }
    return true;
}

function SqValidator($val) {
    $open = 0;
    for ($i = 0; $i < strlen($val); $i++) {
        if ($val[$i] == '(') $open++;
        elseif ($val[$i] == ')') {
            $open--;
            if ($open < 0) return false;
        }
    }
    return $open == 0;
}

function calculate($val) {
    $val = trim($val);
    if ($val === '') return 'Выражение не задано!';
    if (isnum($val)) return $val;
    
    $parts = explode('+', $val);
    if (count($parts) > 1) {
        $sum = 0;
        foreach ($parts as $part) {
            $arg = calculate($part);
            if (!isnum($arg)) return $arg;
            $sum += (float)$arg;
        }
        return (string)$sum;
    }
    
    $parts = explode('-', $val);
    if (count($parts) > 1) {
        $result = calculate($parts[0]);
        if (!isnum($result)) return $result;
        $result = (float)$result;
        for ($i = 1; $i < count($parts); $i++) {
            $arg = calculate($parts[$i]);
            if (!isnum($arg)) return $arg;
            $result -= (float)$arg;
        }
        return (string)$result;
    }
    
    $parts = explode('*', $val);
    if (count($parts) > 1) {
        $product = 1;
        foreach ($parts as $part) {
            $arg = calculate($part);
            if (!isnum($arg)) return $arg;
            $product *= (float)$arg;
        }
        return (string)$product;
    }
    
    $parts = preg_split('/(\/|:)/', $val);
    if (count($parts) > 1) {
        $result = calculate($parts[0]);
        if (!isnum($result)) return $result;
        $result = (float)$result;
        for ($i = 1; $i < count($parts); $i++) {
            $arg = calculate($parts[$i]);
            if (!isnum($arg)) return $arg;
            $divisor = (float)$arg;
            if ($divisor == 0) return 'Деление на ноль!';
            $result /= $divisor;
        }
        return (string)$result;
    }
    
    return 'Недопустимые символы в выражении';
}

function calculateSq($val) {
    $val = trim($val);
    if (!SqValidator($val)) return 'Неправильная расстановка скобок';
    
    $start = strpos($val, '(');
    if ($start === false) {
        return calculate($val);
    }
    
    $end = $start + 1;
    $open = 1;
    while ($open > 0 && $end < strlen($val)) {
        if ($val[$end] == '(') $open++;
        elseif ($val[$end] == ')') $open--;
        $end++;
    }
    
    $inner = substr($val, $start + 1, $end - $start - 2);
    $innerResult = calculateSq($inner);
    if (!isnum($innerResult)) return $innerResult;
    
    $newVal = substr($val, 0, $start) . $innerResult . substr($val, $end);
    return calculateSq($newVal);
}

/* ========== ОБРАБОТКА POST ========== */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['val'])) {
    $expressionValue = trim($_POST['val']);
    
    if ($expressionValue === '') {
        $res = 'Выражение не задано!';
        $resultText = 'Ошибка: ' . $res;
    } else {
        $expressionClean = preg_replace('/\s+/', '', $expressionValue);
        $res = calculateSq($expressionClean);
        $resultText = is_numeric($res) ? "Результат: " . $res : "Ошибка: " . $res;
    }
    
    // Сохраняем в историю и последний результат
    $_SESSION['history'][] = $expressionValue . ' = ' . $res;
    $_SESSION['last_result'] = $resultText;
    $_SESSION['last_expression'] = $expressionValue;
    
    // Редирект, чтобы избежать повторной отправки при обновлении
    header('Location: ?p=calculator');
    exit;
}

/* ========== ПОКАЗ СТРАНИЦЫ (GET) ========== */
$resultText = isset($_SESSION['last_result']) ? $_SESSION['last_result'] : 'Введите выражение и нажмите "Вычислить"';
$expressionValue = isset($_SESSION['last_expression']) ? $_SESSION['last_expression'] : '';
?>

<div class="result-box">
    <strong>Результат:</strong> <?php echo htmlspecialchars($resultText); ?>
</div>

<form method="post" class="calculator-form">
    <div class="form-row">
        <label>Выражение:
            <input type="text" name="val" value="<?php echo htmlspecialchars($expressionValue); ?>" 
                   placeholder="Пример: (2+3)*4/2" required>
        </label>
    </div>
    <button type="submit" class="btn">Вычислить</button>
</form>

<div class="info hint">
    Допустимые символы: цифры, точка (для дробей), +, -, *, /, :, (, )<br>
    Примеры: 2.5+3.1, (4-1)*2, 10/3, 5:2
</div>

<!-- Кнопка очистки истории -->
<div style="margin-top: 20px; text-align: center;">
    <a href="?p=calculator&clear_history=1" class="btn clear-btn" onclick="return confirm('Очистить всю историю вычислений?')">Очистить историю</a>
</div>