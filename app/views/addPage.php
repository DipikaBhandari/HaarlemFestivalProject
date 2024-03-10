<?php
session_start();

if(isset($_SESSION['username'])) {
    include __DIR__ . '/afterlogin.php';
} else {
    include __DIR__ . '/header.php';
}
?>
<div class="container mt-5">
    <h1>Create a new page</h1>
    <label class="form-label" for="pageTitleInput">Enter page title</label>
    <input class="form-control" type="text" name="pageTitleInput" id="pageTitleInput">

    <label for="sectionDropdown">Choose a section type</label>
    <select id="sectionDropdown" name="sectionDropdown">

    </select>


</div>
<script>
    fetch('/pageManagement/getSectionTypes')
    .then(response => {
        if(!response.ok) {
            throw new Error('Failed to fetch section types');
        }
        return response.json();
    })
    .then(data => {
        const selectType = document.getElementById('sectionDropdown');
        data.forEach(typeObj => {
            const option = document.createElement('option');
            option.value = typeObj.type;
            option.textContent = typeObj.type;
            selectType.appendChild(option);
        })
    })
    .catch(error => {
        console.error('Error fetching section types:', error);
    })
</script>