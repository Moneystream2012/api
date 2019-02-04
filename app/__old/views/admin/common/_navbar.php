<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;





if (!isset($active)) $active = '';

?>

<!-- Sidebar -->
<aside id="sidebar">
	<nav class="left-menu">
		<ul>
			<li <?php if ($active == 'dashboard') echo 'class="active"'; ?>><?php echo Html::a('<i class="material-icons">dashboard</i><span>Dashboard</span>', Url::to(['admin/dashboard/index'])); ?></li>
			<li <?php if ($active == 'users') echo 'class="active"'; ?>><?php echo Html::a('<i class="material-icons">person</i><span>Users</span>', Url::to(['admin/user/index'])); ?></li>
			<li <?php if ($active == 'support') echo 'class="active"'; ?>><?php echo Html::a('<i class="material-icons">forum</i><span>Support</span>', Url::to(['admin/support/list'])); ?></li>
			<li <?php if ($active == 'notifications') echo 'class="active"'; ?>><?php echo Html::a('<i class="material-icons">notifications</i><span>Notifications</span>', Url::to(['admin/notification/index'])); ?></li>
			<li <?php if ($active == 'subscribers') echo 'class="active"'; ?>><?php echo Html::a('<i class="material-icons">create</i><span>Subscribers</span>', Url::to(['admin/subscriber/list'])); ?></li>
			<li <?php if ($active == 'parkings') echo 'class="active"'; ?>><?php echo Html::a('<i class="material-icons my-icon">P</i><span>Parkings</span>', Url::to(['admin/parking/list','status'=>1])); ?></li>
			<li <?php if ($active == 'payouts') echo 'class="active"'; ?>><?php echo Html::a('<i class="material-icons">list</i><span>Payouts</span>', Url::to(['admin/payout/index'])); ?></li>
			<li <?php if ($active == 'debts') echo 'class="active"'; ?>><?php echo Html::a('<i class="material-icons my-icon">D</i><span>Debts</span>', Url::to(['admin/parking/debts'])); ?></li>
			<li <?php if ($active == 'setting') echo 'class="active"'; ?>><?php echo Html::a('<i class="material-icons">setting</i><span>Setting</span>', Url::to(['admin/setting/index'])); ?></li>
			<li><?php echo Html::a('<i class="material-icons">dashboard</i><span>User</span>', Url::to(['user/dashboard/index'])); ?></li>
		</ul>
	</nav>
</aside>
	

<!-- 
<div class="sidebar-nav">
	<ul class="nav nav-list">
		<li class="active"><?php //echo Html::a('Dashboard', Url::to(['admin/dashboard/index'])); ?></li>
		<li><?php //echo Html::a('Users', Url::to(['admin/user/index'])); ?></li>
		<li><?php //echo Html::a('Support <span class="badge pull-right">1</span>', Url::to(['admin/support/list'])); ?></li>
		<li><?php //echo Html::a('Notifications <span class="badge pull-right">1</span>', Url::to(['admin/notification/index'])); ?></li>
		<li><?php //echo Html::a('Subscribers', Url::to(['admin/subscriber/list'])); ?></li>
		<li><?php //echo Html::a('Parkings', Url::to(['admin/parking/list'])); ?></li>
		<li><?php //echo Html::a('Debts', Url::to(['admin/parking/debts'])); ?></li>
	</ul>
</div> -->