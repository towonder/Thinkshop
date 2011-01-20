<?php if($showSearch == true):?>
<form id="searchform" action="<?php echo HOME?>/winkel/zoeken/" method="get" id="searchform">
	<div id="searchdiv">
		<div id="searchhotspot" onClick="$('#searchform').submit();"> </div>
		
		<input type="text" name="q" value="Zoeken..." id="searchinput" onclick="doSmartEmpty('#searchinput', 'Zoeken...')">
	</div>
</form>
<?php endif; ?>
