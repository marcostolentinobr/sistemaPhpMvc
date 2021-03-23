<a href="<?= URL ?>Index">INÍCIO</a> |
<? if (isset($_SESSION['USUARIO'])) { ?>
    <a href="<?= URL ?>Curso/listar">CURSO</a> |
    <a href="<?= URL ?>Formacao/listar">FORMAÇÃO</a> |
    <a href="<?= URL ?>Pessoa/listar">PESSOA</a> |
    <?
    echo '
            <small 
                class="sublinhadoPontilhadoPointer"
                title="Clique para alterar a senha&#013;' . getSession('NOME') . ' (' . campo(getSession('CPF'), 'CPF') . ')" 
            >
                <a href="' . URL . 'Usuario/alterarSenha">(' . reticencias(getSession('NOME'), 10) . ')</a>
            </small>
        ';
    ?>
    <small> <a href="<?= URL ?>Login/sair"><sup>Sair</sup></a> </small>
<? } else { ?>
    <a href="<?= URL ?>Usuario/listar">USUARIO</a> |
<? } ?>