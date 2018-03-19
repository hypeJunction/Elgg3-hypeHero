<?php

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof ElggEntity) {
	return;
}

if ($entity instanceof ElggSite) {
    return;
}

$cover_url = $entity->getIconUrl([
	'type' => 'cover',
	'size' => 'hero',
]);


$gravity = $cover->{'cover:gravity'} ? : 'center';

$positions = [
	'center' => '50% 50%',
	'north' => '50% 0',
	'east' => '100% 50%',
	'south' => '50% 100%',
	'west' => '0% 50%',
];

$cover = elgg_format_element('div', [
	'class' => [
		'cover-image',
	],
	'style' => [
		"background-image: url({$cover_url});",
		"background-position: {$positions[$gravity]};",
	],
]);

$icon = elgg_view('page/elements/hero/icon', $vars);
$title = elgg_view('page/elements/hero/title', $vars);
$description = elgg_view('page/elements/hero/subtitle', $vars);

$menu = elgg()->menus->getUnpreparedMenu('owner_block', [
	'entity' => $entity,
]);

$tabs = elgg_view_menu('hero', [
	'items' => $menu->getItems(),
	'entity' => $entity,
	'class' => 'elgg-menu-hz',
	'sort_by' => 'priority',
]);

$edit = elgg_view_menu('cover', [
	'entity' => $entity,
	'class' => 'elgg-menu-hz',
]);

$actions = elgg_view_menu('actions', [
	'entity' => $entity,
	'class' => 'elgg-menu-hz',
]);

?>
<div class="cover-hero">
	<?= $cover ?>
    <div class="cover-hero-header">
        <div class="elgg-inner">
			<?= $edit ?>
        </div>
    </div>
    <div class="cover-hero-body">
        <div class="elgg-inner">
            <div class="elgg-image-block cover-owner-details">
                <div class="elgg-image">
					<?= $icon ?>
                </div>
                <div class="elgg-body">
                    <h3 class="cover-owner-name">
						<?= $title ?>
                    </h3>
					<?php
					if ($description) {
						?>
                        <div class="cover-owner-description">
							<?= $description ?>
                        </div>
						<?php
					}
					?>
                </div>
            </div>
            <div class="cover-owner-actions">
                <?= $actions ?>
            </div>
        </div>
    </div>
    <div class="cover-hero-footer">
        <div class="elgg-inner">
            <?= elgg_view('page/elements/hero/cover_attribution', $vars) ?>
			<?= $tabs ?>
        </div>
    </div>
</div>
