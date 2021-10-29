<?php

/**
 *
 * @package      OpenEMR
 * @link               https://www.open-emr.org
 *
 * @author    Sherwin Gaddis <sherwingaddis@gmail.com>
 * @copyright Copyright (c) 2021 Sherwin Gaddis <sherwingaddis@gmail.com>
 * @license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 *
 */


use OpenEMR\Menu\MenuEvent;
use OpenEMR\Services\Globals\GlobalSetting;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use OpenEMR\Events\Globals\GlobalsInitializedEvent;

function oe_module_batch_credit_card_menu_item(MenuEvent $event)
{
    $menu = $event->getMenu();
    $menuItem = new stdClass();
    $menuItem->requirement = 0;
    $menuItem->target = 'mod';
    $menuItem->menu_id = 'mod0';
    $menuItem->label = xlt("Batch Credit Card Module");
    $menuItem->url = "/interface/modules/custom_modules/oe-module-batching-creditcard/settings.php";
    $menuItem->children = [];
    $menuItem->acl_req = ["patients", "docs"];
    $menuItem->global_req = [];

    foreach ($menu as $item) {
        if ($item->menu_id == 'modimg') {
            $item->children[] = $menuItem;
            break;
        }
    }

    $event->setMenu($menu);

    return $event;
}

/**
 * @var EventDispatcherInterface $eventDispatcher
 * @var array                    $module
 * @global                       $eventDispatcher @see ModulesApplication::loadCustomModule
 * @global                       $module          @see ModulesApplication::loadCustomModule
 */

function createFaxModuleGlobals(GlobalsInitializedEvent $event)
{
    $select_array = array(0 => xl('Disabled'), 1 => xl('PayTrace'));
    $instruct = xl('Enable Credit Card Batch Support. Remember to setup credentials.');

    $event->getGlobalsService()->createSection("Modules", "Report");
    $setting = new GlobalSetting(xl('Enable Credit Card Batch Module'), $select_array, 1, $instruct);
    $event->getGlobalsService()->appendToSection("Modules", "oe_batch_creditcard_enable", $setting);

}

$eventDispatcher->addListener(MenuEvent::MENU_UPDATE, 'oe_module_batch_credit_card_menu_item');
$eventDispatcher->addListener(GlobalsInitializedEvent::EVENT_HANDLE, 'createFaxModuleGlobals');



