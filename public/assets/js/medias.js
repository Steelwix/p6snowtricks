window.onload = () => {
    // Delete button manager
    let links = document.querySelectorAll("[data-delete]")
    for (link of links) {
        link.addEventListener("click", function (e) {
            //Lock nav
            e.preventDefault()
            //Confirm delete
            if (confirm("Voulez-vous supprimer cette image?")) {
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
                    if (data.success)
                        this.parentElement.remove()
                    else
                        alert(data.error)
                }).catch(e => alert(e))
            }
        })
    }
}