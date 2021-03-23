<?

class PessoaFormacaoModel extends Model {

    public $tabela = 'PESSOA_FORMACAO';
    public $ID_CHAVE = 'ID_PESSOA';

    public function incluirPessoaFormacao($id_pessoa) {
        $this->dado['ID_PESSOA'] = $id_pessoa;
        if (!parent::excluir()) {
            return 0;
        }
        if (isset($_POST['ID_FORMACAO'])) {
            foreach ($_POST['ID_FORMACAO'] as $ID_FORMACAO) {
                $this->dado['ID_FORMACAO'] = $ID_FORMACAO;
                if (!parent::incluir($this->dado)) {
                    return 0;
                }
            }
        }
    }

}
