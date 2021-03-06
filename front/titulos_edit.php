<script>

    function loadEdit(id) {
        $("#edt_id").prop('readonly', true).val('Carregando...');
        $("#edt_descricao").prop('readonly', true).val('Carregando...');
        $("#edt_vencimento").prop('readonly', true).val('Carregando...');
        $("#edt_valor").prop('readonly', true).val('Carregando...');
        $("#edt_valorpago").prop('readonly', true).val('Carregando...');
        $("#edt_quitado").prop('readonly', true).val('Carregando...');
        $("#edt_observacao").prop('readonly', true).val('Carregando...');
        $("#edt_id_classificacaofinanceira").prop('readonly', true).val('Carregando...');
        $("#edt_id_centrocusto").prop('readonly', true).val('Carregando...');
        $("#edt_id_familia").prop('readonly', true).val('Carregando...');
        $.ajax({
            url: 'front/titulos_services.php',
            type: 'post',
            dataType: 'json',
            data: {
                'id': id,
                'metodo': 'load'
            }
        }).done(function (data) {
            // Não permitir editar quando for título de Cartão.
            $ReadOnly = data.id_cartao > 0;
            $("#edt_id").val(data.id);
            $("#edt_descricao").prop('readonly', $ReadOnly).val(data.descricao);
            $("#edt_vencimento").prop('readonly', $ReadOnly).val(data.vencimento);
            $("#edt_valor").prop('readonly', $ReadOnly).val(data.valor);
            $("#edt_valorpago").prop('readonly', $ReadOnly).val(data.valorpago);
            $("#edt_quitado").prop('readonly', $ReadOnly).val(data.quitado);
            $("#edt_observacao").prop('readonly', $ReadOnly).val(data.observacao);
            $("#edt_id_classificacaofinanceira").prop('readonly', $ReadOnly).val(data.id_classificacaofinanceira);
            $("#edt_id_centrocusto").prop('readonly', $ReadOnly).val(data.id_centrocusto);
            $("#edt_id_familia").prop('readonly', $ReadOnly).val(data.id_familia);
        });
    }
    
    function edit() {
        $.ajax({
            url: 'front/titulos_services.php',
            type: 'post',
            dataType: 'html',
            data: {
                'id': $('#edt_id').val(),
                'descricao': $('#edt_descricao').val(),
                'vencimento': $('#edt_vencimento').val(),
                'valor': $('#edt_valor').val(),
                'valorpago': $('#edt_valorpago').val(),
                'quitado': $('#edt_quitado').val(),
                'observacao': $('#edt_observacao').val(),
                'id_classificacaofinanceira': $('#edt_id_classificacaofinanceira').val(),
                'id_centrocusto': $('#edt_id_centrocusto').val(),
                'metodo': 'edit'
            }
        }).done(function(e){
            location.reload();
        });
    }
</script>

<form class="form-horizontal" method="post" autocomplete="off">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        </button>
        <h4 class="modal-title" id="editarLabel">Editar tituloss</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label class="col-sm-2 control-label">ID</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="edt_id" name="id" placeholder="ID" value="Carregando..." readonly="readonly">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Descrição</label>
            <div class="col-sm-10">
                <input type="text" id="edt_descricao" class="form-control" name="Descricao" placeholder="Descrição" value="Carregando..." readonly="readonly">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Vencimento</label>
            <div class="col-sm-10">
                <input type="text" id="edt_vencimento" class="form-control datepicker" name="Vencimento" placeholder="Vencimento" value="Carregando..."  readonly="readonly">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Valor</label>
            <div class="col-sm-10">
                <input type="text" id="edt_valor" class="form-control" name="Valor" placeholder="Valor" value="Carregando..."  readonly="readonly">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Valor pago</label>
            <div class="col-sm-10">
                <input type="text" id="edt_valorpago" class="form-control" name="ValorPago" placeholder="Valor pago" value="Carregando..."  readonly="readonly">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Quitado?</label>
            <div class="col-sm-10">
                <input type="text" id="edt_quitado" class="form-control" name="Quitado" placeholder="Quitado?" value="Carregando..."  readonly="readonly">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Cl. Financeira</label>
            <div class="col-sm-10">
                <select name="id_classificacaofinanceira" class="form-control" id="edt_id_classificacaofinanceira">
                    <?php
                    $Controll = new CONTROLLERclassificacoesfinanceiras;
                    $erro = $Controll->RecuperaLista($List);
                    if ($erro->erro) {
                        echo $erro->mensagem;
                    } else {
                        echo '<option value="0"></option>';
                        foreach ($List as &$obj) {
                            echo '<option value="' . $obj->id . '">' . $obj->descricao . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">C. Custo</label>
            <div class="col-sm-10">
                <select name="id_centrocusto" class="form-control" id="edt_id_centrocusto">
                    <?php
                    $Controll = new CONTROLLERcentroscustos;
                    $erro = $Controll->RecuperaLista($List);
                    if ($erro->erro) {
                        echo $erro->mensagem;
                    } else {
                        echo '<option value="0"></option>';
                        foreach ($List as &$obj) {
                            echo '<option value="' . $obj->id . '">' . $obj->descricao . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" onclick="edit()" class="btn btn-primary" data-dismiss="modal">Salvar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
    </div>
</form>
