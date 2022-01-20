function loadDataEmail(){
    setTimeout(function (){
        $("#selectedRecords").load('ajax/loadRecordFromDbAjax.php', {
            column: 'email',
            value: $("#email").val()
        })
    }, 50)

}

function loadDataDate(){
    setTimeout(function (){
        $("#selectedRecords").load('ajax/loadRecordFromDbAjax.php', {
            column: 'date',
            value: $("#date").val()
        })
    }, 50)

}

$("#searchByDate").click(function () {
    loadDataDate();
})
$("#searchByEmail").click(function () {
    loadDataEmail()
})
