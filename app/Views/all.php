<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All</title>
</head>
<body>
    <table>
        <tr>
            <th>No.</th>
            <th>Nama</th>
            <th>Harga</th>
        </tr>
        <?php foreach ($all as $no => $row): ?>
        <tr>
            <td><?php echo $no+1 ?></td>
            <td><?php echo $row['name'] ?></td>
            <td><?php echo $row['price'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>