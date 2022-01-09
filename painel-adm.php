<?php
require_once "includes/config.php";

?>


<!DOCTYPE html>
<html lang="en">

<head>    
    <? include_once 'painel/includes/head.php'; ?>
</head>
<body>
    <div class="container">
		<div class="table-responsive">
			<div class="table-wrapper">
				<div class="table-title">
					<div class="row">
						<div class="col-xs-6">
							<h2>Painel <b>Administrativo</b></h2>
						</div>
						<div class="col-xs-6">
							<a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Adicionar</span></a>
							<a href="#deleteEmployeeModal" class="btn btn-danger" data-toggle="modal"><i class="material-icons">&#xE15C;</i> <span>Deletar</span></a>						
						</div>
					</div>
				</div>
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th>
								<span class="custom-checkbox">
									<input type="checkbox" id="selectAll">
									<label for="selectAll"></label>
								</span>
							</th>
							<th>Nome</th>
							<th>Descrição</th>
							<th>Imagem</th>
							<th>Categoria</th>
							<th>Link</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
                    <?php 
                        $file = file_get_contents("./json/projetos.json");
						$projetos = json_decode($file, true);
				

					// PARA ADICIONAR MAIS UM PROJETO NO JSON
					if(isset($_POST['adicionar'])) { 
						
						$dados = ["nome"=>"teste", "link"=>"", "descricao"=>"teste descricao","categoria"=>"html","imagem"=>""];
						array_push($projetos['projetos'], $dados);

						$myjson = json_encode($projetos);
						file_put_contents("./json/projetos.json",$myjson);
					} 

					$x = count($projetos['projetos']);
					
					for ($i = 0; $i < $x; $i++) {

					?>
						<tr>
							<td>
								<span class="custom-checkbox">
									<input type="checkbox" id="checkbox1" name="options[]" value="1">
									<label for="checkbox1"></label>
								</span>
							</td>
							<td><?= $projetos['projetos'][$i]['nome'] ?></td>
							<td><?= $projetos['projetos'][$i]['descricao']?></td>
							<td><?= $projetos['projetos'][$i]['imagem']?></td>
							<td><?= $projetos['projetos'][$i]['categoria']?></td>
							<td><?= $projetos['projetos'][$i]['link']?></td>
							<td>
								<a href="#editEmployeeModal" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
								<a href="#deleteEmployeeModal" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
							</td>
						</tr>
					<?php } ?>
					</tbody>
				</table>

                <!-- PAGINACAO -->
				<!-- <div class="clearfix">
					<div class="hint-text"><b>5</b> de <b>25</b> páginas</div>
					<ul class="pagination">
						<li class="page-item disabled"><a href="#">Anterior</a></li>
						<li class="page-item"><a href="#" class="page-link">1</a></li>
						<li class="page-item"><a href="#" class="page-link">2</a></li>
						<li class="page-item"><a href="#" class="page-link">3</a></li>
						<li class="page-item"><a href="#" class="page-link">4</a></li>
						<li class="page-item active"><a href="#" class="page-link">5</a></li>
						<li class="page-item"><a href="#" class="page-link">Próximo</a></li>
					</ul>
				</div> -->


			</div>
		</div>        
    </div>
	<!-- Modal de Adicionar -->
	<? include_once 'painel/adicionar.php'; ?>
	<!-- Edit Modal HTML -->
	<? include_once 'painel/editar.php'; ?>
	<!-- Delete Modal HTML -->
	<? include_once 'painel/deletar.php'; ?>

	<script>
		// para evitar reenviar formulario ao apertar para voltar ou dar reload na página
	if ( window.history.replaceState ) {
		window.history.replaceState( null, null, window.location.href );
	}
	</script>
</body>

</html>