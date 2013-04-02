<?php include('header.php'); ?>


			<div>
				<ul class="breadcrumb">
					<li>
						<a href="#">Home</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#">Dashboard</a>
					</li>
				</ul>
			</div>
			<div class="sortable row-fluid">
				<a data-rel="tooltip" title="6 new members." class="well span3 top-block" href="#">
					<span class="icon32 icon-red icon-user"></span>
					<div>Total Members</div>
					<div><?=$database->member->countActive();?></div>
					<span class="notification">All Active</span>
				</a>

				<a data-rel="tooltip" title="4 new pro members." class="well span3 top-block" href="#">
					<span class="icon32 icon-color icon-star-on"></span>
					<div>Social Network Members</div>
					<div><?=$database->member->countSocialNetwork();?></div>
					<span class="notification green">Fb + Tw</span>
				</a>

				<a data-rel="tooltip" title="$34 new sales." class="well span3 top-block" href="#">
					<span class="icon32 icon-color icon-cart"></span>
					<div>Products</div>
					<div><?=$database->product->countActive();?></div>
					<span class="notification yellow">All Active</span>
				</a>
				
				<a data-rel="tooltip" title="12 new messages." class="well span3 top-block" href="#">
					<span class="icon32 icon-color icon-envelope-closed"></span>
					<div>Surveys</div>
					<div><?=$database->survey->countActive();?></div>
					<span class="notification red">All Active</span>
				</a>
			</div>
			

					
			<div class="row-fluid sortable">
				
				<div class="box span4">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-list"></i> Weekly Stat</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<ul class="dashboard-list">
							<li>
								<a href="#">
								<i class="icon-arrow-up"></i>                               
								<span class="green"><?=$database->product_feedback->getWeeklyCount();?></span>
								New Comments                                    
								</a>
							</li>
						  <li>
							<a href="#">
							  <i class="icon-arrow-down"></i>
							  <span class="red"><?=$database->member->getWeeklyCount();?></span>
							  New Registrations
							</a>
						  </li>
						  <li>
							<a href="#">
							  <i class="icon-minus"></i>
							  <span class="blue"><?=$database->product->getWeeklyCount();?></span>
							  New Products                                  
							</a>
						  </li>
						  <li>
							<a href="#">
							  <i class="icon-comment"></i>
							  <span class="yellow"><?=$database->questions->getWeeklyCount();?></span>
							  New Questions                                   
							</a>
						  </li>
						  <li>
							<a href="#">
							  <i class="icon-arrow-up"></i>                               
							  <span class="green"><?=$database->answers->getWeeklyCount();?></span>
							  New Answers                                    
							</a>
						  </li>
						  <li>
							<a href="#">
							  <i class="icon-arrow-down"></i>
							  <span class="red"><?=$database->survey->getWeeklyCount();?></span>
							  New Surveys
							</a>
						  </li>
						  
						</ul>
					</div>
				</div><!--/span-->
						
				<div class="box span4">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i> Last Registred Members</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-minimize"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<div class="box-content">
							<ul class="dashboard-list">
								<?php $member = $database->member->getLatest();?>
								<?php foreach ($member as $item){ ?>
								<?php $item['info']= $database->member_info->get($item['member_id']);?>
								<?php $item['info']= $database->member_info->get($item['member_id']);?>
								<?php $item['info']= $database->member_info->get($item['member_id']);?>
								<li>
									<a href="#">
										
										<img class="dashboard-avatar" alt="<?=$item['info']['first_name']." ".$item['info']['last_name'];?>" src="<?='http://'.(S3_BUCKET).'.s3.amazonaws.com/m_'.$item['public_id']."_normal.jpg";?>"></a>
										<strong>Name:</strong> <a href="#"><?=$item['info']['first_name']." ".$item['info']['last_name'];?>
									</a><br>
									<strong>Since:</strong><?=$item['created_at'];?><br>
									<strong>Status:</strong> <span class="label label-success">Approved</span>                                  
								</li>
								<?php } ?>
							</ul>
						</div>
					</div>
				</div><!--/span-->
						
				<div class="box span4">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-list-alt"></i> Realtime Traffic</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-minimize"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<div id="realtimechart" style="height:190px;"></div>
							<!--<p class="clearfix">You can update a chart periodically to get a real-time effect by using a timer to insert the new data in the plot and redraw it.</p>
							<p>Time between updates: <input id="updateInterval" type="text" value="" style="text-align: right; width:5em"> milliseconds</p>-->
					</div>

				</div><!--/span-->
				
			</div><!--/row-->


				  

		  
       
<?php include('footer.php'); ?>
