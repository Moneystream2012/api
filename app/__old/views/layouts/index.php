<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);

?>

<?php $this->beginPage();?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language; ?>">
	<head>
		<meta charset="<?php echo Yii::$app->charset; ?>" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="shortcut icon" href="img/favicon/favicon.ico" type="image/x-icon">
		<?php echo Html::csrfMetaTags(); ?>

		<title><?php echo Html::encode($this->title); ?></title>

		<?php $this->head();?>
	</head>
	<body class="main-page">
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-101771370-1', 'auto');
            ga('send', 'pageview');
        </script>

		<?php $this->beginBody();?>

		<?php echo $content; ?>

		<?php $this->endBody();?>
	</body>
</html>
<?php $this->endPage();?>