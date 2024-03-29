<?php 

include('header.php'); 
$member = $database->member->getAll();
?>


			<div>
				<ul class="breadcrumb">
					<li>
						<a href="#">Home</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#">Tables</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i> Members</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th>Username</th>
								  <th>Email</th>
								  <th>Date registered</th>
								  <th>Status</th>
								  <th>Actions</th>
							  </tr>
						  </thead>   
						  <tbody>
							
								<?php foreach ($member as $item){ ?>
								<tr>
								<td><?=$item['login'];?></td>
								<td class="center"><?=$item['email'];?></td>
								<td class="center"><?=$item['created_at'];?></td>
								<td class="center">
									<span class="label label-success">Active</span>
								</td>
								<td class="center">
									<a class="btn btn-success" href="#">
										<i class="icon-zoom-in icon-white"></i>  
										View                                            
									</a>
									<a class="btn btn-info" href="#">
										<i class="icon-edit icon-white"></i>  
										Edit                                            
									</a>
									<a class="btn btn-danger" href="#">
										<i class="icon-trash icon-white"></i> 
										Delete
									</a>
								</td>
								</tr>
								<?php } ?>
							

						  </tbody>
					  </table>            
					</div>
				</div><!--/span-->
			
			</div><!--/row-->
			<!--
			<div class="row-fluid sortable">
				<div class="box span6">
					<div class="box-header well" data-original-title>
						<h2>Simple Table</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table">
							  <thead>
								  <tr>
									  <th>Username</th>
									  <th>Date registered</th>
									  <th>Role</th>
									  <th>Status</th>                                          
								  </tr>
							  </thead>   
							  <tbody>
								<tr>
									<td>Muhammad Usman</td>
									<td class="center">2012/01/01</td>
									<td class="center">Member</td>
									<td class="center">
										<span class="label label-success">Active</span>
									</td>                                       
								</tr>
								<tr>
									<td>White Horse</td>
									<td class="center">2012/02/01</td>
									<td class="center">Staff</td>
									<td class="center">
										<span class="label label-important">Banned</span>
									</td>                                       
								</tr>
								<tr>
									<td>Sheikh Heera</td>
									<td class="center">2012/02/01</td>
									<td class="center">Admin</td>
									<td class="center">
										<span class="label">Inactive</span>
									</td>                                        
								</tr>
								<tr>
									<td>Saruar</td>
									<td class="center">2012/03/01</td>
									<td class="center">Member</td>
									<td class="center">
										<span class="label label-warning">Pending</span>
									</td>                                       
								</tr>
								<tr>
									<td>Sana Amrin</td>
									<td class="center">2012/01/21</td>
									<td class="center">Staff</td>
									<td class="center">
										<span class="label label-success">Active</span>
									</td>                                        
								</tr>                                   
							  </tbody>
						 </table>  
						 <div class="pagination pagination-centered">
						  <ul>
							<li><a href="#">Prev</a></li>
							<li class="active">
							  <a href="#">1</a>
							</li>
							<li><a href="#">2</a></li>
							<li><a href="#">3</a></li>
							<li><a href="#">4</a></li>
							<li><a href="#">Next</a></li>
						  </ul>
						</div>     
					</div>
				</div><!--/span-->
				<!--
				<div class="box span6">
					<div class="box-header well" data-original-title>
						<h2>Striped Table</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped">
							  <thead>
								  <tr>
									  <th>Username</th>
									  <th>Date registered</th>
									  <th>Role</th>
									  <th>Status</th>                                          
								  </tr>
							  </thead>   
							  <tbody>
								<tr>
									<td>Muhammad Usman</td>
									<td class="center">2012/01/01</td>
									<td class="center">Member</td>
									<td class="center">
										<span class="label label-success">Active</span>
									</td>                                       
								</tr>
								<tr>
									<td>White Horse</td>
									<td class="center">2012/02/01</td>
									<td class="center">Staff</td>
									<td class="center">
										<span class="label label-important">Banned</span>
									</td>                                       
								</tr>
								<tr>
									<td>Sheikh Heera</td>
									<td class="center">2012/02/01</td>
									<td class="center">Admin</td>
									<td class="center">
										<span class="label">Inactive</span>
									</td>                                        
								</tr>
								<tr>
									<td>Saruar</td>
									<td class="center">2012/03/01</td>
									<td class="center">Member</td>
									<td class="center">
										<span class="label label-warning">Pending</span>
									</td>                                       
								</tr>
								<tr>
									<td>Sana Amrin</td>
									<td class="center">2012/01/21</td>
									<td class="center">Staff</td>
									<td class="center">
										<span class="label label-success">Active</span>
									</td>                                        
								</tr>                                   
							  </tbody>
						 </table>  
						 <div class="pagination pagination-centered">
						  <ul>
							<li><a href="#">Prev</a></li>
							<li class="active">
							  <a href="#">1</a>
							</li>
							<li><a href="#">2</a></li>
							<li><a href="#">3</a></li>
							<li><a href="#">4</a></li>
							<li><a href="#">Next</a></li>
						  </ul>
						</div>     
					</div>
				</div><!--/span--><!--
			</div>
			
			<div class="row-fluid sortable">	
				<div class="box span6">
					<div class="box-header well" data-original-title>
						<h2>Bordered Table</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-bordered">
							  <thead>
								  <tr>
									  <th>Username</th>
									  <th>Date registered</th>
									  <th>Role</th>
									  <th>Status</th>                                          
								  </tr>
							  </thead>   
							  <tbody>
								<tr>
									<td>Muhammad Usman</td>
									<td class="center">2012/01/01</td>
									<td class="center">Member</td>
									<td class="center">
										<span class="label label-success">Active</span>
									</td>                                       
								</tr>
								<tr>
									<td>White Horse</td>
									<td class="center">2012/02/01</td>
									<td class="center">Staff</td>
									<td class="center">
										<span class="label label-important">Banned</span>
									</td>                                       
								</tr>
								<tr>
									<td>Sheikh Heera</td>
									<td class="center">2012/02/01</td>
									<td class="center">Admin</td>
									<td class="center">
										<span class="label">Inactive</span>
									</td>                                        
								</tr>
								<tr>
									<td>Saruar</td>
									<td class="center">2012/03/01</td>
									<td class="center">Member</td>
									<td class="center">
										<span class="label label-warning">Pending</span>
									</td>                                       
								</tr>
								<tr>
									<td>Sana Amrin</td>
									<td class="center">2012/01/21</td>
									<td class="center">Staff</td>
									<td class="center">
										<span class="label label-success">Active</span>
									</td>                                        
								</tr>                                   
							  </tbody>
						 </table>  
						 <div class="pagination pagination-centered">
						  <ul>
							<li><a href="#">Prev</a></li>
							<li class="active">
							  <a href="#">1</a>
							</li>
							<li><a href="#">2</a></li>
							<li><a href="#">3</a></li>
							<li><a href="#">4</a></li>
							<li><a href="#">Next</a></li>
						  </ul>
						</div>     
					</div>
				</div>
				
				<div class="box span6">
					<div class="box-header well" data-original-title>
						<h2>Condensed Table</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-condensed">
							  <thead>
								  <tr>
									  <th>Username</th>
									  <th>Date registered</th>
									  <th>Role</th>
									  <th>Status</th>                                          
								  </tr>
							  </thead>   
							  <tbody>
								<tr>
									<td>Muhammad Usman</td>
									<td class="center">2012/01/01</td>
									<td class="center">Member</td>
									<td class="center">
										<span class="label label-success">Active</span>
									</td>                                       
								</tr>
								<tr>
									<td>White Horse</td>
									<td class="center">2012/02/01</td>
									<td class="center">Staff</td>
									<td class="center">
										<span class="label label-important">Banned</span>
									</td>                                       
								</tr>
								<tr>
									<td>Sheikh Heera</td>
									<td class="center">2012/02/01</td>
									<td class="center">Admin</td>
									<td class="center">
										<span class="label">Inactive</span>
									</td>                                        
								</tr>
								<tr>
									<td>Saruar</td>
									<td class="center">2012/03/01</td>
									<td class="center">Member</td>
									<td class="center">
										<span class="label label-warning">Pending</span>
									</td>                                       
								</tr>
								<tr>
									<td>Sana Amrin</td>
									<td class="center">2012/01/21</td>
									<td class="center">Staff</td>
									<td class="center">
										<span class="label label-success">Active</span>
									</td>                                        
								</tr>                                   
							  </tbody>
						 </table>  
						 <div class="pagination pagination-centered">
						  <ul>
							<li><a href="#">Prev</a></li>
							<li class="active">
							  <a href="#">1</a>
							</li>
							<li><a href="#">2</a></li>
							<li><a href="#">3</a></li>
							<li><a href="#">4</a></li>
							<li><a href="#">Next</a></li>
						  </ul>
						</div>     
					</div>
				</div>
			
			</div>
			
			<div class="row-fluid sortable">	
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2>Combined All</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-bordered table-striped table-condensed">
							  <thead>
								  <tr>
									  <th>Username</th>
									  <th>Date registered</th>
									  <th>Role</th>
									  <th>Status</th>                                          
								  </tr>
							  </thead>   
							  <tbody>
								<tr>
									<td>Muhammad Usman</td>
									<td class="center">2012/01/01</td>
									<td class="center">Member</td>
									<td class="center">
										<span class="label label-success">Active</span>
									</td>                                       
								</tr>
								<tr>
									<td>White Horse</td>
									<td class="center">2012/02/01</td>
									<td class="center">Staff</td>
									<td class="center">
										<span class="label label-important">Banned</span>
									</td>                                       
								</tr>
								<tr>
									<td>Sheikh Heera</td>
									<td class="center">2012/02/01</td>
									<td class="center">Admin</td>
									<td class="center">
										<span class="label">Inactive</span>
									</td>                                        
								</tr>
								<tr>
									<td>Saruar</td>
									<td class="center">2012/03/01</td>
									<td class="center">Member</td>
									<td class="center">
										<span class="label label-warning">Pending</span>
									</td>                                       
								</tr>
								<tr>
									<td>Sana Amrin</td>
									<td class="center">2012/01/21</td>
									<td class="center">Staff</td>
									<td class="center">
										<span class="label label-success">Active</span>
									</td>                                        
								</tr>                                   
							  </tbody>
						 </table>  
						 <div class="pagination pagination-centered">
						  <ul>
							<li><a href="#">Prev</a></li>
							<li class="active">
							  <a href="#">1</a>
							</li>
							<li><a href="#">2</a></li>
							<li><a href="#">3</a></li>
							<li><a href="#">4</a></li>
							<li><a href="#">Next</a></li>
						  </ul>
						</div>     
					</div>
				</div><!--/span-->
			</div><!--/row-->
    
<?php include('footer.php'); ?>
