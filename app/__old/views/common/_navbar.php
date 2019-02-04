<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

if (!isset($active)) $active = '';

$notification = $this->context->getService('Notification')->notificationOfANewNtice();
$notSeen = $notification['notSeenNotification'] 
//if($notSeen > 0 ) 
?>

<!-- Sidebar -->
<aside id="sidebar">
	<nav class="left-menu">
		<ul>
			<li <?php if ($active == 'dashboard') echo 'class="active"'; ?>><?php echo Html::a('<i class="material-icons">dashboard</i> <span>Dashboard</span>', Url::to(['user/dashboard/index'])); ?></li>
			<li <?php if ($active == 'parkings') echo 'class="active"'; ?>><?php echo Html::a('<i class="material-icons my-icon">P</i><span>Parkings</span>', Url::to(['user/parking/index','status'=>1])); ?></li>
			<li <?php if ($active == 'payouts') echo 'class="active"'; ?>><?php echo Html::a('<i class="material-icons">list</i><span>Payouts</span>', Url::to(['user/payout/index'])); ?></li>
			<li <?php if ($active == 'notifications') echo 'class="active"'; ?>><a href="<?php echo Url::to(['user/notification/index']); ?> "> <i class="material-icons <?php if($notSeen > 0 ) echo 'new-message'; ?>">notifications</i><span>Notifications</span> </a></li>
			<li <?php if ($active == 'support') echo 'class="active"'; ?>><?php echo Html::a('<i class="material-icons">forum</i><span>Support</span>', Url::to(['support/index'])); ?></li>
			<li <?php if ($active == 'setting') echo 'class="active"'; ?>><?php echo Html::a('<i class="material-icons">setting</i><span>Setting</span>', Url::to(['user/setting/index'])); ?></li>
			<li><?php if (Yii::$app->user->identity->role == 1) echo Html::a('<i class="material-icons">dashboard</i><span>Admin</span>', Url::to(['admin/dashboard/index'])); ?></li>
		</ul>
	</nav>
<!-- $notification['notSeenNotification'] -->
</aside>
