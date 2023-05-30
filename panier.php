<?php
session_start();
include_once "con_dbb.php";

// Supprimer les produits
// Vérifier si la variable 'del' existe dans la requête GET
if (isset($_GET['del'])) {
    $id_del = $_GET['del'];

    // Vérifier si l'élément existe dans le panier
    if (isset($_SESSION['panier'][$id_del])) {
        unset($_SESSION['panier'][$id_del]);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="panier">
    <a href="index.php" class="link">Boutique</a>
    <section>
        <table>
            <tr>
                <th></th>
                <th>Nom</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Action</th>
            </tr>
            <?php
            $total = 0;

            // Vérifier si le panier est vide
            if (empty($_SESSION['panier'])) {
                echo "<tr><td colspan='5'>Votre panier est vide</td></tr>";
            } else {
                $ids = array_keys($_SESSION['panier']);

                // Récupérer les informations des produits à partir de la base de données
                $product_ids = implode(',', $ids);
                $products = mysqli_query($con, "SELECT * FROM products WHERE id IN ($product_ids)");

                foreach ($products as $product):
                    $quantity = $_SESSION['panier'][$product['id']];
                    $subtotal = $product['prix'] * $quantity;
                    $total += $subtotal;
                    ?>
                    <tr>
                        <td><img src="project_images/<?= $product['img'] ?>" alt="Image du produit"></td>
                        <td><?= $product['noms'] ?></td>
                        <td><?= $product['prix'] ?>€</td>
                        <td><?= $quantity ?></td>
                        <td><a href="panier.php?del=<?= $product['id'] ?>"><img src="delete.png" alt="Supprimer"></a></td>
                    </tr>
                <?php endforeach;
            }
            ?>

            <tr class="total">
                <th>Total : <?= $total ?>€</th>
            </tr>
        </table>
    </section>
</body>
</html>