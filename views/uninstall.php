<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/** @var ?Throwable $moduleException */

CAdminMessage::ShowNote(Loc::getMessage('SUCCESS_MESSAGE'));

if (isset($moduleException)) {
    echo sprintf('<pre>%s</pre>', print_r($moduleException, 1));
}
