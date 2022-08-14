let droppable = document.querySelectorAll('.droppable');
let preventDefaults = e => e.preventDefault() && e.stopPropagation();
for (let i = 0; i < droppable.length; i++) {
    let dropArea = droppable[i],
        pseudoInput = dropArea.querySelector('.pseudo-input'),
        uploadIcon = pseudoInput.querySelector('.icon'),
        uploadText = pseudoInput.querySelector('.text'),
        preview = dropArea.querySelector('.preview');

    let previewImage = file => {
        let reader = new FileReader()
        reader.readAsDataURL(file)
        preview.querySelector('figure').innerHTML = '';
        reader.onloadend = () => {
            let img = document.createElement('img');
            img.src = reader.result;
            preview.querySelector('figure').appendChild(img);
            uploadIcon.classList.add('hidden');
            preview.classList.remove('hidden');
        }
    }

    let highlight = () => {
        dropArea.classList.remove('dropped');
        dropArea.classList.add('highlight');
    }

    let unhighlight = () => {
        dropArea.classList.remove('dropped');
        dropArea.classList.remove('highlight');
    }

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
    });

    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, unhighlight, false);
    });

    dropArea.addEventListener('drop', e => {
        dropArea.classList.remove('highlight');
        dropArea.classList.add('dropped');
        ([...e.dataTransfer.files]).forEach(previewImage);
        dropArea.querySelector('input').files = e.dataTransfer.files;
    }, false);

    dropArea.querySelector('input').addEventListener('change', e => {
        dropArea.classList.add('dropped');
        ([...e.target.files]).forEach(previewImage);
    }, false);
}
