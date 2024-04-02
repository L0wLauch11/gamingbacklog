let modal, modalCloseButton, modalContent;
let modalBackground = document.getElementsByClassName("modal-background")[0];

function modalOpen(button) {
    modal = button.nextElementSibling;
    modalContent = modal.getElementsByClassName("modal-content")[0];
    modalCloseButton = modalContent.getElementsByClassName("modal-close")[0];

    modal.style.display = "block";
    modalBackground.style.display = "block";
}

function modalClose() {
    if (modal == null || modalCloseButton == null || modalContent == null) {
        return;
    }

    modal.style.display = "none";
    modalBackground.style.display = "none";
}

window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
} 