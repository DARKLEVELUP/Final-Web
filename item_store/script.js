document.addEventListener("DOMContentLoaded", function() {
    function formatDateForInput(dateString) {
        const date = new Date(dateString);
        let day = date.getDate();
        let month = date.getMonth() + 1; // Months are zero-based
        let year = date.getFullYear();

        // Add leading zeros to day and month if necessary
        if (day < 10) {
            day = '0' + day;
        }
        if (month < 10) {
            month = '0' + month;
        }

        return `${year}-${month}-${day}`;
    }

    function fetchItems() {
        const itemsPerPageSelect = document.getElementById('itemsPerPage');
        const searchForm = document.getElementById('searchForm');
        const itemsPerPage = itemsPerPageSelect ? itemsPerPageSelect.value : 10;
        const search = searchForm ? searchForm.search.value : '';
        const page = new URLSearchParams(window.location.search).get('page') || 1;

        fetch(`items.php?itemsPerPage=${itemsPerPage}&search=${search}&page=${page}`)
            .then(response => response.json())
            .then(data => {
                const itemsList = document.getElementById('itemsList');
                const pagination = document.getElementById('pagination');
                itemsList.innerHTML = '';
                pagination.innerHTML = '';

                data.items.forEach(item => {
                    const itemElement = document.createElement('div');
                    itemElement.className = 'item';
                    itemElement.innerHTML = `
                        <h3>ID: ${item.id} - ${item.name}</h3>
                        <p>Date Bought: ${formatDateForInput(item.date_bought)}</p>
                        <p>Check Date: ${formatDateForInput(item.check_date)}</p>
                        <p>Warranty: ${item.warranty_years} years</p>
                        <p>Expiry Date: ${formatDateForInput(item.expiry_date)}</p>
                        <a href="update_item.html?id=${item.id}&name=${encodeURIComponent(item.name)}&date_bought=${item.date_bought}&check_date=${item.check_date}&warranty_years=${item.warranty_years}&expiry_date=${item.expiry_date}" class="update">Update</a>
                        <a href="#" class="delete" data-id="${item.id}">Delete</a>
                    `;
                    itemsList.appendChild(itemElement);
                });

                // Add event listeners for delete buttons
                document.querySelectorAll('.delete').forEach(button => {
                    button.addEventListener('click', function(event) {
                        event.preventDefault();
                        const itemId = this.getAttribute('data-id');
                        showModal(itemId);
                    });
                });

                for (let i = 1; i <= data.totalPages; i++) {
                    const pageLink = document.createElement('a');
                    pageLink.href = `?itemsPerPage=${itemsPerPage}&search=${search}&page=${i}`;
                    pageLink.innerText = i;
                    if (i == page) {
                        pageLink.className = 'active';
                    }
                    pagination.appendChild(pageLink);
                }
            });
    }

    function showModal(itemId) {
        const modal = document.getElementById('deleteModal');
        const confirmButton = document.getElementById('confirmDelete');
        const cancelButton = document.getElementById('cancelDelete');

        modal.style.display = 'block';

        confirmButton.onclick = function() {
            deleteItem(itemId);
            modal.style.display = 'none';
        };

        cancelButton.onclick = function() {
            modal.style.display = 'none';
        };

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        };
    }

    function deleteItem(id) {
        fetch(`delete_item.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `id=${id}`
            
        })
        .then(response => response.text())
        .then(data => {
            fetchItems();
        });
    }

    const itemsPerPageSelect = document.getElementById('itemsPerPage');
    const searchForm = document.getElementById('searchForm');

    if (itemsPerPageSelect) {
        itemsPerPageSelect.addEventListener('change', fetchItems);
    }
    if (searchForm) {
        searchForm.addEventListener('submit', function(event) {
            event.preventDefault();
            fetchItems();
        });
    }

    fetchItems();
});