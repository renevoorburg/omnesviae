// code for the autocomplete and form handling:

document.addEventListener('DOMContentLoaded', () => {
    const submitBtn = document.getElementById('submitBtn');
    const originHidden = document.getElementById('originId');
    const destinationHidden = document.getElementById('destinationId');

    document.addEventListener('click', handleOutsideClick);
    document.querySelector('form').addEventListener('submit', submitForm);

    function handleInput(inputValue, inputId, hiddenFieldId) {
        const suggestionsContainer = document.getElementById(`suggestions-${inputId}`);
        const hiddenField = document.getElementById(hiddenFieldId);
        const inputField = document.getElementById(inputId);

        function handleLabelsApiResponse(data) {
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
            .then(data => handleLabelsApiResponse(data))
            .catch(error => {
                console.error("Error fetching suggestions:", error);
            });
    }

    function updateSubmitButton() {
        submitBtn.disabled = !(originHidden.value && destinationHidden.value);
    }

    function handleOutsideClick(event) {
        if (!event.target.closest('.autocomplete-container')) {
            hideSuggestions();
        }
    }

    function hideSuggestions() {
        document.querySelectorAll('.suggestions').forEach(suggestionsContainer => {
            suggestionsContainer.style.display = 'none';
        });
    }

    function getRoute() {
        fetch(`/api/route/${originHidden.value}/${destinationHidden.value}`)
            .then(response => response.json())
            .then(data => showRouteOnMap(data))
            .catch(error => {
                console.error("Error fetching route:", error);
            })
    }

    function submitForm(event) {
        event.preventDefault();
        getRoute();
        window.location = `#${originHidden.value}_${destinationHidden.value}`;
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

    function setInputName(element, name, id) {
        const nameInput = document.getElementById(`${element}`);
        const nameIdInput = document.getElementById(`${element}Id`);
        nameInput.value = name;
        nameIdInput.value = id;
        validateInput(nameInput);
        updateSubmitButton();
    }

    function setFrom(placeId, name) {
        setInputName('origin', name, placeId);
    }

    function setTo(placeId, name) {
        setInputName('destination', name, placeId);
    }

    // expose globally:
    window.setTo = setTo;
    window.setFrom = setFrom;
    window.moveRoutebox = moveRoutebox;
    window.handleInput = handleInput;
    window.getRoute = getRoute;
});


