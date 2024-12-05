function toggleDescription() {
  var shortDescription = document.getElementById("short-description");
  var fullDescription = document.getElementById("full-description");
  var expandLink = document.getElementById("expand-description");

  if (fullDescription.style.display === "none") {
    fullDescription.style.display = "inline";
    expandLink.innerHTML = "Read less";
  } else {
    fullDescription.style.display = "none";
    expandLink.innerHTML = "Read more";
  }
}
