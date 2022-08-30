function isBlankField(field) {
  if (field.value.trim() === "") return true;
  return false;
}

function checkValidField(field, pattern) {
  field.value = field.value.trim();

  if (field.value === "") return false;
  return pattern.test(field.value);
}

function checkEmptyFields(fields) {
  let isEmpty = false;

  for (let i = 0; i < fields.length; i++) {
    if (isBlankField(fields[i])) {
      isEmpty = true;
      addErrorMessageToField(fields[i], "Field cannot be blank");
    }
  }
  return isEmpty;
}

function addErrorMessageToField(field, message) {
  field.style.borderColor = "red";
  field.style.backgroundColor = "#ffe9e9";
  let error_message = document.createElement("p");
  error_message.style.color = "red";
  error_message.style.margin = "0.5rem 0rem";
  error_message.className = "errorMessage";
  error_message.innerText = message;
  let parentDiv = field.parentElement;
  parentDiv.appendChild(error_message);
}

function deleteErrorMessagesOfFields(fields) {
  let errorMessages = document.getElementsByClassName("errorMessage");
  for (let i = 0; i < fields.length; i++) {
    fields[i].style.borderColor = "";
    fields[i].style.backgroundColor = "";
  }
  for (let i = errorMessages.length - 1; i >= 0; i--) {
    errorMessages[i].remove();
  }
}

export {
  checkValidField,
  checkEmptyFields,
  addErrorMessageToField,
  deleteErrorMessagesOfFields,
  isBlankField,
};
