function toggleElementVisibility(elementId, cssDisplay) {
    let element = document.getElementById(elementId);
    if (element == null) {
        console.log('Element not found');
        return;
    }

    if (element.style.display == 'none') {
        element.style.display = cssDisplay;
    } else {
        element.style.display = 'none';
    }
}