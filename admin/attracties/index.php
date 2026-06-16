<?php
session_start();
require_once '../backend/config.php';
if(!isset($_SESSION['user_id']))
{
    $msg = "Je moet eerst inloggen!";
    header("Location: $base_url/admin/login.php?msg=$msg");
    exit;
}
?>

<!doctype html>
<html lang="nl">

<head>
    <title>Attractiepagina / Admin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@400;600;700&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/css/normalize.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/css/main.css">
    <link rel="icon" href="<?php echo $base_url; ?>/favicon.ico" type="image/x-icon" />
</head>

<body>

    <?php require_once '../../header.php'; ?>
    <div class="container">

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <a href="create.php">Nieuwe attractie maken &gt;</a>
            <?php
            require_once '../backend/conn.php';
            // Opdracht: Sorteren op titel (ORDER BY title ASC)
            $query = "SELECT * FROM rides ORDER BY title ASC";
            $statement = $conn->prepare($query);
            $statement->execute();
            $rides = $statement->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <!-- Opdracht: Plaats bovenaan de tabel met attracties een teller -->
            <p class="attractie-teller">De lijst bevat <?php echo count($rides); ?> attracties</p>
        </div>

        <table>
            <tr>
                <th>Titel</th>
                <th>Themagebied</th>
                <th>Min. lengte</th>
                <th>Fastpass</th>
                <th>Actie</th>
            </tr>
            <?php foreach($rides as $ride): ?>
                <tr>
                    <td><?php echo $ride['title']; ?></td>
                    <td><?php echo ucfirst($ride['themeland']); ?></td>
                    <td><?php echo $ride['min_length'] . ' cm'; ?></td>
                    <td><?php echo $ride['fast_pass'] ? 'Ja' : 'Nee'; ?></td>
                    <td><a href="edit.php?id=<?php echo $ride['id']; ?>">aanpassen</a></td>
                </tr>
            <?php endforeach; ?>
        </table>

    </div>

</body>

</html>
