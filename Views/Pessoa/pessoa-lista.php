<?
require_once __DIR__ . '/../template/templateBusca.php';

$ascDesc = 'DESC';
if (isset($_GET['order'])) {
    $campoOrder = explode('@', $_GET['order']);
    if ($campoOrder[1] == $ascDesc) {
        $ascDesc = 'ASC';
    }
}
?>
<table class="table">
    <thead>
        <tr>
            <th><a href='<?= URL_ATUAL . "&order=P.NOME@{$ascDesc}" ?>'>Nome</a></th>
            <th><a href='<?= URL_ATUAL . "&order=CUR_NOME@{$ascDesc}" ?>'>Curso</a></th>
            <th><a href='<?= URL_ATUAL . "&order=FORMACAO_QUANTIDADE@{$ascDesc}" ?>'>Formações</A></th>
            <th><a href='<?= URL_ATUAL . "&order=FORMACAO_PONTOS@{$ascDesc}" ?>'>Pontos</a></th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <? foreach ($this->dadoLista as $dado) { ?>
            <tr>
                <td>
                    <span class="sublinhadoPointer" 
                          title="<?= "$dado[NOME]&#013;Observação: $dado[OBSERVACAO]" ?>" 
                          >
                        <a href="<?= URL . "Pessoa/detalhe/" . $dado['ID_PESSOA'] ?>"><?= reticencias($dado['NOME'], 15) ?></a>
                    </span>
                </td>
                <td><?= reticencias($dado['CUR_NOME'], 15) ?></td>
                <td><?
                    echo $dado['FORMACAO_QUANTIDADE'];
                    echo '
                    <small class="sublinhadoPontilhadoPointer" title="Quantidade de arquivos vinculados">
                        <small> (Arq: ' . count(mArquivosListar(RAIZ . "/arquivos/" . $dado['ID_PESSOA'])) . ')</small>
                    </small>
                ';
                    ?>
                </td>
                <td><?= $dado['FORMACAO_PONTOS'] ?></td>
                <td>
                    <?
                    if (getSession('ID_USUARIO') == $dado['ID_USUARIO']) {
                        require __DIR__ . '/../template/templateBotoes.php';
                    } else {
                        echo '
                        <small class="sublinhadoPontilhadoPointer"
                               title="Cadastrado por: ' . $dado['USU_NOME'] . '"
                        >
                                Não pode alterar
                        </small>
                    ';
                    }
                    ?>
                </td>
            </tr>
        <? } ?>
    </tbody>
</table>
<?
require_once __DIR__ . '/../template/templatePaginacao.php';
