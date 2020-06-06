function check(form) {
    if(form.name.value == "admin" && form.password.value == "admin1") {
        window.open("controlPage.html");
    }
    else {
        alert("Błędne dane logowania!");
    }
}

function alertFunction() {
    alert("Rezerwacja przebiegła pomyślnie!");
}