document.querySelector(".add-button").addEventListener("click", function (e) {
  var poster = document.querySelector('input[name="poster"]');
  var gallery = document.querySelector('input[name="gallery[]"]');

  if (!poster.files.length) {
    alert("Please upload a poster image.");
    e.preventDefault(); // Prevent form submission
  }

  if (!gallery.files.length) {
    alert("Please upload at least one gallery image.");
    e.preventDefault(); // Prevent form submission
  }
});

function validateFileCount(input) {
  const maxFiles = 5;
  console.log(`Selected files: ${input.files.length}`); // Log the number of files selected
  if (input.files.length > maxFiles) {
    alert(`You can only upload a maximum of ${maxFiles} images.`);
    input.value = ""; // Clear the input
  }
}

// Function to display file names for multiple uploaded images (gallery) with a limit of 5 files
function displayGalleryFileNames(event) {
  var files = event.target.files; // Get the selected files
  var fileNamesContainer = document.getElementById("galleryFileNamesContainer");
  fileNamesContainer.innerHTML = ""; // Clear previous file names

  // Check if the file count exceeds the limit
  if (files.length > 5) {
    alert("You can only upload up to 5 gallery images.");
    event.target.value = ""; // Clear the file input
    return;
  }

  // Loop through each selected file and display its name (up to 5 files)
  for (var i = 0; i < files.length; i++) {
    var fileName = document.createElement("div"); // Create a new div for each file name
    fileName.textContent = files[i].name; // Set the text to the file name
    fileNamesContainer.appendChild(fileName); // Add the file name to the container
  }
}

function toggleOtherInput(selectId, inputId) {
  var selectElement = document.getElementById(selectId);
  var inputElement = document.getElementById(inputId);
  if (selectElement.value === "other") {
    inputElement.style.display = "block";
  } else {
    inputElement.style.display = "none";
  }
}
function validateExistingFileCount(input) {
  const maxFiles = 5;
  const existingFilesCount =
    parseInt(input.getAttribute("data-existing-files-count")) || 0;
  const fileCount = input.files.length;

  // Display the file names
  displayFileNames(input);

  // Check if total files exceed the maximum allowed
  if (fileCount + existingFilesCount > maxFiles) {
    alert(
      `You can only upload a maximum of ${
        maxFiles - existingFilesCount
      } additional images.`
    );
    input.value = ""; // Clear the input if the limit is exceeded
    document.getElementById(
      `gallery-file-names-${input.id.split("-")[1]}`
    ).innerHTML = ""; // Clear file names
  }
}

function displayFileNames(input) {
  const fileNamesContainer = document.getElementById(
    `gallery-file-names-${input.id.split("-")[1]}`
  );
  const fileNames = Array.from(input.files)
    .map((file) => file.name)
    .join(", ");

  // Show file names
  fileNamesContainer.textContent = fileNames;
}
