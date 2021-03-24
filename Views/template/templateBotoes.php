
<form method="POST" style="display: inline">
    <input name="<?= $this->ID_CHAVE ?>" value="<?= $dado[$this->ID_CHAVE] ?>" hidden>
    <? if (isset($dado['ITEM_UTILIZADO']) && !$dado['ITEM_UTILIZADO']) { ?>
        <input id="ACAO" name="ACAO" value="Editar" type="submit"><br>
        <input id="ACAO" name="ACAO" value="Excluir" type="submit">
    <? } ?>
</form>