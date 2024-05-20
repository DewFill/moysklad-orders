// show statuses
document.querySelectorAll(".current-status").forEach(function (el) {
    el.addEventListener('click', function (event) {
        event.stopPropagation(); // Prevent the click from propagating to the document

        const parent = el.parentElement;
        let child = parent.children.item(1);


        document.querySelectorAll(".statuses").forEach(function (child) {
            if (!child.contains(event.target)) {
                child.style.display = 'none';
            }
        });


        // Toggle visibility
        if (child.style.display === 'none' || child.style.display === '') {
            child.style.display = 'block';
            child.style.position = 'absolute';
        } else {
            child.style.display = 'none';
        }
    });
});


// hide statuses if clicked outside
document.addEventListener('click', function (event) {
    document.querySelectorAll(".statuses").forEach(function (child) {
        if (!child.contains(event.target)) {
            child.style.display = 'none';
        }
    });
});


document.querySelectorAll(".status").forEach(function (el) {
    el.addEventListener('click', function (event) {
        event.stopPropagation(); // Prevent the click from propagating to the document
        const statusesEl = el.parentElement;
        statusesEl.style.display = "none"
        let currentStatus = statusesEl.parentElement.children.item(0)
        currentStatus.children.item(1).textContent = el.textContent
        currentStatus.classList.replace("clr-" + currentStatus.dataset.color, "clr-" + el.dataset.color);
        currentStatus.dataset.color = el.dataset.color
        const order_id = currentStatus.dataset.orderid
        const status_id = el.dataset.statusid
        console.log(order_id)
        console.log(status_id)
        let updatedAtEl = currentStatus.parentElement.parentElement.children.item(7)
        updatedAtEl.textContent = ""
        changeStatus(order_id, status_id)
            .then((response) => response.json())
            .then(function (result) {
                updatedAtEl.textContent = result["data"]["updated_at"]
            })
            .catch((error) => console.error(error));

    });
});

function changeStatus(order_id, status_id) {
    const formdata = new FormData();
    formdata.append("order_id", order_id);
    formdata.append("status_id", status_id);
    formdata.append("token", getCookie("token"));
    console.log("Token:", getCookie("token"))

    const requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow"
    };

    return fetch("/api/put/order/state", requestOptions)
}

function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
    return null; // Return null if the cookie is not found
}