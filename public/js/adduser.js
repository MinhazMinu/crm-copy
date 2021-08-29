$(document).ready(function () {
    var url = "ajax/get_role.php";
    callajax(url, "", successUser, "json", "GET");

    function successUser(resp) {
        var option = '<option value=""> Choose Role</option>';
        for (var i in resp) {
            var key = resp[i];
            option +=
                '<option value="' + key.code + '">' + key.name + "</option>";
        }
        $("#role").html(option);
    }
});

function callajax(url, data, successUser, dataType, method) {
    $.ajax({
        url: url,
        data: data,
        dataType: dataType,
        method: method,
    })
        .done(function (resp) {
            successUser(resp);
        })
        .fail(function () {
            alert("Serer error");
        });
}
