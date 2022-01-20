<div class="makeReservations container-fluid">
    <div class="container">
        <form action="" method="post">
            <div class="row">
                <h3>Register For cleaning services</h3>
                <input type="text" name="clientName" placeholder="Your name..." required>

                <input type="text" name="clientEmail" placeholder="Your email ..." required>

                <input type="tel" name="clientPhoneNumber" placeholder="Phone number..." required>

                <input type="text" name="clientApartmentAddress" placeholder="Apartment address..." required>

                <!--        TODO dateNow defined as variable in controller as this day.-->
                <label for="dateOfReservation">Select Date</label>
                <input type="date" name="dateOfReservation" min="<?=$dateNow?>" required>

                <!--        TODO set available hours between 7am to 22pm-->
                <label for="timeOfReservation">Select Time</label>
                <select name="timeOfReservation" id="" required>
                    <option value="">select time</option>
                    <?php foreach (range(7, 22) as $hour):?>
                    <option value="<?=$hour?>"><?=$hour . ':00h'?></option>
                    <?php endforeach;?>
                </select>
                <input type="submit">
                <?php if (!empty($errors)): ?>
                <?php foreach ($errors as $error):?>
                    <p><?=$error?></p>
                    <br>
                <?php endforeach;?>
                <?php endif;?>
                <p class="success"><?=$message ?? null?></p>
            </div>

        </form>
    </div>
</div>
