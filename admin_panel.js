$(document).ready(function () {
    // Új termék hozzáadása
    $('body').off('submit', '#addProductForm').on('submit', '#addProductForm', function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append('action', 'add');

        $.ajax({
            url: 'admin_panel.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                try {
                    const res = JSON.parse(response);
                    if (res.success) {
                        showSuccessToast('Termék sikeresen hozzáadva!');
                        $('#content').load('admin_panel.php'); // Frissítés
                    } else {
                        showErrorToast(res.error || 'Hiba történt a termék hozzáadásakor.');
                    }
                } catch (e) {
                    console.error('Nem érvényes JSON válasz:', response);
                    showErrorToast('Szerverhiba történt.');
                }
            },
            error: function () {
                showErrorToast('Kapcsolódási hiba történt.');
            }
        });
    });

    // Kép módosítása
    $('body').off('click', '.clickable-image').on('click', '.clickable-image', function () {
        const productId = $(this).data('id');
        const fileInput = $('<input type="file" accept="image/*">');
        const imageElement = $(this);

        fileInput.on('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    imageElement.attr('src', e.target.result); // Előnézet frissítése
                };
                reader.readAsDataURL(file);

                const formData = new FormData();
                formData.append('action', 'update-image');
                formData.append('id', productId);
                formData.append('image', file);

                $.ajax({
                    url: 'admin_panel.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        try {
                            const res = JSON.parse(response);
                            if (res.success) {
                                showSuccessToast('Kép sikeresen frissítve!');
                            } else {
                                showErrorToast(res.error || 'Hiba történt a kép frissítése során.');
                            }
                        } catch (e) {
                            console.error('Nem érvényes JSON válasz:', response);
                            showErrorToast('Szerverhiba történt.');
                        }
                    },
                    error: function () {
                        showErrorToast('Kapcsolódási hiba történt.');
                    }
                });
            }
        });

        fileInput.click();
    });

     $('body').off('blur', '[contenteditable="true"]').on('blur', '[contenteditable="true"]', function () {
        const element = $(this);
        const originalValue = element.data('original-value') || element.text().trim();
        const newValue = element.text().trim();
        const id = element.data('id');
        const field = element.data('field');

        // Ha nincs változás, ne küldjünk semmit
        if (originalValue === newValue) {
            return;
        }

        // AJAX kérés az inline szerkesztéshez
        $.ajax({
            url: 'admin_panel.php',
            type: 'POST',
            data: {
                action: 'update-inline',
                id: id,
                field: field,
                value: newValue
            },
            success: function (response) {
                try {
                    const res = JSON.parse(response);
                    if (res.success) {
                        showSuccessToast('Módosítás sikeres!');
                        element.data('original-value', newValue); // Eredeti érték frissítése
                    } else {
                        showErrorToast(res.error || 'Hiba történt a frissítés során.');
                    }
                } catch (e) {
                    console.error('Nem érvényes JSON válasz:', response);
                    showErrorToast('Szerverhiba történt.');
                }
            },
            error: function () {
                showErrorToast('Kapcsolódási hiba történt.');
            }
        });
    });

    // Az eredeti érték beállítása, amikor az elemre fókuszálunk
    $('body').off('focus', '[contenteditable="true"]').on('focus', '[contenteditable="true"]', function () {
        const element = $(this);
        element.data('original-value', element.text().trim()); // Eredeti érték mentése
    });

    // Termék törlése
    $('body').off('click', '.delete-product').on('click', '.delete-product', function () {
        const productId = $(this).data('id');
        if (confirm('Biztosan törölni szeretnéd ezt a terméket?')) {
            $.ajax({
                url: 'admin_panel.php',
                type: 'POST',
                data: {
                    action: 'delete',
                    id: productId
                },
                success: function (response) {
                    try {
                        const res = JSON.parse(response);
                        if (res.success) {
                            showSuccessToast('Termék sikeresen törölve!');
                            $('#content').load('admin_panel.php'); // Frissítés
                        } else {
                            showErrorToast(res.error || 'Hiba történt a törlés során.');
                        }
                    } catch (e) {
                        console.error('Nem érvényes JSON válasz:', response);
                        showErrorToast('Szerverhiba történt.');
                    }
                },
                error: function () {
                    showErrorToast('Kapcsolódási hiba történt.');
                }
            });
        }
    });
});
