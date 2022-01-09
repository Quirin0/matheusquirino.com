<!DOCTYPE html>
<html>
<head>
	<meta charset="iso-8859-1">
	<link rel="stylesheet" type="text/css" href="estilo.css">
	<link rel="icon" type="image/png" href="img/icone.png">
	<title>Setup</title>
</head>

<body>
	<?php
	  include("navbar.inc"); 
	?>

	<div class="conteudo">
		<h1>Setup</h1>
		<?php
		  $usuario="super";
		  $senha="12345678"; //NUNCA USE ESSA SENHA!!!
		  if(!isset($_SERVER["PHP_AUTH_USER"]))
		  {
		  	header("WWW-Authenticate: Basic Realm=\"Identifique-se \"");
		  	header("HTTP/1.0 401 Unauthorized");
		  	print("<p>Cancelado pelo usu�rio.</p>");
		  }
		  else
		  {
		  	if(($_SERVER["PHP_AUTH_USER"]==$usuario) AND
		  	  ($_SERVER["PHP_AUTH_PW"]==$senha))
		  	  {
		  	  	print("<p>Acesso autorizado.</p>");

		  	  	require("conexao.php");

		  	  	$query="CREATE DATABASE terra";
		  	  	if(mysqli_query($conn,$query))
		  	  	  print("<p>Banco de dados 'Terra' criado com sucesso.</p>");
		  	  	else
		  	  	  print("<p>Erro ao criar o banco de dados. Mensagem do servidor: ".$conn->error."</p>");
                  
                mysqli_select_db($conn,"terra");
                $query="CREATE TABLE usuario(usu_email varchar(50) primary key,
                                             usu_nome varchar(100) not null,
                                             usu_senha varchar(50) not null,
                                             usu_tel int(11) not null,
                                             usu_nivel integer not null)";
                if(mysqli_query($conn,$query))
		  	  	  print("<p>Tabela 'usuario' criado com sucesso.</p>");
		  	  	else
		  	  	  print("<p>Erro ao criar a tabela. Mensagem do servidor: ".$conn->error."</p>");

		  	  	$senha1=md5("123");
		  	  	$query="INSERT INTO usuario VALUES ('admin@teste.com','Administrador','$senha1',1234,1)";
		  	  	if(mysqli_query($conn,$query))
		  	  	  print("<p>Usu�rio padr�o criado com sucesso.</p>");
		  	  	else
		  	  	  print("<p>Erro ao criar os usu�rio. Mensagem do servidor: ".$conn->error."</p>");

		  	  	$query="CREATE TABLE reserva(res_id integer primary  key auto_increment,
		  	                                 res_local varchar(100) not null,
		  	                                 res_data date not null,
		  	                                 res_msg varchar(400),
		  	                                 usu_email varchar(50) not null,
		  	                                 UNIQUE(res_data),
		  	                                 FOREIGN KEY(usu_email) REFERENCES usuario(usu_email))";
		  	    if(mysqli_query($conn,$query))
		  	  	  print("<p>Tabela 'reserva' criado com sucesso.</p>");
		  	  	else
		  	  	  print("<p>Erro ao criar a tabela. Mensagem do servidor: ".$conn->error."</p>");

		  	  }
		  	  else
		  	  {
		  	  	print("<p>Acesso negado.</p>");
		  	  }
		  }
		?>
	</div>
</body>
</html>