<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tiny.cloud/1/wcaebmg2hnz1n48ydoubfiw8d26z3lhx7oph8dis8t11gokx/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
</head>
<body>
<div class="modal fade" id="sectionModal" tabindex="-1" aria-labelledby="sectionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sectionModalLabel">Section Creator</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="message-container"></div>
                <label class="form-label" for="typeSelector">Choose the type of section: </label>
                <select class="form-control mb-3" name="typeSelector" id="typeSelector" required></select>

                <textarea id="editorNewSection">
                        </textarea>
                <div id="image-div">
                    <input class="form-control mt-3" type="file" name="images[]" id="imageInput" multiple>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-secondary" onclick="addSection()">Save changes</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<script>
    fetch('/pageManagement/getSectionTypes')
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to fetch section types');
            }
            return response.json();
        })
        .then(data => {
            const selectTypes = document.querySelectorAll('select[name="typeSelector"]');
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

</script>
