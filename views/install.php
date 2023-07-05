<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/** @var string|null $postInstallCommand */

CAdminMessage::ShowNote(Loc::getMessage('SUCCESS_MESSAGE'));

if (!empty($postInstallCommand)) {
    echo sprintf('<pre>%s</pre>', print_r($postInstallCommand, true));
}
