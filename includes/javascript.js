// Function to display the file name for any uploaded image
function displayFileName(event, newsId = null) {
  var fileName = event.target.files[0].name; // Get the name of the selected file
  var fileNameContainer;

  if (newsId) {
    // If newsId is provided, update the specific article's container
    fileNameContainer = document.getElementById("fileNameContainer-" + newsId);
  } else {
    // Otherwise, update the default container for adding a new article
    fileNameContainer = document.getElementById("fileNameContainer");
  }

  fileNameContainer.textContent = fileName; // Display the file name in the container
}
