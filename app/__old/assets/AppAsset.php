<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle {
	public $basePath = '@webroot';
	public $baseUrl = '@web';
	public $css = [
		'https://fonts.googleapis.com/icon?family=Material+Icons',
    	'css/bootstrap.min.css',
    	'css/magnific-popup.css',
    	'css/alertify.core.css',
    	'css/animate.min.css',
    	'css/alertify.default.css',
    	'css/owl.carousel.min.css',
    	'css/owl.theme.default.min.css',
    	'css/bootstrap-slider.min.css',
    	'css/bankStyle.css',
    	'css/copyaddress.css',
    	'css/main.css'
	];
	public $js = [
		'js/jquery.min.js',
		'js/bootstrap.min.js',
		'js/bootstrap-slider.min.js',
		'js/wow.min.js',
		'js/jquery.matchHeight-min.js',
		// 'js/jquery.matchHeight-min.js',
		'js/jquery.knob.min.js',
		'js/jquery.magnific-popup.js',
		'js/jquery.maskedinput.min.js',
		'js/SmoothScroll.js',
		'js/alertify.min.js',
		'js/common.js',
		'js/custom.js',
		'js/app.js', // App main js code.
		'js/app.activation.js',
		'js/app_v.js',
		'js/app_e.js',
		'js/app_a.js',
		'js/owl.carousel.min.js',
		'js/parallax.min.js',
		'js/SmoothScroll.js',
		'js/waypoints.min.js',
		// 'js/validator.min.js',
		// 'js/jquery.shuffle.min.js',
		// 'js/modernizr.js',
		// 'js/etimer.js',
		// 'js/jquery.malihu.PageScroll2id.js',
		// 'js/jquery.countTo.js',
		// 'js/etimer.js',
		// 'js/fotorama.js',
	];
	public $depends = [
		// 'yii\web\YiiAsset',
		// 'yii\bootstrap\BootstrapAsset',
	];
}
