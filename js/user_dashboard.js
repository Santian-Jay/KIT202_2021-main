const radio = document.querySelectorAll("input[type='radio']");

radio.forEach(radioItem => {
    radioItem.addEventListener("change", changeItem => {
        let label = document.querySelector(".dashboard-side-bar-radio.active");
        label.classList.remove("active");
        changeItem.target.parentNode.classList.add("active");
    })
})

function submitButtonValue(element, action) {
    //find parent element of the section by button, then find all child in that parent
    let target = element.parentNode;
    let children = target.children;

    //for each child
    for (let i = 0; i < children.length; i++) {
        //change hidden value to submit
        if (children[i].classList.contains("submit-value")) {
            children[i].value = action;
        }
    }
}

function submitButtonID(element, id) {
    //find parent element of the section by button, then find all child in that parent
    let target = element.parentNode;
    let children = target.children;

    //for each child
    for (let i = 0; i < children.length; i++) {
        //change hidden value to submit
        if (children[i].classList.contains("submit-id")) {
            children[i].value = id;
        }
    }
}

function profile() {
    //display the profile section
    Array.from(document.getElementsByClassName("user-profile-overview-item-container")).forEach(element =>
        element.style.display = "flex");

    //hide all other section
    Array.from(document.getElementsByClassName("accommodation-overview-item-container")).forEach(element =>
        element.style.display = "none");
    Array.from(document.getElementsByClassName("my-reviews-overview-item-container")).forEach(element =>
        element.style.display = "none");
    Array.from(document.getElementsByClassName("message-inbox-overview-item-container")).forEach(element =>
        element.style.display = "none");
}

function applications() {
    //display the applications section
    Array.from(document.getElementsByClassName("accommodation-overview-item-container")).forEach(element =>
        element.style.display = "flex");

    //hide all other section
    Array.from(document.getElementsByClassName("user-profile-overview-item-container")).forEach(element =>
        element.style.display = "none");
    Array.from(document.getElementsByClassName("my-reviews-overview-item-container")).forEach(element =>
        element.style.display = "none");
    Array.from(document.getElementsByClassName("message-inbox-overview-item-container")).forEach(element =>
        element.style.display = "none");
}

function myReviews() {
    //display the review section
    Array.from(document.getElementsByClassName("my-reviews-overview-item-container")).forEach(element =>
        element.style.display = "flex");

    //hide all other section
    Array.from(document.getElementsByClassName("user-profile-overview-item-container")).forEach(element =>
        element.style.display = "none");
    Array.from(document.getElementsByClassName("accommodation-overview-item-container")).forEach(element =>
        element.style.display = "none");
    Array.from(document.getElementsByClassName("message-inbox-overview-item-container")).forEach(element =>
        element.style.display = "none");
}

function messageInbox() {
    //display the message inbox section
    Array.from(document.getElementsByClassName("message-inbox-overview-item-container")).forEach(element =>
        element.style.display = "flex");

    //hide all other section
    Array.from(document.getElementsByClassName("user-profile-overview-item-container")).forEach(element =>
        element.style.display = "none");
    Array.from(document.getElementsByClassName("accommodation-overview-item-container")).forEach(element =>
        element.style.display = "none");
    Array.from(document.getElementsByClassName("my-reviews-overview-item-container")).forEach(element =>
        element.style.display = "none");
}

//currently have no link to this page, start with profile section function setting
window.onload = profile();