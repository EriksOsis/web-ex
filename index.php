<?php
//echo "<pre>";
$limit = 5000;
$offset = $_GET["offset"] ?? 0;

$from = $_GET["from"] ?? "";
$to = $_GET["to"] ?? "";

$data = json_decode(file_get_contents(
    "https://data.gov.lv/dati/lv/api/3/action/datastore_search?&offset=$offset&resource_id=d499d2f0-b1ea-4ba2-9600-2c701b03bd4a&limit=$limit"));
?>

<html>
<head>
    <style>
        header {
            text-align: center;
            font-size: large;
        }
        body {
            text-align: center;
        }
        p {
            font-size: 20px;
        }
        table {
            border: black solid;
            margin: auto;
            width: 400px;
        }
        tr {
            text-align: justify;
            background: antiquewhite;
        }
    </style>
</head>
<body>
    <header><h1>Covidz</h1></header>
    <form method="get" action="/">
        <p>Choose dates</p>
        <input type="date" name="from" value="<?php echo $from; ?>"/>
        <input type="date" name="to" value="<?php echo $to; ?>"/>
        <button type="submit" data-value="<?php echo $from; ?>" value="<?php echo $to; ?>"> Filter </button>
    </form>
    <table>
        <tr>
            <th>
                Datums
            </th>
            <th>
                Testu skaits
            </th>
            <th>
                Apstiprinātie
            </th>
            <th>
                Īpatsvars
            </th>
        </tr>
        <?php foreach($data->result->records as $record): ?>
            <?php if(strtotime($record->Datums) >= strtotime($from) && strtotime($record->Datums) <= strtotime($to)): ?>
                <tr>
                    <td>
                        <?php echo date_format(date_create(substr($record->Datums, 0, "15")), "d-m-y"); ?>
                    </td>
                    <td>
                        <?php echo $record->TestuSkaits; ?>
                    </td>
                    <td>
                        <?php echo $record->ApstiprinataCOVID19InfekcijaSkaits; ?>
                    </td>
                    <td>
                        <?php echo $record->Ipatsvars; ?>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </table>
</body>
</html>