//Expand and collapse overview question section
function expandCollapse() {
    var hiddenContainers = document.querySelectorAll('.hiddenQuestionContainer'); 
    var showMoreBtn = document.getElementById('showMoreBtn');
    
    var allHidden = true; // Check if all hidden containers hidden

    for (var i = 0; i < hiddenContainers.length; i++) {
        if (hiddenContainers[i].style.display === 'block') {
            allHidden = false; 
            break;
        }
    }

    for (var i = 0; i < hiddenContainers.length; i++) {
        if (allHidden) {
            hiddenContainers[i].style.display = 'block';  
        } else {
            hiddenContainers[i].style.display = 'none';  
        }
    }

    if (allHidden) {
        shade.style.display = 'none';  
        showMoreBtn.innerHTML = 'Show Less <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"><polygon points="12 6.586 3.293 15.293 4.707 16.707 12 9.414 19.293 16.707 20.707 15.293 12 6.586"/></svg>';
    } else {
        shade.style.display = 'flex';  
        showMoreBtn.innerHTML = 'Show More <svg width="10pt" height="10pt" version="1.1" viewBox="0 0 1200 1200" xmlns="http://www.w3.org/2000/svg"><path transform="scale(50)" d="m21 8.5-9 9-9-9" fill="none" stroke="#000" stroke-miterlimit="10" stroke-width="2" /></svg>';
    }
}
