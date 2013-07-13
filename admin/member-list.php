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

<body ng-app="MemberData">
	<!-- Load Top Menu -->
    <?php include 'template/top_menu.php';?>
    <div class="container">
	   	<div class="row">
			<div class="span12">
				<div ng-controller="MemberDataController" ng-init="getData();">
					<input type="text" ng-model="search" placeholder="Search..." class="input-xlarge">
					<table class="table table-bordered" >
						<tr ng-repeat="item in filterData(search);">
							<td style="width:20%;">{{item.login}}</td>
							<td>{{item.email}}</td>
							<td  style="width:10%;">
								<a href="mail.php?member_id={{item.member_id}}" class="btn btn-warning"><i class="icon-envelope"></i></a>
								<a href="#edit" ng-click="loadEdit(item)" role="button" data-toggle="modal" class="btn btn-info"><i class="icon-edit"></i></a>
							</td>
							
						</tr>
					</table>
					
					<!-- Modal -->
					<div id="edit" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3 id="myModalLabel">Edit Member</h3>
					  </div>
					  <div class="modal-body">
						<p><input type="text" class="input-block-level" value="{{edit.first_name}}" title="First Name" placeholder="First Name"></p>
						<p><input type="text" class="input-block-level" value="{{edit.last_name}}" title="Last Name" placeholder="Last Name"></p>
						<p><input type="text" class="input-block-level" value="{{edit.email}}" title="Email" placeholder="Email"></p>
						<p><input type="text" class="input-block-level" value="{{edit.login}}" title="Login" placeholder="Login"></p>
						<p><textarea class="input-block-level" title="Short Bio" placeholder="Short Bio">{{edit.short_bio}}</textarea></p>
					  </div>
					  <div class="modal-footer">
						<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
						<button class="btn btn-primary">Save changes</button>
					  </div>
					</div>
					
					<div class="pagination">
					  <ul>
						<li ng-class="{disabled: currentPage == 0}"><a href="#" onclick="return false;" ng-click="previous();">Previous</a></li>
						<li><a href="#" onclick="return false;">{{currentPage+1}}</a></li>
						<li><a href="#" onclick="return false;">of</a></li>
						<li><a href="#" onclick="return false;">{{numberOfPages()}}</a></li>
						<li ng-class="{disabled: currentPage >= data.length/pageSize - 1}"><a href="#" onclick="return false;" ng-click="next();">Next</a></li>
					  </ul>
					</div>
				</div>
			</div>
    	
		</div>
		<?php include 'template/footer.php';?>
    </div>
		
	<!--Load Javascript Library-->
    <?php include 'template/js_library.php';?>
	
	<!--Loading Page Controllers -->
	<script>var app = angular.module("MemberData",[]);</script>
	<script type="text/javascript" src="assets/js/controller/memberData.js"></script>
</body>
</html>
