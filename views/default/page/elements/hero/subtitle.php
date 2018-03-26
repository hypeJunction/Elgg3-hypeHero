<?php

$entity = elgg_extract('entity', $vars);

if ($entity instanceof ElggObject) {
	echo elgg_view('object/elements/imprint', $vars);
} else {
	echo elgg_view('page/elements/hero/imprint', $vars);
}