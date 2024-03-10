<!DOCTYPE html>
<html lang="en">
    <head>
        <script src="https://cdn.tiny.cloud/1/wcaebmg2hnz1n48ydoubfiw8d26z3lhx7oph8dis8t11gokx/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    </head>
    <body>
        <div class="modal fade" id="sectionEditorModal" tabindex="-1" aria-labelledby="sectionEditorModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="sectionEditorModalLabel">Section Editor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="message-container"></div>
                        <textarea id="editor">
                        </textarea>
                        <div id="image-div"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-secondary" onclick="saveContent()">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<script>
    tinymce.init({
        selector: 'textarea#editor',
        plugins: 'lists searchreplace wordcount formatpainter a11ychecker tinymcespellchecker powerpaste autocorrect typography',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | spellcheckdialog a11ycheck typography | align lineheight | numlist bullist indent outdent | removeformat',
    });
</script>
