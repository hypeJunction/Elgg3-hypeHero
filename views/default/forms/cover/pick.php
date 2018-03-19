<?php

$entity = elgg_extract('entity', $vars);

echo elgg_view_field([
	'#type' => 'hidden',
	'name' => 'guid',
	'value' => $entity->guid,
]);

$library = elgg()->{'cover.library'};
/* @var $library \hypeJunction\Hero\CoverLibrary */

$images = $library->getImages();

shuffle($images);
$images = array_slice($images, 0, 120);
?>

<div class="hero-cover-libary">
	<?php
	foreach ($images as $image) {
		?>
        <div>
			<?php
			echo elgg_format_element('input', [
				'type' => 'radio',
				'name' => 'uid',
				'value' => $image->uid,
				'id' => $image->uid,
				'class' => 'hero-cover-library-input',
			])
			?>
            <label for="<?= $image->uid ?>" class="hero-cover-library-image"
                   style="background-image:url(<?= $image->getURL(1000, 200) ?>">
				<?php
				echo elgg_view('input/submit', [
					'#type' => 'submit',
					'value' => elgg_echo('hero:cover:use'),
					'class' => 'hero-cover-pick-confirm',
				]);
				?>
                <div class="hero-cover-library-attribution">
					<?php
					if ($image->author || $image->author_url) {
						$author_link = elgg_view('output/url', [
							'text' => $image->author ? : elgg_echo('hero:cover:unknown'),
							'href' => $image->author_url ? : '#',
							'class' => 'hero-cover-library-author',
						]);
						echo elgg_echo('hero:cover:library:author', [$author_link]);
					}

					if ($image->provider || $image->provider_url) {
						echo elgg_view('output/url', [
							'text' => $image->provider ? : elgg_echo('hero:cover:source'),
							'href' => $image->provider_url ? : '#',
							'class' => 'hero-cover-library-provider',
						]);
					}
					?>
                </div>
            </label>
        </div>
		<?php
	}
	?>
</div>
