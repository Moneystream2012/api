<?php
/**
 * @author Aleksey Kucherov <alex.rgb.kiev@gmail.com>
 * @date: 23.10.17
 */

// TODO: refactor test to work
$I = new AcceptanceTester($scenario);
$I->am('system administrator');
$I->wantTo('start payouts deamon');
//$I->runShellCommand('php bin/yii payout/run &');
//$I->runShellCommand('test');