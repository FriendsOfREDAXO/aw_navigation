<?php

/**
 * aw Navigation.
 *
 * @author Wolfgang Bund agile-websites.de
 *
 * @package redaxo5
 */

echo rex_view::title('aw Navigation');

$outtext = file_get_contents('src/addons/awnav/help.php');

$fragment = new rex_fragment();
$fragment->setVar('body', $outtext, false);
$content = $fragment->parse('core/page/section.php');

echo $content;
