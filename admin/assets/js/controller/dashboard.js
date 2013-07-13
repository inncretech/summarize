app.controller("DashboardController", function($scope,$http) {
	$scope.tagCount 			= 0;
	$scope.voteCount 			= 0;
	$scope.opinionCount 		= 0;
	$scope.uniqueMemberCount 	= 0;
	$scope.productCount 		= 0;
   
	$scope.getTagCount = function() {
		$http.post('backend/get/tag_count.php').
		success(function(data){
			
			$scope.tagCount = data;
		}).
		error(function(data){
			
		});		
	};
	
	
	$scope.getVoteCount = function() {
		$http.post('backend/get/vote_count.php').
		success(function(data){
			console.log(data);
			$scope.voteCount = data;
		}).
		error(function(data){
			
		});		
	};
	
	$scope.getOpinionCount = function() {
		$http.post('backend/get/opinion_count.php').
		success(function(data){
			console.log(data);
			$scope.opinionCount = data;
		}).
		error(function(data){
			
		});		
	};
	
	$scope.getUniqueMemberCount = function() {
		$http.post('backend/get/unique_member_count.php').
		success(function(data){
			console.log(data);
			$scope.uniqueMemberCount = data;
		}).
		error(function(data){
			
		});		
	};
	
	$scope.getProductCount = function() {
		$http.post('backend/get/product_count.php').
		success(function(data){
			console.log(data);
			$scope.productCount = data;
		}).
		error(function(data){
			
		});		
	};
	
	$scope.getProductCount();
	$scope.getUniqueMemberCount();
	$scope.getOpinionCount();
	$scope.getTagCount();
	$scope.getVoteCount();
});
