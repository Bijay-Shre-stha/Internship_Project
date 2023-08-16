document.addEventListener("DOMContentLoaded", function () {
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
        element.addEventListener("click", (e) => {
            console.log('edit');
            tr = e.target.parentNode.parentNode;
            title = tr.getElementsByTagName("td")[0].innerText;
            description = tr.getElementsByTagName("td")[1].innerText;
            tag = tr.getElementsByTagName("td")[2].innerText;
            console.log(title, description, tag);
            titleEdit.value = title;
            descriptionEdit.value = description;
            tagEdit.value = tag;
            snoEdit.value = e.target.id;
            console.log(e.target.id);
            $('#editModal').modal('toggle');
        });
    });
});
document.addEventListener("DOMContentLoaded", function () {
    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
        element.addEventListener("click", (e) => {
            console.log('delete',);
            sno = e.target.id;
            if (confirm("Are you sure you want to delete this note!")) {
                console.log("yes");
                window.location = `/todo/index.php?delete=${sno}`;
            }
        });
    });
});