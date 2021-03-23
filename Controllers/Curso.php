<?php

class Curso extends Controller {

    protected $descricao = 'Curso';

    //DADOS
    protected function validaSetDados() {

        //NOME - Obrigatório e até 100 caracteres
        $this->dado['NOME'] = ucwords(mb_strtolower(campo($_POST['NOME'], 'S')));
        $this->campoValidacao('NOME');

        //NOME unico
        if (!$this->erro) {
            if ($this->Model->descricaoExistente(['NOME' => $this->dado['NOME']])) {
                $this->erro['Nome'] = 'Já cadastrado';
            }
        }

        return $this->dadosValidacao();
    }

}
