<?php
/**
 * Usa un form HTML per creare nuove voci
 * nella tabella degli utenti.
 *
 */

require '../contact/config.php';
require '../contact/common.php';

if (isset($_POST['submit'])) {
    if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();
   
    try  {
        $connection = new PDO($dsn, $username, $password, $options);
        
        $new_user = array(
            "nome" => $_POST['nome'],
            "cognome"  => $_POST['cognome'],
            "email"     => $_POST['email'],
            "telefono"       => $_POST['telefono'],
            "indirizzo"  => $_POST['indirizzo']
        );
        $sql = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "utenti",
                implode(", ", array_keys($new_user)),
                ":" . implode(", :", array_keys($new_user))
        );
        
        $statement = $connection->prepare($sql);
        $statement->execute($new_user);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) { ?>
    <blockquote><?php echo $_POST['nome']; ?> è stato correttamente aggiunto.</blockquote>
<?php } ?>

<h2>Aggiungi un utente</h2>

<form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <label for="nome">Nome</label>
    <input type="text" name="nome" id="nome">
    <label for="cognome">Cognome</label>
    <input type="text" name="cognome" id="cognome">
    <label for="email">Email</label>
    <input type="text" name="email" id="email">
    <label for="telefono">Telefono</label>
    <input type="text" name="telefono" id="telefono">
    <label for="location">Indirizzo</label>
    <input type="text" name="indirizzo" id="indirizzo">
    <input type="submit" name="submit" value="Aggiungi">
</form>

<a href="index.php">Torna alla home</a>

<?php require "templates/footer.php"; ?>