<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

?>


<style>
#search-buttom {
    display: inline-block;
    vertical-align: top;
    margin: 0;
    padding: 0;
    text-align: left;
    background: none;
        

    height: 20px;
    border:none;
	color: #24e1ba;

}
</style>
<!-- Header -->
<?php echo $this->render('../../admin/common/_header.php'); ?>
<main id="main">
	<div class="container">
		<div class="row">
			<div class="col-md-2">
		<!-- Nav -->
		<?php echo $this->render('../../admin/common/_navbar', ['active' => 'users']); ?>
	</div>

	<div class="col-md-10" id="information">
		<section class="table-section table-with-tabs">
		<h1 class="page-title">Users</h1>
		<div class="row pull-right">
			<div class="col-md-12 " style="margin-bottom: 15px;">
				<form class="form-inline" method="post"  onsubmit="searchUserByAddress(); return false;">
					<div class="input-group" style="width: 350px; border: 1px solid #24e1ba; border-radius: 4px;">
						<input  class="form-control " style=" height: 35px; background: #46484b; border: none; color: #24e1ba; box-shadow: none" type="text" id="userAddress" >
						<div class="input-group-addon" style="background: #46484b; border:none; padding: 1px;"><button id="search-buttom" ><i class="material-icons">search</i></button></div>
					</div>
				</form>
			</div>
		</div>
<!-- 			<div class="row">
	<div class="col-md-12">
		<h4 class="table-title">Users</h4>
		<ul class="nav nav-tabs">
		<li <?php if (!isset($_GET['status'])) echo 'class="active"'; ?> ><?php echo Html::a("All <span>($allUsers)</span> ", ['admin/user/index']); ?></li>
		<li <?php if (isset($_GET['status']) &&  $_GET['status'] == 1) echo 'class="active"'; ?> ><?php echo Html::a("Confirmed <span>($confirmedUsers)</span> ", ['admin/user/index','status'=>1]); ?></li>
		<li <?php if (isset($_GET['status']) &&  $_GET['status'] == 0) echo 'class="active"'; ?> ><?php echo Html::a("Unconfirmed <span>($unconfirmedUsers)</span> ", ['admin/user/index','status'=>0]); ?></li>
		</ul>
	</div>
</div> -->
			<div class="tab-content">
				<div id="tab1" class="tab-pane fade in active">
					<table class="table border-rounded-table">
						<thead>
							<tr>
								<th>Created</th>
								<th>Adress</th>
								<th>Balance<i class="material-icons">arrow_drop_down</i></th>
								<th>On parkings</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
			                <?php
								if (isset($users) && count($users) > 0) {
									foreach ($users as $user) {
										?>
											<tr>
												<td><?php echo date("d:m:Y H:i:s", $user->created); ?></td>
												<td><?php echo Html::a($user->address, ['admin/user/view', 'id'=>$user->id], ['class' => 'address-link'] )	; ?></td>
												<td><?php echo $user->balance; ?></td>
												<td><?php echo $user->balance; ?></td>
												<td><a href="<?php echo Url::to(['admin/notification/index','id'=>$user->id]) ?>" class="cancel-link">Message</a></td>
											</tr>
										<?php
									}
								}
							?>
						</tbody>
					</table>
					<div class="paginationAll"> 
					<?php
						// отображаем постраничную разбивку
						echo LinkPager::widget([
							'pagination' => $pages,
							'registerLinkTags' => true
						]);
					?>
					</div>
				</div>
			</div>
		</section>
	</div>
		</div>
	</div>
</main>











<!-- 		<p><span>Users</span>
		<span id="right-panel">
			<b>
				All(<span><?php //echo Html::a($allUsers , Url::to(['admin/user/index'])); ?></span>)
			</b>
			<b>
				Confirmed(<span><?php //echo Html::a($confirmedUsers , Url::to(['admin/user/index','status'=>1])); ?></span>)
			</b>
			<b>
				Unconfirmed(<span><?php //echo Html::a($unconfirmedUsers , Url::to(['admin/user/index','status'=>0])); ?></span>)
			</b>
		</span></p> -->
		
<!-- 		<table class="table borderless">
			<thead>
				<tr id="table-head">
					<th>Created</th>
					<th>Adress</th>
					<th>Balance</th>
					<th>On parkings</th>
					<th>Action</th>

				</tr>
			</thead>
			<tbody>
				<?php
					// if (isset($users) && count($users) > 0) {
					// 	foreach ($users as $user) {
							?>
								<tr>
									<td><?php echo date("d:m:Y H:i:s", $user->created); ?></td>
									<td><?php echo Html::a($user->address, Url::to(['admin/user/view', 'id'=>$user->id])); ?></td>
									<td><?php echo $user->balance; ?></td>
									<td><?php echo $user->balance; ?></td>
									<td><?php echo $user->status; ?></td>
								</tr>
							<?php
					// 	}
					// }
				?>
			</tbody>
		</table> -->
<!-- 	</div>
</div> -->