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

<body ng-app="Dashboard">
	<!-- Load Top Menu -->
    <?php include 'template/top_menu.php';?>
    <div class="container">
	   	<div class="row">
			<div class="span12" ng-controller="DashboardController" ng-init="getData();">
				<div class="row-fluid">
            <ul class="thumbnails">
              <li class="span4">
                <div class="thumbnail">
                  
                  <div class="caption">
                    <h3>Site Status</h3>
                    <p><span class="label label-info">{{tagCount}}</span> unique tags all over the site.</p>
					<p><span class="label label-important">{{voteCount}}</span> total votes on products.</p>
					<p><span class="label label-success">{{opinionCount}}</span> opinions by members.</p>
					<p><span class="label label-warning">{{uniqueMemberCount}}</span> members who voted.</p>
					<p><span class="label label-inverse">{{productCount}}</span> products currently on the site.</p>
                    
                  </div>
                </div>
              </li>
              <li class="span4">
                <div class="thumbnail">
                  
                  <div class="caption">
                    <h3>Thumbnail label</h3>
                    <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                    <p><a href="#" class="btn btn-primary">Action</a> <a href="#" class="btn">Action</a></p>
                  </div>
                </div>
              </li>
              <li class="span4">
                <div class="thumbnail">
                 
                  <div class="caption">
                    <h3>Thumbnail label</h3>
                    <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                    <p><a href="#" class="btn btn-primary">Action</a> <a href="#" class="btn">Action</a></p>
                  </div>
                </div>
              </li>
            </ul>
          </div>
			</div>
    	
		</div>
		<?php include 'template/footer.php';?>
    </div>
	
	
	<!--Load Javascript Library-->
    <?php include 'template/js_library.php';?>
	
	<!--Loading Page Controllers -->
	<script>var app = angular.module("Dashboard",[]);</script>
	<script type="text/javascript" src="assets/js/controller/dashboard.js"></script>
</body>
</html>
