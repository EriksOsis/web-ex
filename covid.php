<?php

$search = $_GET["search"] ?? "";
$offset = $_GET['offset'] ?? 0;
$limit = 50;

$q = json_decode(file_get_contents("https://data.gov.lv/dati/lv/api/3/action/datastore_search?q=$search&offset=$offset&resource_id=25e80bf3-f107-4ab4-89ef-251b5b9374e9&limit=$limit"));

?>

<form method="get" action="/">
    <label>
        <input name="search" value="" />
    </label>
    <button type="submit">Iesniegt</button>
</form>

<table border="dotted">
    <thead>
    <th>
        Name
    </th>
    <th>
        Registration code
    </th>
    <th>
        Company type
    </th>
    </thead>
    <tbody>
    <?php foreach ($q->result->records as $record): ?>
        <tr>
            <td>
                <?php echo $record->name;?>
            </td>
            <td>
                <?php echo $record->regcode; ?>
            </td>
            <td>
                <?php echo $record->type; ?>
            </td>
        </tr>
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