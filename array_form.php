<?php
include "layout.php";
?>

<h2>Ввод массива</h2>

<form method="post" action="array_result.php" target="_blank">

<table id="elements">
<tr>
    <td>0</td>
    <td><input type="text" name="element0"></td>
</tr>
</table>

<input type="hidden" id="arrLength" name="arrLength" value="1">

<br>

<select name="algoritm">
    <option value="selection">Сортировка выбором</option>
    <option value="bubble">Пузырьковая сортировка</option>
    <option value="shell">Сортировка Шелла</option>
    <option value="gnome">Сортировка гнома</option>
    <option value="quick">Быстрая сортировка</option>
    <option value="native">Встроенная PHP сортировка</option>
</select>

<br><br>

<button type="button" onclick="addElement()">Добавить элемент</button>
<button type="submit">Сортировать массив</button>

</form>

<script>
function addElement() {
    let table = document.getElementById("elements");
    let index = table.rows.length;

    let row = table.insertRow();

    let cell1 = row.insertCell(0);
    let cell2 = row.insertCell(1);

    cell1.innerHTML = index;
    cell2.innerHTML = `<input type="text" name="element${index}">`;

    document.getElementById("arrLength").value = table.rows.length;
}
</script>

<?php include "footer.php"; ?>