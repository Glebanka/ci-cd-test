function sortable(parentElement, onUpdate) {

    var draggedElement;

    [].slice.call(parentElement.children).forEach(function (itemElement) {
        itemElement.draggable = true;
    });

    function _onDragOver(event) {
        event.preventDefault();
        event.dataTransfer.dropEffect = 'move';

        // Находим ближайший контейнер изображения
        var targetContainer = event.target.closest('.image-container');
        if (targetContainer && targetContainer !== draggedElement) {
            var targetRect = targetContainer.getBoundingClientRect();
            var offsetX = event.clientX - targetRect.left;

            // Вставляем draggedElement перед или после targetContainer
            if (offsetX < targetRect.width / 2) {
                parentElement.insertBefore(draggedElement, targetContainer);
            } else {
                parentElement.insertBefore(draggedElement, targetContainer.nextSibling);
            }
        }
    }

    function _onDragEnd(event) {
        event.preventDefault();
        draggedElement.classList.remove('ghost');
        parentElement.removeEventListener('dragover', _onDragOver, false);
        parentElement.removeEventListener('dragend', _onDragEnd, false);
        onUpdate(draggedElement);
    }

    parentElement.addEventListener('dragstart', function (event) {
        draggedElement = event.target.closest('.image-container');
        if (!draggedElement) return;

        event.dataTransfer.effectAllowed = 'move';
        event.dataTransfer.setData('text/plain', '');

        parentElement.addEventListener('dragover', _onDragOver, false);
        parentElement.addEventListener('dragend', _onDragEnd, false);

        setTimeout(function () {
            draggedElement.classList.add('ghost');
        }, 0);
    }, false);
}
const parentElement = document.getElementById('sortable-images');
if (parentElement != null && parentElement.children.length >= 1) {
    sortable(parentElement, function (item) {
        updateImageOrder();
    });
}

function updateImageOrder() {
    if (document.getElementById('sortable-images') == null || document.getElementById('sortable-images').children.length < 1) {
        return;
    }
    var sortedElements = [].slice.call(document.getElementById('sortable-images').children).map(function (img) {
        return img;
    });
    let sortStart = 1;
    let preparedData = [];
    for (var i = 0; i < sortedElements.length; i++) {
        sortedElements[i].dataset.sort = sortStart;
        ++sortStart;
        preparedData.push({
            id: sortedElements[i].dataset.id,
            sort: sortedElements[i].dataset.sort
        });
    }
    console.log(preparedData);
    document.getElementById('image-order').value = JSON.stringify(preparedData);
}
document.querySelector('form').addEventListener('submit', function (event) {
    updateImageOrder();
});

document.querySelectorAll('.delete-image-btn').forEach(function (button) {
    button.addEventListener('click', function (event) {
        event.preventDefault();
        var imageContainer = button.closest('.image-container');
        var imageId = imageContainer.getAttribute('data-id');
        var input = document.getElementById('images-to-delete');
        var currentValue = input.value ? input.value.split(',') : [];
        if (!currentValue.includes(imageId)) {
            currentValue.push(imageId);
            input.value = currentValue.join(',');
        }
        imageContainer.setAttribute("style", "opacity:30%"); // Удаляем изображение из DOM
    });
});