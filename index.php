<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutique</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <a href="panier.php" class="link">Panier<span><?= isset($_SESSION['panier']) ? array_sum($_SESSION['panier']) : 0 ?></span></a>
    <section class="products_list">
        <?php 
        include_once "con_dbb.php";
        $req = mysqli_query($con, "SELECT * FROM products");

        if ($req && mysqli_num_rows($req) > 0) {
            while ($row = mysqli_fetch_assoc($req)) {
        ?>
        <form action="" class="product">
            <div class="image_product">
                <img src="project_images/<?= $row['img'] ?>" alt="Image du produit">
            </div>
            <div class="content">
                <h4 class="noms"><?= $row['noms'] ?></h4>
                <h2 class="prix"><?= $row['prix'] ?>€</h2>
                <a href="ajouter_panier.php?id=<?= $row['id'] ?>" class="id_product">Ajouter au panier</a>
            </div>
        </form>
        <?php 
            }
        } else {
            echo "Aucun produit trouvé.";
        }
        ?>
    </section>
</body>
</html>