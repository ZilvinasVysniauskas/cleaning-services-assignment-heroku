<script>
    let username;
    let password;
    function passwordCheck() {
        username = prompt("admin user name: ");
        password = prompt("admin password: ");
        if (username && password){
            post({adminName: username, adminPassword: password});
        }
        else {
            location.replace(window.location.origin);
        }

    }
    window.onload=passwordCheck;

    function post(params){
        const form = document.createElement('form');
        form.method = 'post';
        form.action = '';
        for (const [key, value] of Object.entries(params)){
            const hiddenField = document.createElement('input');
            hiddenField.type = 'hidden';
            hiddenField.name = key;
            hiddenField.value = value;

            form.appendChild(hiddenField);
        }
        document.body.appendChild(form);
        form.submit();
    }

</script>