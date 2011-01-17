<?php if($showSearch == true):?>
<form id="searchform" action="<?php echo HOME?>/winkel/zoeken/" method="get">
	<input type="text" name="q" value="Zoeken..." id="searchinput" onclick="doSmartEmpty('#searchinput', 'Zoeken...')">
</form>
<?php endif; ?>
