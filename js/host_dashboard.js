const radio = document.querySelectorAll("input[type='radio']");

function start() {
    radio.forEach(radioItem => {
        radioItem.addEventListener("change", changeItem => {
            let label = document.querySelector(".dashboard-side-bar-radio.active");
            label.classList.remove("active");
            changeItem.target.parentNode.classList.add("active");
        })
    })

    //currently have no link to this page, start with profile section function setting
    profile();
}

function submitButtonValue(element, action, id) {
    //change hidden value for different buttons with different action
    //find parent element of the section by button, then find all child in that parent
    let target = element.parentNode.parentNode;
    let children = target.children;

    //for each child
    for (let i = 0; i < children.length; i++) {
        if (children[i].classList.contains("accommodation-profile-submit-value")) {
            children[i].value = action;
        }

        if (children[i].classList.contains("accommodation-profile-submit-id")) {
            children[i].value = id;
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

function instantiateAccommodationProfile() {

    //modify buttons and hidden value for "add" new accommodation
    document.getElementById("accommodation-review-modal-button").style.display = "none";
    document.getElementById("accommodation-profile-submit-value").value = "add";
    document.getElementById("accommodation-add-submit").style.display = "block";
    document.getElementById("accommodation-delete-submit").style.display = "none";
    document.getElementById("accommodation-edit-submit").style.display = "none";

    document.getElementById("accommodation-profile-inserter").style.display = "flex";

    myPublishes();
}

function removeAllRequire(element) {
    //remove all require class to the form were the button pressed
    //find parent element of the section by button, then find all child in that parent
    let target = element.parentNode.parentNode;
    let children = target.children;

    //for each child
    for (let i = 0; i < children.length; i++) {
        let child = children[i];
        let grandChildren = child.children;

        //for each child's child
        for (let j = 0; j < grandChildren.length; j++) {
            //modify depends tag name
            switch (grandChildren[j].tagName) {
                case "INPUT":
                    grandChildren[j].required = false;
                    break;
                case "SELECT":
                    grandChildren[j].required = false;
                    break;
            }
        }
    }
}

function addAllRequire(element) {
    //add back all require class to the form were the button pressed
    //find parent element of the section by button, then find all child in that parent
    let target = element.parentNode.parentNode;
    let children = target.children;

    //for each child
    for (let i = 0; i < children.length; i++) {
        let child = children[i];
        let grandChildren = child.children;

        //for each child's child
        for (let j = 0; j < grandChildren.length; j++) {
            //modify depends tag name
            switch (grandChildren[j].tagName) {
                case "INPUT":
                    //add required except image element
                    if (!grandChildren[j].classList.contains("image-address")) {
                        grandChildren[j].required = true;
                    }
                    break;
                case "SELECT":
                    grandChildren[j].required = true;
                    break;
            }
        }
    }
}

function enableDeleteWarning(element) {
    //enable the delete confirm message and additional buttons
    //find parent element of the section by button, then find all child in that parent
    let target = element.parentNode.parentNode;
    let children = target.children;

    //for each child
    for (let i = 0; i < children.length; i++) {
        let child = children[i];
        let grandChildren = child.children;

        //for each child's child
        for (let j = 0; j < grandChildren.length; j++) {
            //modify depends tag name
            switch (grandChildren[j].tagName) {
                case "INPUT":
                    if (grandChildren[j].classList.contains("accommodation-delete")) {
                        grandChildren[j].style.display = "inline-block";
                    }
                    break;
                case "SPAN":
                    if (grandChildren[j].classList.contains("error-message")) {
                        grandChildren[j].style.display = "inline-block";
                    }
                    break;
                case "BUTTON":
                    if (grandChildren[j].classList.contains("no-delete")) {
                        grandChildren[j].style.display = "inline-block";
                    }
                    break;
            }
        }
    }
}

function disableDeleteWarning(element) {
    //disable the delete confirm message and additional buttons
    //find parent element of the section by button, then find all child in that parent
    let target = element.parentNode.parentNode;
    let children = target.children;

    //for each child
    for (let i = 0; i < children.length; i++) {
        let child = children[i];
        let grandChildren = child.children;

        //for each child's child
        for (let j = 0; j < grandChildren.length; j++) {
            //modify depends tag name
            switch (grandChildren[j].tagName) {
                case "INPUT":
                    if (grandChildren[j].classList.contains("accommodation-delete")) {
                        grandChildren[j].style.display = "none";
                    }
                    break;
                case "SPAN":
                    if (grandChildren[j].classList.contains("error-message")) {
                        grandChildren[j].style.display = "none";
                    }
                    break;
                case "BUTTON":
                    if (grandChildren[j].classList.contains("no-delete")) {
                        grandChildren[j].style.display = "none";
                    }
                    break;
            }
        }
    }
}

function profile() {
    //display the profile section
    Array.from(document.getElementsByClassName("user-profile-overview-item-container")).forEach(element =>
        element.style.display = "flex");

    //hide all other section
    Array.from(document.getElementsByClassName("accommodation-profile-overview-item-container")).forEach(element =>
        element.style.display = "none");
    Array.from(document.getElementsByClassName("message-inbox-overview-item-container")).forEach(element =>
        element.style.display = "none");
}

function myPublishes() {
    //display the my publishes section
    Array.from(document.getElementsByClassName("accommodation-profile-overview-item-container")).forEach(element =>
        element.style.display = "flex");

    //hide all other section
    Array.from(document.getElementsByClassName("user-profile-overview-item-container")).forEach(element =>
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
    Array.from(document.getElementsByClassName("accommodation-profile-overview-item-container")).forEach(element =>
        element.style.display = "none");
}

//create a start function that always run first when web page loaded
window.onload = start();