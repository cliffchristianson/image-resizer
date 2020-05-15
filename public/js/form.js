// form.js
const formId = "resize-image-form"; // ID of the form
const url = location.href; //  href for the page
const formIdentifier = `${url} ${formId}`; // Identifier used to identify the form
const saveButton = document.querySelector("#save"); // select save button
const alertBox = document.querySelector(".alert"); // select alert display div
let form = document.querySelector(`#${formId}`); // select form
let formElements = form.elements; // get the elements in the form

/**
 * This function gets the values in the form
 * and returns them as an object with the
 * [formIdentifier] as the object key
 * @returns {Object}
 */

const submitForm = () => {
  data = getFormData();
  localStorage.setItem(formIdentifier, JSON.stringify(data[formIdentifier]));
  const message = "Form draft has been saved!";
  alert(message);
  document.getElementById('resize-image-form').submit();
}
const getFormData = () => {
  let data = { [formIdentifier]: {} };
  for (const element of formElements) {
    if (element.name.length > 0 && element.name != '_token') {
      data[formIdentifier][element.name] = element.value;
    }
  }
  return data;
};


/**
 * This function populates the form
 * with data from localStorage
 *
 */
const populateForm = () => {
  if (localStorage.key(formIdentifier)) {
    const savedData = JSON.parse(localStorage.getItem(formIdentifier)); // get and parse the saved data from localStorage
    for (const element of formElements) {
      if(savedData)
      if (element.name in savedData && element.name != '_token') {
        element.value = savedData[element.name];
      }
    }
    const message = "Form has been refilled with saved data!";
    alert(message);
  }
};

document.onload = populateForm(); // populate the form when the document is loaded
