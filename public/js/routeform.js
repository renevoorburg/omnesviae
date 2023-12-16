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
                inputField.classList.add('error-text');
                hiddenField.value = '';
            } else {
                const exactMatch = data.find(item => item.exact);
                hiddenField.value = exactMatch.value;
                inputField.classList.remove('error-text');
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
                suggestionDiv.addEventListener("click", () => {
                    inputField.value = item.label;
                    hiddenField.value = item.value;
                    suggestionsContainer.style.display = 'none';
                    inputField.classList.remove('error-text');
                    updateSubmitButton();
                });
                suggestionsContainer.appendChild(suggestionDiv);
            });
        }

        function updateSubmitButton() {
            const place1Value = document.getElementById('place1Value').value;
            const place2Value = document.getElementById('place2Value').value;
            submitBtn.disabled = !(place1Value && place2Value);
        }

        fetch(`/api/labels/${inputValue}`)
            .then(response => response.json())
            .then(data => handleApiResponse(data))
            .catch(error => {
                console.error("Error fetching suggestions:", error);
            });
    }

    function handleOutsideClick(event) {
        // Check if the click was outside the suggestion box and input field
        if (!event.target.closest('.autocomplete-container')) {
            hideSuggestions();
        }
    }

    function hideSuggestions() {
        // Hide suggestion boxes
        document.querySelectorAll('.suggestions').forEach(suggestionsContainer => {
            suggestionsContainer.style.display = 'none';
        });
    }

    function submitForm(event) {
        event.preventDefault();

        const place1Value = document.getElementById('place1Value').value;
        const place2Value = document.getElementById('place2Value').value;

        fetch(`/api/route/${place1Value}/${place2Value}`)
            .then(response => response.json())
            .then(data => showRouteOnMap(data))
            .catch(error => {
                console.error("Error fetching route:", error);
            })
    }


    function moveRoutebox() {
        var routebox = document.getElementById('route');
        routebox.classList.toggle('moved-down');
    }

    window.moveRoutebox = moveRoutebox; // Expose handleInput globally for the oninput attribute in the HTML
    window.handleInput = handleInput; // Expose handleInput globally for the oninput attribute in the HTML
});
