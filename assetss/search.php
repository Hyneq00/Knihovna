<div class="conteiner">
    <?php foreach($book as $one_book): ?>
        <div class="vysledky">
            <?php
            $imagePath = "../uploads/".$one_book["image"];
            // Kontrola, zda je soubor k dispozici
            if (file_exists($imagePath) && $imagePath !== "../uploads/" ) {
                echo '<img src="'.$imagePath.'" alt="Muj Obrazek">';
            } else {
                // Pokud chybi fotka, zobraz jinou
                echo '<img src="../uploads/001.png" alt="Alternativni Obrazek">';
            }
            ?>
            <br>
            <h3>Název:  <?=htmlspecialchars($one_book["title"])?></h3>
            <h3>Autor:  <?=htmlspecialchars($one_book["author"])?></h3>
            <h3>Rok vydání:  <?=htmlspecialchars($one_book["year_of_publication"])?></h3>
            <h3>Žánr:  <?=htmlspecialchars($one_book["genre"])?></h3>
            <br>
            <?php
            if ($role === "admin") {
                echo '<a href="../admin/admin_kniha.php?id=<?=$one_book["id"]?>">Info</a>';
            } elseif ($role === "user")
                echo '<a href="admin_kniha.php?id=<?=$one_book["id"]?>">Info</a>';
            ?>

            <br>
        </div>
    <?php endforeach; ?>
</div>