edits = document.getElementsByClassName('edit');
Array.from(edits).forEach((element) => {
    element.addEventListener("click", (e) => {
        tr = e.target.parentNode.parentNode;

        title = tr.getElementsByTagName("td")[0].innerText;
        description = tr.getElementsByTagName("td")[1].innerText;
        tag = tr.getElementsByTagName("td")[2].innerText;
        titleEdit.value = title;
        descriptionEdit.value = description;
        tagEdit.value = tag;
        snoEdit.value = e.target.id;
        $('#editModal').modal('toggle');
    })
})
deletes = document.getElementsByClassName('delete');
Array.from(deletes).forEach((element) => {
    element.addEventListener("click", (e) => {
        sno = e.target.id;
        if (confirm("Are you sure you want to delete this note?")) {
            window.location = `/todo/index.php?delete=${sno}`;
        }
    })
})

const alertElement = document.querySelector('.alert');
setTimeout(function () {
    alertElement.remove();
}, 3000);