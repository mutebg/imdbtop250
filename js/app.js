var app = angular.module('imdb', []);

app.controller('Movies', function( $scope, $http, Storage ){
	$scope.movies = [];
	$scope.rangeMin = 0;
	$scope.rangeMax = new Date().getFullYear();
	$scope.watchType = null;
	
	Storage.load();

	var myList = Storage.list();
	$scope.lenght = Object.keys(myList).length;
	$scope.percent = Math.ceil( $scope.lenght * 0.4 );

	$http.get('backend/parser.php').success( function(data) {
		angular.forEach(data, function(value, key){
			data[key]['number'] = key + 1;
			if ( myList[value.id] == null ){
				data[key]['watched'] = false;
			} else {
				data[key]['watched'] = true;
			}
		});
		$scope.movies = data;
	});

	$scope.watch = function(index) {
		var id = $scope.movies[index].id;
		$scope.movies[index].watched = ! $scope.movies[index].watched;
		
		if ( ! Storage.isAdded(id) ) {
			Storage.add(id);
		} else {
			Storage.remove(id);
		}		
		
		$scope.lenght = Object.keys( Storage.list() ).length;
		$scope.percent = Math.ceil( $scope.lenght * 0.4 );
	}

	$scope.rangeFilter = function(movie){
		if( movie.year > $scope.rangeMin && movie.year < $scope.rangeMax) {
	        return true;
	    }
	    return false;
	};

	$scope.watchFilter = function(movie){
		if ( $scope.watchType == null ) {
			return true;
		}	

	  	if( movie.watched == $scope.watchType ) {
	        return true;
	    }

	    return false;
	};
});

function Watched() {
	this.items = {};
	this.storage = localStorage;
	this.storageKey = 'fav-items';
}

Watched.prototype.add = function(id) {
	this.items[id] = id;
	this.save();
}

Watched.prototype.remove = function(id) {
	delete this.items[id];
	this.save();
}

Watched.prototype.list = function() {
	return this.items;
}

Watched.prototype.save = function() {
	this.storage.setItem( this.storageKey, JSON.stringify(this.items) );
}

Watched.prototype.isAdded = function(id) {
	if ( typeof this.items[id] !== 'undefined' ) {
		return true;
	}
	return false;
}

Watched.prototype.load = function() {
	var items = this.storage.getItem( this.storageKey );
	if ( items != null ) {
		this.items = JSON.parse(items);
	}
}

var Watched = function () {
	var factory = {};
	
	factory.items = {};
	factory.storage = localStorage;
	factory.storageKey = 'fav-items';

	factory.add = function(id) {
		this.items[id] = id;
		this.save();
	}

	factory.remove = function(id) {
		delete this.items[id];
		this.save();
	}

	factory.list = function() {
		return this.items;
	}

	factory.save = function() {
		this.storage.setItem( this.storageKey, JSON.stringify(this.items) );
	}

	factory.isAdded = function(id) {
		if ( typeof this.items[id] !== 'undefined' ) {
			return true;
		}
		return false;
	}

	factory.load = function() {
		var items = this.storage.getItem( this.storageKey );
		if ( items != null ) {
			this.items = JSON.parse(items);
		}
	}

	return factory;
};
app.factory('Storage', [Watched]);