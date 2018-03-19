<?php

$entity = elgg_extract('entity', $vars);
?>
<div class="cover-attribution">
	<?php
	if ($entity->{'cover:author'} || $entity->{'cover:author_url'}) {
		$author_link = elgg_view('output/url', [
			'text' => $entity->{'cover:author'} ? : elgg_echo('hero:cover:unknown'),
			'href' => $entity->{'cover:author_url'} ? : '#',
			'class' => 'cover-author',
		]);
		echo elgg_echo('hero:cover:library:author', [$author_link]);
	}

	if ($entity->{'cover:provider'} || $entity->{'cover:provider_url'}) {
		echo elgg_view('output/url', [
			'text' => $entity->{'cover:provider'} ? : elgg_echo('hero:cover:source'),
			'href' => $entity->{'cover:provider_url'} ? : '#',
			'class' => 'cover-provider',
		]);
	}
	?>
</div>