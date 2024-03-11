<?php
session_start();

if(isset($_SESSION['username'])) {
    include __DIR__ . '/afterlogin.php';
} else {
    include __DIR__ . '/header.php';
}
?>
<div class="container mt-5">
    <h1>Pages</h1>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
            foreach ($pages as $page) {?>
               <tr>
                   <td><?php echo $page['pageId'] ?></td>
                   <td><?php echo $page['pageTitle'] ?></td>
                   <td>
                       <a href="/pageManagement/sections?pageId=<?php echo $page['pageId']; ?>"><i class="fa-solid fa-pen"></i></a>
                       <a class="ms-3" href="/pageManagement/deletePage?pageId=<?php echo $page['pageId']; ?>"><i class="fa-solid fa-trash-can" style="color: red"></i></a>
                   </td>
               </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
    <a class="btn btn-primary float-end" href="/pageManagement/addPage">Add page</a>
</div>