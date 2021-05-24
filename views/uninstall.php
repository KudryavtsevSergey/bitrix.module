<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/** @var ?Throwable $moduleException */

CAdminMessage::ShowNote(GetMessage('SUCCESS_MESSAGE'));

if (isset($moduleException)) {
    echo sprintf('<pre>%s</pre>', print_r($moduleException, 1));
}
