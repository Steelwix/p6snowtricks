window.onload = () => {
    // Delete button manager
    let links = document.querySelectorAll("[data-delete]")
    for (link of links) {
        link.addEventListener("click", function (e) {
            //Lock nav
            e.preventDefault()
            //Confirm delete
            if (confirm("Voulez-vous vraiment supprimer cet élément?")) {
                //Send AJAX request to the href link with the delete method
                fetch(this.getAttribute("href"), {
                    method: "DELETE",
                    headers: {
                        "X-Requested-Width": "XMLHttpRequest",
                        "Content-Type": "application/json"
                    },

                    body: JSON.stringify({ "_token": this.dataset.token })
                }).then(
                    //Get JSON Response
                    response => response.json()

                ).then(data => {
                    if (data.success) {
                        this.parentElement.remove()
                        if (data.redirect) {
                            console.log(data.redirect);
                            window.location.href = data.redirect;
                        }
                    }
                    else {
                        alert(data.error)
                    }
                }).catch(e => alert(e))
            }
        })
    }
}