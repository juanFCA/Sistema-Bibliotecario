<?php

require_once "view/template.php";
require_once "modelo/usuario.php";
require_once "dao/livroDAO.php";

template::header();
template::sidebar("principal");
template::mainpanel("Principal");

?>

<div class='content' xmlns="http://www.w3.org/1999/html">
    <div class='container-fluid'>
        <?php
            livroDAO::acervoCardsPaginado();
        ?>
    </div>
</div>

<?php
template::footer("Principal");
?>