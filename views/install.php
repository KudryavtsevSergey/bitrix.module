<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/** @var ?string $postInstallCommand */

CAdminMessage::ShowNote(GetMessage('SUCCESS_MESSAGE'));

if (isset($postInstallCommand)) {
    echo sprintf('<pre>%s</pre>', print_r($postInstallCommand, 1));
}
