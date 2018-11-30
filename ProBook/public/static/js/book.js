var app = angular.module('myApp', []);
app.controller('bookCtrl', function($scope, $http, $timeout) {

    $scope.bookbases = [
        {id:1, imgPath:'/static/img/contoh_buku.png', title:'Merangkai Mimpi', authors:'thareq', price:'4', description:'Satu kata yaitu mantuy bet gakuat kaka'},
        {id:2, imgPath:'/static/img/contoh_buku.png', title:'Untuk Masa Depan Kita', authors:'habibi', price:'5', description:'Kenangan begitu indah untukmu sayang'},
        {id:3, imgPath:'/static/img/contoh_buku.png', title:'Demi Kehidupan yang Indah', authors:'yasya', price:'5', description:'Pege'}
    ];
    $scope.empty = false;
    $scope.search = false;
    $scope.load = false;

    $scope.change = function() {
        $scope.books = [];
        $scope.empty = false;
        $scope.load = true;
        send = $scope.searchText;
        console.log(send);
        $timeout(function () {
            $http.get('http://localhost:4000/search/?query='+send).then(function(response) {
                $scope.books = response.data.data;
                $scope.load = false;
                $scope.search = true;
                if ($scope.books === undefined || $scope.books.length == 0) {
                    console.log(16);
                    $scope.empty = true;
                }
                console.log($scope);
            });
        }, 1000);


        // $scope.search = false;
        // $http.get('http://localhost:4000/search/?query=' + send).then(function(result){
        //     $scope.books = result.data;
        // })
    };

    // $scope.searchQuery = function(searchText) {
    //     $scope.search = true;
    //     $scope.books = [];
    //
    //
    //     //$scope.books.push(query);
    //     for(var i = 0, size = $scope.bookbases.length; i < size ; i++){
    //         var item = $scope.bookbases[i];
    //         //$scope.books.push(item);
    //         if ((item.title).indexOf(query) >=0) {
    //             $scope.books.push(item);
    //         }
    //     }
    //
    //
    // };



});



// $.ajax({
//     type:"GET",
//     url: "http://localhost:4000/search/?query=Flowers",
//     success: function(data) {
//         $("body").append(JSON.stringify(data));
//     },
//     error: function(jqXHR, textStatus, errorThrown) {
//         alert(jqXHR.status);
//     },
//     dataType: "jsonp"
// });​​​​​​​​​​​​​​​

