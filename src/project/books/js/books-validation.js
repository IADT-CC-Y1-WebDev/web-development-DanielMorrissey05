// 09-2: Books-style form validation (formHandler pattern)
console.log("validator")

let submitBtn = document.getElementById('submit_btn');
let bookForm = document.getElementById('book_form');
let errorSummaryTop = document.getElementById('error_summary_top');

let titleInput = document.getElementById('title');
let authorInput = document.getElementById('author');
let releaseYearInput = document.getElementById('release_year');
let isbnInput = document.getElementById('isbn');
let publisherIdInput = document.getElementById('publisher_id');
let descriptionInput = document.getElementById('description');
let formatIdsInput = document.getElementsByName('format_id[]');
let cover_filenameInput = document.getElementById('cover_filename');

let titleError = document.getElementById('title_error');
let authorError = document.getElementById('author_error');
let releaseYearError = document.getElementById('release_year_error');
let isbnError = document.getElementById('isbn_error');
let publisherIdError = document.getElementById('publisher_id_error');
let descriptionError = document.getElementById('description_error');
let formatIdsError = document.getElementById('format_id_error');
let cover_filenameError = document.getElementById('cover_filename_error');

let errors = {};

submitBtn.addEventListener('click', onSubmitForm);

function addError(fieldName, message) {
    errors[fieldName] = message;
}

function showErrorSummaryTop() {
    const messages = Object.values(errors);
    if (messages.length === 0) {
        errorSummaryTop.style.display = 'none';
        errorSummaryTop.innerHTML = '';
        return;
    }
    errorSummaryTop.innerHTML =
        '<strong>Please fix the following:</strong><ul>' +
        messages
            .map(function (m) {
                return '<li>' + m + '</li>';
            })
            .join('') +
        '</ul>';
    errorSummaryTop.style.display = 'block';
}

function showFieldErrors() {
    titleError.innerHTML = errors.title || '';
    authorError.innerHTML = errors.author || '';
    releaseYearError.innerHTML = errors.release_year || '';
    isbnError.innerHTML = errors.isbn_id || '';
    publisherIdError.innerHTML = errors.publisher_id || '';
    descriptionError.innerHTML = errors.description || '';
    formatIdsError.innerHTML = errors.format_id || '';
    cover_filenameError.innerHTML = errors.cover_filename || '';
}

function isRequired(value) {
    return String(value).trim() !== '';
}

function isMinLength(value, min) {
    return String(value).trim().length >= min;
}

function isMaxLength(value, max) {
    return String(value).trim().length <= max;
}

function onSubmitForm(evt) {
    evt.preventDefault();

    errors = {};

    let titleMin = titleInput.minlength || 3;
    let titleMax = titleInput.maxlength || 15;
    let descMin = descriptionInput.minlength || 10;``
    
    //title
    if(!isRequired(titleInput.value)){
        addError('title', 'Title is required!');
    } else if(!isMinLength(titleInput.value, titleMin)){
        addError('title', 'Title must be at least ' + titleMin + ' characters.')
    } else if(!isMaxLength(titleInput.value, titleMax)){
        addError('title', 'Title must not exceed ' + titleMax + ' characters.')
    }

    //author
    if(!isRequired(authorInput.value)){
        addError('author', 'Author is required!');
    } 
    
    //release year
    if(!isRequired(releaseYearInput.value)){
        addError('release_year', 'Release year is required!');
    } 

    //isbn
    if(!isRequired(isbnInput.value)){
        addError('isbn_id', 'Isbn is required!');
    }
    
    //description
    if (!isRequired(descriptionInput.value)) {
        addError('description', 'Description is required.');
    } else if (!isMinLength(descriptionInput.value, descMin)) {
        addError('description', `Description must be at least ${descMin} characters long.`);
    }

    //format
    let formatChecked = false;
    for(let i = 0; i < formatIdsInput.length; i++){
        if (formatIdsInput[i].checked) {
            formatChecked = true;
            break;
        }
    }

    if(!formatChecked){
        addError('format_id', 'Select at least one format.');
    }

    //cover_filename
    if(cover_filenameInput.files.length === 0){
        addError('cover_filename', 'cover_filename is required');
    }

    showFieldErrors();
    showErrorSummaryTop();

    if(Object.keys(errors).length === 0){
    bookForm.submit();
    //alert('Form data valid.')
    }
}