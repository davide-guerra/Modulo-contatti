<?php

/**
  * Riceerca informazioni sulla base di un parametro (esempio: indirizzo).
  */

require '../contact/config.php';
require '../contact/common.php';

if (isset($_POST['submit'])) {
    if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

    try {
    

    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT *
    FROM utenti
    WHERE indirizzo = :indirizzo";

    $indirizzo = $_POST['indirizzo'];

    $statement = $connection->prepare($sql);
    $statement->bindParam(':indirizzo', $indirizzo, PDO::PARAM_STR);
    $statement->execute();

    $result = $statement->fetchAll();
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}
?>
<?php require "templates/header.php"; ?>

<?php
if (isset($_POST['submit'])) {
  if ($result && $statement->rowCount() > 0) { ?>
    <h2>Risultati</h2>

    <table>
      <thead>
<tr>
  <th>#</th>
  <th>Nome</th>
  <th>Cognome</th>
  <th>Email</th>
  <th>Telefono</th>
  <th>Indirizzo</th>
  <th>Data</th>
</tr>
      </thead>
      <tbody>
  <?php foreach ($result as $row) { ?>
      <tr>
<td><?php echo escape($row["id"]); ?></td>
<td><?php echo escape($row["nome"]); ?></td>
<td><?php echo escape($row["cognome"]); ?></td>
<td><?php echo escape($row["email"]); ?></td>
<td><?php echo escape($row["telefono"]); ?></td>
<td><?php echo escape($row["indirizzo"]); ?></td>
<td><?php echo escape($row["date"]); ?> </td>
      </tr>
    <?php } ?>
      </tbody>
  </table>
  <?php } else { ?>
    > Nessun risultato trovato per <?php echo escape($_POST['indirizzo']); ?>.
  <?php }
} ?>

<h2>Cerca un utente per indirizzo</h2>

<form method="post">
  <label for="indirizzo">Indirizzo</label>
  <input type="text" id="indirizzo" name="indirizzo">
  <input type="submit" name="submit" value="Vedi i risultati">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
</form>

<a href="index.php">Torna alla home</a>

<?php require "templates/footer.php"; ?>