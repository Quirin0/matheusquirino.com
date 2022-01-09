<div id="addEmployeeModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post">
                <div class="modal-header">						
                    <h4 class="modal-title">Adicionar</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">					
                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Link da Imagem</label>
                        <input type="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Descricao</label>
                        <textarea class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Link do projeto</label>
                        <input type="text" class="form-control" required>
                    </div>					
                    <div class="form-group">
                        <label>Categoria do projeto</label>
                        <input type="text" class="form-control" required>
                    </div>					
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                    <input type="submit" class="btn btn-success" name="adicionar" value="Pronto">
               
                </div>
            </form>
        </div>
    </div>
</div>