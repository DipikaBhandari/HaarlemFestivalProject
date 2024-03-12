<?php
session_start();

if(isset($_SESSION['username'])) {
    include __DIR__ . '/afterlogin.php';
} else {
    include __DIR__ . '/header.php';
}
?>
<head>
    <script src="https://cdn.tiny.cloud/1/wcaebmg2hnz1n48ydoubfiw8d26z3lhx7oph8dis8t11gokx/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
</head>
<div class="container mt-5">
    <a class="text-dark" href="/pageManagement"><i class="fa-solid fa-angles-left text-dark"></i> Back</a>
    <h1>Create a new page</h1>
    <label class="form-label mt-3" for="pageTitleInput">Enter page title</label>
    <input class="form-control mt-1" type="text" name="pageTitleInput" id="pageTitleInput" required>
    <div id="containerSections">
        <div id="section1">
            <h2 class="mt-5">Section 1</h2>

            <label class="form-label mt-3" for="typeDropdown">Choose a section type</label>
            <select class="form-control mt-1" id="typeDropdown" name="typeDropdown" required>
            </select>

            <label class="form-label mt-3" for="textEditor1">Add text content</label>
            <textarea id="textEditor1"></textarea>

            <input class="form-control mt-3" type="file" name="images[]" id="imageInput" multiple>
        </div>
    </div>
    <button class="btn btn-primary mt-3 float-end" onclick="savePage()">Save page</button>
    <button class="btn btn-secondary m-3 float-end" onclick="addAnotherSection()">Add another section</button>
    <div id="message-container"></div>
</div>

<script>
    let numberOfSections = 1;
    document.addEventListener('focusin', (e) => {
        if (e.target.closest(".tox-tinymce, .tox-tinymce-aux, .moxman-window, .tam-assetmanager-root") !== null) {
            e.stopImmediatePropagation();
        }
    });


    function initializeSection(){
        fetch('/pageManagement/getSectionTypes')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to fetch section types');
                }
                return response.json();
            })
            .then(data => {
                const selectTypes = document.querySelectorAll('select[name="typeDropdown"]');
                selectTypes.forEach(selectType => {
                    if (selectType.length === 0)
                    data.forEach(typeObj => {
                        const option = document.createElement('option');
                        option.value = typeObj.type;
                        option.textContent = typeObj.type;
                        selectType.appendChild(option);
                    });
                });
            })
            .catch(error => {
                console.error('Error fetching section types:', error);
            });

        tinymce.init({
            selector: 'textarea',
            plugins: 'lists searchreplace wordcount formatpainter a11ychecker tinymcespellchecker powerpaste autocorrect typography',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | spellcheckdialog a11ycheck typography | align lineheight | numlist bullist indent outdent | removeformat',
        });
    }
    window.addEventListener('DOMContentLoaded', initializeSection);

    function addAnotherSection(){
        numberOfSections++;
        const container = document.querySelector('#containerSections');
        const lastSection = container.lastElementChild;
        const newSection = document.createElement('div');
        newSection.id = `section${numberOfSections}`;
        newSection.innerHTML = `
        <h2 class="mt-5">Section ${numberOfSections}</h2>
        <label class="form-label mt-3" for="typeDropdown${numberOfSections}">Choose a section type</label>
        <select class="form-control mt-1" id="typeDropdown${numberOfSections}" name="typeDropdown" required>
        </select>
        <label class="form-label mt-3" for="textEditor${numberOfSections}">Add text content</label>
        <textarea id="textEditor${numberOfSections}"></textarea>
        <input class="form-control mt-3" type="file" name="images[]" id="imageInput${numberOfSections}" multiple>
    `;
        container.appendChild(newSection);

        initializeSection();
    }

    function savePage(){
        const pageTitle = document.getElementById('pageTitleInput').value;
        const sections = document.querySelectorAll('[id^=section]');
        const formData = new FormData();
        sections.forEach((section, index) => {
            const sectionType = section.querySelector('select').value;
            const textEditorId = `textEditor${index + 1}`;
            console.log("Textarea ID:", textEditorId);
            const sectionContent = tinymce.get(textEditorId).getContent();
            formData.append(`sections[${index}][sectionType]`, sectionType);
            formData.append(`sections[${index}][content]`, sectionContent);

            const filesInput = section.querySelector('input[type="file"]');
            const files = filesInput.files;
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                formData.append(`sections[${index}][images][${i}]`, file);
            }
        })
        formData.append('pageTitle', pageTitle);
        saveToDatabase(formData);

    }

    function saveToDatabase(formData){
        fetch('/pageManagement/savePage', {
            method: 'POST',
            body: formData
        })
            .then(response => {
                if(!response.ok) {
                    document.getElementById('message-container').innerHTML = '<div class="alert alert-danger mt-3">Failed to save changes. Please try again.</div>';
                } else{
                    console.log('Page saved successfully');
                    document.getElementById('message-container'). innerHTML = '<div class="alert alert-success mt-3">Changes were saved successfully.</div>';
                    setTimeout(()=>{
                        window.location.href = '/pageManagement';
                    },3000);
                }
            })
            .catch(error => {
                document.getElementById('message-container').innerHTML = '<div class="alert alert-danger mt-3">Failed to save changes. Please try again.</div>';
            })
    }
</script>