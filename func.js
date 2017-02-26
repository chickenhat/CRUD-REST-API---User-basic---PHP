/**
 * Created by Alice on 2/21/2017.
 */
function Send(url, method, params, callback, id) {
    var http = new XMLHttpRequest();
    http.open(method, url, true);
    var result;
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.onreadystatechange = function() {//Call a function when the state changes.
        if(http.readyState == 4 && http.status == 200) {
            result = http.responseText;
            window[callback](result,id);
        }
    }
    http.send(params);
}

$(document).ready(function(){
    $('#get-all-user').click(function () {
        Send('api.php/user','GET','','showresult','result0');
    });
    $('#get-user').click(function () {
        var username = $('#get-username').val();
        Send('api.php/user/'+username,'GET','','showresult','result0');
    });
    $('#add-user').click(function () {
        var username=$('#add-username').val();
        var password=$('#add-password').val();
        var email=$('#add-email').val();
        var profileName=$('#add-profilename').val();
        console.log(username,password,email);
        Send('api.php/user','POST','username='+username+'&password='+password+'&email='+email+'&profileName='+profileName,'showresult','result1');
    });
    $('#del-user').click(function () {
        var username=$('#del-username').val();
        console.log(username);
        Send('api.php/user/'+username,'DELETE','','showresult','result2');
    });
    $('#change-user').click(function () {
        var username=$('#change-username').val();
        var password=$('#change-password').val();
        var email=$('#change-email').val();
        var profileName=$('#change-profilename').val();
        console.log(username,password,email);
        Send('api.php/user/'+username,'PUT','username='+username+'&password='+password+'&email='+email+'&profileName='+profileName,'showresult','result3');
    });
});

function showresult(text, id) {
    $('#'+id).html('<pre>'+text+'</pre>');
}