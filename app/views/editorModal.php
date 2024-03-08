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
                        <textarea id="editor">
                        </textarea>
                        <!--<form action="">
                            <h4 class="form-label mt-3"><label for="img">Change image:</label></h4>
                            <img id="currentImage" src="" alt="" style="max-width:200px;">
                            <input class="form-control mt-3" type="file" id="img" name="img" accept="image.*">
                        </form>-->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-secondary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<script>
    tinymce.init({
        selector: 'textarea#editor',
        plugins: 'anchor autolink charmap emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage advtemplate autocorrect typography inlinecss',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    });
</script>
