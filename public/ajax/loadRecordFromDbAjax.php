<?php
include __DIR__ . '/../../includes/autoload.php';
include __DIR__ . '/../../includes/DatabaseConnection.php';
$table = new \Common\DatabaseTable($pdo, 'user_reservations', 'id');
$controller = new \CleaningApp\Controllers\AdminPagesController($table);

$selectedData = $controller->getRecordsFromDb($_POST['column'], $_POST['value']);
if (count($selectedData) > 0){
    $definer = 1;
    foreach ($selectedData as $record){
        $deleteButtonId = 'deleteButton' . $definer;
        $editButtonId = 'editButton' . $definer;
        $editRecordId = 'editRecord' . $definer;
        $recordId = $record['id'];
        $inputNameId = 'name' . $definer;
        $inputEmailId = 'email' . $definer;
        $inputPhoneId = 'phone' . $definer;
        $inputApartmentId = 'apartment' . $definer;
        $inputDateId = 'date' . $definer;
        $inputTimeId = 'time' . $definer;
        $saveButtonId = 'saveRecord' . $definer;
        echo '
        <p><b>Name: </b>' . $record['name'] . ' <b>Email: </b> ' . $record['email'] . '
        <b>Phone Number: </b> ' . $record['phone_number'] . ' <b>Apartment Number</b>
        ' . $record['apartment_address'] . ' <b>Date: </b> ' . $record['date'] . '
        <b>Time: </b> ' . $record['time'] . '</p>
        <div class="btn" id="'. $deleteButtonId.'">delete</div>
        <div class="btn" id="'. $editButtonId.'">edit</div>
        <div class="editRecord" id="'. $editRecordId.'">
            <input type="text" id="'.$inputNameId.'" value="'.$record['name'].'">
            <input type="text" id="'.$inputEmailId.'" value="'.$record['email'].'">
            <input type="text" id="'.$inputPhoneId.'" value="'.$record['phone_number'].'">
            <input type="text" id="'.$inputApartmentId.'" value="'.$record['apartment_address'].'">
            <input type="date" id="'.$inputDateId.'" value="'.$record['date'].'">
            <input type="text" id="'.$inputTimeId.'" value="'.$record['time'].'">
            <input type="submit" id="'.$saveButtonId.'">
        </div>
        <script>
            $("#'.$editRecordId.'").css("display", "none");
            
            $("#'.$deleteButtonId.'").click(function (){
                $.post("/ajax/updateAjax.php", {
                    task: "delete",
                    id: '.$recordId.'
                })
                if ($("#'.$inputDateId.'").val() === $("#date").val()){
                    loadDataDate();
                }
                else {
                    loadDataEmail()
                }
            })
            $("#'.$saveButtonId.'").click(function (){
                $.post("/ajax/updateAjax.php", {
                    task: "update",
                    id: '.$recordId.',
                    name: $("#'.$inputNameId.'").val(),
                    email: $("#'.$inputEmailId.'").val(),
                    phone: $("#'.$inputPhoneId.'").val(),
                    apartment: $("#'.$inputApartmentId.'").val(),
                    date: $("#'.$inputDateId.'").val(),
                    time: $("#'.$inputTimeId.'").val()
                })
                //needs better solution, will cause error in some cases;
                if ($("#'.$inputDateId.'").val() === $("#date").val()){
                    loadDataDate();
                }
                else {
                    loadDataEmail()
                }
            })
            $("#'.$editButtonId.'").click(function (){
            console.log("im here2");
                if ($("#'.$editRecordId.'").css("display") === "none"){
                    $("#'.$editRecordId.'").css("display", "block");
                }else {
                console.log("im here3");
                    $("#'.$editRecordId.'").css("display", "none");
                }
                
            })
        </script>
        ';
        $definer++;
    }
}
else{
    echo 'no records';
}
