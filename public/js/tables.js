window.addEventListener('DOMContentLoaded',function(){
    var addTableButton = document.getElementById('add-table-button');
    var newTableForm = document.querySelector('.new-table');

    addTableButton.addEventListener('click', function() {
        newTableForm.style.display = 'block';
    });
});