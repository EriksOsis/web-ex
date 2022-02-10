<?php

$search = $_GET["search"] ?? "";
$offset = $_GET['offset'] ?? 0;
$limit = 50;
$from = $_GET['from'] ?? "";
$to = $_GET['to'] ?? "";

$q = json_decode(file_get_contents("https://data.gov.lv/dati/lv/api/3/action/datastore_search?q=$search&offset=$offset&resource_id=8ea0ee31-1bea-4336-bbe4-2e66ccdadd1b&limit=$limit"));

?>
<html>
<head>Covidz</head>
<body>
<form method="get" action="/">
    <label for="Date"></label>
    <input type="date" name="from" value="<?php echo $from ?>">
    <input type="date" name="to" value="<?php echo $to ?>">
    <button type="submit" value="<?php echo $from . $to; ?>"
</form>

<table border="dotted">
    <thead>
    <th>
        ID
    </th>
    <th>
        Datums
    </th>
    <th>
        Valstu skaits
    </th>
    <th>
        saslimušie 14 dienās
    </th>
    </thead>
    <tbody>
    <?php foreach ($q->result->records as $record): ?>
        <?php if (strtotime($record->date) >= strtotime($from) && strtotime($record->date) <= strtotime($to)): ?>
        <tr>
            <td>
                <?php echo date_format(date_create(substr($record->date, 0, "15")), "dd-mm-yyyy"); ?>
            </td>
            <td>
                <?php echo $record->id;?>
            </td>
            <td>
                <?php echo $record->date; ?>
            </td>
            <td>
                <?php echo $record->country; ?>
            </td>
            <td>
                <?php echo $record->sick; ?>
            </td>
        </tr>
    <?php endif; ?>
    <?php endforeach; ?>
    </tbody>
</table>

<form method="get" action="/">
    <?php if ($offset > 0): ?>
        <button type="submit" name="offset" value="<?php echo $offset-$limit; ?>"> Previous</button>
    <?php endif ?>

    <?php if (count($q->result->records) >= $limit): ?>
        <button type="submit" name="offset" value="<?php echo $offset+$limit; ?>"> Next</button>
    <?php endif ?>
</form>
</body>
</html>