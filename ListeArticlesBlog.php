<?php

require("dbConnect.php");

try {
    $requete = 'SELECT wp_posts.id as id
                     , post_title
                     , post_content
                     , post_date
                     , wp_users.display_name
                  from wp_posts, wp_users
                 where post_author = wp_users.id
                   and post_type = "post"
                   and post_status = "publish"
                 order by post_date DESC
                 ';
    $req = $dbh->query($requete);
    $req->setFetchMode(PDO::FETCH_ASSOC);

    $tab = $req->fetchAll();
    $req->closeCursor();

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Le titre</title>
    </head>

    <body>
        <!-- method par defaut = GET -->
        <form action="search.php" method="">
            <label for="search">Recherche : </label>
            <input type="text" name="s" id="search">
            <!-- <input type="Submit" value="Valider"> -->
            <button type="submit" class="btn btn-primary mt-5">Valider</button>
        </form>


        <h1>Test : affich qlq articles de la table wp_post</h1>

        <?php foreach ($tab as $row) { ?>
            <h2><a href="Article.php?id=<?= $row["id"] ?>"> <?= $row["post_title"] ?></a></h2>
            <p><?= $row["post_content"] ?></p>
            <p>Ecrit par : <?= $row["display_name"] ?> - Le : <?= $row["post_date"] ?></p>
        <?php } ?>
    </body>

    </html>

<?php

    $dbh = null;
    // echo "<br>" . "Connection Terminée";
} catch (PDOException $e) {
    print "Erreur sur la requete : " . $e->getMessage() . "<br/>";
    die();
}
