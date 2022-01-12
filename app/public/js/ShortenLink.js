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
                displayNewLink(data.short_link);
            },
            error: function (data) {
                console.log(data);
                wipePrevData();
                displayNewLink(data.responseJSON.message);
            }
        });
    }
}

function wipePrevData() {
    var paragraph = document.getElementById("new_link");
    paragraph.innerText = "New link:";
}

function displayNewLink(link) {
    var paragraph = document.getElementById("new_link");
    paragraph.innerText += " " + link;
}
