document.querySelector(".add-button").addEventListener("click", function (e) {
  var poster = document.querySelector('input[name="poster"]');
  var gallery = document.querySelector('input[name="gallery[]"]');

  if (!poster.files.length) {
    alert("Please upload a poster image.");
    e.preventDefault();
  }

  if (!gallery.files.length) {
    alert("Please upload at least one gallery image.");
    e.preventDefault();
  }
});

function validateFileCount(input) {
  const maxFiles = 5;
  console.log(`Selected files: ${input.files.length}`);
  if (input.files.length > maxFiles) {
    alert(`You can only upload a maximum of ${maxFiles} images.`);
    input.value = "";
  }
}

function displayGalleryFileNames(event) {
  var files = event.target.files;
  var fileNamesContainer = document.getElementById("galleryFileNamesContainer");
  fileNamesContainer.innerHTML = "";

  if (files.length > 5) {
    alert("You can only upload up to 5 gallery images.");
    event.target.value = "";
    return;
  }

  for (var i = 0; i < files.length; i++) {
    var fileName = document.createElement("div");
    fileName.textContent = files[i].name;
    fileNamesContainer.appendChild(fileName);
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

  displayFileNames(input);

  if (fileCount + existingFilesCount > maxFiles) {
    alert(
      `You can only upload a maximum of ${
        maxFiles - existingFilesCount
      } additional images.`
    );
    input.value = "";
    document.getElementById(
      `gallery-file-names-${input.id.split("-")[1]}`
    ).innerHTML = "";
  }
}

function displayFileNames(input) {
  const fileNamesContainer = document.getElementById(
    `gallery-file-names-${input.id.split("-")[1]}`
  );
  const fileNames = Array.from(input.files)
    .map((file) => file.name)
    .join(", ");

  fileNamesContainer.textContent = fileNames;
}
