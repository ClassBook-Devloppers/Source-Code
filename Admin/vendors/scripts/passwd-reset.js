 document.getElementById('resetForm').addEventListener('submit', function(e) {
            e.preventDefault();
            document.getElementById('message').innerHTML = '';
            var email = document.getElementById('email').value;

            // Envoi des données via AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'reset-password.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        document.getElementById('message').innerHTML = xhr.responseText;
                    } else {
                        console.error('Une erreur s\'est produite.');
                    }
                }
            };
            xhr.send('email=' + encodeURIComponent(email));
        });