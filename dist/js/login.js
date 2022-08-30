import * as DefaultFormHandler from "./modules/form_handling.js";

const LOGIN_FORM = document.querySelector("#login-content #login-form");
const FIELDS = document.querySelectorAll(
  "#login-content #login-form fieldset input"
);

LOGIN_FORM.addEventListener("submit", validateLoginPage);

function validateLoginPage(evt) {
  evt.preventDefault();
  DefaultFormHandler.deleteErrorMessagesOfFields(FIELDS);
  DefaultFormHandler.checkEmptyFields(FIELDS);

  let errorMessages = document.getElementsByClassName("errorMessage");
  if (errorMessages.length === 0) {
    LOGIN_FORM.submit();
  }
}
