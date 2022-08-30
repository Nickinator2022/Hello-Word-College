import * as DefaultFormHandler from "./modules/form_handling.js";

const FIELD_SETS = document.querySelectorAll(".main-form fieldset");
const APPLY_FORM = document.querySelector("#apply-content #apply-form");

window.addEventListener("load", addAsterisksToRequiredFields, false);
APPLY_FORM.addEventListener("submit", validateApplyPage, false);

function addAsterisksToRequiredFields() {
  for (let i = 0; i < FIELD_SETS.length; i += 2) {
    let fieldSetDivGroup = FIELD_SETS[i].querySelectorAll(".field-group div");
    addAsteriskToFieldGroup(fieldSetDivGroup);
  }
}

function addAsteriskToFieldGroup(fieldGroup) {
  for (let i = 0; i < fieldGroup.length; i++) {
    let span = document.createElement("span");
    span.style.color = "red";
    span.innerText = " * ";
    fieldGroup[i].children[0].appendChild(span);
  }
}

function validateApplyPage(evt) {
  evt.preventDefault();
  let requiredFields = getRequiredFields();
  let email = requiredFields[2];
  let confirmEmail = requiredFields[3];
  let cellPhone = requiredFields[4];
  let homePhone = requiredFields[5];
  let password = requiredFields[8];
  let checkPassword = requiredFields[9];

  DefaultFormHandler.deleteErrorMessagesOfFields(requiredFields);
  DefaultFormHandler.checkEmptyFields(requiredFields);

  checkPhone(cellPhone);
  checkPhone(homePhone);
  checkEmail(email);
  checkTwoInputs(email, confirmEmail);
  checkValidPass(password);
  checkTwoInputs(password, checkPassword);
  let errorMessages = document.getElementsByClassName("errorMessage");
  if (errorMessages.length === 0) {
    APPLY_FORM.submit();
  }
}

function getRequiredFields() {
  let requiredFields = [];

  for (let i = 0; i < FIELD_SETS.length; i += 2) {
    let fieldSetDivs = FIELD_SETS[i].querySelectorAll(".field-group div");
    putFieldsInArray(fieldSetDivs, requiredFields);
  }

  return requiredFields;
}

function putFieldsInArray(fields, fieldsArray) {
  for (let i = 0; i < fields.length; i++) {
    fieldsArray.push(fields[i].children[2]);
  }
}

function checkPhone(number) {
  let numericCheck = /^\+?(1[ .-]?)?(\(?\d{3}\)?)[ .-]?\d{3}[ .-]?\d{4}$/;

  if (DefaultFormHandler.isBlankField(number)) return;

  if (!DefaultFormHandler.checkValidField(number, numericCheck)) {
    DefaultFormHandler.addErrorMessageToField(
      number,
      "Field must be valid 10-11 digit phone number"
    );

    return false;
  }
  // If valid number
  number.value = number.value.replace(/[\(\)\- .\+]/g, "");
  return true;
}

function checkEmail(email) {
  let emailCheck = /^[_\w\-]+(\.[_\w\-]+)*@[\w\-]+(\.[\w\-]+)*(\.[\D]{2,6})$/;

  if (DefaultFormHandler.isBlankField(email)) return;

  if (!DefaultFormHandler.checkValidField(email, emailCheck)) {
    DefaultFormHandler.addErrorMessageToField(
      email,
      "Please provide a valid email address"
    );

    return false;
  }
  return true;
}

function checkTwoInputs(input1, input2) {
  if (
    DefaultFormHandler.isBlankField(input2) ||
    DefaultFormHandler.isBlankField(input1)
  )
    return;

  if (input1.value != input2.value) {
    DefaultFormHandler.addErrorMessageToField(
      input2,
      "This field and the previous field must match"
    );
    return false;
  }
  return true;
}

function checkValidPass(password) {
  let passwordCheck =
    /^(?=.*\d)(?=.*[@!#$%^&*()])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z@!#$%^&*()]{8,}/;

  if (DefaultFormHandler.isBlankField(password)) return;

  if (!DefaultFormHandler.checkValidField(password, passwordCheck)) {
    DefaultFormHandler.addErrorMessageToField(
      password,
      "Password must contain a capital letter, a lowercase letter, a number, a valid symbol (!@()#$%^&*), and be at least 8 characters with no spaces"
    );

    return false;
  }
  return true;
}
