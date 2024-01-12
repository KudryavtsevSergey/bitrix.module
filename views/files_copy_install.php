<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();

use Bitrix\Main\Localization\Loc;
use Sun\BitrixModule\Installer\AbstractFilesCopyInstaller;
use Sun\BitrixModule\Installer\InstallerInterface;
use Sun\BitrixModule\Installer\SuccessRedirectInstaller;

/** @var string $moduleId */
/** @var string $stepValue */

Loc::loadMessages(__FILE__);

if (isset($_SESSION[$moduleId]) && $_SESSION[$moduleId] === SuccessRedirectInstaller::SUCCESS) {
    unset($_SESSION[$moduleId]);
    CAdminMessage::ShowNote(Loc::getMessage('SUCCESS_MESSAGE'));
}
?>

<form method="POST">
  <?= bitrix_sessid_post() ?>
  <input type="hidden" name="id" value="<?= $moduleId ?>">
  <input type="hidden" name="<?= InstallerInterface::STEP_FIELD; ?>" value="<?= $stepValue; ?>">

  <div class="adm-detail-content-wrap">
    <div class="adm-detail-content">
      <div class="adm-detail-title"><?= Loc::getMessage('FILES_COPY_SETTINGS') ?> <?= $moduleId; ?></div>
      <div class="adm-detail-content-item-block">
        <table class="adm-detail-content-table edit-table">
          <tbody>
          <tr>
            <td style="width: 50%" class="adm-detail-content-cell-l">
              <?= Loc::getMessage('IS_COPY_FILES') ?>
              <br />
              <?= $stepValue; ?>
            </td>
            <td style="width: 50%" class="adm-detail-content-cell-r">
              <input
                type="checkbox"
                id="is_copy_files"
                name="<?= AbstractFilesCopyInstaller::IS_COPY_FILES_FIELD_NAME ?>"
                checked
                class="adm-designed-checkbox"
              />
              <label class="adm-designed-checkbox-label" for="is_copy_files"></label>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="adm-detail-content-btns-wrap" id="tabControl_buttons_div" style="left: 0;">
      <div class="adm-detail-content-btns">
        <input
          type="submit"
          value="<?= Loc::getMessage('SAVE'); ?>"
          title="<?= Loc::getMessage('SAVE'); ?>"
          class="adm-btn-save"
        />
      </div>
    </div>
  </div>
</form>
