function validarForm() {
    var cpf = document.getElementById('cpf').value;
    if(cpf.length !== 11 || isNaN(cpf)) {
        alert('O CPF deve possuir estritamente 11 caracteres numéricos. Verifique e envie novamente.');
        return false;
    }
    return true;
}
