<?php

class Pessoa extends Controller {

    protected $descricao = 'Pessoa';
    //Curso
    private $Curso;
    protected $cursoLista;
    //Formacao
    protected $Formacao;
    protected $formacaoLista;
    //PessoaFormacao
    protected $PessoaFormacao;
    public $pessoaFormacaoLista;

    public function __construct() {
        parent::__construct();

        //Caso a ação tenha dado ok e tenha arquivo enviar o arquivo
        if ($this->ok && @$_FILES['ARQUIVO']['name'][0]) {
            $ARQ = $_FILES['ARQUIVO'];
            $chave = coalesce(@$this->valorChave, $this->Model->ultimoInsertId());

            foreach ($ARQ['name'] as $ind => $nome) {
                $extencao = strtolower(pathinfo($nome, PATHINFO_EXTENSION));
                $arq_local = RAIZ . "/arquivos/{$chave}_" . date('Ymd_His') . "_$ind.$extencao";
                if (!move_uploaded_file($ARQ['tmp_name'][$ind], $arq_local)) {
                    echo '
                        <h1 style="color: red">
                            Cadastrado mais talvez haja arquivos que não foi enviado, tente novamente.
                        </h1>
                    ';
                }
            }
        }

        $this->PessoaFormacao = instanciaModel('PessoaFormacao');

        //instancia de curso e formação
        $this->Curso = instanciaModel('Curso');
        $this->cursoLista = $this->Curso->listar();

        //Quando for para editar setar os dados de formação vinculado a pessoa
        $this->setFormacao();

        if ($this->acaoDescricaoPost == 'Editar') {
            $this->setPessoaFormacao();
        }

        //Excluir arquivo
        foreach ($_POST as $dado => $valor) {
            if (strpos(base64_decode($dado), 'XCLUIR-' . CHAVE) == 1) {
                $ARQ = str_replace('EXCLUIR-', '', base64_decode($dado));
                $ARQ_FILE = RAIZ . "/arquivos/" . $ARQ;
                IF (file_exists($ARQ_FILE)) {
                    unlink($ARQ_FILE);
                }
            }
        }
    }

    //DADOS
    protected function validaSetDados() {

        //OBSERVACAO opcional e ate 1000 caracteres
        $this->dado['OBSERVACAO'] = trim($_POST['OBSERVACAO']);
        if (!$this->dado['OBSERVACAO']) {
            $this->dado['OBSERVACAO'] = 'NULL';
        }
        $this->campoValidacao('OBSERVACAO', 1000, false);

        //NOME - Obrigatório e até 100 caracteres
        $this->dado['NOME'] = ucwords(mb_strtolower(campo($_POST['NOME'], 'S')));
        $this->campoValidacao('NOME', 50, true, false, 3);
        if (!nomeSobreNomeValidar($this->dado['NOME'])) {
            $this->erro['Nome'] = 'É necessário nome e sobrenome';
        }

        //ID_CURSO - Obrigatório
        $this->dado['ID_CURSO'] = $_POST['ID_CURSO'];
        $this->campoValidacao('ID_CURSO', 3, true, true);

        //ID_USUARIO - Obrigatório
        $this->dado['ID_USUARIO'] = getSession('ID_USUARIO');
        $this->campoValidacao('ID_USUARIO');

        //NOME unico
        if (!$this->erro) {
            if ($this->Model->descricaoExistente(['P.NOME' => $this->dado['NOME']])) {
                $this->erro['Nome'] = 'Já cadastrado';
            }
        }

        return $this->dadosValidacao();
    }

    public function setFormacao() {
        $this->Formacao = instanciaModel('Formacao');
        $this->Formacao->keyChave = true;
        $this->formacaoLista = $this->Formacao->listar();
    }

    public function templateLista() {
        require __DIR__ . '/../Views/' . CLASSE . '/' . strtolower(CLASSE) . '-lista.php';
    }

    public function setPessoaFormacao() {
        $this->PessoaFormacao->addWhere($this->ID_CHAVE, coalesce(CHAVE, @$_POST['ID_PESSOA']));
        $pessoaFormacaoLista = $this->PessoaFormacao->listar();
        foreach ($pessoaFormacaoLista as $pessoaFormacao) {
            $this->pessoaFormacaoLista[$pessoaFormacao['ID_FORMACAO']] = $pessoaFormacao;
        }
    }

    public function detalhe() {
        $this->setPessoaFormacao();
        $this->Model->addWhere($this->ID_CHAVE, CHAVE);
        $this->dado = $this->Model->listar()[0];
        $this->action = 'Pessoa/detalhe/' . CHAVE;
        $this->requireForm('detalhe', 'Detalhe', false);
    }

}
