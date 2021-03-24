<?php

class PessoaModel extends Model {

    public $tabela = 'PESSOA';
    public $ID_CHAVE = 'ID_PESSOA';
    public $buscarCampos = ['P.NOME', 'C.NOME'];
    //PessoaFormacao
    private $PessoaFormacao;

    public function __construct($pdo = '', $valorBuscar = '') {
        parent::__construct($pdo, $valorBuscar);
        $this->PessoaFormacao = instanciaModel('PessoaFormacao', $this->pdo());
    }

    public function listar() {
        $sql = "
            SELECT P.*,
                   C.NOME AS CUR_NOME,
                   (SELECT COUNT(*) FROM PESSOA_FORMACAO PF WHERE PF.ID_PESSOA = P.ID_PESSOA) AS FORMACAO_QUANTIDADE,
                   (    SELECT COALESCE(SUM(F.PONTO),0) 
                          FROM PESSOA_FORMACAO PF 
                          JOIN FORMACAO F
                            ON F.ID_FORMACAO = PF.ID_FORMACAO
                          WHERE PF.ID_PESSOA = P.ID_PESSOA
                    ) AS FORMACAO_PONTOS,
                   0 AS ITEM_UTILIZADO,
                   U.NOME AS USU_NOME
              FROM PESSOA P 
              JOIN CURSO C
                ON C.ID_CURSO = P.ID_CURSO
              JOIN USUARIO U
                ON U.ID_USUARIO = P.ID_USUARIO
        ";

        if (isset($_GET['order'])) {
            $campoOrder = explode('@', $_GET['order']);
            $this->addOrder("$campoOrder[0] $campoOrder[1]");
        }

        $this->addOrder('FORMACAO_PONTOS DESC');
        $this->addOrder('C.NOME');

        return $this->listaRetorno($sql);
    }

    public function incluir($valores, $tabela = '') {
        $okPessoa = parent::incluir($valores, $tabela);
        $id_pessoa = $this->pdo()->lastInsertId();
        if ($okPessoa) {
            $this->PessoaFormacao->incluirPessoaFormacao($id_pessoa);
        }
        return $okPessoa;
    }

    public function alterar($dado, $tabela = '') {
        $okPessoa = parent::alterar($dado);
        if ($okPessoa) {
            $this->PessoaFormacao->incluirPessoaFormacao($_POST['ID_PESSOA']);
        }
        return $okPessoa;
    }

    public function excluir($tabela = '') {
        $okPessoaExcluir = parent::excluir();
        if ($okPessoaExcluir) {
            $this->PessoaFormacao->valorChave = $_POST['ID_PESSOA'];
            return $this->PessoaFormacao->excluir();
        }
        return $okPessoaExcluir;
    }

}
