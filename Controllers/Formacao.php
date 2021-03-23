<?php

class Formacao extends Controller {

    protected $descricao = 'Formação';

    //DADOS
    protected function validaSetDados() {

        //NOME - Obrigatório e até 100 caracteres
        $this->dado['NOME'] = ucwords(mb_strtolower(campo($_POST['NOME'], 'S')));
        $this->campoValidacao('NOME');

        //PONTO - Obrigatório e até 100 caracteres
        $this->dado['PONTO'] = trim($_POST['PONTO']);
        $this->campoValidacao('PONTO', 3, true, true);

        //Nome unico
        if (!$this->erro) {
            if ($this->Model->descricaoExistente(['NOME' => $this->dado['NOME']])) {
                $this->erro['Nome'] = 'Já cadastrado';
            }
        }

        //Ponto unico
        if (!$this->erro) {
            if ($this->Model->descricaoExistente(['PONTO' => $this->dado['PONTO']])) {
                $this->erro['Ponto'] = 'Já cadastrado';
            }
        }

        return $this->dadosValidacao();
    }

}
