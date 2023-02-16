const ticketUpdateForm = document.forms.ticket_form;
const messages = {
    emptyTicketSubject : 'Please enter a subject',
    emptyTicketDescription : 'Please enter a description',
}

function errorBloc(input, message) {
    input.classList.add('is-invalid');
    let div = document.createElement('div');
    div.classList.add('invalid-feedback');
    div.innerHTML = message;
    input.insertAdjacentElement('afterend', div);
    setTimeout(() => {
        document.querySelector('.invalid-feedback').parentNode.removeChild(document.querySelector('.invalid-feedback'));
        input.classList.remove('is-invalid');
    }, 3000);
    event.preventDefault();
}

if (ticketUpdateForm) {
    ticketUpdateForm.addEventListener('submit', (event) => {
        let ticketSubject = document.getElementById('ticket_form_subject');
        let ticketDescription = document.getElementById('ticket_form_description');
        if (ticketSubject.value === '') {
            errorBloc(ticketSubject, messages.emptyTicketSubject);
        }

        if (ticketDescription.value === '') {
            errorBloc(ticketDescription, messages.emptyTicketDescription);
        }
    })
}

