<div class="container">
    <h3>Choose download criteria</h3>
    <div>
        <form action="" method="post">
            <p>Date  range: </p>
            <div>
                <select name="dateRange" onchange="changeDisplay('#dateRange', '#dateRangeInputs')" id="dateRange">
                    <option value="noInputs">All dates</option>
                    <option value="showInputs">Range from-to</option>
                </select>
                <div id="dateRangeInputs">
                    <p>From:</p>
                    <input type="date" name="dateFrom">
                    <p>To:</p>
                    <input type="date" name="dateTo">
                </div>
            </div>

            <p>Time Range: </p>
            <div>
                <select name="timeRange" onchange="changeDisplay('#timeRange', '#timeRangeInputs')" id="timeRange">
                    <option value="noInputs">All times</option>
                    <option value="showInputs">Range from-to</option>
                </select>
                <div id="timeRangeInputs">
                    <p>From:</p>
                    <select name="timeFrom" id="">
                        <option value="">select time</option>
                        <?php foreach (range(7, 22) as $hour):?>
                            <option value="<?=$hour?>"><?=$hour . ':00h'?></option>
                        <?php endforeach;?>
                    </select>
                    <p>To:</p>
                    <select name="timeTo" id="">
                        <option value="">select time</option>
                        <?php foreach (range(7, 22) as $hour):?>
                            <option value="<?=$hour?>"><?=$hour . ':00h'?></option>
                        <?php endforeach;?>
                    </select>

                </div>
            </div>
            <input type="submit" value="download csv">
        </form>
        <div>
            <?php if (!empty($errors)):?>
                <?php foreach ($errors as $error):?>
                    <p><?=$error?></p>
                <?php endforeach;?>
            <?php endif; ?>
        </div>
    </div>
</div>
<script>
    $("#dateRangeInputs").css('display', 'none');
    $("#timeRangeInputs").css('display', 'none');
    function changeDisplay(choice, inputs){
        if ($(choice).val() === 'showInputs'){
            $(inputs).css("display", "block")
        }
        else{
            $(inputs).css("display", "none")
        }
    }

</script>