
<div class="container d-flex justify-content-between adminMainPage">
    <div class="getByDate w-30">
        <h5>Select all records on specific date</h5>
        <input type="date"  id="date">
        <div class="btn" id="searchByDate">search</div>
    </div>
    <div class="getByEmail w-30 ">
        <h5>Select records on specific email</h5>
        <input type="text" id="email">
        <div class="btn" id="searchByEmail">search</div>
    </div>
</div>
<div class="container records">
    <div id="selectedRecords">

    </div>
</div>


<script>
    <?php
        include __DIR__ . '/../javascript/mainAdminPage.js.php';
    ?>
</script>