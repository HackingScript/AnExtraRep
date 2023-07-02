document.getElementById('userForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission

    var formData = new FormData(this);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'insert.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            alert('User details and PDF file inserted successfully!');
            document.getElementById('userForm').reset();
        } else {
            alert('An error occurred. Please try again.');
        }
    };
    xhr.send(formData);
});
