document.getElementById('readMoreLink').addEventListener('click', function (event){
    event.preventDefault();
    let photoSection = document.getElementById('photo-col');
    let readMoreSections = document.getElementsByClassName('container subsection');
    for (const readMoreSection of readMoreSections) {

        if (readMoreSection.style.display === 'none' || readMoreSection.style.display === '') {
            readMoreSection.style.display = 'block';
        }
    }
    if (photoSection.style.display ==="none" || photoSection.style.display === ""){
        photoSection.style.display = 'block';
    }
    this.style.display = 'none';
})

document.getElementById('readLessLink').addEventListener('click', function (event){
    event.preventDefault();

    let photoSection = document.getElementById('photo-col');
    let readMoreSections = document.getElementsByClassName('container subsection');
    for (const readMoreSection of readMoreSections) {
        readMoreSection.style.display = 'none';
    }
    photoSection.style.display = 'none';

    document.getElementById('readMoreLink').style.display = 'block';
})