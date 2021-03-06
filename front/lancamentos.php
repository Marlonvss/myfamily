<?php
$Controll = new CONTROLLERlancamentos();
error_reporting(E_ERROR);
session_start();

if (isset($_GET['remove'])) {
    $erro = $Controll->Remove($_GET['remove']);
    if ($erro->erro) {
        echo $erro->mensagem;
    }
}

function MakeLinkOptionsLancamento($id) {
    return
            '<button type="button" class="my_btn btn btn-link btn-md" onclick="loadEdit(' . $id . ')" data-toggle="modal" data-target="#editar"><i class="fa fa-folder-open-o" aria-hidden="true"></i></button>' .
            '<button type="button" class="my_btnbtn btn-link btn-md" onclick="loadDelete(' . $id . ')" data-toggle="modal" data-target="#deletar"><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
}

//Recupera todos Centros de custos
$ctrlCentroCusto = new CONTROLLERcentroscustos();
$erro = $ctrlCentroCusto->RecuperaLista($listCentroCusto);
if ($erro->erro) {
    echo $erro->mensagem;
}

//Recupera todas Classificações financeiras
$ControllClassificacao = new CONTROLLERclassificacoesfinanceiras();
$erro = $ControllClassificacao->RecuperaLista($listClassificacoes);
if ($erro->erro) {
    echo $erro->mensagem;
}
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#novo">Novo</button>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <td class="col-md-1">#</td>
                        <td class="col-md-5">Descrição</td>
                        <td class="col-md-1">Data</td>
                        <td class="col-md-1">Valor</td>
                        <td class="col-md-2">C. Custo</td>
                        <td class="col-md-1">Título</td>
                        <td class="col-md-1">Opções</td>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $erro = $Controll->RecuperaListaMesCorrente($List);
                    if ($erro->erro) {
                        echo $erro->mensagem;
                    } else {
                        foreach ($List as &$obj) {

                            $txtCentroCusto = '';
                            if ($obj->id_centrocusto > 0) {
                                $ctrlCentroCusto->LocateIDInList($obj->id_centrocusto, $listCentroCusto, $centroCusto);
                                $txtCentroCusto = $centroCusto->descricao;
                            }

                            $txtImagem = '';
                            if ($obj->id_classificacaofinanceira > 0) {
                                $ControllClassificacao->LocateIDInList($obj->id_classificacaofinanceira, $listClassificacoes, $Classificacao);
                                $txtImagem = '<i class="fa ' . $Classificacao->imagem . '"></i> - ';
                            };

                            $txtValor = $obj->valor;
                            if ($obj->sinal == 0) {
                                $txtValor = $obj->valor * -1;
                            };

                            $txtTitulo = '';
                            if ($obj->id_titulo > 0) {
                                $txtTitulo = '<button type="button" class="my_btn btn btn-link btn-md" onclick="viewTitulo(' . $obj->id_titulo . ')" data-toggle="modal" data-target="#titulo_visualizar"><i class="fa fa-barcode" aria-hidden="true"></i></button>';
                            }

                            echo '<tr>'
                            . '<td>' . $obj->id . '</td>'
                            . '<td>' . $txtImagem . $obj->descricao . '</td>'
                            . '<td>' . date('d/m/Y', strtotime($obj->data)) . '</td>'
                            . '<td>R$ ' . number_format($txtValor, 2, ',', '.') . '</td>'
                            . '<td>' . $txtCentroCusto . '</td>'
                            . '<td>' . $txtTitulo . '</td>'
                            . '<td>' . MakeLinkOptionsLancamento($obj->id) . '</td>'
                            . '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" data-backdrop="static" id="novo" tabindex="-1" role="dialog" aria-labelledby="novoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php include 'lancamentos_add.php'; ?>
        </div>
    </div>
</div>

<div class="modal fade" data-backdrop="static" id="editar" tabindex="-1" role="dialog" aria-labelledby="editarLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php include 'lancamentos_edit.php'; ?>
        </div>
    </div>
</div>

<div class="modal fade" data-backdrop="static" id="deletar" tabindex="-1" role="dialog" aria-labelledby="deletarLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php include 'lancamentos_del.php'; ?>
        </div>
    </div>
</div>