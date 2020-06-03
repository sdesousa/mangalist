import $ from 'jquery';

let $collectionHolder;
const $addNewButton = $('<a href="#" class="btn btn-darker ml-5">+</a>');
const $newLinkLi = $('<li class="my-4 offset-10"></li>').append($addNewButton);

$(document).ready(function () {
    $collectionHolder = $('#authorList');
    $collectionHolder.find('.authorElem').each(function () {
        addRemoveButton($(this));
    });
    $collectionHolder.append($newLinkLi);
    $collectionHolder.data('index', $collectionHolder.find('.authorElem').length)
    $addNewButton.click(function (e) {
        e.preventDefault();
        addNewForm($collectionHolder, $newLinkLi);
    });
});

function addNewForm($collectionHolder, $newLinkLi)
{
    const prototype = $collectionHolder.data('prototype');
    const index = $collectionHolder.data('index');
    let newForm = prototype;
    newForm = newForm.replace(/__name__/g, index);
    $collectionHolder.data('index', index + 1);
    let $newFormLi = $('<li class="col-10 offset-1 authorElem mb-3 p-4 border-turquoise"></li>').append(newForm);
    $newLinkLi.before($newFormLi);
    addRemoveButton($newFormLi);
}

function addRemoveButton($formLi)
{
    const $removeButton = $('<a href="#" class="btn btn-danger offset-11">-</a>');
    $formLi.append($removeButton);
    $removeButton.click(function (e) {
        e.preventDefault();
        $formLi.slideUp(1000, function () {
            $(this).remove();
        });
    });
}

$('#admin_manga_editor').change(function () {
    const editorSelector = $(this);
    $.ajax({
        url: "/admin/manga/list",
        type: "GET",
        dataType: "JSON",
        data: {
            editorId: editorSelector.val()
        },
        success: function (editorCollections) {
            let editorCollectionSelect = $("#admin_manga_editorCollection");
            editorCollectionSelect.html('');
            editorCollectionSelect.append('<option value> - </option>');
            $.each(editorCollections, function (key, editorCollection) {
                console.log(editorCollection)
                editorCollectionSelect.append('<option value="' + editorCollection.id + '">' + editorCollection.editor + '</option>');
            });
        },
        error: function (err) {
            alert("Une erreur s'est produite lors de la récupération des données ...");
        }
    });
});
