<!-- Header -->
<?php echo $this->render('../../admin/common/_header.php'); ?>
<main id="main">
	<div class="container">
		<div class="row">
			<div class="col-md-2">
		<!-- Nav -->
		<?php echo $this->render('../../admin/common/_navbar', ['active' => 'dashboard']); ?>
	</div>
<!-- 	<style>
		.dash-m{
			margin: 5px;
			border: 1px solid #ddd;
		}
		.dash-s{
			margin: 5px;
			border: 1px solid #ddd;
		}
		.dash-s-p{
			margin-top: 25%;
			margin-bottom: 25%;
			margin-left: 45%;
		}
	</style> -->



    <!-- Main -->
          <div class="col-md-6">
            <!-- Total Section -->
            <section class="total-section">
              <div class="row">
                <div class="col-md-6 col-sm-6">
                  <div class="total-block inline-block">
                    <div class="total-inner">
                      <div class="total-title">Total supply</div>
                      <div class="total-value">0000.00000000 MNX</div>
                      <div class="total-percent">100%</div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-sm-6">
                  <div class="total-block inline-block">
                    <div class="total-inner">
                      <div class="total-title">BTC Reserve</div>
                      <div class="total-value">0000.00000000 BTC</div>
                      <div class="total-percent">100%</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4 col-sm-4">
                  <div class="total-block">
                    <div class="total-inner">
                      <div class="total-title">BANK MNC Reserve</div>
                      <div class="total-value">0000.00000000 MNX</div>
                      <div class="total-percent">100%</div>
                    </div>
                  </div>
                  <div class="total-block">
                    <div class="total-inner">
                      <div class="total-title">Cold reserve</div>
                      <div class="total-value">0000.00000000 MNX</div>
                      <div class="total-percent">100%</div>
                    </div>
                  </div>
                  <div class="total-block">
                    <div class="total-inner">
                      <div class="total-title">Active reserve</div>
                      <div class="total-value">0000.00000000 MNX</div>
                      <div class="total-percent">100%</div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4 col-sm-4">
                  <div class="total-block">
                    <div class="total-inner">
                      <div class="total-title">On hands</div>
                      <div class="total-value">0000.00000000 MNX</div>
                      <div class="total-percent">100%</div>
                    </div>
                  </div>
                  <div class="total-block">
                    <div class="total-inner">
                      <div class="total-title">Free on market</div>
                      <div class="total-value">0000.00000000 MNX</div>
                      <div class="total-percent">100%</div>
                    </div>
                  </div>
                  <div class="total-block">
                    <div class="total-inner">
                      <div class="total-title">Total parked</div>
                      <div class="total-value"><?php echo number_format($parkingTotal ? : 0, 8); ?> MNX</div>
                      <div class="total-percent">100%</div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4 col-sm-4">
                  <div class="total-block">
                    <div class="total-inner">
                      <div class="total-title">Freezing</div>
                      <div class="total-value">0000.00000000 MNX</div>
                      <div class="total-percent">100%</div>
                    </div>
                  </div>
                  <div class="total-block tower-block">


                  				<?php

							if (isset($parkingTotalType) && count($parkingTotalType) > 0) {
								foreach ($parkingTotalType as $type) {
									?>
					                    <div class="total-inner">
					                      <div class="total-title"><?php echo $type['type']->title; ?></div>
					                      <div class="total-value"><?php echo number_format($type['sum'] ? : 0, 8); ?> MNX</div>
					                    </div>
									<?php
								}
							}
						?>
                  </div>
                </div>
              </div>
            </section>
            <!-- Chart Section -->
            <section class="chart-section">
              <div class="chart-descr">Chart изменение цены и объема паркинга</div>
            </section>
            <!-- Chart Section -->
            <section class="chart-section">
              <div class="chart-descr">Chart Графики изменения процентной ставки по трем паркингам</div>
            </section>
          </div>
          <div class="col-md-4"><a href="#pt-creation-popup" class="button-bordered parking-type-button call-popup">Create parking type</a>
            <!-- Parking Rate Section -->
            <section class="parking-rate-section">
              <div class="parking-rate-item clearfix">
                <div class="left-side">
                  <div class="parking-rate-title">Minimum park:</div>
                  <input type="text" class="parking-rate-input">
                </div>
                <div class="right-side">
                  <div class="parking-rate-value">5 MNX</div>
                  <button type="button" class="change-button">Change</button>
                  <button type="button" class="cancel-button">Cancel</button>
				  <a href="#confirmation-green-popup" class="button-bordered change-link call-popup">Change</a>
                </div>
              </div>

						<?php

							if (isset($parkingType) && count($parkingType) > 0) {
								foreach ($parkingType as $type) {
									?>
						              <div class="parking-rate-item clearfix" parking-rate-item-id="<?php echo $type->id; ?>">
						                <div class="left-side">
						                  <div class="parking-rate-title"><?php echo $type->title; ?> rate:</div>
						                  <input type="text" class="parking-rate-input" parking-rate-input-id="<?php echo $type->id; ?>">
						                </div>
						                <div class="right-side">
						                  <div class="parking-rate-value" id="parking-rate-value-<?php echo $type->id; ?>" rate="<?php echo $type->rate; ?>"><?php echo $type->rate; ?>%</div>
						                  <button type="button" class="change-button" parking-type-id="<?php echo $type->id; ?>">Change</button>
						                  <button type="button" class="cancel-button" parking-cancel-id="<?php echo $type->id; ?>">Cancel</button>
										  <a href="#confirmation-green-popup" class="button-bordered change-link call-popup" parking-save-id="<?php echo $type->id; ?>">Save</a>
						                </div>
						              </div>
									<?php
								}
							}
						?>
									<!-- 	<li class="list-group-item">
											<button class="btn btn-xs pull-right admin-change-parking-type" data-toggle="modal" data-target="#parkingEditForm" parking-type-id="<?php //echo $type->id; ?>">Change</button>
												<?php //echo $type->title; ?>
											<span class="pull-right"><?php //echo $type->rate; ?>%</span>
										</li> -->




            </section>
            <!-- Table Section -->
            <section class="table-section">
              <table class="table users-table">
                <thead>
                  <tr>
                    <th>User type</th>
                    <th>Web</th>
                    <th>Android</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Unconfirmed users:</td>
                    <td><?php echo $unconfirmedWebUsers; ?></td>
                    <td>0</td>
                    <td><?php echo $unconfirmedWebUsers; ?></td>
                  </tr>
                  <tr>
                    <td>Confirmed users:</td>
                    <td><?php echo $confirmedWebUsers; ?></td>
                    <td>0</td>
                    <td><?php echo $confirmedWebUsers; ?></td>
                  </tr>
                  <tr>
                    <td>Total users:</td>
                    <td><?php echo $totalWebUsers; ?></td>
                    <td>0</td>
                    <td><?php echo $totalWebUsers; ?></td>
                  </tr>
                </tbody>
              </table>
            </section>
          </div>
        </div>
      </div>
    </main>
    <!-- Alerts -->
    <div class="info-alerts">
      <div id="parking-created" class="alert alert-dismissible alert-success">
        <button type="button" data-dismiss="alert" class="close">×</button><span>Parking has been created</span>
      </div>
    </div>


<!-- Modal for parkingtype editing -->
<?php echo $this->render('../../admin/common/_add_parking_type_popup.php'); ?>
<?php echo $this->render('../../admin/common/_edit_parking_type_popup.php'); ?>

<!-- 
  <div class="col-md-10">
    <div class="row">
      <div class="col-md-12" style="padding: 0px;">
        <div class="col-md-7">
          <div class="col-md-4 text-center">
            <div class="dash-m">
              <h6>MNC Reserve</h6>
              <p>10000MNX</p>
              <p>100%</p>
            </div>
          </div>
          <div class="col-md-4 text-center">
            <div class="dash-m">
              <h6>Freezing</h6>
              <p>10000MNX</p>
              <p>100%</p>
            </div>
          </div>
          <div class="col-md-4 text-center">
            <div class="dash-m">
              <h6>On hands</h6>
              <p>10000MNX</p>
              <p>100%</p>
            </div>
          </div>
          <div class="col-md-4 text-center">
            <div class="dash-m">
              <h6>Total parked</h6>
              <p><?php //echo number_format($parkingTotal ? : 0, 8); ?> MNX</p>
              <p>100%</p>
            </div>
          </div>
          <div class="col-md-4 text-center">
            <div class="dash-m">
              <h6>BTC Reserve</h6>
              <p>10000MNX</p>
              <p>100%</p>
            </div>
          </div>
          <div class="col-md-4 text-center">
            <div class="dash-m">
              <h6>Total supply</h6>
              <p>10000MNX</p>
              <p>100%</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="dash-m">
            <?php

             // if (isset($parkingTotalType) && count($parkingTotalType) > 0) {
             //   foreach ($parkingTotalType as $type) {
                  ?>
                    <h6 class="text-center"><?php // echo $type['type']->title; ?></h6>
                    <p><?php  //echo number_format($type['sum'] ? : 0, 8); ?> MNX</p>
                  <?php
               // }
             // }
            ?>

            </div>
          </div>


          <div class="col-md-8">
            <div class="dash-s">
              <p class="dash-s-p">Chart</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="dash-s">
              <button class="btn btn-primary admin-add-parking-type" data-toggle="modal" data-target="#parkingAddForm">Create parking type</button>
            </div>
          </div>          
        </div>
        <div class="col-md-5">
          <div class="col-md-12">
            <ul class="list-group">

              <li class="list-group-item">
              <button class="btn btn-xs pull-right">Change</button>
                Minimum park:
              <span class="pull-right">5 MNX</span>
              </li>
            <?php

              // if (isset($parkingType) && count($parkingType) > 0) {
              //  foreach ($parkingType as $type) {
                  ?>
                    <li class="list-group-item">
                      <button class="btn btn-xs pull-right admin-change-parking-type" data-toggle="modal" data-target="#parkingEditForm" parking-type-id="<?php  //echo $type->id; ?>">Change</button>
                        <?php  //echo $type->title; ?>
                      <span class="pull-right"><?php  //echo $type->rate; ?>%</span>
                    </li>
                  <?php
              //  }
              // }
            ?>
            </ul>
          </div>
          <div class="col-md-12">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>User type</th>
                <th>Web</th>
                <th>Android</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Unconfirmed users</td>
                <td><?php // echo $unconfirmedWebUsers; ?></td>
                <td>0</td>
                <td><?php // echo $unconfirmedWebUsers; ?></td>
              </tr>
              <tr>
                <td>Confirmed users</td>
                <td><?php // echo $confirmedWebUsers; ?></td>
                <td>0</td>
                <td><?php // echo $confirmedWebUsers; ?></td>
              </tr>
              <tr>
                <td>Total users</td>
                <td><?php // echo $totalWebUsers; ?></td>
                <td>0</td>
                <td><?php // echo $totalWebUsers; ?></td>
              </tr>
            </tbody>
          </table> 
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div></main> -->
