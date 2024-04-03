

document.addEventListener("DOMContentLoaded", function() {
  var toggleButton = document.getElementById('toggleButton');
  var memberDiv = document.getElementById('member');
  var imageDiv = document.querySelector('.image');
  var mainMembersDiv = document.querySelector('.main-members');

  if (toggleButton && memberDiv) {
    toggleButton.addEventListener('click', function() {
      toggleContent(memberDiv, imageDiv, toggleButton, mainMembersDiv);
    });
  }
});

function toggleContent(memberDiv, imageDiv, toggleButton, mainMembersDiv) {
  if (memberDiv && toggleButton && mainMembersDiv) {
    var isVisible = memberDiv.classList.toggle('visible');
    memberDiv.classList.toggle('hidden');
    imageDiv.classList.toggle('hidden');
    console.log(isVisible)
    // Change button text based on visibility of element
    toggleButton.textContent = isVisible ? 'Less' : 'More';

    // Scroll to the main-members div if it's being shown
    if (isVisible) {
      console.log("hello")
    } else {
      // Scroll to the top of the page if hiding the main member div
      mainMembersDiv.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  }
}
