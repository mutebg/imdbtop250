<!DOCTYPE html>
	<html ng-app="imdb">
	<head>
		<base href="">
		<title></title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="user-scalable=no, width=device-width, maximum-scale=1.0">
		<meta name="description" content="">
		<meta name="keywords" content="">

		<link rel="stylesheet" href="css/main.css">
		
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.8/angular.min.js"></script>
		<script src="js/app.js"></script>
		<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,300,700' rel='stylesheet' type='text/css'>
	</head>
	<body ng-controller="Movies">
		<header>
			<h1>Top 250 checklist</h1>
			<p>your list is <strong>{{percent}}</strong>% ({{lenght}}) complete</p>
		</header>
		
		<div class="filter clearfix">
			<input type="text" class="search" ng-model="search" value="" placeholder="find movie..."/>
			<p class="by-year">
				By year: 
				<a href="" class="year" ng-click="rangeMin = 0; 	rangeMax = 1949"><1950</a>,
				<a href="" class="year" ng-click="rangeMin = 1950; 	rangeMax = 1959">1950 to 1959</a>,
				<a href="" class="year" ng-click="rangeMin = 1960; 	rangeMax = 1969">1960 to 1969</a>,
				<a href="" class="year" ng-click="rangeMin = 1970; 	rangeMax = 1979">1970 to 1979</a>,
				<a href="" class="year" ng-click="rangeMin = 1980; 	rangeMax = 1989">1980 to 1989</a>,
				<a href="" class="year" ng-click="rangeMin = 1990; 	rangeMax = 1999">1990 to 1999</a>,
				<a href="" class="year" ng-click="rangeMin = 2000; 	rangeMax = 3000">>2000</a>
				<a href="" class="year selected" ng-click="rangeMin = 0; 	rangeMax = 3000">All</a><br />
				By watch 
				<a href="" class="watch selected" ng-click="watchType = null ">All</a>, 
				<a href="" class="watch" ng-click="watchType = true">Only watched</a>, 
				<a href="" class="watch" ng-click="watchType = false">Only unwatched</a> 

			</p>
		</div>


		<div class="movies">
			<div class="movie" ng-repeat="movie in movies | filter:search | filter:rangeFilter | filter:watchFilter ">

				<a href="http://www.imdb.com/title/{{movie.id}}" class="poster" target="_blank">
					<img src="{{movie.large_img}}" />
				</a>
				<h2 class="title">{{movie.title}}</h2>
				<div class="year">{{movie.year}}</div>
				<p class="info">	
					Rating <span class="rating">{{movie.rating}}/10</span>
					from <span class="voters">{{movie.voters}} users</span>
				</p>
				<div class="number">{{movie.number}}</div>
				<button class="btn" ng-click="watch(movie.number-1)" ng-show="!movie.watched">Mark as watched</button>
				<button class="btn orange" ng-click="watch(movie.number-1)" ng-show="movie.watched">Watched</button>
			</div>
		
		</div>

		<script>
			$(function(){
				$('.by-year a').on('click', function(e){
					e.preventDefault();
					if ( $(this).hasClass('year') ) {
						$('.by-year a.year').removeClass('selected');
					} else {
						$('.by-year a.watch').removeClass('selected');
					}	
					$(this).addClass('selected');
				});
			});
		</script>
	</body>
</html>