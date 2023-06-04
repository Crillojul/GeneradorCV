
// Titulación
    function nuevaTitulacion(variable_numerica) {
        var formTitulacion = `
            <label for="nombre_titulacion">Nombre de la titulación: </label>
            <input id="nombre_titulacion" name="nombre_titulacion_${variable_numerica}" type="text" pattern="[a-zA-Z0-9_.-() ]{2,60}" required><br>
            <label for="fecha_titulacion">Fecha de finalización: </label>
            <input id="fecha_titulacion" name="fecha_titulacion_${variable_numerica}" type="date"><br>
            <label for="centro_titulacion">Nombre del centro: </label>
            <input id="centro_titulacion" name="centro_titulacion_${variable_numerica}" type="text" pattern="[a-zA-Z0-9_.-() ]{2,60}"><br><br>
        `;
        document.getElementById('contenedor_titulacion').insertAdjacentHTML('beforeend', formTitulacion);
    }

    const botonTitulacion = document.getElementById('añadirTitulacion');
    let x = 1;
    botonTitulacion.addEventListener('click', function() {
        nuevaTitulacion(x);
        x++;
    });

// Idioma
    function nuevoIdioma(variable_numerica) {
        var formIdioma = `
            <label for="idioma">Idioma: </label>
            <input id="idioma" name="idioma_${variable_numerica}" type="text" pattern="[a-zA-Z0-9_.-() ]{2,40}" required><br>
            <label for="nivel">Nivel: </label>
            <input id="nivel" name="nivel_${variable_numerica}" type="text" pattern="[a-zA-Z0-9_.-() ]{2,40}"><br>
            <label for="certificado">certificado: </label>
            <input id="certificado" name="certificado_${variable_numerica}" type="text" pattern="[a-zA-Z0-9_.-() ]{2,40}"><br><br>
        `;
        document.getElementById('contenedor_idiomas').insertAdjacentHTML('beforeend', formIdioma);
    }

    const botonIdioma = document.getElementById('añadirIdioma');
    let y = 1;
    botonIdioma.addEventListener('click', function() {
        nuevoIdioma(y);
        y++;
    });

// Experiencia
    function nuevaExperiencia(variable_numerica) {
        var formExperiencia = `
            <label for="titulo_exp">Título de la experiencia: </label>
            <input id="titulo_exp" name="titulo_exp_${variable_numerica}" type="text" pattern="[a-zA-Z0-9_.-() ]{2,60}" required><br>
            <label for="categoria">Categoría del puesto: </label>
            <input id="categoria" name="categoria_${variable_numerica}" type="text" pattern="[a-zA-Z0-9_.-() ]{2,60}"><br>
            <label for="descripcion">Descripción del puesto: </label>
            <input id="descripcion" name="descripcion_${variable_numerica}" type="text" pattern="[a-zA-Z0-9_.-() ]{2,60}"><br>
            <label for="fecha_inicio">Fecha de inicio: </label>
            <input id="fecha_inicio" name="fecha_inicio_${variable_numerica}" type="date"><br>
            <label for="fecha_fin">Fecha de finalización: </label>
            <input id="fecha_fin" name="fecha_fin_${variable_numerica}" type="date"><br><br>
        `;
        document.getElementById('contenedor_experiencia').insertAdjacentHTML('beforeend', formExperiencia);
    }

    const botonExperiencia = document.getElementById('añadirExperiencia');
    let z = 1;
    botonExperiencia.addEventListener('click', function() {
        nuevaExperiencia(z);
        z++;
    });