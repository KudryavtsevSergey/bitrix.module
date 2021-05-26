<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use Sun\BitrixModule\Enum\OptionTypeEnum;
use Sun\BitrixModule\Installer\OptionsInstaller;
use Sun\BitrixModule\Installer\SuccessRedirectInstaller;
use Sun\BitrixModule\Option\OptionGroup;
use Sun\BitrixModule\Option\OptionUtils;
use Sun\BitrixModule\Option\OptionValue;
use Sun\BitrixModule\Option\SelectOption;
use Sun\BitrixModule\Option\TextOption;

/** @var OptionGroup[] $optionGroups */
/** @var OptionValue[] $optionValues */
/** @var string $moduleId */

Loc::loadMessages(__FILE__);

if (isset($_SESSION[$moduleId]) && $_SESSION[$moduleId] == SuccessRedirectInstaller::SUCCESS) {
  unset($_SESSION[$moduleId]);
  CAdminMessage::ShowNote(GetMessage('SUCCESS_MESSAGE'));
}
?>

<form method="POST">
  <?= bitrix_sessid_post() ?>
  <input type="hidden" name="id" value="<?= $moduleId ?>">
  <input type="hidden" name="<?= OptionsInstaller::STEP_FIELD; ?>" value="<?= OptionsInstaller::STEP_VALUE; ?>">

  <div class="adm-detail-content-wrap">
    <div class="adm-detail-content">
      <div class="adm-detail-title"><?= GetMessage('MODULE_SETTINGS') ?> <?= $moduleId; ?></div>
      <div class="adm-detail-content-item-block">
        <table class="adm-detail-content-table edit-table">
          <tbody>
          <? foreach ($optionGroups as $optionGroup): ?>
            <tr class="heading">
              <td colspan="2"><b><?= $optionGroup->getName(); ?></b></td>
            </tr>
            <? foreach ($optionGroup->getOptions() as $option): ?>
              <? $value = OptionUtils::getOptionValue($optionValues, $option); ?>
              <tr>
                <td class="adm-detail-content-cell-l">
                  <label for="<?= $option->getName() ?>">
                    <?= $option->getName(); ?>:
                  </label>
                </td>
                <td class="adm-detail-content-cell-r">
                  <? switch ($option->getType()):
                    case OptionTypeEnum::TEXT: ?>
                      <? /** @var TextOption $option */ ?>
                      <input
                        type="text"
                        size="30"
                        maxlength="255"
                        id="<?= $option->getName() ?>"
                        value="<?= $value ?>"
                        name="<?= $option->getName() ?>"
                      />
                      <? break;
                    case OptionTypeEnum::SELECT: ?>
                      <? /** @var SelectOption $option */ ?>
                      <select
                        id="<?= $option->getName() ?>"
                        name="<?= $option->getName() ?>"
                        class="typeselect"
                      >
                        <? foreach ($option->getValues() as $optionValue): ?>
                          <option
                            value="<?= $optionValue->getValue(); ?>"
                            <? if ($optionValue->getValue() == $value): ?>selected<? endif; ?>
                          ><?= $optionValue->getName(); ?></option>
                        <? endforeach; ?>
                      </select>
                      <? break;
                  endswitch; ?>
                </td>
              </tr>
            <? endforeach; ?>
          <? endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="adm-detail-content-btns-wrap" id="tabControl_buttons_div" style="left: 0;">
      <div class="adm-detail-content-btns">
        <input
          type="submit"
          value="<?= GetMessage('SAVE'); ?>"
          title="<?= GetMessage('SAVE'); ?>"
          class="adm-btn-save"
        >
      </div>
    </div>
  </div>
</form>
