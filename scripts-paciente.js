function agregarPaciente() {
    var formData = $("#pacienteForm").serialize();

    $.ajax({
        type: "POST",
        url: "insertar_paciente.php",
        data: formData,
        success: function(response) {
            $("#mensaje").html(response);
            limpiarFormulario(); // Limpia el formulario después de agregar
        },
        error: function(xhr, status, error) {
            $("#mensaje").html("Error al agregar paciente: " + xhr.responseText);
        }
    });
}

function limpiarFormulario() {
    document.getElementById("pacienteForm").reset();
    $("#mensaje").html(""); // Limpia también el mensaje de respuesta
}
