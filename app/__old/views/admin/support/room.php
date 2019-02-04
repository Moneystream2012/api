<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

?>

<!-- Header -->
<?php echo $this->render('../common/_header.php'); ?>
<!-- Main -->
<main id="main">
	<div class="container">
		<div class="row">
			<div class="col-md-2">
				<!-- Nav -->
				<?php echo $this->render('../common/_navbar', ['active' => 'support']); ?>
			</div>
			<div class="col-md-7">
				<!-- Support Section -->
				<section class="notifications-section">
					<!-- <h1 class="page-title">Support</h1> -->
					<div class="messages-block">
						<div class="messages-top">
							<div class="address">
								<?php echo Html::a($user->address, Url::to(['admin/user/view', 'id'=>$user->id]), ['class' => 'address']); ?>
								<div class="status unconfirmed"><a href="#" onclick="closeRoom(<?php echo $_GET['id']; ?>)"><i class="material-icons">close</i></a></div>
							</div>
							<a href="<?php echo Url::to(['admin/support/list']);?>" class="back-link"><i class="material-icons">arrow_back</i><span>Back</span></a>
						</div>
						<div class="message-area" id="chat-room">
							<?php
							if (isset($messages) && count($messages) > 0) {
								foreach ($messages as $message) {
									?>
									<div class="message-item support-item" id="message-<?php echo $message->id; ?>">
										<?php if($message->user_id == Yii::$app->user->identity->id) {
											echo '<div class="avatar"><i>S</i></div>';
										} else {
											echo  '<div class="avatar" style="border-color:white; color:white;"><i class="material-icons">person</i></div>';
											} 
											?>
										<div class="top-place clearfix">
											<div class="left-side">

												<div class="login"><?php //echo $message->user_id; ?></div>
											</div>
											<div class="date"><?php echo date("d M Y H:i", $message->created); ?></div>
										</div>
										<?php if($message->user_id == Yii::$app->user->identity->id){ 
											echo  "<div class=\"text\" >".$message->message."</div></div>";
										} else { 
											echo  "<div class=\"text\" style=\"color:white;\">".$message->message."</div></div>";
											} 
								}
							}
							?>
						</div>
						<form class="add-message">
							<div class="form-group">
								<textarea name="message" id="chat-message" placeholder="Type your tex here..."></textarea>
								<button class="button-bordered send-button"  type="button" onclick="sendMessage();">Send</button>
							</div>
						</form>
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

<script>
		Array.prototype.remove= function(){
		    var what, a= arguments, L= a.length, ax;
		    while(L && this.length) {
		        what= a[--L];
		        while((ax= this.indexOf(what))!= -1) {
        		    this.splice(ax, 1);
        		}
    		}
    		return this;
		}

		var messagesIds = [];
		var biggestId = 0;
		var initChat = true;
		var userId = "<?php echo Yii::$app->user->identity->id; ?>";
		function sendMessage() {
			var message = $('#chat-message').val();
			if (!message) return;
			var data = {
				"message":message,
				"_csrf":app._csrf
			};

			$.post('?r=admin/support/write-message-by-support&id=<?php echo $id; ?>', data, function(response) {
				if (response.status) {
					updateMessages(response.data);
					$('#chat-message').val('');
				}
			});
		}

		function fetchMessages() {
			$.post('?r=admin/support/fetch-messages&id=<?php echo $id; ?>', {"_csrf":app._csrf}, function(response) {
				console.log(response);
				if (response.status) {
					updateMessages(response.data, true);
				}
			});
		}

		function time(e){
			var a = new Date(e * 1000);
			var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
			var year = a.getFullYear();
			var month = months[a.getMonth()];
			var date = ('0'+a.getDate()).slice(-2);
			var hour = a.getHours();
			var min = a.getMinutes();
			var time = date + ' ' + month + ' ' + year + ' ' + hour + ':' + min ;
			return time;
		}

		function structMessages(e){

			var newMessage = '<div class="message-item  support-item" id="message-'+e.id+'">';
			if(e.user_id === userId ) newMessage += '		<div class="avatar"><i>S</i></div>';
			else newMessage += '		<div class="avatar" style="border-color:white; color:white;"><i class="material-icons">person</i></div>';
			newMessage += '		<div class="top-place clearfix">';
			newMessage += '			<div class="left-side">';
			newMessage += '				<div class="login">'+/*e.user_id+*/'</div>';
			newMessage += '			</div>';
			newMessage += '			<div class="date">'+time(e.created)+'</div>';
			newMessage += '		</div>';
			newMessage += '		<div class="text">'+e.message+'</div>';
			newMessage += '		</div>';

			return newMessage;
		}

		function updateMessages(messages, update) {
			console.log(messages);
			update = update || false;
			var bufferIds = messagesIds.slice();

			if (messages.length > 0) {
				messages.map(function(e) {
					bufferIds.remove(e.id);

					if ($('#message-'+e.id).length != 0)
						return;

					if (e.id > biggestId) {
						$('#chat-room').append(structMessages(e));
						$('#chat-room').animate({scrollTop:999},0);
			// $('.message-area').append(message);
			// $(".add-message").trigger("reset");
					}

					// if (!initChat) {
					// 	if (e.user_id == 1) document.getElementById('out-sound').play();
					// 	else document.getElementById('in-sound').play();
					// }

					messagesIds.push(e.id);
				});

				if (bufferIds.length > 0) {
					bufferIds.map(function(id) {
						if ($('#message-'+id).length != 0)
							$('#message-'+id).remove();
						messagesIds.remove(id);
					});
				}

				var chatRoom = document.getElementById("chat-room");
				if (chatRoom.scrollHeight - chatRoom.scrollTop < 400) {
					chatRoom.scrollTop = chatRoom.scrollHeight;
				}

				if (initChat) {
					var chatRoom = document.getElementById("chat-room");
					chatRoom.scrollTop = chatRoom.scrollHeight;
					initChat = false;
				}
			} else {$('#chat-room').html('');messagesIds = [];}
			if (update) setTimeout(fetchMessages, 1000);
		}

		window.onload = function() {
			if ($('.message-item').length > 0) {
				$('.message-item').each(function(i, e) {
					messagesIds.push($(e).attr('id').split('-')[1]);
					if (e.id > biggestId) biggestId = e.id;
				});
			}
			fetchMessages();
		};
	</script>
<!-- 	<audio id="in-sound" src="<?php echo \yii\helpers\Url::base().'/sounds/in.mp3'?>" preload="auto"></audio>
	<audio id="out-sound" src="<?php echo \yii\helpers\Url::base().'/sounds/out.mp3'?>" preload="auto"></audio> -->