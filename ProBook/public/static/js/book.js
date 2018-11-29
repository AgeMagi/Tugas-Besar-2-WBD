angular.module('myApp', []).controller('bookCtrl', function($scope) {

    $scope.books = [
        {id:1, img_path:'/static/img/contoh_buku.png', title:'Merangkai Mimpi', author:'thareq', rating:'4', description:'Satu kata yaitu mantuy bet gakuat kaka'},
        {id:2, img_path:'/static/img/contoh_buku.png', title:'Untuk Masa Depan Kita', author:'habibi', rating:'5', description:'Kenangan begitu indah untukmu sayang'},
        {id:3, img_path:'/static/img/contoh_buku.png', title:'Demi Kehidupan yang Indah', author:'yasya', rating:'5', description:'Pege'}
    ];

    $scope.search = false;
    #scope.searchQuery = function(query) {
        $scope.search = true;

    };

});