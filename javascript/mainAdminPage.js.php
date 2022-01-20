function loadDataEmail(){
    $("#selectedRecords").load('ajax/loadRecordFromDbAjax.php', {
        column: 'email',
        value: $("#email").val()
    })
}
function loadDataDate(){
    $("#selectedRecords").load('ajax/loadRecordFromDbAjax.php', {
        column: 'date',
        value: $("#date").val()
    })
}

$("#searchByDate").click(function () {
    loadDataDate();
})
$("#searchByEmail").click(function () {
    loadDataEmail()
})
