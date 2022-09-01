const radio = document.querySelectorAll("input[type='radio']");

function start() {
    radio.forEach(radioItem => {
        radioItem.addEventListener("change", changeItem => {
            let label = document.querySelector(".dashboard-side-bar-radio.active");
            label.classList.remove("active");
            changeItem.target.parentNode.classList.add("active");
        })
    })

    houseList();
}

function submitButtonValue(element, action) {
    //change hidden value for different buttons with different action
    //find parent element of the section by button, then find all child in that parent
    let target = element.parentNode.parentNode;
    let children = target.children;

    //for each child
    for (let i = 0; i < children.length; i++) {
        //if (children[i].id == "accommodation-profile-submit-value") {
            //children[i].value = action;
        //}

        if (children[i].classList.contains('accommodation-profile-submit-value')) {
            children[i].value = action;
        }
    }
}

function houseList() {
    //display accommodation list section and hide other section
    document.getElementById("house-list-item-container").style.display = "block";
    document.getElementById("booking-list-item-container").style.display = "none";
    document.getElementById("review-list-item-container").style.display = "none";
    document.getElementById("inbox-list-item-container").style.display = "none";
    document.getElementById("user-list-item-container").style.display = "none";
}

function bookingList() {
    //display booking list section and hide other section
    document.getElementById("house-list-item-container").style.display = "none";
    document.getElementById("booking-list-item-container").style.display = "block";
    document.getElementById("review-list-item-container").style.display = "none";
    document.getElementById("inbox-list-item-container").style.display = "none";
    document.getElementById("user-list-item-container").style.display = "none";
}

function reviewList() {
    //display review list section and hide other section
    document.getElementById("house-list-item-container").style.display = "none";
    document.getElementById("booking-list-item-container").style.display = "none";
    document.getElementById("review-list-item-container").style.display = "block";
    document.getElementById("inbox-list-item-container").style.display = "none";
    document.getElementById("user-list-item-container").style.display = "none";
}

function inboxList() {
    //display inbox list section and hide other section
    document.getElementById("house-list-item-container").style.display = "none";
    document.getElementById("booking-list-item-container").style.display = "none";
    document.getElementById("review-list-item-container").style.display = "none";
    document.getElementById("inbox-list-item-container").style.display = "block";
    document.getElementById("user-list-item-container").style.display = "none";
}

function userList() {
    //display user list section and hide other section
    document.getElementById("house-list-item-container").style.display = "none";
    document.getElementById("booking-list-item-container").style.display = "none";
    document.getElementById("review-list-item-container").style.display = "none";
    document.getElementById("inbox-list-item-container").style.display = "none";
    document.getElementById("user-list-item-container").style.display = "block";
}

//create a start function that always run first when web page loaded
window.onload = start();