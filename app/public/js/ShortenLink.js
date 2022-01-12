function shortenLink() {
    let link = document.getElementById('link').value;
    if (!link) {
        alert("Поле не может быть пустым!");
    } else {
        $.ajax({
            method: 'GET',
            url: 'http://127.0.0.1:8080/api/short-link?link=' + link,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                wipePrevData();
                displayResponse(data.short_link);
            },
            error: function (data) {
                console.log(data);
                wipePrevData();
                displayResponse(data.responseJSON.message);
            }
        });
    }
}

function wipePrevData() {
    var paragraph = document.getElementById("new_link");
    paragraph.innerText = "New link:";
}

function displayResponse(response) {
    var paragraph = document.getElementById("new_link");
    paragraph.innerText += " " + response;
}
