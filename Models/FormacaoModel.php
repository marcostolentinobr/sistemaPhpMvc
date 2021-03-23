<?php

class FormacaoModel extends Model {

    public $tabela = 'FORMACAO';
    public $ID_CHAVE = 'ID_FORMACAO';
    public $buscarCampos = ['F.NOME'];

    public function listar() {
        $sql = "
            SELECT F.*,
                   CONCAT(F.NOME,' (', F.PONTO, ')') AS NOME_PONTO,  
                   (SELECT COUNT(*) FROM PESSOA_FORMACAO PF WHERE PF.ID_FORMACAO = F.ID_FORMACAO) AS ITEM_UTILIZADO
              FROM FORMACAO F 
        ";
        $this->addOrder('F.PONTO DESC');

        return $this->listaRetorno($sql);
    }

}
