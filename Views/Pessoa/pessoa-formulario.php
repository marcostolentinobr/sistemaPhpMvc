<!-- NOME -->
<? $campo = ['NOME', 'Nome', 'text', 100, ' required minlength="3" class="nomeSobrenome" onblur="return validaNomeSobrenome(NOME)" minlength="3" '] ?>
<label for="<?= $campo[0] ?>" ><?= $campo[1] ?></label>
<input type="<?= $campo[3] ?>" id="<?= $campo[0] ?>"  name="<?= $campo[0] ?>" value="<?= @$this->dado[$campo[0]] ?>" maxlength="<?= $campo[2] ?>" <?= $campo[4] ?> ><br>

<!-- CURSO -->
<? $campo = ['ID_CURSO', 'Curso', 'select', '', ' required '] ?>
<label for="<?= $campo[0] ?>" ><?= $campo[1] ?>:</label>
<select id="<?= $campo[0] ?>" name="<?= $campo[0] ?>" <?= $campo[4] ?>>
    <option></option>
    <? foreach ($this->cursoLista as $curso) { ?>
        <option value="<?= $curso[$campo[0]] ?>" <?= (@$this->dado[$campo[0]] == $curso[$campo[0]] ? 'selected' : '') ?>><?= $curso['NOME'] ?></option>
    <? } ?>
</select><br>

<!-- FORMAÇÃO -->
<? $campo = ['ID_FORMACAO', 'Formação', 'select', '', ' multiple '] ?>
<label for="<?= $campo[0] ?>" style="font-weight: normal"><?= $campo[1] ?>:</label>
<select id="<?= $campo[0] ?>[]" name="<?= $campo[0] ?>[]" <?= $campo[4] ?>>
    <? foreach ($this->formacaoLista as $formacao) { ?>
        <option value="<?= $formacao[$campo[0]] ?>" <?= (isset($this->pessoaFormacaoLista[$formacao[$campo[0]]]) ? 'selected' : '') ?>><?= $formacao['NOME'] ?></option>
    <? } ?>
</select><br>

<!-- ARQUIVO -->
<? $campo = ['ARQUIVO', 'Comprovante de título', 'file', '', ' multiple '] ?>
<label for="<?= $campo[0] ?>" style="font-weight: normal"><?= $campo[1] ?>:</label>
<input type="<?= $campo[2] ?>" id="<?= $campo[0] ?>[]" name="<?= $campo[0] ?>[]" <?= $campo[4] ?>><br>

<?
if ($this->acaoDescricaoPost == 'Editar') {
    echo '<small style="color:red">Para ver ou editar arquivos clique no nome da pessoa</small><br>';
}
?>

<!-- OBSERVACAO -->
<? $campo = ['OBSERVACAO', 'Observação', 'textarea', '1000', ' style="height: 100px" ']; ?>
<label for="<?= $campo[0] ?>" style="font-weight: normal"><?= $campo[1] ?>:</label>
<textarea maxlength="<?= $campo[3] ?>" id="<?= $campo[0] ?>" name="<?= $campo[0] ?>" <?= $campo[4] ?>><?= @$this->dado[$campo[0]] ?></textarea>
