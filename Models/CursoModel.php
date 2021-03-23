<?php

class CursoModel extends Model {

    public $tabela = 'CURSO';
    public $ID_CHAVE = 'ID_CURSO';
    public $buscarCampos = ['C.NOME'];

    public function listar() {
        $sql = "
            SELECT C.*,
                   (SELECT COUNT(*) FROM PESSOA P WHERE P.ID_CURSO = C.ID_CURSO) AS ITEM_UTILIZADO
              FROM CURSO C 
        ";

        return $this->listaRetorno($sql);
    }

}
