<?php

namespace app\controllers\admin;

use Yii;
use app\controllers\AppController;

class ParkingTypeController extends AppController {
	
	public function actionGetTypeById() {
        try {
            return $this->getService('ParkingType')->getTypeById();
        } catch (Exception $e) {
            return $this->sendError('You reached some error');
        }
    }
	
	public function actionAdd() {
        try {
            return $this->getService('ParkingType')->add();
        } catch (Exception $e) {
            return $this->sendError('You reached some error');
        }
    }
	
	public function actionEdit() {
        try {
            return $this->getService('ParkingType')->edit();
        } catch (Exception $e) {
            return $this->sendError('You reached some error');
        }
    }
}