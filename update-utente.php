<?php
/**
 * Un form per modificare i dettagli dell'utente.
 *
 */
require '../contact/config.php';
require '../contact/common.php';

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();
  
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $utente =[
      "id"          => $_POST['id'],
      "nome"        => $_POST['nome'],
      "cognome"     => $_POST['cognome'],
      "email"       => $_POST['email'],
      "telefono"    => $_POST['telefono'],
      "indirizzo"   => $_POST['indirizzo'],
      "date"        => $_POST['date']
    ];
    $sql = "UPDATE utenti 
            SET id = :id, 
              nome = :nome, 
              cognome = :cognome, 
              email = :email, 
              telefono = :telefono, 
              indirizzo = :indirizzo, 
              date = :date 
            WHERE id = :id";
  
  $statement = $connection->prepare($sql);
  $statement->execute($utente);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
  
if (isset($_GET['id'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $id = $_GET['id'];
    $sql = "SELECT * FROM utenti WHERE id = :id";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();
    
    $utente = $statement->fetch(PDO::FETCH_ASSOC);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
} else {
    echo "Qualcosa è andato storto!!! :(";
    exit;
}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) : ?>
	<blockquote><?php echo escape($_POST['nome']); ?> è stato aggiornato correttamente.</blockquote>
<?php endif; ?>

<h2>Modica un contatto</h2>

<form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <?php foreach ($utente as $key => $value) : ?>
      <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
	    <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo escape($value); ?>" <?php echo ($key === 'id' ? 'readonly' : null); ?>>
    <?php endforeach; ?> 
    <input type="submit" name="submit" value="Procedi">
</form>

<a href="index.php">Torna alla home</a>

<?php require "templates/footer.php"; ?>