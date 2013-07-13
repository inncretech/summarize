app.controller("MailController", function($scope,$http) {
	$scope.success 	= false;
	$scope.loading 	= false;
	$scope.path 	= '';
	$scope.mailNo	= 'default';
	
	$scope.sendMail = function() {
		$scope.loading = true;
		$scope.success = false;
		if (member_id == false) {
			$scope.path = 'backend/post/mail_send.php?case=0';
		}else{
			$scope.path = 'backend/post/mail_send.php?case=1&member_id='+member_id;
		}
		console.log($scope.path);
		$http.post($scope.path,{subject:$scope.subject,message:$('#editor').cleanHtml()}).
		success(function(data){
			console.log(data);
			$scope.success = true;
			$scope.loading = false;
		}).
		error(function(data){
			
		});		
	};
	
	$scope.loadMail = function(no) {
		
		$scope.subject = $scope.mail[no].subject;
		$("#editor").html($scope.mail[no].message);
		
	};
	
	$scope.getMail = function() {
		$http.post('backend/get/mail_data.php').
		success(function(data){
			$scope.mail = data;
		}).
		error(function(data){
			
		});		
	}; 
	
	$scope.getMail();
	
	$scope.deleteMail = function(no) {
		$scope.loading = true;
		$scope.success = false;
		console.log();
		$http.post('backend/post/mail_delete.php',{mail_id:$scope.mail[no].mail_id}).
		success(function(data){
			console.log(data);
			$scope.success = true;
			$scope.loading = false;
			$scope.getMail();
		}).
		error(function(data){
			
		});		
	}; 

	
	$scope.saveMail = function() {
		$scope.loading = true;
		$scope.success = false;
		$http.post('backend/post/mail_save.php',{subject:$scope.subject,message:$('#editor').cleanHtml()}).
		success(function(data){

			$scope.success = true;
			$scope.loading = false;
			$scope.getMail();
		}).
		error(function(data){
			
		});		
	}; 

});
