/***********************************************************************
 * Author: Clifford Christianson
 * Creation Date: May 14, 2020
 * form.js
 * This application resizes images to
 * different horizontal widths automatically
 * We take up to 12 sizes and an image file as input.
 * It will then save the image file in
 * each of the horizontal width sizes
 * Don't put this on an internet server
 * or someone will upload a RAT!
 * Always store uploaded user files off server somewhere else!
 * Validate the actual images, not the extension
 * Use on your local development environment only!
 * Make sure GD library is installed
 * and enabled with phpinfo();
 *
 *
 *               ____...---...___
 * ___.....---"""        .       ""--..____
 *     .                  .            .
 * .            ^_.--._^      /|
 *        .    .'()..()`.    / /
 *            ( `-.__.-' )  ( (    .
 *   .         \        /    \ \
 *       .      \      /      ) )        .
 *            .' -.__.- `.-.-'_.'
 * .        .'  /-____-\  `.-'       .
 *          \  /-.____.-\  /-.
 *           \ \`-.__.-'/ /\|\|           .
 *          .'  `.    .'  `.
 *          |/\/\|    |/\/\|
 * jro
 **********************************************************************/

var formId = "resize-image-form"; // ID of the form
const url = location.href; //  href for the page
var formIdentifier = `${url} ${formId}`;
let form = document.querySelector(`#${formId}`); // select form
let formElements = form.elements; // get the elements in the form

/**
 * This function gets the values in the form
 * and returns them as an object with the
 * [formIdentifier] as the object key
 * @returns {Object}
 */

const submitForm = () =>
{
  data = getFormData();
  localStorage.setItem(formIdentifier, JSON.stringify(data[formIdentifier]));
  document.getElementById("resize-image-form").submit();
};

const buildFigure = () =>
{
  data = getFormData();
  localStorage.setItem(formIdentifier, JSON.stringify(data[formIdentifier]));

  // we don't submit, we need to hide step 2 and show step 3
  document.getElementById("step1").style.display = "none";
  document.getElementById("step2").style.display = "none";
  document.getElementById("step3").style.display = "block";

  // lets build the code block
  if(document.getElementById('offset') != null)
    var offset = parseInt(document.getElementById('offset').value);
  else
    var offset = 0;
  
  // lets set the link
  createAnchorElement('image-link', 'image-link-span');
  
  loop = 0;

  // lets set the responsive images
  for(cnt=1; cnt<13; cnt++)
  {
    if(document.getElementById('image'+cnt) != null)
    {
      ++loop;
      buildElement(cnt, offset)
    }
  }
  // lets set the default img tag
  lastImage = document.getElementById('image' + loop).innerHTML;
  document.getElementById('image-src').innerHTML = "&lt;image src='" + lastImage + "' /&gt;";

  // lets set the end link
  createEndAnchorElement('image-link', 'image-end-link-span');
  
  // let's add the figure-caption-link
  createAnchorElement('caption-link', 'caption-link-span');
  
  // add the figure-caption
  createElement('figure-caption', 'figure-caption-span');

  // add the ending caption-link
  createEndAnchorElement('caption-link', 'caption-end-link-span');
  
  // add the cite-link
  createAnchorElement('cite-link', 'cite-link-span');
  
  // add the cite
  createElement('cite', 'cite-span');
  
  // add the ending cite-link
  createEndAnchorElement('cite-link', 'cite-link-end-span');
  
};

const createAnchorElement = (elem, elemSpan) =>
{
  if(document.getElementById(elem).value)
  {
    // set the link
    var elemLink = document.getElementById(elem).value;
    document.getElementById(elemSpan).innerHTML = "&lt;a href='" + elemLink + "' target='_blank'&gt;";
  }
  else
  {
    // remove the span from the dom
    var elemLinkSpan = document.getElementById(elemSpan);
    elemLinkSpan.remove();
  }
}

const createEndAnchorElement = (elem, elemSpan) =>
{
  if(document.getElementById(elem).value)
  {
    // set the link
    var elemLink = document.getElementById(elem).value;
    document.getElementById(elemSpan).innerHTML = "&lt;/a&gt;";
  }
  else
  {
    // remove the span from the dom
    var elemLinkSpan = document.getElementById(elemSpan);
    elemLinkSpan.remove();
  }
}

const createElement = (elem, elemSpan) =>
{
  if(document.getElementById(elem).value)
  {
    // set the element
    var elemValue = document.getElementById(elem).value;
    if(elem === 'cite')
      document.getElementById(elemSpan).innerHTML = "&lt;cite&gt;" + elemValue + "&lt;/cite&gt;";
    else
      document.getElementById(elemSpan).innerHTML =  elemValue;
  }
  else
  {
    // remove the span from the dom
    var elemLinkSpan = document.getElementById(elemSpan);
    elemLinkSpan.remove();
  }
}

const buildElement = (index, offset) =>
{
  const size = parseInt(document.getElementById('size' + index).value);
  if(document.getElementById('image' + index) != null)
  {
    const image = document.getElementById('image' + index).innerHTML;
    document.getElementById('min-width-' + index).innerHTML = size + offset;
    document.getElementById('image-srcset-' + index).innerHTML = image;
  }
}

const getFormData = () =>
{
  let data = { [formIdentifier]: {} };
  for(const element of formElements)
  {
    if(element.name.length > 0 && element.name != "_token")
    {
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
const populateForm = () =>
{
  if(localStorage.key(formIdentifier))
  {
    const savedData = JSON.parse(localStorage.getItem(formIdentifier)); // get and parse the saved data from localStorage
    for(const element of formElements)
    {
      if(savedData)
      {
        if(element.name in savedData &&
            element.name != "_token" &&
            element.name != "photo")
        {
          element.value = savedData[element.name];
        }
      }
    }
  }
};

document.onload = populateForm();
