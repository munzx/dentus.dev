var dentus = angular.module('dentus', ['ui.bootstrap','ngRoute']);

dentus.config(function ($routeProvider) {
	$routeProvider
	.when('/',{
		controller : 'home',
		templateUrl : 'partials/main.html'
	})
	.when('/admin',{
		controller : 'adminSubscribers',
		templateUrl : 'partials/adminSubscribers.html'
	})
	.when('/admin/subscribers',{
		controller : 'adminSubscribers',
		templateUrl : 'partials/adminSubscribers.html'
	})
	.when('/admin/admins',{
		controller : 'adminAdmins',
		templateUrl : 'partials/adminAdmins.html'
	})
	.when('/admin/users',{
		controller : 'adminUsers',
		templateUrl : 'partials/adminUsers.html'
	})
	.when('/admin/clinics',{
		controller : 'adminClinics',
		templateUrl : 'partials/adminClinics.html'
	})
	.when('/admin/visits',{
		controller : 'adminVisits',
		templateUrl : 'partials/adminVisits.html'
	})
	.when('/clinics',{
		controller : 'clinics',
		templateUrl : 'partials/clinics.html'
	})
	.when('/subscribers',{
		controller : 'subscribers',
		templateUrl : 'partials/subscribers.html'
	})
	.when('/faq',{
		controller : 'cms',
		templateUrl : 'partials/faq.html'
	})
	.when('/contactus',{
		controller : 'cms',
		templateUrl : 'partials/contactus.html'
	})
	.when('/login',{
		controller : 'login',
		templateUrl : 'partials/login.html'
	})
	.otherwise({redirectTo : '/'});
}).run(function ($rootScope) {
	$rootScope.home = '/';
	$rootScope.world = ["Afghanistan","Ã…land Islands","Albania","Algeria","American Samoa","AndorrA","Angola","Anguilla","Antarctica","Antigua and Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia and Herzegovina","Botswana","Bouvet Island","Brazil","British Indian Ocean Territory","Brunei Darussalam","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central African Republic","Chad","Chile","China","Christmas Island","Cocos (Keeling) Islands","Colombia","Comoros","Congo","Congo, The Democratic Republic of the","Cook Islands","Costa Rica","Cote D'Ivoire","Croatia","Cuba","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands (Malvinas)","Faroe Islands","Fiji","Finland","France","French Guiana","French Polynesia","French Southern Territories","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guadeloupe","Guam","Guatemala","Guernsey","Guinea","Guinea-Bissau","Guyana","Haiti","Heard Island and Mcdonald Islands","Holy See (Vatican City State)","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran, Islamic Republic Of","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Korea, Democratic People'S Republic of","Korea, Republic of","Kuwait","Kyrgyzstan","Lao People'S Democratic Republic","Latvia","Lebanon","Lesotho","Liberia","Libyan Arab Jamahiriya","Liechtenstein","Lithuania","Luxembourg","Macao","Macedonia, The Former Yugoslav Republic of","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Martinique","Mauritania","Mauritius","Mayotte","Mexico","Micronesia, Federated States of","Moldova, Republic of","Monaco","Mongolia","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauru","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","Niue","Norfolk Island","Northern Mariana Islands","Norway","Oman","Pakistan","Palau","Palestinian Territory, Occupied","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Pitcairn","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russian Federation","RWANDA","Saint Helena","Saint Kitts and Nevis","Saint Lucia","Saint Pierre and Miquelon","Saint Vincent and the Grenadines","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia and Montenegro","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Georgia and the South Sandwich Islands","Spain","Sri Lanka","Sudan","Suriname","Svalbard and Jan Mayen","Swaziland","Sweden","Switzerland","Syrian Arab Republic","Taiwan, Province of China","Tajikistan","Tanzania, United Republic of","Thailand","Timor-Leste","Togo","Tokelau","Tonga","Trinidad and Tobago","Tunisia","Turkey","Turkmenistan","Turks and Caicos Islands","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States","United States Minor Outlying Islands","Uruguay","Uzbekistan","Vanuatu","Venezuela","Viet Nam","Virgin Islands, British","Virgin Islands, U.S.","Wallis and Futuna","Western Sahara","Yemen","Zambia","Zimbabwe"];
	$rootScope.uaeCities = [
	'Abu Dhabi',
	'Al Ain',
	'Dubai',
	'Sharjah',
	'Ajman',
	'Ras Alkhayma',
	'Fujeera',
	'Um Alquween'
	];
});

dentus.controller('login',function  ($scope,$http,$location,$rootScope) {

	$http.get('check')
	.success(function (data,success) {
		if(data == 'true'){
			$scope.accessDenied = false;
			$scope.logIn = false;
			$scope.logOut = true;
		} else {
			$scope.accessDenied = false;
			$scope.logIn = true;
			$scope.logOut = false;
		}
	})

	$scope.doLogIn = function () {
		$http.post('login',$scope.logInfo)
		.success(function (data,success) {
			$scope.logIn = false;
			$scope.logOut = true;

			switch(data)
			{
				case '"admin"':
				$location.path('/admin');
				$rootScope.home = '/admin';
				break;
				case '"subscriber"':
				$location.path('/subscribers');
				$rootScope.home = '/subscribers';
				break;
				case '"clinic"': 
				$location.path('/clinics');
				$rootScope.home = '/clinics';
				break;
			}

		})
		.error(function (data,error) {
			$scope.accessDenied = true;
		});
	}

	$scope.doLogOut = function () {
		$http.get('logout')
		.success(function (data,success) {
			$location.path('/');
			$scope.accessDenied = false;
			$scope.logIn = true;
			$scope.logOut = false;
			$scope.logInfo = '';
		});
	}

});

dentus.controller('adminSubscribers',function ($http,$scope,$rootScope) {
	var saveStatus;
	$scope.noData = false;
	$scope.connectError = false;
	$scope.subscribersTable = true;
	$scope.newSubscriberForm = false;

	$http.get('subscribers')
	.success(function (data,success) {
		if(data.length == 0){
			$scope.noData = true;
		} else {
			$scope.subscribers = data;
			$scope.subscribersTable = true;
		}
	})
	.error(function (data,error) {
		$scope.connectError = true;
	});

	$scope.showNewSubscriberForm = function () {
		saveStatus = 'New';
		$scope.newSubscriberForm = true;
	}

	$scope.closeNewSubscriberForm = function () {
		saveStatus = '';
		$scope.newSubscriberForm = false;
		$scope.newSubscriberInfo = {};
	}

	$scope.closeConnectError = function () {
		$scope.connectError = false;
	}

	$scope.showSubscriberHistory = function (id) {
		$scope.subscribersTable = false;
		$scope.newSubscriberForm = false;
		$scope.subscriberHistory = true;
	}

	$scope.backToSubscribers = function () {
		$scope.subscribersTable = true;
		$scope.newSubscriberForm = false;
		$scope.subscriberHistory = false;		
	}

	$scope.saveSubscriber = function (id) {
		if(saveStatus === 'New'){
			var formData = new FormData($('#newSubscriberForm')[0]);
			$.ajax({
				url: 'subscribers/add',
				type: 'POST',
				data: formData,
				cache: false,
				success : function (data) {
					$scope.$apply(function() {
						$scope.newSubscriberInfo.id = data['id'];
						$scope.newSubscriberInfo.serial_number = parseInt(data['serial_number']);
						$scope.subscribers.unshift($scope.newSubscriberInfo);
						$scope.newSubscriberForm = false;
						$scope.newSubscriberInfo = {};
					});
				},
				error : function (XMLHttpRequest, textStatus, errorThrown) {
					$scope.$apply(function() {
						$scope.connectError = true;
					});
				},
				contentType: false,
				processData: false
			});
		} else {
			var formData = new FormData($('#newSubscriberForm')[0]);
			$.ajax({
				url: 'subscribers/'+id+'/update',
				type: 'POST',
				data: formData,
				cache: false,
				success : function (data) {
					$scope.$apply(function() {
						$scope.newSubscriberForm = false;
						$scope.newSubscriberInfo = {};
					});
				},
				error : function (XMLHttpRequest, textStatus, errorThrown) {
					$scope.$apply(function() {
						$scope.connectError = true;
					});
				},
				contentType: false,
				processData: false
			});
		}
	}

	$scope.editSubscriber = function (index,id) {
		saveStatus = 'Edit';
		$scope.newSubscriberInfo = $scope.subscribers[index];
		$scope.newSubscriberInfo['childern'] = parseInt($scope.subscribers[index].childern);
		$scope.newSubscriberInfo['mobile_number'] = parseInt($scope.subscribers[index].mobile_number);
		$scope.newSubscriberInfo['company_phone'] = parseInt($scope.subscribers[index].company_phone);
		$scope.newSubscriberForm = true;
	}

	$scope.removeSubscriber = function (index,id) {
		var answer = confirm('Are you sure you wants to delete ' + $scope.subscribers[index].first_name + ' ' + $scope.subscribers[index].last_name + ' ?');
		if(answer ===  true){
			$http.get('subscribers/'+id+'/delete')
			.success(function (data,success) {
				$scope.subscribers.splice(index,1);
			})
			.error(function (data,success) {
				$scope.connectError = true;
			});
		}
	}

	$scope.genderOptions = [
	'male',
	'female'
	];

	$scope.martialStatusOptions = [
	'Single',
	'Married'
	];

	$scope.nationalityOptions = $rootScope.world;

	$scope.workStatusOptions = [
	'Student',
	'Employed',
	'Unemployed'
	];

	$scope.cityOptions = $rootScope.uaeCities;


});

dentus.controller('adminAdmins',function ($http,$scope) {
	var saveStatus;
	$scope.noData = false;
	$scope.connectError = false;
	$scope.adminsTable = false;
	

	$http.get('admins')
	.success(function (data,success) {
		if(data.length === 0){
			$scope.noData = true;
		} else {
			$scope.admins = data;
			$scope.adminsTable = true;
		}
	})
	.error(function (data,error) {
		$scope.connectError = true;
	});

	$scope.showAdminInfoForm = function () {
		saveStatus = 'Add';
		$scope.newAdminfoForm = true;
	}

	$scope.closeNewAdminfoForm = function () {
		$scope.newAdminfoForm = false;
	}

	$scope.closeConnectError = function () {
		$scope.connectError = false;
	}

	$scope.editAdmin = function (index) {
		saveStatus = 'Edit';
		$scope.newAdminInfo = $scope.admins[index];
		$scope.newAdminfoForm = true;
	}

	$scope.saveAdmin = function (id) {
		if(saveStatus === 'Add'){
			$http.post('admins/add',$scope.newAdminInfo)
			.success(function (data,success) {
				$scope.newAdminInfo.id = data;
				$scope.admins.unshift($scope.newAdminInfo);
				$scope.newAdminfoForm = false;
				$scope.newAdminInfo = {};
			})
			.error(function (data,error) {
				$scope.connectError = true;
			});
		} else {
			$http.post('admins/'+id+'/edit',$scope.newAdminInfo)
			.success(function (data,success) {
				$scope.newAdminfoForm = false;
				$scope.newAdminInfo = {};
			})
			.error(function (data,error) {
				$scope.connectError = true;
			});	
		}
	}

	$scope.deleteAdmin = function (index,id) {
		var answer = confirm('Are you sure you wants to delete the admin ' + $scope.admins[index].first_name + ' ' + $scope.admins[index].last_name + ' ?');
		if(answer === true){
			$http.get('admins/'+id+'/delete')
			.success(function (data,success) {
				$scope.admins.splice(index,1);
			})
			.error(function (data,error) {
				$scope.connectError = true;
			});
		}
	}


});

dentus.controller('adminClinics',function ($http,$scope,$rootScope) {
	var saveStatus;
	$scope.noData = false;
	$scope.connectError = false;
	$scope.clinicsTable = false;

	$http.get('clinics')
	.success(function (data,success) {
		if(data.length === 0){
			$scope.noData = true;
		} else {
			$scope.clinics = data;
			$scope.clinicsTable = true;
		}
	})
	.error(function (data,error) {
		$scope.connectError = true;
	});

	$scope.showClincData = function (id) {
		$scope.clinicsTable = false;
		$scope.newClinicForm = false;
		$scope.clinicData = true;
	}

	$scope.backToClinics = function () {
		$scope.clinicsTable = true;
		$scope.clinicData = false;
	}

	$scope.closeConnectError = function () {
		$scope.connectError = false;
	}

	$scope.closeNewClincForm = function () {
		$scope.newClinicForm = false;
	}

	$scope.showNewClinicForm = function () {
		saveStatus = 'Add';
		$scope.newClinicForm = true;
	}

	$scope.cityOptions = $rootScope.uaeCities;

	$scope.editClinic = function (index) {
		saveStatus = 'Edit';
		$scope.newClinicInfo = $scope.clinics[index];
		$scope.newClinicInfo['phone_number'] = parseInt($scope.clinics[index].phone_number);
		$scope.newClinicForm = true;
	}

	$scope.deleteClinic = function (index,id) {
		var answer = confirm('Are you sure you wants to delete "' + $scope.clinics[index].name + '" clinic ?');

		if(answer === true){
			$http.get('clinics/'+id+'/delete')
			.success(function (data,success) {
				$scope.clinics.splice(index,1);
			})
			.error(function (data,error) {
				$scope.connectError = true;
			});
		}
	}

	$scope.saveClinic = function (id) {
		if(saveStatus === 'Add'){
			var clinicFormData = new FormData($('#newClinicInfo')[0]);
			$.ajax({
				url: 'clinics/add',
				type: 'POST',
				data: clinicFormData,
				cache: false,
				success : function (data) {
					$scope.$apply(function() {
						$scope.newClinicInfo.id = data;
						$scope.clinics.unshift($scope.newClinicInfo);
						$scope.newClinicForm = false;
						$scope.newClinicInfo = {};
					});
				},
				error : function (XMLHttpRequest, textStatus, errorThrown) {
					$scope.$apply(function() {
						$scope.connectError = true;
					});
				},
				contentType: false,
				processData: false
			});
		} else {
			var clinicFormData = new FormData($('#newClinicInfo')[0]);
			$.ajax({
				url: 'clinics/'+id+'/update',
				type: 'POST',
				data: clinicFormData,
				cache: false,
				success : function (data) {
					$scope.$apply(function() {
						$scope.newClinicForm = false;
						$scope.newClinicInfo = {};
					});
				},
				error : function (XMLHttpRequest, textStatus, errorThrown) {
					$scope.$apply(function() {
						$scope.connectError = true;
					});
				},
				contentType: false,
				processData: false
			});
		}
	}


});

dentus.controller('adminVisits',function ($http,$scope) {
	$scope.noData = false;
	$scope.connectError = false;
	$scope.visitsTable = false;

	$scope.closeConnectError = function () {
		$scope.connectError = false;
	}

	$http.get('visits')
	.success(function (data,success) {
		if(data.length === 0){
			$scope.noData = true;
		} else {
			$scope.visits = data;
			$scope.visitsTable = true;
		}
	})
	.error(function (data,error) {
		$scope.connectError = true;
	});

	$scope.deleteVisit = function (index,id) {
		var answer = confirm('Are you sure you wants to delete this visit ?');
		if(answer === true){
			$http.get('visits/'+id+'/delete')
			.success(function (data,success) {
				$scope.visits.splice(index,1);
			})
			.error(function (data,error) {
				$scope.connectError = true;
			});
		}
	}

});

dentus.controller('home',function () {
	
});

dentus.controller('admin',function () {
	
});

dentus.controller('clinics',function ($scope,$http) {
	$scope.connectError = false;
	$scope.noData = false;
	$scope.visitTable = false;
	$scope.subscriberHistory = false;
	$scope.serialNumberForm = true;



	$http.get('clinics/myvisits')
	.success(function (data,success) {
		if(data.length == 0){
			$scope.noData = true;
		} else {
			$scope.visits = data;
			$scope.visitTable = true;
		}
	})
	.error(function (data,error) {
		$scope.noData = true;
		$scope.connectError = true;
	});


	//if the search has been carried out then show the person image otherwise
	//show a defualt image , here we keep the images sources
	var imageSource = {
		default : 'images/clint-icon.jpg',
		subscriber : ''
	};

	$scope.showImage = imageSource.default;

	$scope.closeSearchNotFoundMsg = function () {
		$scope.SearchNotFoundMsg = false;
		$scope.subscriberHistory = false;
	}

	$scope.search = function ($subscriber_id) {
		$http.get('search/subscribers/' + $scope.serialNumber)
		.success(function (data,success) {
			$scope.SearchNotFoundMsg = false;
			$scope.serialNumberForm = false;
			$scope.serialNumber = '';
			$scope.subscriberHistory = true;
			$scope.visitTable = false;
			$scope.searchResult = data;
			imageSource.subscriber = 'uploads/' + data[0].img_link;
			$scope.showImage = imageSource.subscriber;
		})
		.error(function (data,error) {
			$scope.subscriberHistory = false;
			$scope.SearchNotFoundMsg = true;
		});
	}

	$scope.closeConnectError = function () {
		$scope.connectError = false;
	}

	$scope.saveVisit = function () {
		$scope.newVisitInfo.subscriber_id = $scope.searchResult[0].id;
		$http.post('visits/add',$scope.newVisitInfo)
		.success(function (data,success) {
			$scope.SearchNotFoundMsg = false;
			$scope.serialNumberForm = true;
			$scope.serialNumber = '';
			$scope.subscriberHistory = false;
			$scope.visitTable = true;
			$scope.newVisitInfo = {};

			//the subscriber data to be entered in the vistts form
			var subscriberInfo = {};
			subscriberInfo.first_name = $scope.searchResult[0].first_name;
			subscriberInfo.last_name = $scope.searchResult[0].last_name;
			subscriberInfo.birthdate = $scope.searchResult[0].birthdate;
			subscriberInfo.id = data['id'];
			subscriberInfo.case = data['case'];
			subscriberInfo.treatment = data['treatment'];
			subscriberInfo.created_at = data['created_at'];

			$scope.visits.unshift(subscriberInfo);
		})
		.error(function (data,error) {
			$scope.connectError = true;
		});
	}

	$scope.cancelSaveVisit = function () {
		$scope.SearchNotFoundMsg = false;
		$scope.serialNumberForm = true;
		$scope.serialNumber = '';
		$scope.subscriberHistory = false;
		$scope.visitTable = true;
		$scope.showImage = imageSource.default;
	}

});

dentus.controller('cms',function () {
	
});

dentus.controller('subscribers',function ($http,$scope) {
	$scope.visitsHistory = true;
	$scope.vistsDetailsNotFound = true;

	$http.get('subscribers/myinfo')
	.success(function (data,success) {
		$scope.subscriberPageInfo = data;
		if($scope.subscriberPageInfo[0].clinic_name){
			$scope.vistsDetails = true;
			$scope.vistsDetailsNotFound = false;
		}
	})
	.error(function (data,error) {
		$scope.connectError = true;
	});

	$scope.closeConnectError = function () {
		$scope.connectError = false;
	}

	$scope.showVisitDetail = function (index) {
		$scope.visitInfo = $scope.subscriberPageInfo[index];
		$scope.visitsHistory = false;
		$scope.visitDetail = true;
	}

	$scope.closeVisitDetail = function () {
		$scope.visitsHistory = true;
		$scope.visitDetail = false;	
	}

});