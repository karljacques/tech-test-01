// This is undoubtedly my weakest work here. Working like this is not something I'm used to (without a library for managing dom manipulation)
// And I'm just generally out of practise when it comes to front end.
// In the real world, I'd probably use TypeScript for this, and it'd of course be transpiled for better browser compatibility

(function () {
    document.getElementById("create-new-form")
        .addEventListener("submit", function (event) {
            event.preventDefault();

            const data = new URLSearchParams(new FormData(this));
            const options = {
                method: 'POST',
                body: data,
            };

            // This only deals with the happy path, with more time I'd add error handling
            fetch('/listContact', options)
                .then(response => {

                    if (!response.ok) {
                        throw new Error('Request failed');
                    }

                    return response.text();
                })
                .then(data => {
                    const listTable = document.getElementById("list");

                    listTable.innerHTML = data + listTable.innerHTML;
                })
        });

    document.getElementById("list")
        .addEventListener("click", function(event) {
        if (event.target.classList.contains("delete-row")) {
            const id = event.target.getAttribute('data-entity-id');

            const options = {
                method: 'DELETE'
            }

            fetch(`/listContact/${id}`, options)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Delete failed')
                    }
                })
                .then(() =>  document.querySelector(`tr[data-row-id="${id}"]`).remove());
        }
    });

})();
