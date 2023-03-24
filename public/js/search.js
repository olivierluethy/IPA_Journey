function search() {
  // Defining all the variables used in this function
  var input, filter, div, container_children, content, name, textareas, topics, i, txtValue;
  // Get the search field
  input = document.getElementById("inputSearch");
  // Put the value of the input search into the variable filter
  filter = input.value.toUpperCase();

  /* Search through the elements inside the weekly div */
  // Get the weekly div element
  div = document.getElementById("weekly");
  container_children = div.getElementsByClassName("container-child");
  for (i = 0; i < container_children.length; i++) {
      // Get the content element of the container-child div
      content = container_children[i].getElementsByClassName("content")[0];
      // Get the name element of the content div
      name = content.getElementsByClassName("contentText")[0].getElementsByTagName("h1")[0];
      // Get all textareas of the content div
      textareas = content.getElementsByClassName("contentText")[0].getElementsByTagName("textarea");
      // Get the first p element inside the datopic class of the content div
      dates = content.getElementsByClassName("datopic")[0].getElementsByTagName("p")[0];
      // Concatenate the name, textareas and dates values
      txtValue = name.textContent || name.innerText;
      for (j = 0; j < textareas.length; j++) {
          txtValue += textareas[j].textContent || textareas[j].innerText;
      }
      // Add the text content of the topics element to the txtValue variable
      txtValue += dates.textContent || dates.innerText;
      // Check if txtValue includes the filter value
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
          // If the filter value is found, show the container-child div
          container_children[i].style.display = "";
          // Get the next sibling element and set its display style to "none"
          var nextSibling = container_children[i].nextElementSibling;
          if (nextSibling && nextSibling.tagName === "DIV") {
              nextSibling.style.display = "none";
          }
      } else {
          // If the filter value is not found, hide the container-child div
          container_children[i].style.display = "none";
          // Get the next sibling element and set its display style to ""
          var nextSibling = container_children[i].nextElementSibling;
          if (nextSibling && nextSibling.tagName === "DIV") {
              nextSibling.style.display = "";
          }
      }
  }

  /* Search through the elements inside the daily div as well */
  // Get the daily div element
  div = document.getElementById("daily");
  // Get all child elements of the daily div with class "container-child"
  container_children = div.getElementsByClassName("container-child");
  // Loop through all child elements
  for (i = 0; i < container_children.length; i++) {
      // Get the content element inside the current child element
      content = container_children[i].getElementsByClassName("content")[0];
      // Get the h1 element inside the content element
      name = content.getElementsByClassName("contentText")[0].getElementsByTagName("h1")[0];
      // Get all textarea elements inside the content element
      textareas = content.getElementsByClassName("contentText")[0].getElementsByTagName("textarea");
      // Get the first p element inside the datopic element inside the content element. 
      // When theirs no topic it gets the date of release
      topics = content.getElementsByClassName("datopic")[0].getElementsByTagName("p")[0];
      // Loop through all textarea elements
      for (j = 0; j < textareas.length; j++) {
          // Add the text content of the current textarea element to the txtValue variable
          txtValue += textareas[j].textContent || textareas[j].innerText;
      }
      // Add the text content of the topics element to the txtValue variable
      txtValue += topics.textContent || topics.innerText;
      // If the filter text is found in the txtValue variable
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
          // Set the display style of the current child element to ""
          container_children[i].style.display = "";
          // Get the next sibling element and set its display style to "none"
          var nextSibling = container_children[i].nextElementSibling;
          if (nextSibling && nextSibling.tagName === "DIV") {
              nextSibling.style.display = "none";
          }
      } else {
          // Set the display style of the current child element to "none"
          container_children[i].style.display = "none";
          // Get the next sibling element and set its display style to ""
          var nextSibling = container_children[i].nextElementSibling;
          if (nextSibling && nextSibling.tagName === "DIV") {
              nextSibling.style.display = "";
          }
      }
  }
}

function sortByDaily(){
    /* Search through the elements inside the daily div as well */
  // Get the daily div element
  div = document.getElementById("daily");
  // Get all child elements of the daily div with class "container-child"
  container_children = div.getElementsByClassName("container-child");
  // Loop through all child elements
  for (i = 0; i < container_children.length; i++) {
      // Get the content element inside the current child element
      content = container_children[i].getElementsByClassName("content")[0];
      // Get the h1 element inside the content element
      name = content.getElementsByClassName("contentText")[0].getElementsByTagName("h1")[0];
      // Get all textarea elements inside the content element
      textareas = content.getElementsByClassName("contentText")[0].getElementsByTagName("textarea");
      // Get the first p element inside the datopic element inside the content element. 
      // When theirs no topic it gets the date of release
      topics = content.getElementsByClassName("datopic")[0].getElementsByTagName("p")[0];
      // Loop through all textarea elements
      for (j = 0; j < textareas.length; j++) {
          // Add the text content of the current textarea element to the txtValue variable
          txtValue += textareas[j].textContent || textareas[j].innerText;
      }
      // Add the text content of the topics element to the txtValue variable
      txtValue += topics.textContent || topics.innerText;
      // If the filter text is found in the txtValue variable
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
          // Set the display style of the current child element to ""
          container_children[i].style.display = "";
          // Get the next sibling element and set its display style to "none"
          var nextSibling = container_children[i].nextElementSibling;
          if (nextSibling && nextSibling.tagName === "DIV") {
              nextSibling.style.display = "none";
          }
      } else {
          // Set the display style of the current child element to "none"
          container_children[i].style.display = "none";
          // Get the next sibling element and set its display style to ""
          var nextSibling = container_children[i].nextElementSibling;
          if (nextSibling && nextSibling.tagName === "DIV") {
              nextSibling.style.display = "";
          }
      }
  }
}

function sortByWeekly(){
    // Defining all the variables used in this function
  var input, filter, div, container_children, content, name, textareas, topics, i, txtValue;
  // Get the search field
  input = document.getElementById("inputSearch");
  // Put the value of the input search into the variable filter
  filter = input.value.toUpperCase();

  /* Search through the elements inside the weekly div */
  // Get the weekly div element
  div = document.getElementById("weekly");
  container_children = div.getElementsByClassName("container-child");
  for (i = 0; i < container_children.length; i++) {
      // Get the content element of the container-child div
      content = container_children[i].getElementsByClassName("content")[0];
      // Get the name element of the content div
      name = content.getElementsByClassName("contentText")[0].getElementsByTagName("h1")[0];
      // Get all textareas of the content div
      textareas = content.getElementsByClassName("contentText")[0].getElementsByTagName("textarea");
      // Get the first p element inside the datopic class of the content div
      dates = content.getElementsByClassName("datopic")[0].getElementsByTagName("p")[0];
      // Concatenate the name, textareas and dates values
      txtValue = name.textContent || name.innerText;
      for (j = 0; j < textareas.length; j++) {
          txtValue += textareas[j].textContent || textareas[j].innerText;
      }
      // Add the text content of the topics element to the txtValue variable
      txtValue += dates.textContent || dates.innerText;
      // Check if txtValue includes the filter value
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
          // If the filter value is found, show the container-child div
          container_children[i].style.display = "";
          // Get the next sibling element and set its display style to "none"
          var nextSibling = container_children[i].nextElementSibling;
          if (nextSibling && nextSibling.tagName === "DIV") {
              nextSibling.style.display = "none";
          }
      } else {
          // If the filter value is not found, hide the container-child div
          container_children[i].style.display = "none";
          // Get the next sibling element and set its display style to ""
          var nextSibling = container_children[i].nextElementSibling;
          if (nextSibling && nextSibling.tagName === "DIV") {
              nextSibling.style.display = "";
          }
      }
  }
}