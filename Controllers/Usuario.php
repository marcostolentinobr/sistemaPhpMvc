<?php

class Usuario extends Controller {

    protected $descricao = 'Usuário';
    protected $sistemaLargura = 200;
    protected $listarMostrar = false;

    //DADOS
    protected function validaSetDados() {

        //SENHA - Obrigatório e até 20 caracteres
        $this->dado['SENHA'] = campo($_POST['SENHA']);
        $this->campoValidacao('SENHA', 20);

        //Caso exista a variavel SENHA_ATUAL então é alteração de senha
        if (isset($_POST['SENHA_ATUAL'])) {
            //Senha tem que ser a mesma que a senha da sessão
            if ($_POST['SENHA_ATUAL'] != getSession('SENHA')) {
                $this->erro['CPF'] = 'Senha atual inválida';
            }
        } else {
            //NOME - Obrigatório e até 50 caracteres
            $this->dado['NOME'] = ucwords(mb_strtolower(campo($_POST['NOME'], 'S')));
            $this->campoValidacao('NOME', 50, true, false, 7);
            if (!nomeSobreNomeValidar($this->dado['NOME'])) {
                $this->erro['Nome'] = 'É necessário nome e sobrenome';
            }

            //CPF - Obrigatório e válido
            $this->dado['CPF'] = ucwords(mb_strtolower(campo($_POST['CPF'], 'I')));
            if (!cpfValidar($this->dado['CPF'])) {
                $this->erro['CPF'] = 'CPF inválido';
            }

            //Nome unico
            if (!$this->erro) {
                if ($this->Model->descricaoExistente(['CPF' => $this->dado['CPF']])) {
                    $this->erro['Nome'] = 'Já cadastrado';
                }
            }
        }

        return $this->dadosValidacao();
    }

    public function alterarSenha() {
        $this->dado = getSession();
        $this->valorChave = $this->dado['ID_USUARIO'];
        $this->action = 'Usuario/alterarSenha';
        $this->requireForm('senha', 'Alterar');
    }

    protected function executaPosAcao() {
        if ($this->ok == 1 && getSession()) {
            setSession('SENHA', $this->dado['SENHA']);
        }
    }

}
