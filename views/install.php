<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/** @var ?string $postInstallCommand */

CAdminMessage::ShowNote(Loc::getMessage('SUCCESS_MESSAGE'));

if (isset($postInstallCommand)) {
    echo sprintf('<pre>%s</pre>', print_r($postInstallCommand, 1));
}
