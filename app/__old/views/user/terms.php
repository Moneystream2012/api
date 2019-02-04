<?php

use yii\helpers\Url;

?>
<style>
	#main {
		/*border-top: 1px solid black;*/
		 box-shadow: inset 0px 10px 11px 0px rgba(0,0,0,0.3)
		 /*padding-bottom: 5px;*/
}
</style>
<header id="header" >
	<!-- Navbar -->
	<nav id="navbar">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="main-menu-toggle">
              		<div class="one"></div>
              		<div class="two"></div>
              		<div class="three"></div>
              		</div><a href="<?php echo Yii::$app->getHomeUrl(); ?>" class="logo"><img src="img/logo.svg" alt="logo">
					<div class="logo-descr">MinexBank</div></a>
					<div class="right-side">
						

					</div>
				</div>
			</div>
		</div>
	</nav>
</header>
<main id="main">
	<div class="container" style=" font-family:'RobotoMedium', sans-serif; width: ">
		<div style="color: #24e1ba; font-size: 24px; ">Terms and condiotins </div>
		<br>
		<div style="font-size: 12px; ">Effective January 12,2016</div>
		<br>
		<div style="font-size: 16px; color: #24e1ba;">Guideline for using MinexBank</div>
		<br>
		<div align="justify" style="font-size: 14px; "><ul>
			<li>In order to use MinexBank “parking” option, you should have a confirmed Minexcoin wallet.</li>	
			<li>The amount of funds on the balance should not be less than 0.1 MNC, since the minimum sum of parking is 0.1 MNC.</li>
			<li>You can create an unlimited number of parking lots in different categories (daily, monthly, annual) within your balance.</li>
			<li>The amount of parked coins can not exceed the amount of funds on your wallet.</li>
			<li>In case you do not have enough coins to create new parking lot, you can cancel any of your previously created parking lots, using the function “Cancel”.</li>
			<li>Coins on your wallet are always at your disposal, since you do not transfer them to MinexBank or any third party.</li>
			<li>By parking the coins, you undertake a voluntary obligation not to use parked coins for the chosen parking period.</li>
			<li>If you reduce the amount of funds on your wallet by less than the amount of parked coins, the system will cancel your parking lots starting from those created later, until the amount of parked coins becomes less than or equal to the amount of funds on your wallet.</li>
			<li>In case of parking cancellation by you or the system, you will not receive an interest for such parking regardless of how much time has passed since the moment of creation or left before the accept of such parking by the system. The interest will not be credited as well.</li>
			<li>With the course of time, the interest rate for each type of parking will vary depending on the supply and demand balance of Minexcoin on the market. Your interest rate, which was applied at the moment of parking creation, will be valid for your parking before its termination, regardless of the current changes.</li>
			<li>After the expiration of your parking, interest charges on the parked amount of coins will be credited to your wallet and parking will be considered closed, if the parking has not been canceled by you or the system.</li>
			<li>The system does not provide automatic updating of parking after its expiration.</li>
			<li>Transaction fee for paying accrued interest is 0.001 MNC, and shall be paid by the final beneficiary of such payments.</li>
			<li>Virtual currency is not legal tender, is not backed by the government, and accounts and value balances are not subject to consumer protections.</li>
		</ul>
 </div>
		<div style="font-size: 14px; ">Being the developers of Minexcoin and MinexBank products, MinexSystems shall not liable for possible financial losses caused by the price fluctuations of Minexcoin on the market, as well as by illegal actions of third parties, policy and regulations of governments on crypto-currencies in general and minexcoin in particular, as well as for the use of Minexcoin for any illegal activities.</div>
	</div>
</main>

    <footer id="footer">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="copyright">MinexSystems</div>
          </div>
        </div>
      </div>
    </footer>