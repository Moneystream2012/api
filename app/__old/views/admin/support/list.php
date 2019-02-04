<?php
/* @var $this yii\web\View */

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
	box-shadow: none;
}
</style>
<!-- Header -->
<?php echo $this->render('../../admin/common/_header.php'); ?>
<!-- Main -->
<main id="main">
	<div class="container">
		<div class="row">
			<div class="col-md-2">
				<!-- Nav -->
				<?php echo $this->render('../../admin/common/_navbar', ['active' => 'support']); ?>
			</div>
			<h1 class="page-title">Support rooms</h1>
			<div class="row pull-left">
				<div class="col-md-8 " style="margin: 15px;">
					<form class="form-inline" method="post"  onsubmit="searchRoomByAddress(); return false;">
						<div class="input-group" style="width: 350px; border: 1px solid #24e1ba; border-radius: 3px;">
							<input  class="form-control " style=" height: 35px; background: #46484b; border: none; color: #24e1ba; box-shadow: none" type="text" id="userAddress" >
							<div class="input-group-addon" style="background: #46484b; border:none; padding: 1px;"><button id="search-buttom" ><i style="	box-shadow: none;" class="material-icons">search</i></button></div>
						</div>
					</form>
				</div>
			</div>
			<div class="col-md-8">
				<!-- Support Section -->
				<section class="support-section">
					<?php
						if (isset($supportRooms) && count($supportRooms) > 0) {
								 // var_dump($supportRooms); 
							foreach ($supportRooms as $supportRoom) {
								 // var_dump($messages[$supportRoom->id]); 
								?>
								
									<div class="row" id="room-<?php echo $supportRoom->id; ?>">
						
										<div class="col-md-11" style="padding-right: 0;">
											<a href="<?php echo Url::to(['admin/support/room', 'id'=> $supportRoom['id']]);?>" style="max-width: 725px;border-radius:   3px 0 3px 3px;" class="support-item <?php //if($supportRoom->closed < 	$messages[$supportRoom->id]['created']){ echo "new"; } ?> ">
												<div class="avatar"><i class="material-icons">person</i></div>
												<div class="address">
													<!-- 1DKSt2yjJhrZBdz1r3AkUkKTMauwX3nanJ -->
													<!-- 
													<?php //$userId = $supportRoom->user_id - 1; ?> -->
													 <?php //echo $users[$i]['address']; ?>
													 <?php  echo $users[$supportRoom->user_id] ;?>
													<?php if($supportRoom->status == '1'){?>
														<div class="status "><i class="material-icons">check</i></div>
													<?php
													}else if($supportRoom->status == '0'){?>
														<div class="status unconfirmed"><i class="material-icons">close</i></div>
													<?php } ?>
												</div>
												<div class="text">
													<?php echo isset($messages[$supportRoom->id]) ? "<p >(".date("d-m-y H:i", $messages[$supportRoom->id]['created']).")</p> <p>".substr($messages[$supportRoom->id]['message'], 0, 80)."</p> " : '<br>';; ?>
													<!-- <p><?php //echo  date("d-m-y H:i", $supportRoom->created); //echo " closed ----- created ".date("d-m-y H:i",$messages[$supportRoom->id]['created']) ?></p> -->
													<!-- <p>Crafted Recipes line-up are so packed with toppings that you'll need a sp...</p> -->
													<!-- <?php //echo  1?>  -->
												</div>
												<div class="date-time"><?php echo date("d-m-y H:i", $supportRoom['created']); ?></div>
											</a>
										</div>
										<div class="col-md-1" style="padding-left: 0;">
											<button class="btn btn-danger" style=" border-radius: 0 3px 3px 0;" onclick="closeRoom(<?php echo $supportRoom->id; ?>)">X</button>
										</div>
									</div>
								<?php
							}
						}
					?>
					<!-- <a href="#" class="support-item new">
						<div class="avatar"><i class="material-icons">person</i></div>
						<div class="address">
							1DKSt2yjJhrZBdz1r3AkUkKTMauwX3nanJ
							<div class="status unconfirmed"><i class="material-icons">close</i></div>
						</div>
						<div class="text">
							<p>McDonald's wants to get the word out that sandwiches in its new Signature </p>
							<p>Crafted Recipes line-up are so packed with toppings that you'll need a sp...</p>
						</div>
						<div class="date-time">12-12-34 12:54</div>
					</a> -->
					<div class="paginationAll"> 
					<?php
						echo LinkPager::widget([
							'pagination' => $pagination,
							'registerLinkTags' => true
						]);
					?>
					</div>
				</section>
			</div>
		</div>
	</div>
</main>
<!-- Footer -->
<footer id="footer">
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-2">
				<div class="copyright"></div>
			</div>
		</div>
	</div>
</footer>