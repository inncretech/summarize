<?php
session_start();
include "database.php";			
$data=$database->query("Select * from compare where uid='".$_SESSION['uid']."'");
$id="-1";
while ($info=mysql_fetch_array($data)){
	$id=$id.",".$info['idproduct'];
	}
$id=$id."-1";
$id=explode(",",$id);
						$q="select DISTINCT(category),idproduct,(Select name from product as b where a.idproduct=b.idproduct) as name,(Select sum(thumb) from  feedback as b where a.category=b.category and b.type='good' and a.idproduct=b.idproduct) as good_thumb ,(Select sum(thumb) from  feedback as b where a.category=b.category and b.type='bad' and a.idproduct=b.idproduct) as bad_thumb from feedback as a where ";
						
						foreach($id as $p){
							$q=$q."`idproduct`='$p' OR ";
						};
						$q=$q." 1=2 ORDER BY category,idproduct ;";
						$q=$database->query($q);
						$valsArray = array(); 
						if (mysql_num_rows($q)<1){
							die("<tr><td>No items added.</td></tr>");
						}
						
						while ($info=mysql_fetch_array($q)){
							$ok=true;
							foreach ($valsArray as $v){
								if($v==$info){
									$ok=false;
								}
								}
							if ($ok) $valsArray[] =$info;
							
						}
						
						
						//$valsArray = array_unique($valsArray);
					
					?>
						<tr>
							<td id="cat">
							</td>
							
							<?
							$names=array();
							foreach ($valsArray as $v){
								$ok=true;
								foreach($names as $n){
									if ($n==$v['name']){
										$ok=false;
									}
								}
								if ($ok) {
								$names[]=$v['name'];
							?>
							
							<td id="comp-name">
							<b>
								<?=$v['name'];?>
								</b>
							</td>
							<?
							}
							}
							?>
						</tr>
						<?
						$cat=array();
						foreach($valsArray as $v){
						 $ok=true;
								foreach($cat as $n){
									if ($n==$v['category']){
										$ok=false;
									}
								}
								if ($ok) {
								$cat[]=$v['category'];
						?>
						<tr>
							<td id="cat">
							<b>
							<?=$v['category'];?>
							</b>
							</td>
							<?php
							foreach($names as $n){
								$ok=true;
								foreach($valsArray as $vv){
										if ($n==$vv['name'] && $v['category']==$vv['category']){
											$ok=false;
											if($vv['good_thumb']==null){
												$vv['good_thumb']=0;
											}
											
											if($vv['bad_thumb']==null){
												$vv['bad_thumb']=0;
											}
											echo "<td><font color='#08C'>".$vv['good_thumb']."</font>/<font color='#980000'>".$vv['bad_thumb']."</font></td>";
										}										
								}
								if($ok){
									echo "<td>N/A</td>";
								}
							}
							?>
						</tr>
						<?
						}}
						?>