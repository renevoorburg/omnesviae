// code for the autocomplete and form handling:
document.addEventListener('DOMContentLoaded', function () {
    const submitBtn = document.getElementById('submitBtn');
    document.addEventListener('click', handleOutsideClick);
    document.querySelector('form').addEventListener('submit', submitForm);

    function handleInput(inputValue, inputId, hiddenFieldId) {
        const suggestionsContainer = document.getElementById(`suggestions-${inputId}`);
        const hiddenField = document.getElementById(hiddenFieldId);
        const inputField = document.getElementById(inputId);

        function handleApiResponse(data) {
            const hasExactMatch = data.some(item => item.exact);

            if (!hasExactMatch) {
                invalidateInput(inputField);
                hiddenField.value = '';
            } else {
                const exactMatch = data.find(item => item.exact);
                hiddenField.value = exactMatch.value;
                validateInput(inputField);
            }

            if (data.length === 1 && hasExactMatch) {
                suggestionsContainer.style.display = 'none';
            } else if (data.length >= 1) {
                suggestionsContainer.style.display = 'block';
                populateSuggestions(data, inputField, hiddenField, suggestionsContainer);
            } else {
                suggestionsContainer.style.display = 'none';
            }
            updateSubmitButton();
        }

        function populateSuggestions(data) {
            suggestionsContainer.innerHTML = '';

            data.forEach(item => {
                const suggestionDiv = document.createElement("div");
                suggestionDiv.classList.add("suggestion");
                suggestionDiv.textContent = item.label;
                suggestionDiv.setAttribute('role', 'option');
                suggestionDiv.addEventListener("click", () => {
                    inputField.value = item.label;
                    hiddenField.value = item.value;
                    suggestionsContainer.style.display = 'none';
                    validateInput(inputField);
                    updateSubmitButton();
                });
                suggestionsContainer.appendChild(suggestionDiv);
            });
        }

        fetch(`/api/labels/${inputValue}`)
            .then(response => response.json())
            .then(data => handleApiResponse(data))
            .catch(error => {
                console.error("Error fetching suggestions:", error);
            });
    }

    function updateSubmitButton() {
        const originId = document.getElementById('originId').value;
        const destinationId = document.getElementById('destinationId').value;
        submitBtn.disabled = !(originId && destinationId);
    }

    function handleOutsideClick(event) {
        // Check if the click was outside the suggestion box and input field
        if (!event.target.closest('.autocomplete-container')) {
            hideSuggestions();
        }
    }

    function hideSuggestions() {
        document.querySelectorAll('.suggestions').forEach(suggestionsContainer => {
            suggestionsContainer.style.display = 'none';
        });
    }

    function submitForm(event) {
        event.preventDefault();

        const originId = document.getElementById('originId').value;
        const destinationId = document.getElementById('destinationId').value;

        fetch(`/api/route/${originId}/${destinationId}`)
            .then(response => response.json())
            .then(data => showRouteOnMap(data))
            .catch(error => {
                console.error("Error fetching route:", error);
            })
    }


    function moveRoutebox() {
        const routebox = document.getElementById('route');
        routebox.classList.toggle('moved-down');
    }

    function invalidateInput(element) {
        element.classList.add('error-text');
    }

    function validateInput(element) {
        element.classList.remove('error-text');
    }

    function setFrom(placeId, name) {
        document.getElementById('originId').value = placeId;
        document.getElementById('origin').value = name;
        validateInput(document.getElementById('origin'));
        updateSubmitButton();
    }

    function setTo(placeId, name) {
        document.getElementById('destinationId').value = placeId;
        document.getElementById('destination').value = name;
        validateInput(document.getElementById('destination'));
        updateSubmitButton();
    }

    // expose globally:
    window.setTo = setTo;
    window.setFrom = setFrom;
    window.moveRoutebox = moveRoutebox;
    window.handleInput = handleInput;
});


