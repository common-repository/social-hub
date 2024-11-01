
<!-- horizontal style-1 -->
<div id="sssb-social">
	<div class="sssb-horizontal">
	    <ul class='<?= $data->panelStyle; ?>'>

			<?php if(isset($data->socialList['social'])) : foreach ($data->socialList['social'] as $network => $network_info) : ?>
		        <li>
		            <a class="<?= $network; ?> <?= $data->panelSize; ?>"
		            	href="<?= $network_info['link']; ?>" 
		            	alt="Share on Facebook" title="Share on Facebook"
		            	target="blank"
		            >
						<!-- <?= $network; ?> -->
						<span class="socicon socicon-<?= $network; ?>"></span>
		            </a>
		        </li>
			<?php endforeach; endif; ?>

	    </ul>
	</div>
</div>



