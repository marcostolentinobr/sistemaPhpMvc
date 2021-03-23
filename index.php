<? require_once 'config.php' ?>

<title><?= TITULO ?></title>
<base href="<?= URL ?>" />
<link href="libs/estilo.css" rel="stylesheet">
<meta content="width=device-width, initial-scale=1.0" name="viewport">

<center>
    <BR>
    <?
    require_once 'Views/viewMenu.php';
    echo '<BR>';
    require_once 'Views/viewConteudo.php';
    ?>
</center>

<script src="libs/script.js"></script>