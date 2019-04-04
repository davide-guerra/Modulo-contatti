<?php
/**
 * Elenca tutti i contatti con un link per la modifica dei dettagli
 */
require '../contact/config.php';
require '../contact/common.php';
try {
  $connection = new PDO($dsn, $username, $password, $options);
  $sql = "SELECT * FROM utenti";
  $statement = $connection->prepare($sql);
  $statement->execute();
  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>
        
<h2>Modifica un contatto</h2>

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
            <th>Modifica</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row) : ?>
        <tr>
            <td><?php echo escape($row["id"]); ?></td>
            <td><?php echo escape($row["nome"]); ?></td>
            <td><?php echo escape($row["cognome"]); ?></td>
            <td><?php echo escape($row["email"]); ?></td>
            <td><?php echo escape($row["telefono"]); ?></td>
            <td><?php echo escape($row["indirizzo"]); ?></td>
            <td><?php echo escape($row["date"]); ?> </td>
            <td><a href="update-utente.php?id=<?php echo escape($row["id"]); ?>">Modifica</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<a href="index.php">Torna alla home</a>

<?php require "templates/footer.php"; ?>