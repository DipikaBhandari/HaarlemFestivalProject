<?php
if(!isset($_SESSION)){
    session_start();
}

if(isset($_SESSION['username'])) {
    include __DIR__ . '/afterlogin.php';
} else {
    include __DIR__ . '/header.php';
}
?>
<div class="container mt-5">
    <a class="text-dark" href="/pageManagement"><i class="fa-solid fa-angles-left text-dark"></i> Back</a>
    <h1><?php echo $pageTitle ?> Sections</h1>
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Type</th>
            <th>Title</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($sections as $section) {
            // Check if the section type is not section that shouldn't be edited
            if ($section['type'] !== 'crossnavigation' && $section['type'] !== 'marketing' && $section['type'] !== 'card' && $section['type'] !== 'timetable') {
                ?>
                <tr>
                    <td><?php echo $section['sectionId'] ?></td>
                    <td><?php echo $section['type'] ?></td>
                    <td><?php echo !empty($section['heading']) ? strip_tags($section['heading']) : '' ?></td>
                    <td>
                        <a href="#" onclick="openEditorModal(<?php echo $section['sectionId']; ?>)"><i class="fa-solid fa-pen"></i></a>
                        <a class="ms-3" href="/pageManagement/deleteSection?pageId=<?php echo $_GET['pageId']; ?>&sectionId=<?php echo $section['sectionId']; ?>"><i class="fa-solid fa-trash-can" style="color: red"></i></a>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
        </tbody>
    </table>
    <button class="btn btn-primary float-end" onclick="openSectionModal()">Add Section</button>
</div>
<?php include __DIR__ . '/editorModal.php'; ?>
<?php include __DIR__ . '/sectionModal.php'; ?>
<script>
    let currentSectionId;
    function openEditorModal(sectionId) {
        currentSectionId = sectionId;
        var myModal = new bootstrap.Modal(document.getElementById('sectionEditorModal'));
        tinymce.init({
            selector: 'textarea#editor',
            plugins: 'lists',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | align lineheight | numlist bullist indent outdent | removeformat',
        });
        fetch('/pageManagement/getSectionContent?sectionId=' + sectionId)
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Failed to fetch section content');
                }
            })
            .then(data =>{
                let htmlContent = '';
                document.querySelector('#image-div').innerHTML= '';
                if (data.section.heading) {
                    htmlContent += data.section.heading;
                }
                if (data.section.subTitle){
                    htmlContent += data.section.subTitle;
                }

                data.paragraphs.forEach(paragraph => {
                    if (paragraph.text) {
                        htmlContent += paragraph.text;
                    }
                });

                data.images.forEach(image => {
                        const currentImage = document.createElement('img');
                        currentImage.src = image.imagePath;
                        currentImage.id = image.imageId;
                        currentImage.style = 'max-width: 200px;';

                        const imageUpload = document.createElement('input');
                        imageUpload.type = 'file';
                        imageUpload.accept = 'image/*';
                        imageUpload.dataset.imageId = image.imageId;
                        imageUpload.addEventListener('change', function(event) {
                            var file = event.target.files[0];
                            var imageId = event.target.dataset.imageId;
                            // Get the uploaded file
                            if (file) {
                                updateCurrentImage(imageId, URL.createObjectURL(file));
                            }
                        })
                        const imageEditor = document.createElement("form");
                        imageEditor.appendChild(currentImage);
                        imageEditor.appendChild(imageUpload);
                        document.querySelector('#image-div').appendChild(imageEditor);
                });
                tinyMCE.activeEditor.setContent(htmlContent);
                myModal.show();
            })
            .catch(error => {
                console.error('Error fetching section content:', error);
            });
    }

    function updateCurrentImage(imageId, imagePath) {
        const currentImage = document.getElementById(imageId);
        if (currentImage) {
            currentImage.src = imagePath;
        }
    }

    function saveContent(){
        const newContent = tinyMCE.activeEditor.getContent("editor");
        const formData = new FormData();

        formData.append('sectionId', currentSectionId);
        formData.append('content', newContent);

        const imageFiles = document.querySelectorAll('input[type="file"]');
        imageFiles.forEach(fileInput => {
            const file = fileInput.files[0];
            const imageId = fileInput.dataset.imageId;
            if (file) {
                formData.append('images[' + imageId + ']', file);
            }
        });

        fetch('/pageManagement/saveNewContent', {
            method: 'POST',
            body: formData,
        })
            .then(response => {
                if (response.ok) {
                    console.log(formData);
                    const messageContainer = document.getElementById('message-container-edit');
                    messageContainer.innerHTML = '<div class="alert alert-success mt-3">Changes were saved successfully.</div>';
                    setTimeout(() => {
                        const activeModal = document.querySelector('.modal.show');
                        if (activeModal) {
                            const modalInstance = bootstrap.Modal.getInstance(activeModal);
                            modalInstance.hide();
                        }
                        messageContainer.innerHTML='';
                    }, 1000);

                   /* setTimeout(() => {
                        window.location.reload();
                    }, 1500);*/
                } else {
                    const messageContainer = document.getElementById('message-container-edit');
                    messageContainer.innerHTML = '<div class="alert alert-danger mt-3">Failed to save changes. Please try again.</div>';
                }
            })
            .catch(error => {
                const messageContainer = document.getElementById('message-container-edit');
                messageContainer.innerHTML = '<div class="alert alert-danger mt-3">Failed to save changes. Please try again.</div>';
            });
    }

    function openSectionModal(){
        const myModal = new bootstrap.Modal(document.getElementById('sectionModal'));
        tinymce.init({
            selector: 'textarea#editorNewSection',
            plugins: 'lists',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | align lineheight | numlist bullist indent outdent | removeformat',
        });
        myModal.show();
    }

    function addSection(){
        const formData = new FormData();
        const pageId = <?php echo $_GET['pageId']; ?>;
        const sectionType = document.querySelector('select').value;
        const textEditorId = 'sectionModal';
        const sectionContent = tinyMCE.activeEditor.getContent("editorNewSection");
        formData.append(`section[pageId]`, pageId);
        formData.append(`section[sectionType]`, sectionType);
        formData.append(`section[content]`, sectionContent);

        const filesInput = document.querySelector('input[type="file"]');
        const files = filesInput.files;
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            formData.append(`section[images][${i}]`, file);
        }
        const formDataObject = Object.fromEntries(formData);
        console.log(formDataObject);
        saveSection(formData);
    }

    function saveSection(formData){
        fetch('/pageManagement/saveSection', {
            method: 'POST',
            body: formData
        })
            .then(response => {
                if(!response.ok) {
                    document.getElementById('message-container').innerHTML = '<div class="alert alert-danger mt-3">Failed to save changes. Please try again.</div>';
                } else{
                    document.getElementById('message-container'). innerHTML = '<div class="alert alert-success mt-3">Changes were saved successfully.</div>';
                    setTimeout(()=>{
                        window.location.href = '/pageManagement/sections?pageId=<?php echo $_GET['pageId']; ?>';
                    },3000);
                }
            })
            .catch(error => {
                document.getElementById('message-container').innerHTML = '<div class="alert alert-danger mt-3">Failed to save changes. Please try again.</div>';
            })
    }
</script>