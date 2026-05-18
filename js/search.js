document.addEventListener('DOMContentLoaded', function () {
    var searchInput = document.getElementById('searchInput');
    var vendorFilter = document.getElementById('vendorFilter');
    var formFilter = document.getElementById('formFilter');
    var categoryButtons = document.querySelectorAll('.category-btn');
    var medicineContainer = document.getElementById('medicineContainer');

    var selectedCategory = '';

    function loadMedicines() {
        var q = searchInput.value.trim();
        var vendor = vendorFilter.value;
        var form = formFilter.value;

        fetch(
            'index.php?page=ajax&type=search&q=' +
            encodeURIComponent(q),
            { credentials: 'same-origin' }
        )
            .then(function (response) {
                return response.json();
            })
            .then(function (medicines) {
                var html = '';

                medicines.forEach(function (m) {
                    if (vendor !== '' && m.vendor_name !== vendor) {
                        return;
                    }

                    if (selectedCategory !== '' && m.category_name !== selectedCategory) {
                        return;
                    }
                    if (form !== '' && m.category_type !== form) {
                        return;
                    }
                    var availability = 'Out of Stock';
                    if (parseInt(m.availability) > 0) {
                        availability =
                            'In Stock (' + m.availability + ')';
                    }
                    var image = '';
                    if (m.image_path) {
                        image =
                            '<img ' +
                            'src="uploads/medicines/' +
                            m.image_path +
                            '" ' +
                            'class="medicine-image" ' +
                            'alt="' + m.name + '">';
                    }

                    var description =
                        '<details class="medicine-details">' +
                        '<summary>View Description</summary>' +
                        '<p>' + (m.description || 'No description available.') + '</p>' +
                        '</details>';

                    var buttonHtml = '';

                    if (parseInt(m.availability) > 0) {
                        buttonHtml =
                            '<button ' +
                            'type="button" ' +
                            'class="btn add-to-cart" ' +
                            'data-medicine-id="' + m.id + '">' +
                            'Add to Cart' +
                            '</button>';
                    } else {
                        buttonHtml =
                            '<button ' +
                            'type="button" ' +
                            'class="btn" ' +
                            'disabled>' +
                            'Out of Stock' +
                            '</button>';
                    }

                    html +=
                        '<div class="medicine-card">' +
                        image +

                        '<div class="medicine-content">' +
                        '<h3>' + m.name + '</h3>' +

                        '<p class="medicine-meta">' +
                        '<strong>Vendor:</strong> ' +
                        m.vendor_name +
                        '</p>' +

                        '<p class="medicine-meta">' +
                        '<strong>Category:</strong> ' +
                        m.category_name +
                        '</p>' +

                        '<p class="medicine-meta">' +
                        '<strong>Type:</strong> ' +
                        m.category_type.charAt(0).toUpperCase() +
                        m.category_type.slice(1) +
                        '</p>' +

                        '<p class="medicine-price">' +
                        '৳ ' +
                        parseFloat(m.price).toFixed(2) +
                        '</p>' +

                        '<p class="medicine-stock">' +
                        '<strong>Availability:</strong> ' +
                        availability +
                        '</p>' +

                        description +
                        '</div>' +

                        buttonHtml +
                        '</div>';
                });

                if (html === '') {
                    html = '<p>No medicines found.</p>';
                }

                medicineContainer.innerHTML = html;
            })
            .catch(function (error) {
                console.error(error);
            });
    }

    if (searchInput) {
        searchInput.addEventListener('input', loadMedicines);
    }

    if (vendorFilter) {
        vendorFilter.addEventListener('change', loadMedicines);
    }

    if (formFilter) {
        formFilter.addEventListener('change', loadMedicines);
    }

    categoryButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            categoryButtons.forEach(function (btn) {
                btn.classList.remove('active');
            });

            this.classList.add('active');
            selectedCategory =
                this.getAttribute('data-category');

            loadMedicines();
        });
    });


});