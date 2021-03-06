<?php
/**
 * @package    solo
 * @copyright  Copyright (c)2014-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license    GNU GPL version 3 or later
 */

use Awf\Text\Text;

defined('_AKEEBA') or die();

/** @var   \Solo\View\Update\Html  $this */

$router = $this->container->router;
$product = Text::_('SOLO_APP_TITLE')
?>
<div class="akeeba-block--failure" id="solo-error-update-stuck">
	<h3>
		<?php echo Text::_('SOLO_UPDATE_STUCK_HEAD') ?>
	</h3>

	<p><?php echo Text::_('SOLO_UPDATE_STUCK_INFO'); ?></p>

	<p><?php echo Text::sprintf('SOLO_UPDATE_NOTSUPPORTED_ALTMETHOD', $product); ?></p>

	<p class="liveupdate-buttons">
		<a href="<?php echo $router->route('index.php?view=update&force=1') ?>" class="akeeba-btn--primary">
			<span class="akion-refresh"></span>
			<?php echo Text::_('SOLO_UPDATE_REFRESH_INFO') ?>
		</a>
	</p>
</div> 
