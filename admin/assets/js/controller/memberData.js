app.controller("MemberDataController", function($scope,$http) {
	$scope.currentPage 	= 0;
    $scope.pageSize 	= 10;
    $scope.data   		= [];
	$scope.search 		= '';
	$scope.edit			= {}
	
    $scope.numberOfPages = function(){
        return Math.ceil($scope.data.length/$scope.pageSize);                
    }
	$scope.getData = function() {
		$http.post('backend/get/member_data.php').
		success(function(data){
			$.each(data, function(index, value) {
				$scope.data.push(value);
			});
		}).
		error(function(data){
			
		});		
	};
	
	$scope.loadEdit = function(item) {
		$scope.edit = item.info;	
	};
	
	$scope.filterData = function(query){
		if (query.length == 0 ) {
			return $scope.data.slice($scope.currentPage*$scope.pageSize,$scope.currentPage*$scope.pageSize+$scope.pageSize);
		} else {
			return $scope.data.filter( function(item){return ((item.email.contains(query))||(item.login.contains(query)));} ).slice(0,10);
		}		
	}
		
	$scope.previous = function() {
		if ($scope.currentPage != 0) $scope.currentPage = $scope.currentPage - 1;
	}
	
	$scope.next = function() {
		if ($scope.currentPage < ($scope.data.length / $scope.pageSize - 1)) $scope.currentPage = $scope.currentPage + 1;
	}

});

//We already have a limitTo filter built-in to angular,
//let's make a startFrom filter
app.filter('startFrom', function() {
    return function(input, start) {
        start = +start; //parse to int
		console.log(input);
        return input.slice(start);
    }
});
String.prototype.contains = function(it) { return this.indexOf(it) != -1; };