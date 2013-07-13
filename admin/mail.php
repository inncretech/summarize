<?php
include "backend/database/database.class.php";
include "backend/session.class.php";
include "backend/global.function.php";

($db->member->checkAdmin($session->getValue('member_id')) ? null : Redirect(SITE_ROOT));

//Template Variables
$template['title'] = "Admin";
?> 

<!DOCTYPE html>
<html lang="en">
 
<!-- Load Header -->
<?php include 'template/header.php' ;?>

<body ng-app="Mail">
	<!-- Load Top Menu -->
    <?php include 'template/top_menu.php';?>
    <div class="container">
	   	<div class="row">
			<div class="span12 well" ng-controller="MailController">
				
				<div class="form-inline">
					<select ng-model="mailNo" >
						<option value="default">No Template</option>
						<option ng-repeat="item in mail" value="{{$index}}">
							{{item.subject}}
						</option>
					</select>
					<button ng-disabled="mailNo == 'default'" class="btn btn-warning" ng-click="loadMail(mailNo);">Load Mail</button>
					<button ng-disabled="mailNo == 'default'" class="btn btn-danger" ng-click="deleteMail(mailNo);">Delete Mail</button>
				</div>
				
				<hr>
				<input type="text" class="input-block-level" ng-model="subject" placeholder="Mail Subject">
				<?php include 'template/wysiwyg.php';?>
				<br>
				<div class="alert alert-success" ng-show="success"><strong>Action Compleated</strong></div>
				<div class="alert alert-info" ng-show="loading"><strong>Loading...</strong></div>
				<button class="btn btn-success" ng-click="sendMail();">Send Mail</button>
				<button class="btn btn-info" ng-click="saveMail();">Save Mail</button>
			</div>
		</div>
		<?php include 'template/footer.php';?>
    </div>
	
	
	<!--Load Javascript Library-->
    <?php include 'template/js_library.php';?>
	
	<!--Load Init Javascript -->
	<script type="text/javascript" src="assets/js/init/wysiwyg.js"></script>
	
	<script>var app = angular.module("Mail",[]);</script>
	<script>var member_id = <?=(isset($_GET['member_id']) ? $_GET['member_id'] : false )?> ;</script>
	<!--Load Angular Controller -->
	<script type="text/javascript" src="assets/js/controller/mail.js"></script>
</body>
</html>
