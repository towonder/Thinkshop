<?php
Configure::write('Config.language', 'eng');
?>
<h2><?php __('Thinkshop installeren')?></h2>
<div id="installdiv">
<p><?php __('Thinkshop heeft nog geen database connectie en goede veiligheidsinstellingen.')?></p>

<a href="install" onClick="doSubmit()" class="giant pill button"><?php __('Begin met installeren')?></a>
</div>