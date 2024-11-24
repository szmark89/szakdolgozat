$(document).ready(function () {
    var modalContainer = $('#modalContainer');

    $('#loginBtn').click(function () {
        $.ajax({
            url: 'login.html',
            success: function (data) {
                modalContainer.html(data);
                modalContainer.show();

                // Bezárás gomb regisztrálása
                $('.close').click(function () {
                    modalContainer.hide();
                });

                $('#loginForm').submit(function (event) {
                    event.preventDefault();

                    var formData = {
                        username: $('#username').val(),
                        password: $('#password').val()
                    };

                    $.ajax({
                        type: 'POST',
                        url: 'login.php',
                        data: formData,
                        success: function (response) {
                            if (response.includes("Sikeres")) {
                                showSuccessToast("Sikeres bejelentkezés!");
                                modalContainer.hide();
                                updateNavbar();
                            } else {
                                showErrorToast(response);
                            }
                        }
                    });
                });
            }
        });
    });

    // Kijelentkezés kezelése zöld toast megjelenítésével
    $('#logoutBtn').click(function () {
        $.post('login.php', {
            logout: true
        }, function (response) {
            $('#successToast').text(response); // Kijelentkezési üzenet
            showSuccessToast("Sikeres kijelentkezés!"); // Zöld toast megjelenítése
            updateNavbar();
        });
    });
});

function updateNavbar() {
    $.ajax({
        url: 'navbar.php',
        success: function (data) {
            $('#navbar').html(data); // Újra beillesztjük a frissített navbar tartalmat
        }
    });
}

// Toast megjelenítése a hibás jelszóhoz
function showErrorToast(response) {
    var toast = $('#errorToast');
    toast.text(response);
    toast.addClass('show'); // Láthatóvá tesszük a toast-ot
    setTimeout(function () {
        toast.removeClass('show'); // 3 másodperc után eltűnik
    }, 3000);
}

// Toast megjelenítése kijelentkezéskor
function showSuccessToast(msg) {
    var toast = $('#successToast');
    toast.text(msg);
    toast.addClass('show');
    setTimeout(function () {
        toast.removeClass('show');
    }, 3000);
}
