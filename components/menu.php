<?php
require_once "includes/config.php";
?>
<div class="circle-menu bar">
    <div class="hamburger">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
    </div>
</div>
<div class="inner-menu js-menu">
    <ul class="nav">
        <li class="nav__item"><a href="home">Inicio</a></li>
        <li class="nav__item"><a href="formacao.php">Formação</a></li>
        <li class="nav__item"><a href="portfolio">Portfolio</a></li>
        <!-- <li class="nav__item"><a href="blog.php">Blog</a></li> -->
        <li class="nav__item"><a href="contato">Contato</a></li>
        <?php
            if(isset($_SESSION['login']) && $_SESSION['login']=='true'){ 
        ?>
            <li class="nav__item"><a href="sair.php">Sair</a></li>
        <?php }else{ ?>
            <li class="nav__item"><a href="login">Login</a></li>
        <?php } ?>
    </ul>
</div>
