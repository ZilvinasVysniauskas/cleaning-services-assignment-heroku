function loadDataEmail(){
    setTimeout($("#selectedRecords").load('ajax/loadRecordFromDbAjax.php', {
        column: 'email',
        value: $("#email").val()
    }),10000);

}

function loadDataDate(){
    setTimeout($("#selectedRecords").load('ajax/loadRecordFromDbAjax.php', {
        column: 'date',
        value: $("#date").val()
    }), 10000);

}

$("#searchByDate").click(function () {
    loadDataDate();
})
$("#searchByEmail").click(function () {
    loadDataEmail()
})
