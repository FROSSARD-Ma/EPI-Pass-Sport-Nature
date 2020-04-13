class Message {

    constructor(message) {
        this.message = message;
    }

    // Ajoput message
    validMessage() {
        message.style.display = 'block';
        message.classList.add('valid');
        message.innerHTML = this.message;
        setTimeout(()=> this.clearMessage(), 3000); // 3s
    }

    errorMessage() {
        message.style.display = 'block';
        message.classList.add('error');
        message.innerHTML = this.message;
        setTimeout(()=> this.clearMessage(), 3000); // 3s
    }

    clearMessage () {
        message.classList.remove('valid');
        message.classList.remove('error');
        message.style.display = 'none';
    }
}